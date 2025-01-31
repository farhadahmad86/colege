<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\ExcelDataImport;
use App\Models\BalancesModel;
use App\Models\College\CustomVoucherModel;
use App\Models\College\FeePaidVoucherModel;
use App\Models\College\FeeVoucherModel;
use App\Models\College\Student;
use App\Models\College\StudentBalances;
use App\Models\College\StudentInstallment;
use App\Models\College\TransportVoucherModel;
use App\Models\PostingReferenceModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;


class FeePaidVoucherTempController extends Controller
{
    public function submit_fee_paid_voucher_excel(Request $request)
    {
        $rules = [
            'add_fee_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_fee_excel.max' => "Your File size too long.",
            'add_fee_excel.required' => "Please select your Area Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);
        $user = Auth::user();
        $posting_reference = PostingReferenceModel::where('pr_clg_id', $user->user_clg_id)->pluck('pr_id')->first();

        $postingReference = PostingReferenceModel::where('pr_clg_id', $request->user()->user_clg_id)->value('pr_id');

        if (!$request->hasFile('add_fee_excel')) {
            return response()->json(['error' => 'Excel file is required'], 422);
        }

        $path = $request->file('add_fee_excel');
        $data = Excel::toArray(new ExcelDataImport, $path);
        $excelData = json_decode(json_encode($data), false);

        $totalVoucherAmount = 0;
        $accountId = $request->account;
        $accountName = $this->get_account_name($accountId);

        $accountsVal = [];
        $entryAccountsVal = [];
        $voucherNoNotFound = [];
        $registrationNoNotFound = [];

        foreach ($excelData as $rows) {
            foreach ($rows as $row) {
                $rowData = (array)$row;
                $request->merge($rowData);

                if (!isset($request->voucher_no)) {
                    continue;
                }

                $feeVoucher = $this->fetchVoucherData($request, $request->user());
                if (!$feeVoucher) {
                    $voucherNoNotFound[] = $request->voucher_no;
                    continue;
                }

                $student = Student::where('registration_no', $request->std_id)
                    ->where('clg_id', $request->user()->user_clg_id)
                    ->select('id', 'full_name', 'class_id')
                    ->first();

                if (!$student) {
                    $registrationNoNotFound[] = $request->std_id;
                    continue;
                }

                $fineAmount = $this->calculateFineAmount($feeVoucher, $request->amount);
                $voucherPaidDate = date('Y-m-d', strtotime($request->date));

                $entryAccountsVal[] = $this->prepareEntryAccount(
                    $feeVoucher, $student, $request, $fineAmount, $voucherPaidDate, $postingReference
                );

                $accountsVal = array_merge(
                    $accountsVal,
                    $this->prepareAccounts($feeVoucher, $student, $request, $fineAmount, $postingReference)
                );

                $totalVoucherAmount += $request->amount;
            }
        }

        return response()->json([
            'total_voucher_amount' => $totalVoucherAmount,
            'voucher_no_not_found' => $voucherNoNotFound,
            'registration_no_not_found' => $registrationNoNotFound,
            'entry_accounts' => $entryAccountsVal,
            'accounts' => $accountsVal,
        ]);
    }

    private function fetchVoucherData(Request $request, $user)
    {
        $voucherType = substr($request->voucher_no, 0, 1);
        $voucherModel = match ($voucherType) {
            '7', '3' => FeeVoucherModel::class,
            '9' => CustomVoucherModel::class,
            '5' => TransportVoucherModel::class,
            default => null,
        };

        if (!$voucherModel) {
            return null;
        }
        if ($voucherType == 3 || $voucherType == 7) {
            $prfix = 'fv_';
        }else if ($voucherType == 9) {
            $prfix = 'cv_';
        }else if ($voucherType == 5) {
            $prfix = 'tv_';
        }
        return $voucherModel::where($prfix.'v_no', $request->voucher_no)
            ->where($prfix.'reg_no', $request->std_id)
            ->where($prfix.'clg_id', $user->user_clg_id)
            ->first();
    }

    private function calculateFineAmount($voucher, $amount)
    {
        return $voucher->total_amount < $amount ? $amount - $voucher->total_amount : 0;
    }

    private function prepareEntryAccount($voucher, $student, $request, $fineAmount, $voucherPaidDate, $postingReference)
    {
        return [
            'account_code' => '110201',
            'account_name' => '110201 - Tuition Fee Receivable HO',
            'account_amount' => $voucher->total_amount,
            'voucher_no' => $request->voucher_no,
            'std_id' => $student->id,
            'reg_no' => $request->std_id,
            'date' => $voucherPaidDate,
            'fine_account_code' => '311131',
            'fine_account_name' => '311131 - Fine Income HO',
            'fine_amount' => $fineAmount,
            'class' => $voucher->class_id,
            'branch_id' => $voucher->branch_id,
            'posting_reference' => $postingReference,
            'total_account_amount' => $request->amount,
            'account_remarks' => '',
        ];
    }

    private function prepareAccounts($voucher, $student, $request, $fineAmount, $postingReference)
    {
        $accounts = [
            [
                'account_code' => '110201',
                'account_name' => '110201 - Tuition Fee Receivable HO',
                'account_amount' => $voucher->total_amount,
                'type' => 'Cr',
                'description' => "{$request->std_id} - {$student->full_name}",
                'posting_reference' => $postingReference,
            ],
        ];

        if ($fineAmount > 0) {
            $accounts[] = [
                'account_code' => '311131',
                'account_name' => '311131 - Fine Income HO',
                'account_amount' => $fineAmount,
                'type' => 'Cr',
                'description' => "{$request->std_id} - {$student->full_name}",
                'posting_reference' => $postingReference,
            ];
        }

        return $accounts;
    }
}
