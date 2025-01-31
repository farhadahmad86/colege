<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountHeadsModel;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\PostingReferenceModel;
use App\Models\ProductModel;
use App\Models\ReportConfigModel;
use App\Models\SaleInvoiceItemsModel;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class FinancialsController extends Controller
{
    public function balance_sheet(Request $request, $array = null, $str = null)
    {
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->from;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->year;
        if (!empty($end)) {
            $search_to = '2022-04-29';
            $search_from = '2022-04-30';
        }
        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $trial_view_list = array();
        if (!empty($end)) {

            $query_stock = DB::table('financials_products');
            $stock_datas = $query_stock->orderBy('pro_id', 'ASC')
                ->select('pro_id', 'pro_p_code', 'pro_code', 'pro_title',
                    \DB::raw("
                    (SELECT
                        IF( (SELECT sm_bal_total FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date < '$start' ORDER BY sm_id ASC LIMIT 1) >= 0,
                         (SELECT sm_bal_total FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date < '$start' ORDER BY sm_id DESC LIMIT 1),
                          (SELECT sm_bal_total FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date <= '$start' ORDER BY sm_id DESC LIMIT 1) ))
                    as opening_balance,

                    (SELECT
                        IF( (SELECT sm_bal_total FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date <= '$end' ORDER BY sm_id ASC LIMIT 1) >= 0,
                         (SELECT sm_bal_total FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date <= '$end' ORDER BY sm_id DESC LIMIT 1),
                          (SELECT sm_bal_total FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date <= '$end' ORDER BY sm_id DESC LIMIT 1) ))
                    as closing_balance

                ")
                )
                ->get();
            $stock_closing_balance = 0;
            $stock_opening_balance = 0;

            foreach ($stock_datas as $stock) {
                $stock_opening_balance = $stock_opening_balance + $stock->opening_balance;
                $stock_closing_balance = $stock_closing_balance + $stock->closing_balance;
            }


            $controls = AccountHeadsModel::where('coa_level', 1)->whereIn('coa_code', [1, 2, 5])->orderBy('coa_code', 'ASC')->select('coa_code', 'coa_head_name', 'coa_level')->get();

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

                        if ($search_year == $this->getYearEndId()) {
                            $query = DB::table('financials_accounts as accounts')
                                ->where('account_parent_code', $child_code);
                            $entries = $query->orderBy('account_id', 'ASC')
                                ->select('accounts.account_id', 'accounts.account_parent_code', 'accounts.account_uid', 'accounts.account_name',
                                    \DB::raw("
                    (SELECT
                        IF( (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date <= '$end' ORDER BY bal_id ASC LIMIT 1) >= 0,
                         (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date <= '$end' ORDER BY bal_id DESC LIMIT 1),
                          (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date <= '$end' ORDER BY bal_id DESC LIMIT 1) ))
                    as opening_balance,
                    (SELECT SUM(bal_dr) FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' AND bal_transaction_type != 'OPENING_BALANCE' ) as total_inwards,
                    (SELECT SUM(bal_cr) FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' AND bal_transaction_type != 'OPENING_BALANCE' ) as total_outwards,
                    (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as ledger_balance_of_customer

                ")
                                )->get();
                        } else {
                            $query = DB::table('financials_accounts as accounts')
                                ->where('account_parent_code', $child_code);
                            $entries = $query->orderBy('account_id', 'ASC')
                                ->select('accounts.account_id', 'accounts.account_parent_code', 'accounts.account_uid', 'accounts.account_name',
                                    \DB::raw("
                    (SELECT
                        IF( (SELECT bal_total FROM financials_balances_$search_year WHERE bal_account_id = account_uid AND bal_day_end_date <= '$end' ORDER BY bal_id ASC LIMIT 1) >= 0,
                         (SELECT bal_total FROM financials_balances_$search_year WHERE bal_account_id = account_uid AND bal_day_end_date <= '$end' ORDER BY bal_id DESC LIMIT 1),
                          (SELECT bal_total FROM financials_balances_$search_year WHERE bal_account_id = account_uid AND bal_day_end_date <= '$end' ORDER BY bal_id DESC LIMIT 1) ))
                    as opening_balance,
                    (SELECT SUM(bal_dr) FROM financials_balances_$search_year WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' AND bal_transaction_type != 'OPENING_BALANCE' ) as total_inwards,
                    (SELECT SUM(bal_cr) FROM financials_balances_$search_year WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' AND bal_transaction_type != 'OPENING_BALANCE' ) as total_outwards,
                    (SELECT bal_total FROM financials_balances_$search_year WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as ledger_balance_of_customer

                ")
                                )->get();
                        }


                        foreach ($entries as $entry) {
                            $entry_code = $entry->account_uid;
                            if ($entry_code != 110111) {
                                $entry_balance = $entry->opening_balance;
                                $entry_inward = $entry->total_inwards;
                                $entry_outward = $entry->total_outwards;
                            } else {
                                $entry_balance = $stock_closing_balance;
                                $entry_inward = 0;
                                $entry_outward = $stock_opening_balance;
                            }

                            $entry_name = $entry->account_name;

                            if ($control_code == 4) {

                                if ($entry_outward > 0) {

                                    $trial_view_list[$control_code]['balance'] = $trial_view_list[$control_code]['balance'] + $entry_outward;

                                    $trial_view_list[$control_code]['child'][$parent_code]['balance'] = $trial_view_list[$control_code]['child'][$parent_code]['balance'] + $entry_outward;

                                    $child_balance = $child_balance + $entry_outward;
                                } else {

                                    $trial_view_list[$control_code]['balance'] = $trial_view_list[$control_code]['balance'] - $entry_inward;

                                    $trial_view_list[$control_code]['child'][$parent_code]['balance'] = $trial_view_list[$control_code]['child'][$parent_code]['balance'] - $entry_inward;

                                    $child_balance = $child_balance - $entry_inward;
                                }
                            } else {
                                $trial_view_list[$control_code]['balance'] = $trial_view_list[$control_code]['balance'] + $entry_balance;

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


        return view('financials.balance_sheet', compact('trial_view_list', 'search_to', 'search_from', 'search_year'));

    }

// update code by shahzaib start
    public
    function balance_sheet_report_generator(Request $request, $array = null, $str = null)
    {
        $search_year = $this->getYearEndId();
        return view('financials.balance_sheet_report_generator', compact('search_year'));

    }

// update code by shahzaib end

    // update code by shahzaib start
    public
    function profit_n_loss_generator(Request $request, $array = null, $str = null)
    {
        $search_year = $this->getYearEndId();
        return view('financials.profit_n_loss_generator', compact('search_year'));
    }

// update code by shahzaib end

//    public function profit_n_loss(Request $request, $array = null, $str = null)
//    {
//        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->to;
//        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->from;
//
//        $start = date('Y-m-d', strtotime($search_to));
//        $end = date('Y-m-d', strtotime($search_from));
//        $controls = AccountHeadsModel::whereIn('coa_code', [3, 4])->orderBy('coa_code', 'ASC')->get();
//
//        $revenue_parent_account = AccountHeadsModel::where('coa_parent', 3)->orderBy('coa_code', 'ASC')->pluck('coa_code');
//        $expense_parent_account = AccountHeadsModel::where('coa_parent', 4)->orderBy('coa_code', 'ASC')->pluck('coa_code');
//
//
//        $revenue_child_account = AccountHeadsModel::whereIn('coa_parent', $revenue_parent_account)->orderBy('coa_code', 'ASC')->pluck('coa_code');
//        $revenue_child_account_name = AccountHeadsModel::whereIn('coa_parent', $revenue_parent_account)->orderBy('coa_code', 'ASC')->select('coa_code', 'coa_head_name', 'coa_parent')->get();
//
//        $expense_child_account = AccountHeadsModel::whereIn('coa_parent', $expense_parent_account)->orderBy('coa_code', 'ASC')->pluck('coa_code');
//        $expense_child_account_name = AccountHeadsModel::whereIn('coa_parent', $expense_parent_account)->orderBy('coa_code', 'ASC')->select('coa_code', 'coa_head_name', 'coa_parent')->get();
//
//        $stock_closing_balance = 0;
//        $stock_opening_balance = 0;
//        $revenue_datas = '';
//        $expense_datas = '';
//        $stock_datas = '';
//        $query_revenue = DB::table('financials_accounts as accounts')
//            ->whereIn('account_parent_code', $revenue_child_account);
//        if (!empty($search_from)) {
//
//            $revenue_datas = $query_revenue->orderBy('account_id', 'ASC')
//                ->select('accounts.account_id', 'accounts.account_parent_code', 'accounts.account_uid', 'accounts.account_name',
//                    \DB::raw("
//                    (SELECT
//                        IF( (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date < '$end' ORDER BY bal_id ASC LIMIT 1) >= 0,
//                         (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date < '$end' ORDER BY bal_id DESC LIMIT 1),
//                          (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date <= '$end' ORDER BY bal_id DESC LIMIT 1) ))
//                    as opening_balance,
//
//                    (SELECT SUM(bal_dr) FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' AND bal_transaction_type != 'OPENING_BALANCE' ) as total_inwards,
//                    (SELECT SUM(bal_cr) FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' AND bal_transaction_type != 'OPENING_BALANCE' ) as total_outwards,
//                    (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as ledger_balance_of_customer
//
//                ")
//                )
//                ->get();
//
//            $query_expense = DB::table('financials_accounts as accounts')
//                ->whereIn('account_parent_code', $expense_child_account);
//
//            $expense_datas = $query_expense->orderBy('account_parent_code', 'ASC')
//                ->select('accounts.account_id', 'accounts.account_parent_code', 'accounts.account_uid', 'accounts.account_name',
//                    \DB::raw("
//                    (SELECT
//                        IF( (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date < '$end' ORDER BY bal_id ASC LIMIT 1) >= 0,
//                         (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date < '$end' ORDER BY bal_id DESC LIMIT 1),
//                          (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date <= '$end' ORDER BY bal_id DESC LIMIT 1) ))
//                    as opening_balance,
//                    (SELECT SUM(bal_dr) FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' AND bal_transaction_type != 'OPENING_BALANCE' ) as total_inwards,
//                    (SELECT SUM(bal_cr) FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' AND bal_transaction_type != 'OPENING_BALANCE' ) as total_outwards,
//                    (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as ledger_balance_of_customer
//
//                ")
//                )
//                ->get();
//
//            $query_stock = DB::table('financials_products');
//            $stock_datas = $query_stock->orderBy('pro_id', 'ASC')
//                ->select('pro_id', 'pro_p_code', 'pro_code', 'pro_title',
//                    \DB::raw("
//                    (SELECT
//                        IF( (SELECT sm_bal_total FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date < '$start' ORDER BY sm_id ASC LIMIT 1) >= 0,
//                         (SELECT sm_bal_total FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date < '$start' ORDER BY sm_id DESC LIMIT 1),
//                          (SELECT sm_bal_total FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date <= '$start' ORDER BY sm_id DESC LIMIT 1) ))
//                    as opening_balance,
//
//                    (SELECT
//                        IF( (SELECT sm_bal_total FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date < '$end' ORDER BY sm_id ASC LIMIT 1) >= 0,
//                         (SELECT sm_bal_total FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date < '$end' ORDER BY sm_id DESC LIMIT 1),
//                          (SELECT sm_bal_total FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date <= '$end' ORDER BY sm_id DESC LIMIT 1) ))
//                    as closing_balance
//
//                ")
//                )
//                ->get();
//
//
//            foreach ($stock_datas as $stock) {
//                $stock_opening_balance = $stock_opening_balance + $stock->opening_balance;
//                $stock_closing_balance = $stock_closing_balance + $stock->closing_balance;
//            }
//        }
//
//
//        return view('financials.profit_n_loss', compact('controls', 'revenue_datas', 'expense_datas', 'expense_child_account', 'expense_child_account_name', 'revenue_child_account', 'search_to', 'search_from', 'revenue_child_account_name', 'stock_closing_balance', 'stock_opening_balance', 'stock_datas'
//        ));
//    }
//


    public function profit_n_loss2(Request $request, $array = null, $str = null)
    {
        $EXPENSES = config('global_variables.expense');
        $REVENUES = config('global_variables.revenue');
        $INCOME_FROM_SALES_GROUP_UID = 310;
        $SALES_REVENUE_PARENT_UID = 31010;
        $SALES_ACCOUNT_UID = 310101;
        $SALE_RETURN_ACCOUNT_UID = 310102;


        $salesAccountUID = config('global_variables.sale_account');
        $saleReturnAccountUID = config('global_variables.sales_returns_and_allowances');
        $purchaseAccountUID = config('global_variables.purchase_account');
        $purchaseReturnAccountUID = config('global_variables.purchase_return_and_allowances');
        $stockAccountUID = config('global_variables.stock_in_hand');
        $claimIssueAccountUID = config('global_variables.claim_issue');
        $claimReceivedAccountUID = config('global_variables.claim_received');


        $SALE_DISCOUNT_GROUP_UID = 415;


        $SALES_TRADE_DISCOUNT_PARENT_UID = 41511;
        $CGS_EXPENSE_GROUP_UID = config('global_variables.cgs_second_head');


        $NET_SALES_CODE = 11;
        $CGS_CODE = 12;
        $CGS_PURCHASES_CODE = 120; // change to cgsEntry function also
        $GROSS_REVENUE_CODE = 13;
        $NET_OPERATING_INCOME_CODE = 14;


        // PnL portions arrays
        $pnlSalesEntryList = array();
        $pnlCGSEntryList = array();
        $grossRevenueEntry = array();
        $pnlExpensesList = array();
        $netOperatingIncomeEntry = array();
        $pnlOtherRevenueList = array();
        // sales entry


        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->from;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->year;
        if (!empty($end)) {
            $search_to = '2022-03-29';
            $search_from = '2022-03-31';
        }
        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $trial_view_list = array();
        if (!empty($end)) {


            $query_stock = DB::table('financials_products');
            $stock_datas = $query_stock->orderBy('pro_id', 'ASC')
                ->select('pro_id', 'pro_p_code', 'pro_code', 'pro_title',
                    \DB::raw("
                    (SELECT
                        IF( (SELECT sm_bal_total FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date < '$start' ORDER BY sm_id ASC LIMIT 1) >= 0,
                         (SELECT sm_bal_total FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date < '$start' ORDER BY sm_id DESC LIMIT 1),
                          (SELECT sm_bal_total FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date <= '$start' ORDER BY sm_id DESC LIMIT 1) ))
                    as opening_balance,

                    (SELECT
                        IF( (SELECT sm_bal_total FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date <= '$end' ORDER BY sm_id ASC LIMIT 1) >= 0,
                         (SELECT sm_bal_total FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date <= '$end' ORDER BY sm_id DESC LIMIT 1),
                          (SELECT sm_bal_total FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date <= '$end' ORDER BY sm_id DESC LIMIT 1) ))
                    as closing_balance

                ")
                )
                ->get();
            $stock_closing_balance = 0;
            $stock_opening_balance = 0;

            foreach ($stock_datas as $stock) {
                $stock_opening_balance = $stock_opening_balance + $stock->opening_balance;
                $stock_closing_balance = $stock_closing_balance + $stock->closing_balance;
            }


            $controls = AccountHeadsModel::where('coa_level', 1)->whereIn('coa_code', [3, 4])->orderBy('coa_code', 'ASC')->select('coa_code', 'coa_head_name', 'coa_level')->get();

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

                        if ($search_year == $this->getYearEndId()) {
                            $query = DB::table('financials_accounts as accounts')
                                ->where('account_parent_code', $child_code);
                            $entries = $query->orderBy('account_id', 'ASC')
                                ->select('accounts.account_id', 'accounts.account_parent_code', 'accounts.account_uid', 'accounts.account_name',
                                    \DB::raw("
                    (SELECT
                        IF( (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date <= '$end' ORDER BY bal_id ASC LIMIT 1) >= 0,
                         (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date <= '$end' ORDER BY bal_id DESC LIMIT 1),
                          (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date <= '$end' ORDER BY bal_id DESC LIMIT 1) ))
                    as opening_balance,
                    (SELECT SUM(bal_dr) FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' AND bal_transaction_type != 'OPENING_BALANCE' ) as total_inwards,
                    (SELECT SUM(bal_cr) FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' AND bal_transaction_type != 'OPENING_BALANCE' ) as total_outwards,
                    (SELECT bal_total FROM financials_balances WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as ledger_balance_of_customer

                ")
                                )
                                ->get();
                        } else {

                            $query = DB::table('financials_accounts as accounts')
                                ->where('account_parent_code', $child_code);
                            $entries = $query->orderBy('account_id', 'ASC')
                                ->select('accounts.account_id', 'accounts.account_parent_code', 'accounts.account_uid', 'accounts.account_name',
                                    \DB::raw("
                    (SELECT
                        IF( (SELECT bal_total FROM financials_balances_$search_year WHERE bal_account_id = account_uid AND bal_day_end_date <= '$end' ORDER BY bal_id ASC LIMIT 1) >= 0,
                         (SELECT bal_total FROM financials_balances_$search_year WHERE bal_account_id = account_uid AND bal_day_end_date <= '$end' ORDER BY bal_id DESC LIMIT 1),
                          (SELECT bal_total FROM financials_balances_$search_year WHERE bal_account_id = account_uid AND bal_day_end_date <= '$end' ORDER BY bal_id DESC LIMIT 1) ))
                    as opening_balance,
                    (SELECT SUM(bal_dr) FROM financials_balances_$search_year WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' AND bal_transaction_type != 'OPENING_BALANCE' ) as total_inwards,
                    (SELECT SUM(bal_cr) FROM financials_balances_$search_year WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' AND bal_transaction_type != 'OPENING_BALANCE' ) as total_outwards,
                    (SELECT bal_total FROM financials_balances_$search_year WHERE bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as ledger_balance_of_customer

                ")
                                )
                                ->get();
                        }


                        foreach ($entries as $entry) {
                            $entry_code = $entry->account_uid;

                            $entry_balance = $entry->opening_balance;
                            $entry_inward = $entry->total_inwards;
                            $entry_outward = $entry->total_outwards;
                            $entry_name = $entry->account_name;
                            if ($entry_inward > $entry_outward) {
                                $balanceBF = $entry_inward - $entry_outward;
                            } else {
                                $balanceBF = $entry_outward - $entry_inward;
                            }

                            // fixed accounts value for PnL
                            switch ($entry_code) {
                                case $salesAccountUID:
                                    $totalSalesValue = (double)$balanceBF;
                                    break;
                                case $saleReturnAccountUID:
                                    $totalSalesReturnValue = (double)$balanceBF;
                                    break;
                                case $purchaseAccountUID:
                                    $totalPurchaseValue = (double)$balanceBF;
                                    break;
                                case $purchaseReturnAccountUID:
                                    $totalPurchaseReturnValue = (double)$balanceBF;
                                    break;
                                case $stockAccountUID:
                                    $openingStockBalance = (double)$balanceBF;
                                    break;
                                case $claimIssueAccountUID:
                                    $claimIssueValue = (double)$balanceBF;
                                    break;
                                case $claimReceivedAccountUID:
                                    $claimReceivedValue = (double)$balanceBF;
                                    break;
                            }


                            if ($control_code == 4) {

                                if ($entry_outward > 0) {

                                    $trial_view_list[$control_code]['balance'] = $trial_view_list[$control_code]['balance'] + $entry_outward - $entry_inward;

                                    $trial_view_list[$control_code]['child'][$parent_code]['balance'] = $trial_view_list[$control_code]['child'][$parent_code]['balance'] + $entry_outward -
                                        $entry_inward;

                                    $child_balance = $child_balance + $entry_outward;
                                } else {

                                    $trial_view_list[$control_code]['balance'] = $trial_view_list[$control_code]['balance'] - $entry_inward + $entry_outward;

                                    $trial_view_list[$control_code]['child'][$parent_code]['balance'] = $trial_view_list[$control_code]['child'][$parent_code]['balance'] - $entry_inward + $entry_outward;

                                    $child_balance = $child_balance - $entry_inward;
                                }
                            } else {
                                $trial_view_list[$control_code]['balance'] = $trial_view_list[$control_code]['balance'] + $entry_balance;

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

            $pnlSalesChildList = array();
            $pnlSalesChildList[] = array('parent' => $NET_SALES_CODE, 'code' => $salesAccountUID, 'name' => "Sales", 'level' => 4, 'balance' => $totalSalesValue);
            $pnlSalesChildList[] = array('parent' => $NET_SALES_CODE, 'code' => $saleReturnAccountUID, 'name' => "Sales Return", 'level' => 4, 'balance' => $totalSalesReturnValue);
            // trade discount entry
            $tradeDiscountChildEntryBalance = 0;
            if (array_key_exists($SALE_DISCOUNT_GROUP_UID, $trial_view_list[$EXPENSES]['child'])) {
                if (array_key_exists($SALES_TRADE_DISCOUNT_PARENT_UID, $trial_view_list[$EXPENSES]['child'][$SALE_DISCOUNT_GROUP_UID]['child'])) {
                    $tradeDiscountChildEntry = $trial_view_list[$EXPENSES]['child'][$SALE_DISCOUNT_GROUP_UID]['child'][$SALES_TRADE_DISCOUNT_PARENT_UID];
                    $tradeDiscountChildEntry['parent'] = $NET_SALES_CODE;
                    $pnlSalesChildList[] = $tradeDiscountChildEntry;
                    $tradeDiscountChildEntryBalance = $tradeDiscountChildEntry['balance'];
                }
            }
            $netSalesValue = ($totalSalesValue - $totalSalesReturnValue - $tradeDiscountChildEntryBalance);
            $pnlSalesEntryList = array('parent' => 0, 'code' => $NET_SALES_CODE, 'name' => "Net Sales", 'level' => 2, 'child' => $pnlSalesChildList, 'balance' => $netSalesValue);


            // CGS entry
            $totalPurchases = $totalPurchaseValue - $totalPurchaseReturnValue;
            $totalClaims = $claimReceivedValue - $claimIssueValue;
            $totalCGSExpenses = 0;
            $cgsChildList = array();
            $cgsChildList[] = array('parent' => $CGS_CODE, 'code' => $stockAccountUID, 'name' => "Opening Stock", 'level' => 4, 'balance' => $stock_opening_balance);
            $purchasesChildList = array();
            $purchasesChildList[] = array('parent' => $CGS_PURCHASES_CODE, 'code' => $purchaseAccountUID, 'name' => "Purchase", 'level' => 4, 'balance' => $totalPurchaseValue);
            $purchasesChildList[] = array('parent' => $CGS_PURCHASES_CODE, 'code' => $claimReceivedAccountUID, 'name' => "Claim Received", 'level' => 4, 'balance' => $claimReceivedValue);
            $purchasesChildList[] = array('parent' => $CGS_PURCHASES_CODE, 'code' => $purchaseReturnAccountUID, 'name' => "Purchase Return", 'level' => 4, 'balance' => $totalPurchaseReturnValue);
            $purchasesChildList[] = array('parent' => $CGS_PURCHASES_CODE, 'code' => $claimIssueAccountUID, 'name' => "Claim Issue", 'level' => 4, 'balance' => $claimIssueValue);
            $cgsChildList[] = array('parent' => $CGS_CODE, 'code' => $CGS_PURCHASES_CODE, 'name' => "Purchases", 'level' => 3, 'child' => $purchasesChildList, 'balance' => $totalPurchases + $totalClaims);
            $cgsExpenseChildList = array();
            if (array_key_exists($CGS_EXPENSE_GROUP_UID, $trial_view_list[$EXPENSES]['child'])) {
                $cgsExpensesParent = $trial_view_list[$EXPENSES]['child'][$CGS_EXPENSE_GROUP_UID]['child'];
                foreach ($cgsExpensesParent as $cgsExp) {
                    $child = $cgsExp['child'];
                    foreach ($child as $exp) {
                        if ($exp['code'] == $purchaseAccountUID || $exp['code'] == $purchaseReturnAccountUID || $exp['code'] == $claimReceivedAccountUID || $exp['code'] == $claimIssueAccountUID) {
                            continue;
                        }
                        $cgsExpenseChildList[] = $exp;
                        $totalCGSExpenses += $exp['balance'];
                    }
                }
                if (count($cgsExpenseChildList) > 0) {
                    $cgsChildList[] = array('parent' => $CGS_CODE, 'code' => $CGS_EXPENSE_GROUP_UID, 'name' => "CGS Expenses", 'level' => 3, 'child' => $cgsExpenseChildList, 'balance' =>
                        $totalCGSExpenses);
                }
            }
            $cgsChildList[] = array('parent' => $CGS_CODE, 'code' => $stockAccountUID, 'name' => "Closing Stock", 'level' => 4, 'balance' => $stock_closing_balance);
            $totalCGSValue = (($stock_opening_balance + ($totalPurchases + $totalClaims + $totalCGSExpenses)) - $stock_closing_balance);
            $pnlCGSEntryList = array('parent' => 0, 'code' => $CGS_CODE, 'name' => "CGS (Cost of Goods Sold) ", 'level' => 2, 'child' => $cgsChildList, 'balance' => $totalCGSValue);

            // gross revenue entry
            $grossRevenueValue = $netSalesValue - $totalCGSValue;
            $grossRevenueEntry = array('parent' => 0, 'code' => $GROSS_REVENUE_CODE, 'name' => "Gross Revenue", 'level' => 4, 'balance' => $grossRevenueValue);

            // expenses
            $totalExpenses = 0;
            $pnlExpensesList = $trial_view_list[$EXPENSES];
            $pnlTempExpensesBalance = $trial_view_list[$EXPENSES]['balance'];
            $pnlTempCGSExpenseBalance = 0;
            $pnlTempSalesDiscountBalance = 0;
            $pnlTempTradeDiscountBalance = 0;
            if (array_key_exists($CGS_EXPENSE_GROUP_UID, $pnlExpensesList['child'])) {
                $pnlTempCGSExpenseBalance = $pnlExpensesList['child'][$CGS_EXPENSE_GROUP_UID]['balance'];
                unset($pnlExpensesList['child'][$CGS_EXPENSE_GROUP_UID]);
            }
            if (array_key_exists($SALE_DISCOUNT_GROUP_UID, $pnlExpensesList['child'])) {
                $pnlTempSalesDiscountBalance = $pnlExpensesList['child'][$SALE_DISCOUNT_GROUP_UID]['balance'];
                if (array_key_exists($SALES_TRADE_DISCOUNT_PARENT_UID, $pnlExpensesList['child'][$SALE_DISCOUNT_GROUP_UID]['child'])) {
                    $pnlTempTradeDiscountBalance = $pnlExpensesList['child'][$SALE_DISCOUNT_GROUP_UID]['child'][$SALES_TRADE_DISCOUNT_PARENT_UID]['balance'];
                    unset($pnlExpensesList['child'][$SALE_DISCOUNT_GROUP_UID]['child'][$SALES_TRADE_DISCOUNT_PARENT_UID]);
                }
                $pnlExpensesList['child'][$SALE_DISCOUNT_GROUP_UID]['balance'] = $pnlTempSalesDiscountBalance - $pnlTempTradeDiscountBalance;
                if (count($pnlExpensesList['child'][$SALE_DISCOUNT_GROUP_UID]['child']) == 0) {
                    unset($pnlExpensesList['child'][$SALE_DISCOUNT_GROUP_UID]);
                }
            }
            $totalExpenses = $pnlTempExpensesBalance - $pnlTempCGSExpenseBalance - $pnlTempTradeDiscountBalance;
            $pnlExpensesList['balance'] = $totalExpenses;
            $pnlExpensesList['parent'] = 0;
// net operating income
            $netOperatingIncome = $grossRevenueValue + $totalExpenses;
            $netOperatingIncomeEntry = array('parent' => 0, 'code' => $NET_OPERATING_INCOME_CODE, 'name' => "Net Operating Income", 'level' => 4, 'balance' => $netOperatingIncome);

            // other revenues
            $totalOtherRevenue = 0;
            $pnlOtherRevenueList = $trial_view_list[$REVENUES];
            $pnlOtherRevenueBalance = $trial_view_list[$REVENUES]['balance'];
            $pnlOtherRevenueSalesBalance = 0;
            $pnlOtherRevenueSalesReturnBalance = 0;
            if (array_key_exists($INCOME_FROM_SALES_GROUP_UID, $pnlOtherRevenueList['child'])) {
                if (array_key_exists($SALES_REVENUE_PARENT_UID, $pnlOtherRevenueList['child'][$INCOME_FROM_SALES_GROUP_UID]['child'])) {
                    $tempSalesRevenueChildList = $pnlOtherRevenueList['child'][$INCOME_FROM_SALES_GROUP_UID]['child'][$SALES_REVENUE_PARENT_UID]['child'];
                    if (array_key_exists($SALES_ACCOUNT_UID, $tempSalesRevenueChildList)) {
                        $pnlOtherRevenueSalesBalance = $tempSalesRevenueChildList[$SALES_ACCOUNT_UID]['balance'];
                        unset($tempSalesRevenueChildList[$SALES_ACCOUNT_UID]);
                    }
                    if (array_key_exists($SALE_RETURN_ACCOUNT_UID, $tempSalesRevenueChildList)) {
                        $pnlOtherRevenueSalesReturnBalance = $tempSalesRevenueChildList[$SALE_RETURN_ACCOUNT_UID]['balance'];
                        unset($tempSalesRevenueChildList[$SALE_RETURN_ACCOUNT_UID]);
                    }
                    $pnlOtherRevenueList['child'][$INCOME_FROM_SALES_GROUP_UID]['child'][$SALES_REVENUE_PARENT_UID]['child'] = $tempSalesRevenueChildList;
                    // ***********************************
                    $saleRevBal = $pnlOtherRevenueList['child'][$INCOME_FROM_SALES_GROUP_UID]['child'][$SALES_REVENUE_PARENT_UID]['balance'];
                    $saleRevBal -= ($pnlOtherRevenueSalesBalance - $pnlOtherRevenueSalesReturnBalance);
                    $pnlOtherRevenueList['child'][$INCOME_FROM_SALES_GROUP_UID]['child'][$SALES_REVENUE_PARENT_UID]['type'] = ($saleRevBal < 0) ? 'DR' : 'CR';
                    $pnlOtherRevenueList['child'][$INCOME_FROM_SALES_GROUP_UID]['child'][$SALES_REVENUE_PARENT_UID]['balance'] = abs($saleRevBal);
                    // ***********************************
                    // ***********************************
                    $incomeFrmSaleBal = $pnlOtherRevenueList['child'][$INCOME_FROM_SALES_GROUP_UID]['balance'];
                    $incomeFrmSaleBal -= ($pnlOtherRevenueSalesBalance - $pnlOtherRevenueSalesReturnBalance);
                    $pnlOtherRevenueList['child'][$INCOME_FROM_SALES_GROUP_UID]['type'] = ($incomeFrmSaleBal < 0) ? 'DR' : 'CR';
                    $pnlOtherRevenueList['child'][$INCOME_FROM_SALES_GROUP_UID]['balance'] = abs($incomeFrmSaleBal);
                    // ***********************************
                }
            }
            $totalOtherRevenue = $pnlOtherRevenueBalance - ($pnlOtherRevenueSalesBalance - $pnlOtherRevenueSalesReturnBalance);
            $pnlOtherRevenueList['balance'] = $totalOtherRevenue;
            $pnlOtherRevenueList['type'] = ($totalOtherRevenue < 0) ? 'DR' : 'CR';
            $pnlOtherRevenueList['parent'] = 0;

            // net profit / loss
            $netProfitOrLossAmount = $netOperatingIncome + $totalOtherRevenue;

            $netProfitOrLossAbsoluteAmount = abs($netProfitOrLossAmount);
            $netProfitOrLossAmount = number_format($netProfitOrLossAmount, 2, '.', '');
            $netProfitOrLossAbsoluteAmount = number_format($netProfitOrLossAbsoluteAmount, 2, '.', '');
            $lossColorClass = '';
            if ($netProfitOrLossAmount < 0) {
                $netProfitOrLoss = "Loss";
                $lossColorClass = 'loss';
            }
        }


        return view('financials.profit_n_loss', compact('trial_view_list', 'search_to', 'search_from', 'stock_closing_balance', 'stock_opening_balance', 'pnlSalesEntryList', 'pnlSalesEntryList', 'pnlCGSEntryList', 'grossRevenueEntry', 'totalExpenses', 'pnlExpensesList', 'netOperatingIncomeEntry', 'netOperatingIncome', 'pnlOtherRevenueList', 'netProfitOrLossAbsoluteAmount'));

    }
}
