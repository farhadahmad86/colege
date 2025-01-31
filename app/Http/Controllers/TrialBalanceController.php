<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountHeadsModel;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Cache;

class TrialBalanceController extends Controller
{

    public function trial_balance(Request $request)
    {
        // Record start time
        $startTime = microtime(true);
        $user = Auth::user();
        $searchParameters = $this->getSearchParameters($request);

        $tableName = $searchParameters['year'] == $searchParameters['current_year']
            ? 'financials_balances'
            : 'financials_balances_' . $searchParameters['year'];

        $balances = DB::table($tableName)
            ->leftJoin('financials_accounts', 'financials_accounts.account_uid', '=', "$tableName.bal_account_id")
            ->leftJoin('financials_coa_heads', 'financials_coa_heads.coa_code', '=', "financials_accounts.account_parent_code")
            ->leftJoin('financials_coa_heads as 2ndAba', '2ndAba.coa_code', '=', "financials_coa_heads.coa_parent")
            ->leftJoin('financials_coa_heads as 1stAba', '1stAba.coa_code', '=', "2ndAba.coa_parent")
            ->select(
                "$tableName.bal_account_id",
                'financials_accounts.account_name',
                'financials_coa_heads.coa_code as 3rd_code',
                'financials_coa_heads.coa_head_name as 3rd',
                '2ndAba.coa_head_name as 2nd',
                '2ndAba.coa_code as 2nd_code',
                '1stAba.coa_head_name as 1st',
                '1stAba.coa_code as 1st_code',
                DB::raw("SUM(CASE
            WHEN $tableName.bal_day_end_date < '{$searchParameters['start_date']}' THEN $tableName.bal_dr
            ELSE 0
         END) -
         SUM(CASE
            WHEN $tableName.bal_day_end_date < '{$searchParameters['start_date']}' THEN $tableName.bal_cr
            ELSE 0
         END) AS opening_balance"),
                DB::raw("SUM(CASE
            WHEN $tableName.bal_day_end_date BETWEEN '{$searchParameters['start_date']}' AND '{$searchParameters['end_date']}' THEN $tableName.bal_dr
            ELSE 0
         END) AS entry_dr_balance"),
                DB::raw("SUM(CASE
            WHEN $tableName.bal_day_end_date BETWEEN '{$searchParameters['start_date']}' AND '{$searchParameters['end_date']}' THEN $tableName.bal_cr
            ELSE 0
         END) AS entry_cr_balance")
            )
            ->where("$tableName.bal_account_id", '!=', 110111)
            ->where("$tableName.bal_year_id", $searchParameters['year'])
            ->where("$tableName.bal_clg_id", $user->user_clg_id)
            ->groupBy("$tableName.bal_account_id", 'financials_accounts.account_name', 'financials_coa_heads.coa_code', '2ndAba.coa_code', '1stAba.coa_code')
            ->get();

        $treeWithTotals = $balances->groupBy('1st')->map(function ($firstLevel, $firstName) {
            return [
                'name' => $firstName,
                'code' => $firstLevel->first()->{'1st_code'}, // Retrieve the first instance of the 1st code
                'opening_balance' => $firstLevel->sum('opening_balance'),
                'entry_dr_balance' => $firstLevel->sum('entry_dr_balance'),
                'entry_cr_balance' => $firstLevel->sum('entry_cr_balance'),
                'children' => $firstLevel->groupBy('2nd')->map(function ($secondLevel, $secondName) {
                    return [
                        'name' => $secondName,
                        'code' => $secondLevel->first()->{'2nd_code'}, // Retrieve the first instance of the 2nd code
                        'opening_balance' => $secondLevel->sum('opening_balance'),
                        'entry_dr_balance' => $secondLevel->sum('entry_dr_balance'),
                        'entry_cr_balance' => $secondLevel->sum('entry_cr_balance'),
                        'children' => $secondLevel->groupBy('3rd')->map(function ($thirdLevel, $thirdName) {
                            return [
                                'name' => $thirdName,
                                'code' => $thirdLevel->first()->{'3rd_code'}, // Retrieve the first instance of the 3rd code
                                'opening_balance' => $thirdLevel->sum('opening_balance'),
                                'entry_dr_balance' => $thirdLevel->sum('entry_dr_balance'),
                                'entry_cr_balance' => $thirdLevel->sum('entry_cr_balance'),
                                'accounts' => $thirdLevel->map(function ($account) {
                                    return [
                                        'code' => $account->bal_account_id,
                                        'name' => $account->account_name,
                                        'opening_balance' => $account->opening_balance,
                                        'entry_dr_balance' => $account->entry_dr_balance,
                                        'entry_cr_balance' => $account->entry_cr_balance,
                                    ];
                                })->values()
                            ];
                        })->values()
                    ];
                })->values()
            ];
        })->values();
        // Record end time
        $endTime = microtime(true);

// Calculate execution time in seconds
        $executionTime = $endTime - $startTime;

        if ($request->array) {
            return $this->generateTrialBalanceOutput($treeWithTotals, $searchParameters, $executionTime, $request->str);
        }
        return view('trial_balance', [
            'from' => $searchParameters['from'],
            'to' => $searchParameters['to'],
            'search_year' => $searchParameters['year'],
            'treeWithTotals' => $treeWithTotals,
            'executionTime' => $executionTime,
        ]);
    }

    /**
     * Extract and sanitize search parameters.
     */
    private function getSearchParameters(Request $request)
    {
        $ar = json_decode($request->array);
        $from = $request->from ?? $ar[1]->{'value'} ?? '';
        $to = $request->to ?? $ar[2]->{'value'} ?? '';
        $year = $request->year ?? $ar[3]->{'value'} ?? '';

        if (empty($from) || empty($to) || empty($year)) {
            $day_end = (new DayEndController())->day_end();
            $end_date = date("Y-m-d", strtotime($day_end->de_datetime));
            $from = $to = $end_date;
            $year = $this->getYearEndId();
        }

        return [
            'from' => $from,
            'to' => $to,
            'year' => $year,
            'start_date' => date('Y-m-d', strtotime($from)),
            'end_date' => date('Y-m-d', strtotime($to)),
            'current_year' => $this->getYearEndId(),
        ];
    }

    /**
     * Generate trial balance output as PDF or Excel.
     */
    private function generateTrialBalanceOutput($treeWithTotals, $searchParameters, $executionTime, $type)
    {
        $footer = view('print._partials.pdf_footer')->render();
        $header = view('print._partials.pdf_header', [
            'pge_title' => 'Trial Balance',
            'srch_fltr' => [$searchParameters['from'], $searchParameters['to'], $searchParameters['year']]
        ])->render();

        $options = [
            'footer-html' => $footer,
            'header-html' => $header,
        ];

        if ($type === 'pdf') {
            return PDF::loadView('print.trial_balance.trial_balance', compact('treeWithTotals', 'executionTime'))
                ->setOptions($options)
                ->stream('Trial_Balance.pdf');
        } elseif ($type === 'download_pdf') {
            return PDF::loadView('print.trial_balance.trial_balance', compact('treeWithTotals', 'executionTime'))
                ->setOptions($options)
                ->download('Trial_Balance.pdf');
        } elseif ($type === 'download_excel') {
            return Excel::download(new ExcelFileCusExport($treeWithTotals, $executionTime), 'Trial_Balance.xlsx');
        }
    }

}
