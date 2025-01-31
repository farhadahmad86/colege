<?php

namespace App\Http\Controllers;

use App\Exports\IncomeStatementExport;
use App\Exports\TrialBalanceExport;
use App\Mail\DailyReport;
use App\Models\AccountHeadsModel;
use App\Models\AccountOpeningClosingBalanceModel;
use App\Models\AccountRegisterationModel;
use App\Models\BalanceSheetItemsModel;
use App\Models\BalanceSheetModel;
use App\Models\BalancesModel;
use App\Models\DayEndModel;
use App\Models\IncomeStatementItemsModel;
use App\Models\IncomeStatementModel;
use App\Models\InventoryModel;
use App\Models\ProductCostingModel;
use App\Models\ProductModel;
use App\Models\PurchaseInvoiceItemsModel;
use App\Models\PurchaseInvoiceModel;
use App\Models\SaleInvoiceModel;
use App\User;
use Auth;
use PDF;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\RequestException;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Mail;

class DayEndController extends Controller
{

    public function nabeel_day_end(){
        $trialViewList = array();
        $user = Auth::user();
        $first = AccountHeadsModel::select('coa_code', 'coa_head_name', 'coa_level')->where('coa_clg_id',$user->user_clg_id)->where('coa_level',1)->get();

        $second = AccountHeadsModel::select('coa_code', 'coa_head_name', 'coa_level')->where('coa_clg_id',$user->user_clg_id)->where('coa_level',2)->get();

        $third = AccountHeadsModel::select('coa_code', 'coa_head_name', 'coa_level')->where('coa_clg_id',$user->user_clg_id)->where('coa_level',3)->get();

        $all = AccountHeadsModel::select('coa_code', 'coa_head_name', 'coa_level')->where('coa_clg_id',$user->user_clg_id)->get();

        $entryQuery = AccountRegisterationModel::select('account_uid', 'account_name',
            'account_today_opening_type', 'account_today_opening', 'account_today_debit', 'account_today_credit',
            'account_monthly_opening_type', 'account_monthly_opening', 'account_monthly_debit', 'account_monthly_credit','account_balance')->where('account_parent_code',11010)->where('account_clg_id',
                $user->user_clg_id)->get();

//        dd($first,$second,$third,$entryQuery);

        $trialBalanceHTMLReport = '';

        return view('nabeel_day_end',compact('first','second','third','all'));
    }

    public function nabeel_day_end_array(){
        $trialViewList = array();
        $user = Auth::user();
        $first = AccountHeadsModel::select('coa_code', 'coa_head_name', 'coa_level')->where('coa_clg_id',$user->user_clg_id)->where('coa_level',1)->get();

        foreach ($first as $ff){

            $controlCode = $ff['coa_code'];
            $controlName = $ff['coa_head_name'];
            $controlLevel = $ff['coa_level'];

            $trialViewList[$controlCode] =
                array('parent' => 0, 'code' => $controlCode, 'name' => "$controlName", 'level' => $controlLevel, 'child' => array(), 'type' => '', 'opening' => 0.00, 'inwards' => 0.00, 'outwards' => 0.00, 'balance' => 0.00);

            $parent = AccountHeadsModel::select('coa_code', 'coa_head_name', 'coa_level')->where('coa_clg_id',$user->user_clg_id)->where('coa_parent',$ff->coa_code)->get();
            $parent_balance = 0;

            foreach ($parent as $pa) {

                $parentCode = $pa['coa_code'];
                $parentName = $pa['coa_head_name'];
                $parentLevel = $pa['coa_level'];

                $trialViewList[$controlCode]['child'][$parentCode] =
                    array('parent' => $controlCode, 'code' => $parentCode, 'name' => "$parentName", 'level' => $parentLevel, 'child' => array(), 'type' => '', 'opening' => 0.00, 'inwards' => 0.00, 'outwards' => 0.00, 'balance' => 0.00);

                $child = AccountHeadsModel::select('coa_code', 'coa_head_name', 'coa_level')->where('coa_clg_id',$user->user_clg_id)->where('coa_parent',$pa->coa_code)->get();
                $balance = 0;


                foreach ($child as $ch) {

                    $childBalance = 0;

                    $childCode = $ch['coa_code'];
                    $childName = $ch['coa_head_name'];
                    $childLevel = $ch['coa_level'];
                    $entryAccounts = array();

                    $entryQuery = AccountRegisterationModel::select('account_uid', 'account_name',
                        'account_today_opening_type', 'account_today_opening', 'account_today_debit', 'account_today_credit',
                        'account_monthly_opening_type', 'account_monthly_opening', 'account_monthly_debit', 'account_monthly_credit','account_balance')->where('account_parent_code',$ch->coa_code)
                        ->where('account_clg_id',$user->user_clg_id)->get();


                    foreach ($entryQuery as $entry) {

                        $balance += $entry->account_balance;
                        $parent_balance += $entry->account_balance;
                        $childBalance += $entry->account_balance;


                        $entryCode = $entry->account_uid;
                        $entryName = $entry->account_name;
                        $entryLevel = 4;
                        $entryBalance = $entry->account_balance;



                        $entryAccounts[$entryCode] =
                            array('parent' => $childCode, 'code' => $entryCode, 'name' => "$entryName", 'level' => $entryLevel, 'type' => '', 'opening' => '', 'inwards' => '', 'outwards' => '', 'balance' => $entryBalance);

                    }
//                    if (count($entryAccounts) > 0) {
//                        $trialViewList[$controlCode]['child'][$parentCode]['child'][$childCode] =
//                            array('parent' => $parentCode, 'code' => $childCode, 'name' => "$childName", 'level' => 3, 'child' => array(), 'type' => '', 'opening' => 0.00, 'inwards' => 0.00, 'outwards' => 0.00, 'balance' => 0.00);
//
//                        $trialViewList[$controlCode]['child'][$parentCode]['child'][$childCode]['child'] = $entryAccounts;
//                    }
                    $trialViewList[$controlCode]['child'][$parentCode]['balance'] = $childBalance;

                }
                $trialViewList[$entryCode]['balance'] = $balance;

//                $trialViewList[$controlCode]['child'][$parentCode]['balance'] = $balance;
            }
            $trialViewList[$controlCode]['balance'] = $parent_balance;
        }


        dd($trialViewList);



        return view('nabeel_day_end_array',compact('first','second','third','all'));
    }



    public function nabeel_balance_sheet(){

        $balanceSheetHTMLReport = '';
        $user=Auth::user();

        $trialViewList = array();

        $first = AccountHeadsModel::select('coa_code', 'coa_head_name', 'coa_level')->where('coa_clg_id',$user->user_clg_id)->where('coa_level',1)->get();

        foreach ($first as $ff){

            $controlCode = $ff['coa_code'];
            $controlName = $ff['coa_head_name'];
            $controlLevel = $ff['coa_level'];

            $trialViewList[$controlCode] =
                array('parent' => 0, 'code' => $controlCode, 'name' => "$controlName", 'level' => $controlLevel, 'child' => array(), 'type' => '', 'opening' => 0.00, 'inwards' => 0.00, 'outwards' => 0.00, 'balance' => 0.00);

            $parent = AccountHeadsModel::select('coa_code', 'coa_head_name', 'coa_level')->where('coa_clg_id',$user->user_clg_id)->where('coa_parent',$ff->coa_code)->get();
            $parent_balance = 0;

            foreach ($parent as $pa) {

                $parentCode = $pa['coa_code'];
                $parentName = $pa['coa_head_name'];
                $parentLevel = $pa['coa_level'];

                $trialViewList[$controlCode]['child'][$parentCode] =
                    array('parent' => $controlCode, 'code' => $parentCode, 'name' => "$parentName", 'level' => $parentLevel, 'child' => array(), 'type' => '', 'opening' => 0.00, 'inwards' => 0.00, 'outwards' => 0.00, 'balance' => 0.00);

                $child = AccountHeadsModel::select('coa_code', 'coa_head_name', 'coa_level')->where('coa_clg_id',$user->user_clg_id)->where('coa_parent',$pa->coa_code)->get();
                $balance = 0;


                foreach ($child as $ch) {

                    $childCode = $ch['coa_code'];
                    $childName = $ch['coa_head_name'];
                    $childLevel = $ch['coa_level'];
                    $entryAccounts = array();

                    $entryQuery = AccountRegisterationModel::select('account_uid', 'account_name',
                        'account_today_opening_type', 'account_today_opening', 'account_today_debit', 'account_today_credit',
                        'account_monthly_opening_type', 'account_monthly_opening', 'account_monthly_debit', 'account_monthly_credit','account_balance')->where('account_parent_code',$ch->coa_code)
                        ->where('account_clg_id',$user->user_clg_id)->get();


                    foreach ($entryQuery as $entry) {

                        $balance += $entry->account_balance;
                        $parent_balance += $entry->account_balance;


                        $entryCode = $entry->account_uid;
                        $entryName = $entry->account_name;
                        $entryLevel = 4;
                        $entryBalance = $entry->account_balance;



                        $entryAccounts[$entryCode] =
                            array('parent' => $childCode, 'code' => $entryCode, 'name' => "$entryName", 'level' => $entryLevel, 'type' => '', 'opening' => '', 'inwards' => '', 'outwards' => '', 'balance' => $entryBalance);

                    }
                    if (count($entryAccounts) > 0) {
                        $trialViewList[$controlCode]['child'][$parentCode]['child'][$childCode] =
                            array('parent' => $parentCode, 'code' => $childCode, 'name' => "$childName", 'level' => 3, 'child' => array(), 'type' => '', 'opening' => 0.00, 'inwards' => 0.00, 'outwards' => 0.00, 'balance' => 0.00);

                        $trialViewList[$controlCode]['child'][$parentCode]['child'][$childCode]['child'] = $entryAccounts;
                    }
                }

                $trialViewList[$controlCode]['child'][$parentCode]['balance'] = $balance;
            }
            $trialViewList[$entryCode]['balance'] = $parent_balance;

        }

        dd($trialViewList);



        return view('nabeel_day_end_array',compact('first','second','third','all'));
    }


    public function nabeel_income_statement(){

        $search_to = '2022-04-01';
        $search_from = '2022-04-30';
        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $sale = 0;
        $sale_return = 0;

        $trial_view_list = array();
        if (!empty($end)) {

            $controls = AccountHeadsModel::where('coa_level', 1)->orderBy('coa_code', 'ASC')->select('coa_code', 'coa_head_name', 'coa_level')->get();

            foreach ($controls as $control) {
                $control_code = $control->coa_code;
                $control_name = $control->coa_head_name;
                $trial_view_list[$control_code] = array('parent' => 0, 'code' => $control_code, 'name' => $control_name, 'level' => 1, 'child' => array(), 'type' => '', 'opening' => 0.00, 'inward' => 0.00, 'outward' => 0.00, 'balance' => 0.00);
                $parents = AccountHeadsModel::where('coa_parent', $control->coa_code)->orderBy('coa_code', 'ASC')->select('coa_code', 'coa_head_name', 'coa_level')->get();
                foreach ($parents as $parent) {
                    $parent_code = $parent->coa_code;
                    $parent_name = $parent->coa_head_name;

                    $childs_accounts = array();

                    $trial_view_list[$control_code]['child'][$parent_code] = array('parent' => $control_code, 'code' => $parent_code, 'name' => $parent_name, 'level' => 2, 'child' => array(), 'type' => '', 'opening' => 0.00, 'inward' => 0.00, 'outward' => 0.00, 'balance' => 0.00);
                    $childs = AccountHeadsModel::where('coa_parent', $parent->coa_code)->orderBy('coa_code', 'ASC')->select('coa_code', 'coa_head_name', 'coa_level')->get();

                    foreach ($childs as $child) {
                        $child_code = $child->coa_code;
                        $child_name = $child->coa_head_name;
                        $entry_accounts = array();

//                    $trial_view_list[$control_code]['child'][$parent_code]['child'][$child_code] = array('parent'=>$parent_code,'code'=>$child_code,'name'=>$child_name,'level'=>3,'child'=>array(),
//                        'type'=>'','opening'=>0.00,'inward'=>0.00,'outward'=>0.00,'balance'=> 0.00);
                        $child_balance = 0;
                        $child_inward = 0;
                        $child_outward = 0;
                        $query = DB::table('financials_accounts as accounts')
                            ->where('account_parent_code', $child_code);
                        $entries = $query->orderBy('account_id', 'ASC')
                            ->select('accounts.account_id', 'accounts.account_parent_code', 'accounts.account_uid', 'accounts.account_name',
                                \DB::raw("
                    (SELECT
                        IF( (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date < '$end' ORDER BY bal_id ASC LIMIT 1) >= 0,
                         (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date < '$end' ORDER BY bal_id DESC LIMIT 1),
                          (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date <= '$end' ORDER BY bal_id DESC LIMIT 1) ))
                    as opening_balance,
                    (SELECT SUM(bal_dr) FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' AND bal_transaction_type != 'OPENING_BALANCE' ) as total_inwards,
                    (SELECT SUM(bal_cr) FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' AND bal_transaction_type != 'OPENING_BALANCE' ) as total_outwards,
                    (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as ledger_balance_of_customer

                ")
                            )
                            ->get();


                        foreach ($entries as $entry) {
                            $entry_code = $entry->account_uid;
                            $entry_name = $entry->account_name;
                            $entry_balance = $entry->opening_balance;
                            $entry_inward = $entry->total_inwards;
                            $entry_outward = $entry->total_outwards;

                            if ($control_code == 4) {

                                if ($entry_code == 310101){
                                    $sale = $sale + $entry_balance;
                                }
                                if ($entry_code == 310102){
                                    $sale_return = $sale_return + $entry_balance;
                                }

                                if ($entry_outward > 0 ) {

                                    $trial_view_list[$control_code]['balance'] = $trial_view_list[$control_code]['balance'] + $entry_outward;



                                    $trial_view_list[$control_code]['child'][$parent_code]['balance'] = $trial_view_list[$control_code]['child'][$parent_code]['balance'] + $entry_outward;

                                    $child_balance = $child_balance + $entry_outward;
                                } else {

                                    $trial_view_list[$control_code]['balance'] = $trial_view_list[$control_code]['balance'] - $entry_inward;

                                    $balanceBF = $trial_view_list[$control_code]['balance'] - $entry_inward;

                                    $trial_view_list[$control_code]['child'][$parent_code]['balance'] = $trial_view_list[$control_code]['child'][$parent_code]['balance'] - $entry_inward;

                                    $child_balance = $child_balance - $entry_inward;
                                }
                            } else {
                                $trial_view_list[$control_code]['balance'] = $trial_view_list[$control_code]['balance'] + $entry_balance;

//                                by nabeel
                                $balanceBF = $trial_view_list[$control_code]['balance'] + $entry_balance;

                                $trial_view_list[$control_code]['child'][$parent_code]['balance'] = $trial_view_list[$control_code]['child'][$parent_code]['balance'] + $entry_balance;

                                $child_balance = $child_balance + $entry_balance;
                            }

                            // control head start calculation

                            $trial_view_list[$control_code]['inward'] = $trial_view_list[$control_code]['inward'] + $entry_inward;
                            $trial_view_list[$control_code]['outward'] = $trial_view_list[$control_code]['outward'] + $entry_outward;
                            // control head end calculation
                            // parent head start calculation

                            $trial_view_list[$control_code]['child'][$parent_code]['inward'] = $trial_view_list[$control_code]['child'][$parent_code]['inward'] + $entry_inward;
                            $trial_view_list[$control_code]['child'][$parent_code]['outward'] = $trial_view_list[$control_code]['child'][$parent_code]['outward'] + $entry_outward;
                            // parent head end calculation
                            // child head end calculation

                            $child_inward = $child_inward + $entry_inward;
                            $child_outward = $child_outward + $entry_outward;
                            // child head end calculation
                            $entry_accounts[$entry_code] = array('parent' => $child_code, 'code' => $entry_code, 'name' => $entry_name, 'level' => 4, 'type' => '', 'opening' => $entry_balance, 'inward' => $entry_inward, 'outward' => $entry_outward, 'balance' => $entry_balance);
                        }
                        if (count($entries) > 0) {
                            $trial_view_list[$control_code]['child'][$parent_code]['child'][$child_code] = array('parent' => $parent_code, 'code' => $child_code, 'name' => $child_name, 'level' => 3, 'child' => array(), 'type' => '',
                                'opening' => 0.00, 'inward' => 0.00, 'outward' => 0.00, 'balance' => 0.00);

                            $trial_view_list[$control_code]['child'][$parent_code]['child'][$child_code]['balance'] = $child_balance;
                            $trial_view_list[$control_code]['child'][$parent_code]['child'][$child_code]['inward'] = $child_inward;
                            $trial_view_list[$control_code]['child'][$parent_code]['child'][$child_code]['outward'] = $child_outward;
                            $trial_view_list[$control_code]['child'][$parent_code]['child'][$child_code]['child'] = $entry_accounts;
                        }

                    }
                    if (count($trial_view_list[$control_code]['child'][$parent_code]['child']) == 0) {
                        unset($trial_view_list[$control_code]['child'][$parent_code]);
                    }

                }

            }
        }




        //        variables
        $incomeStatementHTMLReport = '';
        $netProfitOrLoss = 'Profit';
        $netProfitOrLossAmount = 0;
        $netProfitOrLossAbsoluteAmount = 0;
        $incomeStatementError = false;
        $incomeStatementErrorMessage = "";

        $NET_SALES_CODE = 11;
        $CGS_CODE = 12;
        $CGS_PURCHASES_CODE = 120; // change to cgsEntry function also
        $GROSS_REVENUE_CODE = 13;
        $NET_OPERATING_INCOME_CODE = 14;



//        Arays
        $pnlSalesEntryList = array();
        $pnlCGSEntryList = array();
        $grossRevenueEntry = array();
        $pnlExpensesList = array();
        $netOperatingIncomeEntry = array();
        $pnlOtherRevenueList = array();
        $pnlSalesChildList = array();

        $pnlSalesChildList[] = array('parent' => $NET_SALES_CODE, 'code' => 310101, 'name' => "Sales", 'level' => 4, 'balance' => $sale);
        $pnlSalesChildList[] = array('parent' => $NET_SALES_CODE, 'code' => 310102, 'name' => "Sales Return", 'level' => 4, 'balance' => $sale_return);



        dd($trial_view_list[$control_code]['child'][$parent_code]);
        dd($trial_view_list[4]['child'][415]['balance']);



        return view('nabeel_day_end_array',compact('first','second','third','all'));
    }





    public function day_end_start_date()
    {
        $user = Auth::user();
        $start_date = DayEndModel::where('de_clg_id',$user->user_clg_id)->pluck('de_datetime')->first();

        $end_date = DayEndModel::where('de_clg_id',$user->user_clg_id)->orderBy('de_id', 'DESC')->pluck('de_datetime')->first();
        if ($start_date == null) {
            $start_date = date("d-m-Y");
            $end_date = date("d-m-Y");
        } else {
            $start_date = date("d-m-Y", strtotime($start_date));
            $end_date = date("d-m-Y", strtotime($end_date));
        }
        $formatted_dt1 = Carbon::parse($end_date);

        $formatted_dt2 = Carbon::parse($start_date);

        $diff_in_days = $formatted_dt1->diffInDays($formatted_dt2);

        return $diff_in_days;
    }









    public function day_end_date()
    {
        $user = Auth::user();
        $date = DayEndModel::where('de_clg_id',$user->user_clg_id)->where('de_datetime_status', 'OPEN')->orderBy('de_id', 'DESC')->pluck('de_datetime')->first();

        if ($date == null) {
            $date = date("d-m-Y");
        } else {
            $date = date("d-m-Y", strtotime($date));
        }

        return $date;
    }

    public function day_end()
    {
        $user = Auth::user();
        $date = DayEndModel::where('de_clg_id',$user->user_clg_id)->orderBy('de_id', 'DESC')->first();//where('de_datetime_status', 'OPEN')->

        if ($date === null) {
            $date = (object)array(
                "de_id" => "0",
                "de_datetime" => date("Y-m-d"),
            );
        }
        return $date;
    }

    public function start_day_end()
    {

        $user = Auth::user();
        $dynd_status = 'LOCKED';
        $dynd_id = $this->day_end();
        $chkStts = DayEndModel::where('de_clg_id',$user->user_clg_id)->where('de_id',$dynd_id->de_id)->first();
        if( !empty($dynd_id->de_id) ) {
            if (!empty($chkStts) && $chkStts->de_status === 'LOCKED') {
                $dynd_status = 'UN_LOCKED';
            }
            else if (!empty($chkStts) && $chkStts->de_status === 'UN_LOCKED') {
                $dynd_status = 'LOCKED';
            }
        }

        return view('start_day_end', compact('dynd_status'));
    }



    // create code by shahzaib start
    public function execute_day_end( Request $request, $array = null, $str = null, $tableformat = null )
    {
        $user =Auth::user();
        $ar = json_decode($request->array);
        $uid = (!isset($request->uid) && empty($request->uid)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->uid;
        $upass = (!isset($request->upassword) && empty($request->upassword)) ? ((!empty($ar)) ? $ar[0]->{'value'} : '') : $request->upassword;
        $tbformat = (isset($request->tableformat) && !empty($request->tableformat) ) ? $request->tableformat : '0';
        $type = (isset($request->str) && !empty($request->str) ) ? $request->str : 'web';
        $pge_title = 'Day End';
        $srch_fltr = [];
        $tb_format = '';
        if($tbformat === '0'){
            $tb_format = 'Short Format';
        }
        else if($tbformat === '1'){
            $tb_format = 'Medium Format';
        }
        else if($tbformat === '2'){
            $tb_format = 'Detail Format';
        }
        else if($tbformat === '3'){
            $tb_format = 'Full Detail Format';
        }
        else{
            $tb_format = 'Short Format';
        }
        array_push($srch_fltr, 'Day End In '.$tb_format);



        $user = User::where('user_clg_id',$user->user_clg_id)->where('user_id', '=', $uid)->first();
        if(Hash::check($upass, $user->user_password)) {

            $endpoint = config('global_variables.execute_day_end');
            $client = new Client();

            $response = $client->request('POST',  $endpoint, [
                'form_params' => [
                    'uid' => $uid,
                    'upass' => $upass,
                    'from' => 'web',
                    'type' => $type,
                    'clg_id' => $user->user_clg_id,
                    'tbformat' => $tbformat,
                ]
            ]);

            $content = $response->getBody()->getContents();
            // $statusCode = $response->getStatusCode();
            // $content = json_decode($response->getBody(), true);


            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title','srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = PDF::loadHTML($content);
            $pdf->setOptions($options);

            if( $type === 'pdf') {
                return $pdf->stream($pge_title.'_x.pdf');
            }
            else if( $type === 'download_pdf') {
                return $pdf->download($pge_title.'_x.pdf');
            }
            else {

                return response()->json(['status'=>'true','message'=>'Successfully Executed', 'data'=>$content]);
//                return response()->json(['status'=>'true','message'=>'Successfully Executed', 'data'=>$content]);
            }
        }
        else {
            return response()->json(['status'=>'false','message'=>'password is Incorrect']);
        }

    }
    // create code by shahzaib end


    // create code by shahzaib start
    public function day_end_report( Request $request, $array = null, $str = null, $tableformat = null )
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $uid = (!isset($request->uid) && empty($request->uid)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->uid;
        $upass = (!isset($request->upassword) && empty($request->upassword)) ? ((!empty($ar)) ? $ar[0]->{'value'} : '') : $request->upassword;
        $tbformat = (isset($request->tableformat) && !empty($request->tableformat) ) ? $request->tableformat : 0;
        $type = (isset($request->str) && !empty($request->str) ) ? $request->str : 'web';
        $pge_title = 'Day End';
        $srch_fltr = [];
        $tb_format = '';
        if($tbformat === '0'){
            $tb_format = 'Short Format';
        }
        else if($tbformat === '1'){
            $tb_format = 'Medium Format';
        }
        else if($tbformat === '2'){
            $tb_format = 'Detail Format';
        }
        else if($tbformat === '3'){
            $tb_format = 'Full Detail Format';
        }
        else{
            $tb_format = 'Short Format';
        }
        array_push($srch_fltr, 'Day End In '.$tb_format);


        $user = User::where('user_clg_id',$user->user_clg_id)->where('user_id', '=', $uid)->first();
        $endpoint = config('global_variables.day_end_report');
        $client = new Client();
        $response = $client->request('POST',  $endpoint, [
            'form_params' => [
                'uid' => $uid,
                'upass' => $upass,
                'from' => 'web',
                'type' => $type,
                'clg_id' => $user->user_clg_id,
                'tbformat' => $tbformat,
            ]
        ]);

        $content = $response->getBody()->getContents();

        $footer = view('print._partials.pdf_footer')->render();
        $header = view('print._partials.pdf_header', compact('pge_title','srch_fltr'))->render();
        $options = [
            'footer-html' => $footer,
            'header-html' => $header,
        ];

        $pdf = PDF::loadHTML($content);
        $pdf->setOptions($options);

        if( $type === 'pdf') {
            return $pdf->stream($pge_title.'_x.pdf');
        }
        else if( $type === 'download_pdf') {
            return $pdf->download($pge_title.'_x.pdf');
        }
        else {
            return response()->json(['status'=>'true','message'=>'Successfully Executed', 'data'=>$content], 200);
        }

    }
    // create code by shahzaib end

    // create code by shahzaib start
    public function day_end_unlock(Request $request){
        $user = Auth::user();
        $uid = (!isset($request->lck_un_lck_duid) && empty($request->lck_un_lck_duid)) ? '' : $request->lck_un_lck_duid;
        $upass = (!isset($request->lck_un_lck_pass) && empty($request->lck_un_lck_pass)) ? '' : $request->lck_un_lck_pass;

        $dynd_status = 'LOCKED';
        $dynd_id = $this->day_end();

        $user = User::where('user_clg_id',$user->user_clg_id)->where('user_id', '=', $uid)->first();
        $chkStts = DayEndModel::where('de_clg_id',$user->user_clg_id)->where('de_id',$dynd_id->de_id)->first();
//        dd($chkStts, $dynd_id->de_id);
        $query = DB::table('financials_day_end');

        if(Hash::check($upass, $user->user_password)) {
            if( !empty($dynd_id->de_id) ) {
                $query->where('de_id', $dynd_id->de_id);
//                dd($chkStts->de_status, $dynd_id->de_id);
                if (!empty($chkStts) && $chkStts->de_status === 'LOCKED') {
                    $query->where('de_status', 'LOCKED')
                        ->update(['de_status' => 'UN_LOCKED']);
                    $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Unlocked Day End');
                    $dynd_status = 'LOCKED';
                    Session::flash('success','Day End Successfully Unlocked');
                    return redirect()->back();
                }
                else if (!empty($chkStts) && $chkStts->de_status === 'UN_LOCKED') {
                    $query->where('de_status', 'UN_LOCKED')
                        ->update(['de_status' => 'LOCKED']);
                    $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Locked Day End');
                    $dynd_status = 'UN_LOCKED';
                    Session::flash('success','Day End Successfully Locked');
                    return redirect()->back();
                }
                else {
                    Session::flash('fail','Some Thing Went Wrong. Unable To Find the System Status');
                    return redirect()->back();
                }
            }
            else {
                Session::flash('fail','Some Thing Went Wrong. Unable To Find the Current System Date');
                return redirect()->back();
            }
        }
        else {
            Session::flash('fail','Incorrect Password. Try Again');
            return redirect()->back();
        }


    }
    // create code by shahzaib end


    public function close_day_end()
    {
        $user = Auth::user();
        $email_to = User::where('user_clg_id',$user->user_clg_id)->where('user_id', 1)->pluck('user_email')->first();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        DB::beginTransaction();

        $check_inventory = $this->check_inventory();
        $check_warehouse = $this->check_warehouse();
        $check_cash_account = $this->check_cash_account($day_end);
        $check_stock_account = $this->check_stock_account($day_end);
        $check_bank_account = $this->check_bank_account($day_end);
        $product_average_costing = $this->product_average_costing($day_end);
        $account_opening_closing = $this->account_opening_closing($day_end);
        $income = $this->income_statement($day_end);
        $balance_sheet = $this->balance_sheet($day_end);
//        $sale_tax = $this->sale_tax($day_end);


        if ($check_inventory > 0) {
            return redirect('index')->with('fail', 'Some product stock is negative.Make sure it could be 0 or Positive');
        }

        if ($check_warehouse == 0) {
            return redirect('index')->with('fail', 'Some product stock is negative in any warehouse. Make sure it could be 0 or Positive');
        }

        if ($check_cash_account > 0) {

            return redirect('index')->with('fail', 'Cash Account/s is negative. Make sure it could be 0 or Positive');
        }

        if ($check_stock_account > 0) {
            return redirect('index')->with('fail', 'Stock Account/s is negative. Make sure it could be 0 or Positive');
        }

        if ($check_bank_account > 0) {
            return redirect('index')->with('fail', 'Bank Account/s is negative. Make sure it could be 0 or Positive');
        }

        if ($product_average_costing == 0) {
            return redirect('index')->with('fail', 'Product Costing Not Successful. Try Again Later');//Some Thing Went Wrong. Try Again Later
        }

        if ($account_opening_closing == 0) {
            return redirect('index')->with('fail', 'Account Closing Balance Not Successful. Try Again Later');//Some Thing Went Wrong. Try Again Later
        }

        if ($income == 0) {
            return redirect('index')->with('fail', 'Income Statement Gone Wrong');//Some Thing Went Wrong. Try Again Later
        }

        if ($balance_sheet == 0) {
            return redirect('index')->with('fail', 'Balance Sheet Gone Wrong');//Some Thing Went Wrong. Try Again Later
        }

//        $product_costings = DB::table('financials_product_costing')
//            ->join('financials_products', 'financials_products.pro_code', '=', 'financials_product_costing.pc_pro_id')
//            ->where('pc_day_end_date', $day_end->de_datetime)
//            ->orderby('pc_pro_id', 'ASC')
//            ->get();
//
////        $product_costings= ProductCostingModel::where('pc_day_end_date',$day_end->de_datetime)->get();
//        $trial_balances = AccountOpeningClosingBalanceModel::where('aoc_day_end_date', $day_end->de_datetime)->get();
//
//        $income_statement = IncomeStatementModel::where('is_day_end_date', $day_end->de_datetime)->first();
//
//        if ($income_statement) {
//            $accounts = IncomeStatementItemsModel::where('isi_income_statement_id', $income_statement->is_id)->get();
//        }
//
//        $balance_sheets = BalanceSheetModel::where('bs_day_end_date', $day_end->de_datetime)->first();
//
//        if ($balance_sheets) {
//            $balance_sheet_items = BalanceSheetItemsModel::where('bsi_balance_sheet_id', $balance_sheets->bs_id)->get();
//        }
//
//        DB::rollBack();
//        return view('day_end_report', compact('trial_balances', 'income_statement', 'accounts', 'product_costings','balance_sheets','balance_sheet_items'));


        if ($check_inventory == 0 && $check_cash_account == 0 && $check_stock_account == 0 && $check_bank_account == 0 && $product_average_costing == 1 && $account_opening_closing == 1 && $income == 1 && $check_warehouse == 1 && $balance_sheet == 1) {

            $run_day_end = $this->run_day_end();

            if ($run_day_end == 1) {
                DB::commit();

                $trial_path = 'public/Trial Balance/trial_balance' . date("Y-m-d", strtotime("-1 day", strtotime($day_end->de_datetime))) . '.xls';
                $income_path = 'public/Income Statement/income_statement' . date("Y-m-d", strtotime("-1 day", strtotime($day_end->de_datetime))) . '.xls';

                Excel::store(new TrialBalanceExport, $trial_path);
                Excel::store(new IncomeStatementExport, $income_path);
                Mail::to($email_to)->send(new DailyReport('storage/app/' . $trial_path, 'storage/app/' . $income_path));
//                DB::rollBack();
                return redirect('index')->with('success', 'Day End Run Successfully');
            } else {
                DB::rollBack();
                return redirect('index')->with('fail', 'Day End Failed! Try again later');
            }

        } else {
            DB::rollBack();
            return redirect('index')->with('fail', 'Day End Failed! Try again later');
        }

    }

    public function check_inventory()
    {
        $check_inventory = InventoryModel::where('invt_available_stock', '<', 0)->count();

        return $check_inventory;
    }

    public function check_warehouse()
    {
        $user = Auth::user();
        $check_quantity = 1;

        $check_warehouses = DB::table('financials_warehouse_stock')
            ->join('financials_products', 'financials_products.pro_code', '=', 'financials_warehouse_stock.whs_product_code')
            ->join('financials_warehouse', 'financials_warehouse.wh_id', '=', 'financials_warehouse_stock.whs_warehouse_id')
            ->where('whs_clg_id',$user->user_clg_id)
            ->where('pro_clg_id',$user->user_clg_id)
            ->where('wh_clg_id',$user->user_clg_id)
            ->select('pro_code as product_code', 'pro_title as title', 'wh_title as warehouse', 'whs_stock as quantity')
            ->get();

        foreach ($check_warehouses as $check_warehouse) {

            if ($check_warehouse->quantity < 0) {
                $check_quantity = 0;
            }
        }

        return $check_quantity;
    }

    public function check_cash_account($day_end)
    {
        $user = Auth::user();
        $cash_accounts = AccountRegisterationModel::where('account_clg_id',$user->user_clg_id)->where('account_parent_code', config('global_variables.cash'))->get();

        $count = 0;

        foreach ($cash_accounts as $cash_account) {

            $check_cash_account = BalancesModel::where('bal_clg_id',$user->user_clg_id)->where('bal_account_id', $cash_account->account_uid)->where('bal_day_end_date', $day_end->de_datetime)
                ->orderBy('bal_id', 'DESC')->first();

            if (!empty($check_cash_account->bal_total)) {
                if ($check_cash_account->bal_total < 0) {
                    $count++;
                }
            }

        }

        return $count;
    }

    public function check_stock_account($day_end)
    {
        $user = Auth::user();
        $stock_accounts = AccountRegisterationModel::where('account_clg_id',$user->user_clg_id)->where('account_parent_code', config('global_variables.stock'))->get();

        $count = 0;

        foreach ($stock_accounts as $stock_account) {

            $check_stock_account = BalancesModel::where('bal_clg_id',$user->user_clg_id)->where('bal_account_id', $stock_account->account_uid)->where('bal_day_end_date', $day_end->de_datetime)
                ->orderBy('bal_id', 'DESC')->first();

            if (!empty($check_stock_account->bal_total)) {
                if ($check_stock_account->bal_total < 0) {
                    $count++;
                }
            }
        }

        return $count;
    }

    public function check_bank_account($day_end)
    {
        $user = Auth::user();
        $bank_accounts = AccountRegisterationModel::where('account_clg_id',$user->user_clg_id)->where('account_parent_code', config('global_variables.bank_head'))->get();

//        $check_bank_account = BalancesModel::where('bal_total', '<', 0)->whereIn('bal_account_id', $bank_account)->where('bal_day_end_date', $day_end->de_datetime)->count();

        $count = 0;

        foreach ($bank_accounts as $bank_account) {

            $check_bank_account = BalancesModel::where('bal_clg_id',$user->user_clg_id)->where('bal_account_id', $bank_account->account_uid)->where('bal_day_end_date', $day_end->de_datetime)
                ->orderBy('bal_id', 'DESC')->first();

            if (!empty($check_bank_account->bal_total)) {
                if ($check_bank_account->bal_total < 0) {
                    $count++;
                }
            }
        }

        return $count;
    }

    public function getProductQuantity($pro_code)
    {
        $stock = InventoryModel::where('invt_product_id', $pro_code)->pluck('invt_product_id')->first();
        return $stock;
    }

    public function product_average_costing($day_end)
    {
        $user = Auth::user();
        $purchased_products = DB::table('financials_purchase_invoice')
            ->where('pi_clg_id',$user->user_clg_id)
            ->join('financials_purchase_invoice_items', 'financials_purchase_invoice_items.pii_purchase_invoice_id', '=', 'financials_purchase_invoice.pi_id')
            ->where('pi_status', 'PURCHASE')
            ->where('pi_day_end_id', $day_end->de_id)
            ->get();

        $product_ids = array();

        foreach ($purchased_products as $purchased_product) {
            $product_ids[$purchased_product->pii_product_code] = $purchased_product->pii_product_code; // Get unique country by code.
        }

        $products = DB::table('financials_products')
            ->join('financials_inventory', 'financials_products.pro_code', '=', 'financials_inventory.invt_product_id')
            ->where('pro_clg_id',$user->user_clg_id)
            ->whereIn('pro_code', $product_ids)
            ->get();

        $average_prices = '';
        $set_value = 1;

        foreach ($products as $product) {

            $average_prices = [];
            $qty = 0;

            foreach ($purchased_products as $purchased_product) {

                if ($product->pro_code == $purchased_product->pii_product_code) {
                    $pro_code = $product->pro_code;
                    $average_prices[] = $purchased_product->pii_net_rate * $purchased_product->pii_qty;
                    $inventory = $product->invt_available_stock;
                    $qty += $purchased_product->pii_qty;
                }
            }

            $difference = $inventory - $qty;

            if ($difference > 0) {

                $previous_amount = $product->pro_average_rate * $difference;

                $total_amount = $previous_amount + (array_sum($average_prices));

                $total_quantity = $qty + $difference;

                $average_price = $total_amount / $total_quantity;


            } else {
                $average_price = array_sum($average_prices) / $qty;
            }

            $product = ProductModel::where('pro_clg_id',$user->user_clg_id)->where('pro_code', $pro_code)->first();

            $product->pro_average_rate = $average_price;
            $product->save();

            $pro_qty = InventoryModel::where('invt_product_id', $pro_code)->first();

            $product_costing = new ProductCostingModel();

            $product_costing->pc_pro_id = $pro_code;
            $product_costing->pc_pro_cost = $average_price;
            $product_costing->pc_pro_quantity = $pro_qty->invt_available_stock;
            $product_costing->pc_day_end_id = $day_end->de_id;
            $product_costing->pc_day_end_date = $day_end->de_datetime;
            $product_costing->pc_created_date_time = Carbon::now()->toDateTimeString();

            if ($product_costing->save()) {

                $set_value = 1;
            } else {
                $set_value = 0;
            }

        }

        return $set_value;
    }

    public function account_opening_closing($day_end)
    {
        $data = [];
        $difference = 0;
        $accounts = AccountRegisterationModel::get();

        foreach ($accounts as $account) {
//            $balances = BalancesModel::where('bal_account_id', $account->account_uid)->where('bal_day_end_date', $day_end->de_datetime)->get();

//            $balances = BalancesModel::where('bal_account_id', $account->account_uid)->where('bal_day_end_date', $day_end->de_datetime)->orderBy('bal_id', 'DESC')->first();
            $balances = BalancesModel::where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->first();

//            $difference = $balances->sum('bal_dr') - $balances->sum('bal_cr');
            $difference = $balances->bal_total;

            if ($difference < 0) {
                $difference = $difference * -1;
                $type = 'CR';
            } elseif ($difference > 0) {
                $type = 'DR';
            }

            if ($difference != 0) {

                $data[] = ['aoc_account_uid' => $account->account_uid, 'aoc_account_name' => $account->account_name, 'aoc_balance' => $difference, 'aoc_type' => $type, 'aoc_day_end_id' => $day_end->de_id, 'aoc_day_end_date' => $day_end->de_datetime, 'aoc_created_date_time' => Carbon::now()->toDateTimeString()];

            }
        }

        $account_balance = AccountOpeningClosingBalanceModel::insert($data); // Eloquent approach

        if ($account_balance) {
            return 1;
        } else {
            return 0;
        }

    }

    public function sale_tax($day_end)
    {
        $total_sale_tax_receivable = PurchaseInvoiceModel::where('pi_day_end_id', $day_end->de_id)->sum('pi_sales_tax');

        $data[] = ['aoc_account_uid' => config('global_variables.sale_tax_receivable'), 'aoc_account_name' => 'Sale Tax Receivable', 'aoc_balance' => $total_sale_tax_receivable, 'aoc_type' => 'DR', 'aoc_day_end_id' => $day_end->de_id, 'aoc_day_end_date' => $day_end->de_datetime, 'aoc_created_date_time' => Carbon::now()->toDateTimeString()];

        $total_sale_tax_payable = SaleInvoiceModel::where('si_day_end_id', $day_end->de_id)->sum('si_sales_tax');

        $data[] = ['aoc_account_uid' => config('global_variables.sale_tax_payable'), 'aoc_account_name' => 'Sale Tax Payable', 'aoc_balance' => $total_sale_tax_payable, 'aoc_type' => 'CR', 'aoc_day_end_id' => $day_end->de_id, 'aoc_day_end_date' => $day_end->de_datetime, 'aoc_created_date_time' => Carbon::now()->toDateTimeString()];

        $tax_account_balance = AccountOpeningClosingBalanceModel::insert($data); // Eloquent approach

        if ($tax_account_balance) {
            return 1;
        } else {
            return 0;
        }
    }

    public function income_statement($day_end)
    {
        $opening_inventory = IncomeStatementModel::where('is_day_end_date', date("Y-m-d", strtotime("-1 day", strtotime($day_end->de_datetime))))->pluck('is_ending_inventory')->first();

        if ($opening_inventory == null) {
            $opening_inventory = 0;
        }

        $sales = $this->account_balances($day_end, config('global_variables.sale_account'));

        $sales_return = $this->account_balances($day_end, config('global_variables.sales_returns_&_allowances'));

        $total_sale = $sales - $sales_return;

        $purchase = $this->today_total_purchase($day_end);

        $purchase_return = $this->account_balances($day_end, config('global_variables.purchases_returns_&_allowances'));

        $total_purchase = $purchase - $purchase_return;

        $ending_inventory = $this->ending_inventory();

        $cost_of_goods_sold = $opening_inventory + $total_purchase - $ending_inventory;

        $gross_revenue_one = $total_sale - $cost_of_goods_sold;

        $total_other_revenue = $this->balances_of_expense_revenue($day_end, 3) - $sales - $sales_return;

        $gross_revenue_two = $gross_revenue_one + $total_other_revenue;

        $total_expense = $this->balances_of_expense_revenue($day_end, 4) - $purchase_return;

        $profit_loss = $gross_revenue_two - $total_expense;

        $profitOrLoss = "Profit";

        if ($profit_loss < 0) {
            $profitOrLoss = "Loss";
        }

        $income_statement = new IncomeStatementModel();

        $income_statement->is_sales = $sales;
        $income_statement->is_sales_return = $sales_return;
        $income_statement->is_total_sales = $total_sale;
        $income_statement->is_opening_inventory = $opening_inventory;
        $income_statement->is_purchase = $purchase;
        $income_statement->is_purchase_return = $purchase_return;
        $income_statement->is_total_purchase = $total_purchase;
        $income_statement->is_ending_inventory = $ending_inventory;
        $income_statement->is_total_cgs = $cost_of_goods_sold;
        $income_statement->is_gross_revenue_one = $gross_revenue_one;
        $income_statement->is_other_total_revenue = $total_other_revenue;
        $income_statement->is_gross_revenue_two = $gross_revenue_two;
        $income_statement->is_total_expense = $total_expense;
        $income_statement->is_profit_loss = $profitOrLoss;
        $income_statement->is_profit_loss_amount = $profit_loss;
        $income_statement->is_day_end_id = $day_end->de_id;
        $income_statement->is_day_end_date = $day_end->de_datetime;
        $income_statement->is_current_datetime = Carbon::now()->toDateTimeString();

        if ($income_statement->save()) {

            $accounts = $this->get_revenue_expense_account($day_end);

            $data = [];
            foreach ($accounts as $account) {

                $type = substr($account->aoc_account_uid, 0, 1);
                if ($type == 3) {
                    $account_type = 'REVENUE';
                } else {
                    $account_type = 'EXPENSE';
                }

                $data[] = ['isi_income_statement_id' => $income_statement->is_id, 'isi_type' => $account_type, 'isi_title' => $account->aoc_account_name, 'isi_amount' => $account->aoc_balance];
            }

            $accounts = IncomeStatementItemsModel::insert($data);

            if ($accounts) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function get_revenue_expense_account($day_end)
    {
        $accounts = AccountOpeningClosingBalanceModel::where('aoc_day_end_date', $day_end->de_datetime)
            ->where(function ($query) {
                $query->where('aoc_account_uid', 'like', 3 . '%')
                    ->orWhere('aoc_account_uid', 'like', 4 . '%');
            })
            ->where('aoc_account_uid', '!=', config('global_variables.purchases_returns_&_allowances'))
            ->where('aoc_account_uid', '!=', config('global_variables.sale_account'))
            ->where('aoc_account_uid', '!=', config('global_variables.sales_returns_&_allowances'))
            ->orderBy('aoc_account_uid')
            ->get();

        return $accounts;
    }

    public function account_balances($day_end, $account_id)
    {
        $account_balance = AccountOpeningClosingBalanceModel::where('aoc_account_uid', $account_id)->where('aoc_day_end_date', $day_end->de_datetime)->orderby('aoc_id', 'DESC')->pluck('aoc_balance')->first();

        if ($account_balance == null) {
            $account_balance = 0;
        }

        return $account_balance;
    }

    public function balances_of_expense_revenue($day_end, $account_head)
    {
        $account_balance = AccountOpeningClosingBalanceModel::where('aoc_account_uid', 'like', $account_head . '%')->where('aoc_day_end_date', $day_end->de_datetime)->sum('aoc_balance');

        return $account_balance;
    }

    public function today_total_purchase($day_end)
    {
        $today_total_purchase = PurchaseInvoiceModel::where('pi_day_end_date', $day_end->de_datetime)->get();

        $today_total_purchase = $today_total_purchase->sum('pi_grand_total');

        return $today_total_purchase;
    }

    public function ending_inventory()
    {
        $ending_inventory = DB::table('financials_inventory')
            ->join('financials_products', 'financials_products.pro_code', '=', 'financials_inventory.invt_product_id')
            ->get();

        $ending_inventory = $ending_inventory->sum(function ($t) {
            return $t->invt_available_stock * $t->pro_average_rate;
        });

        return $ending_inventory;
    }

    public function balance_sheet($day_end)
    {
        $data = [];
        $type = '';

        $total_assets = 0;
        $total_liabilities = 0;
        $total_equity = 0;

        $account_head = config('global_variables.assets') .','. config('global_variables.liabilities') .','. config('global_variables.equity');

        $accounts = AccountOpeningClosingBalanceModel::where('aoc_account_uid', 'like', $account_head . '%')->where('aoc_day_end_date', $day_end->de_datetime)->orderby('aoc_account_uid', 'ASC')->get();


        foreach ($accounts as $account) {

            $head = substr($account->aoc_account_uid, 0, 1);

            if ($head == 1) {
                $total_assets += $account->aoc_balance;

            } elseif ($head == 2) {
                $total_liabilities += $account->aoc_balance;

            } elseif ($head == 3) {
                $total_equity += $account->aoc_balance;

            }
        }

        $balance_sheet = new BalanceSheetModel();

        $balance_sheet->bs_total_assets = $total_assets;
        $balance_sheet->bs_total_liabilities = $total_liabilities;
        $balance_sheet->bs_total_equity = $total_equity;
        $balance_sheet->bs_liabilities_and_equity = $total_liabilities + $total_equity;
        $balance_sheet->bs_day_end_id = $day_end->de_id;
        $balance_sheet->bs_day_end_date = $day_end->de_datetime;
        $balance_sheet->bs_current_datetime = Carbon::now()->toDateTimeString();

        $balance_sheet->save();

        foreach ($accounts as $account) {

            $head = substr($account->aoc_account_uid, 0, 1);

            if ($head == 1) {

                $type = 'ASSETS';

            } elseif ($head == 2) {

                $type = 'LIABILITIES';

            } elseif ($head == 3) {

                $type = 'EQUITIES';

            }

            $data[] = ['bsi_balance_sheet_id' => $balance_sheet->bs_id, 'bsi_type' => $type, 'bsi_title' => $account->aoc_account_name, 'bsi_amount' => $account->aoc_balance];

        }

        $account_balance = BalanceSheetItemsModel::insert($data); // Eloquent approach

        if ($account_balance) {
            return 1;
        } else {
            return 0;
        }
    }

    public function run_day_end()
    {
        $ip = request()->ip();

        $user = Auth::User();

        $current_date = $this->day_end();

        $your_date = strtotime("1 day", strtotime($current_date->de_datetime));
        $new_date = date("Y-m-d", $your_date);

        $last_day_end = DayEndModel::where('de_clg_id',$user->user_clg_id)->where('de_id', $current_date->de_id)->first();

        $last_day_end->de_datetime_status = 'CLOSE';

        if ($last_day_end->save()) {

            $day_end = new DayEndModel();

            $day_end->de_datetime_status = 'OPEN';
            $day_end->de_datetime = $new_date;
            $day_end->de_current_datetime = Carbon::now()->toDateTimeString();
            $day_end->de_createdby = $user->user_id;
            $day_end->de_clg_id = $user->user_clg_id;
            $day_end->de_ip = $ip;

            if ($day_end->save()) {
                return 1;

            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

//    public function day_end_login()
//    {
//        return view('start_day_end');
//    }


}
