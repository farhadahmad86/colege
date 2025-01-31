<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountGroupModel;
use App\Models\AccountRegisterationModel;
use App\Models\AreaModel;
use App\Models\BalancesModel;
use App\Models\PurchaseInvoiceModel;
use App\Models\RegionModel;
use App\Models\SectorModel;
use App\User;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SupplierAgingReportController extends Controller
{
    // update code by shahzaib start
    public function supplier_aging_report(Request $request, $array = null, $str = null)
    {

        $ar = json_decode($request->array);
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->from;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_account_id = (!isset($request->account_id_aging) && empty($request->account_id_aging)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->account_id_aging;
        $search_account_name = (!isset($request->account_name_aging) && empty($request->account_name_aging)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->account_name_aging;
        $search_sale_person = (!isset($request->sale_person) && empty($request->sale_person)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->sale_person;
        $search_region = (!isset($request->region) && empty($request->region)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->region;
        $search_area = (!isset($request->area) && empty($request->area)) ? ((!empty($ar)) ? $ar[7]->{'value'} : '') : $request->area;
        $search_sector = (!isset($request->sector) && empty($request->sector)) ? ((!empty($ar)) ? $ar[8]->{'value'} : '') : $request->sector;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';

        $prnt_page_dir = 'print.supplier_aging_report.supplier_aging_report';
        $pge_title = 'Supplier Aging Report ( ' . $search_account_name . ' )';
        $srch_fltr = [];
        array_push($srch_fltr, $search_account_name, $search_from, $search_to);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $regions = RegionModel::orderBy('reg_title', 'ASC')->get();
        $areas = AreaModel::orderBy('area_title', 'ASC')->get();
        $sectors = SectorModel::orderBy('sec_title', 'ASC')->get();
        $heads = config('global_variables.payable');
        $account_lists = AccountRegisterationModel::where('account_parent_code', $heads)->orderBy('account_uid', 'ASC')->get();
        $sale_persons = User::where('user_delete_status', '!=', 1)
            ->where('user_disabled', '!=', 1)
            ->where('user_id', '!=', 1)
            ->where('user_role_id', 5)
            ->orderBy('user_role_id', 'DESC')
            ->orderBy('user_name', 'ASC')
            ->get();


        $start = date('Y-m-d', strtotime($search_from));
        $end = date('Y-m-d', strtotime($search_to));


        $query = DB::table('financials_accounts as accounts')
            ->where('account_parent_code', $heads);

        if( ( isset($search_account_id) && !empty($search_account_id) ) && $search_account_id !== "All"){
            $query->where('account_uid', $search_account_id);
        }

        if( empty($search_account_id) && ( empty($search_from) && empty($search_to) ) ){
            $query->where('account_uid', $search_account_id);
        }

        if( isset($search_sale_person) && !empty($search_sale_person) ){
            $query->where('account_sale_person', $search_sale_person);
        }

        if( isset($search_region) && !empty($search_region) ){
            $query->where('account_region_id', $search_region);
        }

        if( isset($search_area) && !empty($search_area) ){
            $query->where('account_area', $search_area);
        }

        if( isset($search_sector) && !empty($search_sector) ){
            $query->where('account_sector_id', $search_sector);
        }

        $datas = $query->orderBy('account_id', 'ASC')
            ->select('accounts.account_id', 'accounts.account_parent_code', 'accounts.account_uid', 'accounts.account_name', 'accounts.account_region_id', 'accounts.account_area', 'accounts.account_sector_id',
                \DB::raw("
                    (SELECT
                        IF( (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date < '$start' ORDER BY bal_id ASC LIMIT 1) >= 0,
                         (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date < '$start' ORDER BY bal_id DESC LIMIT 1),
                          (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date <= '$start' ORDER BY bal_id ASC LIMIT 1) ))
                    as opening_balance,

                    (SELECT SUM(bal_cr) FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' AND bal_transaction_type != 'OPENING_BALANCE' ) as total_inwards,
                    (SELECT SUM(bal_dr) FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' AND bal_transaction_type != 'OPENING_BALANCE' ) as total_outwards,
                    (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as ledger_balance_of_customer,

                    (SELECT bal_day_end_date FROM financials_balances WHERE bal_account_id = account_uid AND bal_cr != 0 AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as last_inward_transaction_date,
                    (SELECT bal_transaction_type FROM financials_balances WHERE bal_account_id = account_uid AND bal_cr != 0 AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as last_inward_transaction_type,
                    (SELECT bal_cr FROM financials_balances WHERE bal_account_id = account_uid AND bal_cr != 0 AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as last_inward_transaction_amount,

                    (SELECT bal_day_end_date FROM financials_balances WHERE bal_account_id = account_uid AND bal_dr != 0 AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as last_outward_transaction_date,
                    (SELECT bal_transaction_type FROM financials_balances WHERE bal_account_id = account_uid AND bal_dr != 0 AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as last_outward_transaction_type,
                    (SELECT bal_dr FROM financials_balances WHERE bal_account_id = account_uid AND bal_dr != 0 AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as last_outward_transaction_amount,

                    (SELECT DATEDIFF('$end', bal_day_end_date) FROM financials_balances WHERE bal_account_id = account_uid AND bal_cr != 0 AND bal_day_end_date < '$end' ORDER BY bal_id DESC LIMIT 1 ) as inward_not_received_last_days,
                    (SELECT DATEDIFF('$end', bal_day_end_date) FROM financials_balances WHERE bal_account_id = account_uid AND bal_dr != 0 AND bal_day_end_date < '$end' ORDER BY bal_id DESC LIMIT 1 ) as outward_not_received_last_days

                ")
            )
            ->paginate($pagination_number);


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl'=>[
                    'verify_peer'=>FALSE,
                    'verify_peer_name'=>FALSE,
                    'allow_self_signed'=>TRUE,
                ]
            ]);
            $optionss =[
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled'=>true, 'isRemoteEnabled'=>true]);
            $pdf->getDomPDF()->setHttpContext($options,$optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        }
        else {
            return view('supplier_aging_report', compact('datas', 'search_account_id', 'search_account_name', 'search_from', 'search_to', 'search_region', 'search_area', 'search_sector', 'account_lists', 'regions', 'areas', 'sectors', 'sale_persons', 'search_sale_person'));
        }

    }
    // update code by shahzaib end
}
