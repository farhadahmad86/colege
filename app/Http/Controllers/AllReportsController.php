<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountGroupModel;
use App\Models\AccountRegisterationModel;
use App\Models\AreaModel;
use App\Models\BalanceSheetItemsModel;
use App\Models\BalanceSheetModel;
use App\Models\BalancesModel;
use App\Models\CategoryInfoModel;
use App\Models\GroupInfoModel;
use App\Models\MainUnitModel;
use App\Models\ProductGroupModel;
use App\Models\ProductModel;
use App\Models\PurchaseInvoiceItemsModel;
use App\Models\PurchaseSaletaxItemsInvoiceModel;
use App\Models\RegionModel;
use App\Models\RolesModel;
use App\Models\SaleInvoiceItemsModel;
use App\Models\SaleInvoiceModel;
use App\Models\SaleSaletaxInvoiceItemsModel;
use App\Models\SectorModel;
use App\Models\StockMovementModels;
use App\Models\TownModel;
use App\Models\UnitInfoModel;
use App\Models\WarehouseModel;
use App\User;
use Auth;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class AllReportsController extends Controller
{

    public function all_reports()
    {
        return view('all_reports', compact(''));
    }

    public function client_recovery_report(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();

        $regions = RegionModel::where('reg_clg_id', '=', $user->user_clg_id)->where('reg_delete_status', '!=', 1)->where('reg_disabled', '!=', 1)->orderBy('reg_title', 'ASC')->get();
        $areas = AreaModel::where('area_clg_id', '=', $user->user_clg_id)->where('area_delete_status', '!=', 1)->where('area_disabled', '!=', 1)->orderBy('area_title', 'ASC')->get();
        $sectors = SectorModel::where('sec_clg_id', '=', $user->user_clg_id)->where('sec_delete_status', '!=', 1)->where('sec_disabled', '!=', 1)->orderBy('sec_title', 'ASC')->get();
        $towns = TownModel::where('town_clg_id', '=', $user->user_clg_id)->where('town_delete_status', '!=', 1)->where('town_disabled', '!=', 1)->orderBy('town_title', 'ASC')->get();

        $sale_persons = User::where('user_id', '!=', 1)->where('user_designation', '!=', 1)->where('user_clg_id', '=', $user->user_clg_id)->where('user_delete_status', '!=', 1)->where('user_id', '!=', 1)->orderBy('user_role_id', 'DESC')->orderBy('user_name', 'ASC')->get();


        $ar = json_decode($request->array);
        $search_region = (!isset($request->region) && empty($request->region)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->region;
        $search_area = (!isset($request->area) && empty($request->area)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->area;
        $search_sector = (!isset($request->sector) && empty($request->sector)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->sector;
        $search_town = (!isset($request->town) && empty($request->town)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->town;
        $search_sale_persons = (!isset($request->sale_person) && empty($request->sale_person)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->sale_person;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->from;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[7]->{'value'} : '') : $request->to;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[8]->{'value'} : '') : $request->year;


        $prnt_page_dir = 'print.account_receivable_payable_list.account_receivable_payable_list';
        $pge_title = 'Account Payable Receivable';
        $srch_fltr = [];
        array_push($srch_fltr, $search_region, $search_area, $search_sector, $search_town, $search_sale_persons,  $search_from, $search_to);

        $start = date('Y-m-d', strtotime($search_from));
        $end = date('Y-m-d', strtotime($search_to));


        $pagination_number = (empty($ar)) ? 30 : 100000000;
        $ttl_amnt=0;
        $query = DB::table('financials_accounts')
            ->where('account_parent_code','=',11013)
            ->leftJoin('financials_region', 'financials_accounts.account_region_id', 'financials_region.reg_id')
            ->leftJoin('financials_sectors', 'financials_accounts.account_sector_id', 'financials_sectors.sec_id')
            ->leftJoin('financials_areas', 'financials_accounts.account_area', 'financials_areas.area_id')
            ->leftJoin('financials_towns', 'financials_towns.town_id', 'financials_accounts.account_town_id')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_accounts.account_sale_person');

        if (!empty($search_region)) {
            $query->where('account_region_id', $search_region);
        }

        if (!empty($search_area)) {
            $query->where('account_area', $search_area);
        }

        if (!empty($search_sector)) {
            $query->where('account_sector_id', $search_sector);
        }
        if (!empty($search_town)) {
            $query->where('account_town_id', $search_town);
        }

        if (!empty($search_sale_persons)) {
            $query->where('account_sale_person', $search_sale_persons);
        }

        if ($user->user_level !== 100) {
            $query->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
        }
        if (!empty($search_year)) {
            $query->where('account_year_id', '=', $search_year);
        } else {
            $search_year =$this->getYearEndId();
            $query->where('account_year_id', '=', $search_year);
        }
        $datas = $query
//            ->where('account_delete_status', '!=', 1)
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->select('financials_accounts.*', 'financials_region.reg_title', 'financials_sectors.sec_title', 'financials_areas.area_title', 'financials_users.user_id', 'financials_users.user_name',
                'financials_users.user_designation', 'financials_towns.town_title')
            ->paginate($pagination_number);

        $query_lst = DB::table('financials_accounts')->where('account_clg_id', '=', $user->user_clg_id);
        if ($user->user_level !== 100) {
            $query_lst->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
        }
        $account_list = $query_lst->where('account_type', '!=', 0)
            ->where('account_delete_status', '!=', 1)
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->pluck('account_name')
            ->all();


        $balance = [];
        $balance_date_array = [];

        if (!empty($search_from) || !empty($search_to)) {
            foreach ($datas as $account) {
                $default = BalancesModel::where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)
                    ->whereDate('bal_day_end_date', '>=', $start)
                    ->whereDate('bal_day_end_date', '<=', $end)
                    ->where('bal_year_id', '=', $search_year)
                    ->orderBy('bal_id',
                    'DESC')->pluck('bal_total')->first();

                $balance_date = BalancesModel::where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)
                    ->whereDate('bal_day_end_date', '>=', $start)
                    ->whereDate('bal_day_end_date', '<=', $end)
                    ->where('bal_year_id', '=', $search_year)
                    ->orderBy('bal_id', 'DESC')->sum('bal_dr');


                $balance_date_array[] = $balance_date;

                if (empty($default)) {
                    $balance[] = 0;
                } else {
                    $ttl_amnt += $default;
                    $balance[] = $default;
                }
            }
        } else {

            foreach ($datas as $account) {
                $default = 0;
                $default = BalancesModel::where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();

                $balance_date = BalancesModel::where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_day_end_date')
                    ->first();
                $balance_date_array[] = $balance_date;


                if (empty($default)) {
                    $balance[] = 0;
                } else {
                    $ttl_amnt += $default;
                    $balance[] = $default;
                }
            }
        }


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'balance', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $balance), $pge_title . '_x.xlsx');
            }

        } else {
            return view('client_recovery_report', compact('datas', 'areas','search_year', 'balance', 'account_list', 'regions', 'sale_persons', 'search_region', 'search_area', 'search_sector', 'search_town', 'areas', 'ttl_amnt',
                'sectors', 'towns', 'search_sale_persons', 'search_from', 'search_to', 'balance_date_array'));
        }
    }

    // update code by shahzaib start
    public function aging_report_party_wise_purchase(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $heads = explode(',', config('global_variables.payable_receivable'));
        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->where('account_clg_id', $user->user_clg_id)->orderBy('account_uid', 'ASC')->pluck('account_uid')->all();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.aging_report_party_wise_purchase.aging_report_party_wise_purchase';
        $pge_title = 'Party Wise Purchase Aging List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        if (!empty($search)) {

            $purchase_ids = DB::table('financials_purchase_invoice')
                ->where('pi_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(pi_id) AS pi_id'))
                ->where('pi_party_name', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%')
                ->whereIn('pi_party_code', $accounts)
                ->groupBy('pi_party_code');

            $sale_tax_purchase_ids = DB::table('financials_purchase_saletax_invoice')
                ->where('psi_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(psi_id) AS psi_id'))
                ->where('psi_party_name', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%')
                ->whereIn('psi_party_code', $accounts)
                ->groupBy('psi_party_code');
        } elseif (!empty($search_to) && !empty($search_from)) {

            $purchase_ids = DB::table('financials_purchase_invoice')
                ->where('pi_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(pi_id) AS pi_id'))
                ->whereDate('pi_day_end_date', '>=', $start)
                ->whereDate('pi_day_end_date', '<=', $end)
                ->whereIn('pi_party_code', $accounts)
                ->groupBy('pi_party_code');

            $sale_tax_purchase_ids = DB::table('financials_purchase_saletax_invoice')
                ->where('psi_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(psi_id) AS psi_id'))
                ->whereDate('psi_day_end_date', '>=', $start)
                ->whereDate('psi_day_end_date', '<=', $end)
                ->whereIn('psi_party_code', $accounts)
                ->groupBy('psi_party_code');
        } elseif (!empty($search_to)) {

            $purchase_ids = DB::table('financials_purchase_invoice')
                ->where('pi_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(pi_id) AS pi_id'))
                ->where('pi_day_end_date', $start)
                ->whereIn('pi_party_code', $accounts)
                ->groupBy('pi_party_code');

            $sale_tax_purchase_ids = DB::table('financials_purchase_saletax_invoice')
                ->where('psi_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(psi_id) AS psi_id'))
                ->where('psi_day_end_date', $start)
                ->whereIn('psi_party_code', $accounts)
                ->groupBy('psi_party_code');
        } elseif (!empty($search_from)) {

            $purchase_ids = DB::table('financials_purchase_invoice')
                ->where('pi_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(pi_id) AS pi_id'))
                ->where('pi_day_end_date', $end)
                ->whereIn('pi_party_code', $accounts)
                ->groupBy('pi_party_code');

            $sale_tax_purchase_ids = DB::table('financials_purchase_saletax_invoice')
                ->where('psi_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(psi_id) AS psi_id'))
                ->where('psi_day_end_date', $end)
                ->whereIn('psi_party_code', $accounts)
                ->groupBy('psi_party_code');
        } else {
            $purchase_ids = DB::table('financials_purchase_invoice')
                ->where('pi_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(pi_id) AS pi_id'))
                ->groupBy('pi_party_code')
                ->whereIn('pi_party_code', $accounts);


            $sale_tax_purchase_ids = DB::table('financials_purchase_saletax_invoice')
                ->where('psi_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(psi_id) AS psi_id'))
                ->groupBy('psi_party_code')
                ->whereIn('psi_party_code', $accounts);
        }

        $sale_tax_prchs_in = DB::table('financials_purchase_saletax_invoice')
            ->where('psi_clg_id', $user->user_clg_id)
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_purchase_saletax_invoice.psi_createdby')
            ->select(DB::raw('psi_id as pi_id, psi_party_code as pi_party_code, psi_party_name as pi_party_name, psi_day_end_date as pi_day_end_date, psi_grand_total as pi_grand_total, psi_detail_remarks as pi_detail_remarks, psi_datetime as pi_datetime, psi_ip_adrs as pi_ip_adrs, psi_brwsr_info as pi_brwsr_info, financials_users.user_id, financials_users.user_name, "pur_sltx_in" as type'))
            ->whereIn('psi_id', $sale_tax_purchase_ids);

        $prchs_in = DB::table('financials_purchase_invoice')
            ->where('pi_clg_id', $user->user_clg_id)
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_purchase_invoice.pi_createdby')
            ->select(DB::raw('pi_id, pi_party_code, pi_party_name, pi_day_end_date, pi_grand_total, pi_detail_remarks, pi_datetime, pi_ip_adrs, pi_brwsr_info, financials_users.user_id, financials_users.user_name, "pur_in" as type'))
            ->whereIn('pi_id', $purchase_ids)
            ->union($sale_tax_prchs_in)
            ->orderBy('pi_datetime', 'DESC');

        $datas = DB::query()->fromSub($prchs_in, 'financials_purchase_saletax_invoice')
            ->where('psi_clg_id', $user->user_clg_id)
            ->select('pi_id', 'pi_party_code', 'pi_party_name', 'pi_day_end_date', 'pi_grand_total', 'pi_detail_remarks', 'pi_datetime', 'pi_ip_adrs', 'pi_brwsr_info', 'user_id', 'user_name', 'type')
            ->groupBy('pi_party_code')
            ->paginate($pagination_number);


        $party = AccountRegisterationModel::whereIn('account_parent_code', $heads)->where('account_clg_id', $user->user_clg_id)->orderBy('account_name', 'ASC')->pluck('account_name')->all();

        $current_date = $this->day_end_date_only();
        $balance = $current_date;


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);

            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'balance'));
            //            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $current_date), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports/aging_report_party_wise_purchase', compact('datas', 'party', 'current_date', 'search_to', 'search_from', 'search'));
        }
    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function aging_report_party_wise_sale(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $heads = explode(',', config('global_variables.payable_receivable'));

        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->where('account_clg_id', $user->user_clg_id)->orderBy('account_uid', 'ASC')->pluck('account_uid')->all();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.aging_report_party_wise_sale.aging_report_party_wise_sale';
        $pge_title = 'Party Wise Sale Aging List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        if (!empty($search)) {

            $sales_id = DB::table('financials_sale_invoice')
                ->where('si_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(si_id) AS si_id'))
                ->where('si_party_name', 'like', '%' . $search . '%')
                ->whereIn('si_party_code', $accounts)
                ->groupBy('si_party_code');

            $sale_tax_sales_id = DB::table('financials_sale_saletax_invoice')
                ->where('ssi_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(ssi_id) AS ssi_id'))
                ->where('ssi_party_name', 'like', '%' . $search . '%')
                ->whereIn('ssi_party_code', $accounts)
                ->groupBy('ssi_party_code');
        } elseif (!empty($search_to) && !empty($search_from)) {

            $sales_id = DB::table('financials_sale_invoice')
                ->where('si_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(si_id) AS si_id'))
                ->whereDate('si_day_end_date', '>=', $start)
                ->whereDate('si_day_end_date', '<=', $end)
                ->whereIn('si_party_code', $accounts)
                ->groupBy('si_party_code');

            $sale_tax_sales_id = DB::table('financials_sale_saletax_invoice')
                ->where('ssi_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(ssi_id) AS ssi_id'))
                ->whereDate('ssi_day_end_date', '>=', $start)
                ->whereDate('ssi_day_end_date', '<=', $end)
                ->whereIn('ssi_party_code', $accounts)
                ->groupBy('ssi_party_code');
        } elseif (!empty($search_to)) {

            $sales_id = DB::table('financials_sale_invoice')
                ->where('si_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(si_id) AS si_id'))
                ->where('si_day_end_date', $start)
                ->whereIn('si_party_code', $accounts)
                ->groupBy('si_party_code');

            $sale_tax_sales_id = DB::table('financials_sale_saletax_invoice')
                ->where('ssi_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(ssi_id) AS ssi_id'))
                ->where('ssi_day_end_date', $start)
                ->whereIn('ssi_party_code', $accounts)
                ->groupBy('ssi_party_code');
        } elseif (!empty($search_from)) {

            $sales_id = DB::table('financials_sale_invoice')
                ->where('si_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(si_id) AS si_id'))
                ->where('si_day_end_date', $end)
                ->whereIn('si_party_code', $accounts)
                ->groupBy('si_party_code');

            $sale_tax_sales_id = DB::table('financials_sale_saletax_invoice')
                ->where('ssi_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(ssi_id) AS ssi_id'))
                ->where('ssi_day_end_date', $end)
                ->whereIn('ssi_party_code', $accounts)
                ->groupBy('ssi_party_code');
        } else {

            $sales_id = DB::table('financials_sale_invoice')
                ->where('si_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(si_id) AS si_id'))
                ->whereIn('si_party_code', $accounts)
                ->groupBy('si_party_code');

            $sale_tax_sales_id = DB::table('financials_sale_saletax_invoice')
                ->where('ssi_clg_id', $user->user_clg_id)
                ->select(DB::raw('MAX(ssi_id) AS ssi_id'))
                ->whereIn('ssi_party_code', $accounts)
                ->groupBy('ssi_party_code');
        }

        $sale_tax_sales_in = DB::table('financials_sale_saletax_invoice')
            ->where('ssi_clg_id', $user->user_clg_id)
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_sale_saletax_invoice.ssi_createdby')
            ->select(DB::raw('ssi_id, ssi_party_code, ssi_party_name, ssi_day_end_date, ssi_grand_total, ssi_detail_remarks, ssi_datetime, ssi_ip_adrs, ssi_brwsr_info, financials_users.user_id, financials_users.user_name, "sales_sltx_in" as type'))
            ->whereIn('ssi_id', $sale_tax_sales_id);


        $sales_in = DB::table('financials_sale_invoice')
            ->where('si_clg_id', $user->user_clg_id)
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_sale_invoice.si_createdby')
            ->select(DB::raw('si_id, si_party_code, si_party_name, si_day_end_date, si_grand_total, si_detail_remarks, si_datetime, si_ip_adrs, si_brwsr_info, financials_users.user_id, financials_users.user_name, "sales_in" as type'))
            ->whereIn('si_id', $sales_id)
            ->union($sale_tax_sales_in)
            ->orderBy('si_datetime', 'DESC');
        //            ->paginate($pagination_number);

        $datas = DB::query()->fromSub($sales_in, 'financials_sale_saletax_invoice')
            ->where('ssi_clg_id', $user->user_clg_id)
            ->select('si_id', 'si_party_code', 'si_party_name', 'si_day_end_date', 'si_grand_total', 'si_detail_remarks', 'si_datetime', 'si_ip_adrs', 'si_brwsr_info', 'user_id', 'user_name', 'type')
            ->groupBy('si_party_code')
            ->paginate($pagination_number);


        $party = AccountRegisterationModel::whereIn('account_parent_code', $heads)->where('account_clg_id', $user->user_clg_id)->orderBy('account_name', 'ASC')->pluck('account_name')->all();

        $current_date = $this->day_end_date_only();
        $balance = $current_date;


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);

            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'balance'));
            //            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $current_date), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports/aging_report_party_wise_sale', compact('datas', 'party', 'current_date', 'search_to', 'search_from', 'search'));
        }
    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function aging_report_product_wise(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.aging_report_product_wise.aging_report_product_wise';
        $pge_title = 'Product Wise Aging List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $first_query = DB::table('financials_sale_invoice')
            ->where('si_clg_id', $user->user_clg_id)
            ->join('financials_sale_invoice_items', 'financials_sale_invoice_items.sii_invoice_id', '=', 'financials_sale_invoice.si_id')
            ->join('financials_products', 'financials_products.pro_code', '=', 'financials_sale_invoice_items.sii_product_code')
            ->select(DB::raw('MAX(si_id) AS si_id'), 'pro_code', 'pro_title', 'si_day_end_id', 'si_day_end_date')
            ->whereIn(
                'si_id',
                DB::table('financials_sale_invoice_items')->where('ssi_clg_id', $user->user_clg_id)->select([DB::raw('MAX(sii_invoice_id) AS sii_invoice_id')])
                    ->whereIn('sii_product_code', DB::table('financials_products')->where('pro_clg_id', $user->user_clg_id)->pluck('pro_code')->all())->groupBy('sii_product_code')->pluck('sii_invoice_id')->all()
            );

        $second_query = DB::table('financials_products')
            ->where('pro_clg_id', $user->user_clg_id)
            ->select(DB::raw('MAX(0) AS si_id'), 'pro_code', 'pro_title', DB::raw('MAX(0) AS si_day_end_id'), DB::raw('MAX(0) AS si_day_end_date'))
            ->whereNotIn('pro_code', DB::table('financials_sale_invoice_items')->where('ssi_clg_id', $user->user_clg_id)->groupBy('sii_product_code')->pluck('sii_product_code')->all());


        if (isset($search) && !empty($search)) {
            $first_query->where('pro_title', $search)
                ->orWhere('pro_code', $search);

            $second_query->where('pro_title', $search)
                ->orWhere('pro_code', $search);
        }

        if ((isset($search_to) && !empty($search_to)) && (isset($search_from) && !empty($search_from))) {
            $first_query->whereDate('pro_day_end_date', '>=', $start)
                ->whereDate('pro_day_end_date', '<=', $end);

            $second_query->whereDate('pro_day_end_date', '>=', $start)
                ->whereDate('pro_day_end_date', '<=', $end);
        }

        if (isset($search_to) && !empty($search_to)) {
            $first_query->where('pro_day_end_date', $start);

            $second_query->where('pro_day_end_date', $start);
        }

        if (isset($search_from) && !empty($search_from)) {
            $first_query->where('pro_day_end_date', $end);

            $second_query->where('pro_day_end_date', $end);
        }

        $first_query_result = $first_query->groupBy('pro_code')->get();

        $second_query_result = $second_query->groupBy('pro_code')->get();

        $datas = $first_query_result->merge($second_query_result);

        $products = ProductModel::where('pro_clg_id', $user->user_clg_id)->orderBy('pro_title', 'ASC')->pluck('pro_title')->all();

        $current_date = $this->day_end_date_only();
        $balance = $current_date;


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
                'margin-top' => 24,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'balance'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $current_date), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports/aging_report_product_wise', compact('datas', 'products', 'current_date', 'search_to', 'search_from', 'search'));
        }
    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function sale_invoice_wise_profit(Request $request, $array = null, $str = null)
    {
        $heads = explode(',', config('global_variables.payable_receivable_cash') . ',' . config('global_variables.bank_head'));
        $user = Auth::user();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.sale_invoice_wise_profit.sale_invoice_wise_profit';
        $pge_title = 'Sale Invoice Wise Profit List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $query = DB::table('financials_sale_invoice')
            ->where('si_clg_id', $user->user_clg_id);

        if (!empty($search)) {
            $query->where('si_party_name', 'like', '%' . $search . '%');
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereBetween('si_day_end_date', [$start, $end]);
        } elseif (!empty($search_to)) {
            $query->where('si_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('si_day_end_date', $end);
        }


        $datas = $query->orderBy('si_id', 'DESC')
            ->paginate($pagination_number);


        $party = AccountRegisterationModel::whereIn('account_parent_code', $heads)->where('account_clg_id', $user->user_clg_id)->orderBy('account_name', 'ASC')->pluck('account_name')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);

            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            //            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports/sale_invoice_wise_profit', compact('datas', 'party', 'search', 'search_to', 'search_from'));
        }
    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function sale_person_wise_profit(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.sale_person_wise_profit.sale_person_wise_profit';
        $pge_title = 'Sale Person Wise Profit List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $query = DB::table('financials_sale_invoice')
            ->where('si_clg_id', $user->user_clg_id)
            ->join('financials_users', 'financials_users.user_id', '=', 'financials_sale_invoice.si_sale_person')
            ->select('user_id', 'user_name', 'user_commission_per', 'si_day_end_id', 'si_day_end_date', DB::raw("SUM(si_grand_total) as sale"), DB::raw("SUM(si_invoice_profit) as profit"));

        if (!empty($search)) {
            $query->where('user_name', 'like', '%' . $search . '%');
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereBetween('si_day_end_date', [$start, $end]);
        } elseif (!empty($search_to)) {
            $query->where('si_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('si_day_end_date', $end);
        }

        $datas = $query->groupBy('si_party_code')
            ->orderBy('si_id', 'DESC')
            ->paginate($pagination_number);

        $sale_persons = User::where('user_id', '!=', 1)->where('user_clg_id', $user->user_clg_id)->orderBy('user_role_id', 'DESC')->orderBy('user_name', 'ASC')->pluck('user_name')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports/sale_person_wise_profit', compact('datas', 'search', 'sale_persons', 'search_to', 'search_from'));
        }
    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function client_wise_profit(Request $request, $array = null, $str = null)
    {
        $heads = explode(',', config('global_variables.receivable'));
        $user = Auth::user();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.client_wise_profit.client_wise_profit';
        $pge_title = 'Client Wise Profit List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $query = DB::table('financials_sale_invoice')
            ->where('si_clg_id', $user->user_clg_id)
            ->rightJoin('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_sale_invoice.si_party_code')
            ->where('account_clg_id', $user->user_clg_id)
            ->select('account_uid', 'account_name', 'si_day_end_date', DB::raw("SUM(si_grand_total) as sale"), DB::raw("SUM(si_invoice_profit) as profit"))
            ->where('account_parent_code', config('global_variables.payable'));

        if (!empty($search)) {
            $query->where('si_party_name', 'like', '%' . $search . '%');
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereBetween('si_day_end_date', [$start, $end]);
        } elseif (!empty($search_to)) {
            $query->where('si_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('si_day_end_date', $end);
        }


        $datas = $query->groupBy('si_party_code')
            ->orderBy('si_id', 'DESC')
            ->paginate($pagination_number);

        $party = AccountRegisterationModel::whereIn('account_parent_code', $heads)->where('account_clg_id', $user->user_clg_id)->orderBy('account_name', 'ASC')->pluck('account_name')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports/client_wise_profit', compact('datas', 'party', 'search', 'search_to', 'search_from'));
        }
    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function supplier_wise_profit(Request $request, $array = null, $str = null)
    {
        $heads = explode(',', config('global_variables.payable'));
        $user = Auth::user();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.supplier_wise_profit.supplier_wise_profit';
        $pge_title = 'Supplier Wise Profit List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $query = DB::table('financials_sale_invoice')
            ->where('si_clg_id', $user->user_clg_id)
            ->rightJoin('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_sale_invoice.si_party_code')
            ->where('account_clg_id', $user->user_clg_id)
            ->select('account_uid', 'account_name', 'si_day_end_date', DB::raw("SUM(si_grand_total) as sale"), DB::raw("SUM(si_invoice_profit) as profit"))
            ->where('account_parent_code', config('global_variables.payable'));

        if (!empty($search)) {
            $query->where('si_party_name', 'like', '%' . $search . '%');
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereBetween('si_day_end_date', [$start, $end]);
        } elseif (!empty($search_to)) {
            $query->where('si_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('si_day_end_date', $end);
        }


        $datas = $query->groupBy('si_party_code')
            ->orderBy('si_id', 'DESC')
            ->paginate($pagination_number);

        $party = AccountRegisterationModel::whereIn('account_parent_code', $heads)->where('account_clg_id', $user->user_clg_id)->orderBy('account_name', 'ASC')->pluck('account_name')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports/supplier_wise_profit', compact('datas', 'party', 'search', 'search_to', 'search_from'));
        }
    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function product_wise_profit(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.product_wise_profit.product_wise_profit';
        $pge_title = 'Product Wise Profit List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        if (!empty($search)) {
            $datas = DB::table('financials_sale_invoice_items')
                ->where('si_clg_id', $user->user_clg_id)
                ->rightJoin('financials_products', 'financials_products.pro_code', '=', 'financials_sale_invoice_items.sii_product_code')
                ->where('pro_clg_id', $user->user_clg_id)
                ->select('pro_code', 'pro_title', DB::raw("SUM(sii_product_profit) as profit"), DB::raw("SUM(sii_amount) as sale"))
                ->where('pro_title', 'like', '%' . $search . '%')
                ->groupBy('sii_product_code')
                ->orderBy('pro_title', 'ASC')
                ->paginate($pagination_number);
        } else {
            $datas = DB::table('financials_sale_invoice_items')
                ->where('sii_clg_id', $user->user_clg_id)
                ->rightJoin('financials_products', 'financials_products.pro_code', '=', 'financials_sale_invoice_items.sii_product_code')
                ->where('account_clg_id', $user->user_clg_id)
                ->select('pro_code', 'pro_title', DB::raw("SUM(sii_product_profit) as profit"), DB::raw("SUM(sii_amount) as sale"))
                ->groupBy('sii_product_code')
                ->orderBy('pro_title', 'ASC')
                ->paginate($pagination_number);
        }

        $products = ProductModel::where('pro_clg_id', $user->user_clg_id)->orderBy('pro_title', 'ASC')->pluck('pro_title')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports/product_wise_profit', compact('datas', 'products', 'search'));
        }
    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function product_last_purchase_rate_verification(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $accounts = AccountRegisterationModel::whereIn('account_parent_code', explode(',', config('global_variables.payable_receivable_cash')))->where('account_clg_id', $user->user_clg_id)->orderBy('account_name', 'ASC')->get();
        $products = ProductModel::where('pro_clg_id', $user->user_clg_id)->orderBy('pro_id', 'ASC')->get();

        $pro_code = '';
        $pro_name = '';


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_account = (!isset($request->account) && empty($request->account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->account;
        $search_product = (!isset($request->product) && empty($request->product)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.product_last_purchase_rate_verification.product_last_purchase_rate_verification';
        $pge_title = 'Product Last Purchase Rate Verification List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_account, $search_product, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        foreach ($products as $product) {
            $selected = $product->pro_code == $search_product ? 'selected' : '';
            $pro_code .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' $selected>$product->pro_code</option>";
            $pro_name .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' $selected>$product->pro_title</option>";
        }


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query_saletax = DB::table('financials_purchase_saletax_invoice')
            ->where('psi_clg_id', $user->user_clg_id)
            ->join('financials_purchase_saletax_invoice_items', 'financials_purchase_saletax_invoice.psi_id', '=', 'financials_purchase_saletax_invoice_items.psii_purchase_invoice_id')
            ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_purchase_saletax_invoice_items.psii_product_code')
            ->where('pro_clg_id', $user->user_clg_id);


        $query = DB::table('financials_purchase_invoice')
            ->where('pi_clg_id', $user->user_clg_id)
            ->join('financials_purchase_invoice_items', 'financials_purchase_invoice.pi_id', '=', 'financials_purchase_invoice_items.pii_purchase_invoice_id')
            ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_purchase_invoice_items.pii_product_code')
            ->where('pro_clg_id', $user->user_clg_id);
        //            ->where('pi_status', 'PURCHASE')
        //            ->where(function ($query) {
        //                $query->where('pi_party_code', 'like', config('global_variables.receivable') . '%')
        //                    ->orWhere('pi_party_code', 'like', config('global_variables.payable') . '%');
        //            });


        if (!empty($request->search)) {
            $query->where(function ($query) use ($search) {
                $query->where('pi_party_name', 'like', $search . '%')
                    ->orWhere('pii_product_name', 'like', $search . '%');
            });
            $query_saletax->where(function ($query_saletax) use ($search) {
                $query_saletax->where('psi_party_name', 'like', $search . '%')
                    ->orWhere('psii_product_name', 'like', $search . '%');
            });
        }

        if (!empty($search_account)) {
            $query->where('pi_party_code', $search_account);
            $query_saletax->where('psi_party_code', $search_account);
        }

        if (!empty($search_product)) {
            $get_p_id = PurchaseInvoiceItemsModel::where('pii_clg_id', $user->user_clg_id)->where('pii_product_code', $search_product)->pluck('pii_purchase_invoice_id')->all();
            $get_ps_id = PurchaseSaletaxItemsInvoiceModel::where('psii_clg_id', $user->user_clg_id)->where('psii_product_code', $search_product)->pluck('psii_purchase_invoice_id')->all();
            $query->whereIn('pi_id', $get_p_id);
            $query_saletax->whereIn('psi_id', $get_ps_id);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereBetween('pi_day_end_date', [$start, $end]);
            $query_saletax->whereBetween('psi_day_end_date', [$start, $end]);
        } elseif (!empty($search_to)) {
            $query->where('pi_day_end_date', $start);
            $query_saletax->where('psi_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('pi_day_end_date', $end);
            $query_saletax->where('psi_day_end_date', $end);
        }


        $query_saletax->select(DB::raw('psi_id as id, psi_party_code as party_code, psi_party_name as party_name, psii_product_code as product_code, psii_product_name as product_name, psii_qty as qty, psii_rate as rate, psii_amount as amount, psi_day_end_date as day_end_date, psii_created_at as update_datetime, "Sale Tax" as type'));

        $query_sale = $query->select(DB::raw('pi_id as id, pi_party_code as party_code, pi_party_name as party_name, pii_product_code as product_code, pii_product_name as product_name, pii_qty as qty, pii_rate as rate, pii_amount as amount, pi_day_end_date as day_end_date, pii_created_at as update_datetime, "Without Sale Tax" as type'))
            ->union($query_saletax)
            ->orderBy('update_datetime', 'DESC');


        $datas = DB::query()->fromSub($query_sale, 'financials_purchase_saletax_invoice')
            ->where('psi_clg_id', $user->user_clg_id)
            ->select('id', 'party_code', 'party_name', 'product_code', 'product_name', 'qty', 'rate', 'amount', 'day_end_date', 'type', 'update_datetime')
            ->groupBy('product_code')
            ->latest('update_datetime')
            ->first();


        //        $product_title = ProductModel::orderBy('pro_title', 'ASC')->pluck('pro_title')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
                'margin-top' => 24,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports/product_last_purchase_rate_verification', compact('datas', 'search', 'accounts', 'search_account', 'search_product', 'pro_code', 'pro_name', 'search_to', 'search_from'));
        }
    }
    // update code by shahzaib end


    // update code by nabeel start
    public function party_last_purchase_rate_verification(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $accounts = $this->get_account_query('purchase')[0];

        //        $accounts = AccountRegisterationModel::whereIn('account_parent_code', explode(',', config('global_variables.payable_receivable_cash')))->orderBy('account_name', 'ASC')->get();
        $products = ProductModel::where('pro_clg_id', $user->user_clg_id)->orderBy('pro_id', 'ASC')->get();

        $pro_code = '';
        $pro_name = '';


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_account = (!isset($request->account) && empty($request->account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->account;
        $search_product = (!isset($request->product) && empty($request->product)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.product_last_purchase_rate_verification.product_last_purchase_rate_verification';
        $pge_title = 'Product Last Purchase Rate Verification List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_account, $search_product, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        foreach ($products as $product) {
            $selected = $product->pro_code == $search_product ? 'selected' : '';
            $pro_code .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' $selected>$product->pro_code</option>";
            $pro_name .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' $selected>$product->pro_title</option>";
        }


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query_saletax = DB::table('financials_purchase_saletax_invoice')
            ->where('psi_clg_id', $user->user_clg_id)
            ->join('financials_purchase_saletax_invoice_items', 'financials_purchase_saletax_invoice.psi_id', '=', 'financials_purchase_saletax_invoice_items.psii_purchase_invoice_id')
            ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_purchase_saletax_invoice_items.psii_product_code')
            ->where('pro_clg_id', $user->user_clg_id);


        $query = DB::table('financials_purchase_invoice')
            ->where('pi_clg_id', $user->user_clg_id)
            ->join('financials_purchase_invoice_items', 'financials_purchase_invoice.pi_id', '=', 'financials_purchase_invoice_items.pii_purchase_invoice_id')
            ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_purchase_invoice_items.pii_product_code')
            ->where('pro_clg_id', $user->user_clg_id);
        //            ->where('pi_status', 'PURCHASE')
        //            ->where(function ($query) {
        //                $query->where('pi_party_code', 'like', config('global_variables.receivable') . '%')
        //                    ->orWhere('pi_party_code', 'like', config('global_variables.payable') . '%');
        //            });


        if (!empty($request->search)) {
            $query->where(function ($query) use ($search) {
                $query->where('pi_party_name', 'like', $search . '%')
                    ->orWhere('pii_product_name', 'like', $search . '%');
            });
            $query_saletax->where(function ($query_saletax) use ($search) {
                $query_saletax->where('psi_party_name', 'like', $search . '%')
                    ->orWhere('psii_product_name', 'like', $search . '%');
            });
        }

        if (!empty($search_account)) {
            $query->where('pi_party_code', $search_account);
            $query_saletax->where('psi_party_code', $search_account);
        }

        if (!empty($search_product)) {
            $get_p_id = PurchaseInvoiceItemsModel::where('pii_clg_id', $user->user_clg_id)->where('pii_product_code', $search_product)->pluck('pii_purchase_invoice_id')->all();
            $get_ps_id = PurchaseSaletaxItemsInvoiceModel::where('psii_clg_id', $user->user_clg_id)->where('psii_product_code', $search_product)->pluck('psii_purchase_invoice_id')->all();
            $query->whereIn('pi_id', $get_p_id);
            $query_saletax->whereIn('psi_id', $get_ps_id);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereBetween('pi_day_end_date', [$start, $end]);
            $query_saletax->whereBetween('psi_day_end_date', [$start, $end]);
        } elseif (!empty($search_to)) {
            $query->where('pi_day_end_date', $start);
            $query_saletax->where('psi_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('pi_day_end_date', $end);
            $query_saletax->where('psi_day_end_date', $end);
        }


        $query_saletax->select(DB::raw('psi_id as id, psi_party_code as party_code, psi_party_name as party_name, psii_product_code as product_code, psii_product_name as product_name, psii_qty as qty, psii_rate as rate, psii_amount as amount, psi_day_end_date as day_end_date, psii_created_at as update_datetime, "Sale Tax" as type'));

        $query_sale = $query->select(DB::raw('pi_id as id, pi_party_code as party_code, pi_party_name as party_name, pii_product_code as product_code, pii_product_name as product_name, pii_qty as qty, pii_rate as rate, pii_amount as amount, pi_day_end_date as day_end_date, pii_created_at as update_datetime, "Without Sale Tax" as type'))
            ->union($query_saletax)
            ->orderBy('update_datetime', 'DESC');


        $datas = DB::query()->fromSub($query_sale, 'financials_purchase_saletax_invoice')
            ->where('psi_clg_id', $user->user_clg_id)
            ->select('id', 'party_code', 'party_name', 'product_code', 'product_name', 'qty', 'rate', 'amount', 'day_end_date', 'type', 'update_datetime')
            ->groupBy('product_code')
            ->latest('update_datetime')
            ->get();


        //        $product_title = ProductModel::orderBy('pro_title', 'ASC')->pluck('pro_title')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
                'margin-top' => 24,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports/party_last_purchase_rate_verification', compact('datas', 'search', 'accounts', 'search_account', 'search_product', 'pro_code', 'pro_name', 'search_to', 'search_from'));
        }
    }
    // update code by nabeel end

    // update code by shahzaib start
    public function product_last_sale_rate_verification(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $accounts = AccountRegisterationModel::whereIn('account_parent_code', explode(',', config('global_variables.payable_receivable_cash')))->where('account_clg_id', $user->user_clg_id)->orderBy('account_name', 'ASC')->get();
        $products = ProductModel::where('pro_clg_id', $user->user_clg_id)->orderBy('pro_id', 'ASC')->get();
        $pro_code = '';
        $pro_name = '';

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_account = (!isset($request->account) && empty($request->account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->account;
        $search_product = (!isset($request->product) && empty($request->product)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.product_last_sale_rate_verification.product_last_sale_rate_verification';
        $pge_title = 'Product Last Sale Rate Verification List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_account, $search_product, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        foreach ($products as $product) {
            $selected = $product->pro_code == $search_product ? 'selected' : '';
            $pro_code .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' $selected>$product->pro_code</option>";
            $pro_name .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' $selected>$product->pro_title</option>";
        }

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query_saletax = DB::table('financials_sale_saletax_invoice')
            ->where('ssi_clg_id', $user->user_clg_id)
            ->join('financials_sale_saletax_invoice_items', 'financials_sale_saletax_invoice.ssi_id', '=', 'financials_sale_saletax_invoice_items.ssii_invoice_id')
            ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_sale_saletax_invoice_items.ssii_product_code')
            ->where('pro_clg_id', $user->user_clg_id);
        //            ->where(function ($query) {
        //                $query->where('ssi_party_code', 'like', config('global_variables.receivable') . '%')
        //                    ->orWhere('ssi_party_code', 'like', config('global_variables.payable') . '%');
        //            });

        $query = DB::table('financials_sale_invoice')
            ->where('si_clg_id', $user->user_clg_id)
            ->join('financials_sale_invoice_items', 'financials_sale_invoice.si_id', '=', 'financials_sale_invoice_items.sii_invoice_id')
            ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_sale_invoice_items.sii_product_code')
            ->where('pro_clg_id', $user->user_clg_id);

        if (!empty($request->search)) {
            $query->where(function ($query) use ($search) {
                $query->where('si_party_name', 'like', $search . '%')
                    ->orWhere('sii_product_name', 'like', $search . '%');
            });
            $query_saletax->where(function ($query_saletax) use ($search) {
                $query_saletax->where('ssi_party_name', 'like', $search . '%')
                    ->orWhere('ssii_product_name', 'like', $search . '%');
            });
        }

        if (!empty($search_account)) {
            $query->where('si_party_code', $search_account);
            $query_saletax->where('ssi_party_code', $search_account);
        }

        if (!empty($search_product)) {
            $get_p_id = SaleInvoiceItemsModel::where('ssi_clg_id', $user->user_clg_id)->where('sii_product_code', $search_product)->pluck('sii_invoice_id')->all();
            $get_ps_id = SaleSaletaxInvoiceItemsModel::where('ssii_clg_id', $user->user_clg_id)->where('ssii_product_code', $search_product)->pluck('ssii_invoice_id')->all();
            $query->whereIn('si_id', $get_p_id);
            $query_saletax->whereIn('ssi_id', $get_ps_id);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereBetween('si_day_end_date', [$start, $end]);
            $query_saletax->whereBetween('ssi_day_end_date', [$start, $end]);
        } elseif (!empty($search_to)) {
            $query->where('si_day_end_date', $start);
            $query_saletax->where('ssi_day_end_date', $start);
        } elseif (isset($search_from) && !empty($search_from)) {
            $query->where('si_day_end_date', $end);
            $query_saletax->where('ssi_day_end_date', $end);
        }

        $query_saletax->select(DB::raw('ssi_id as id, ssi_party_code as party_code, ssi_party_name as party_name, ssii_product_code as product_code, ssii_product_name as product_name, ssii_qty as qty, ssii_rate as rate, ssii_amount as amount, ssi_day_end_date as day_end_date, ssii_created_at as update_datetime, "Sale Tax" as type'));

        $query_sale = $query->select(DB::raw('si_id as id, si_party_code as party_code, si_party_name as party_name, sii_product_code as product_code, sii_product_name as product_name, sii_qty as qty, sii_rate as rate, sii_amount as amount, si_day_end_date as day_end_date, sii_created_at as update_datetime, "Without Sale Tax" as type'))
            ->union($query_saletax)
            ->orderBy('update_datetime', 'DESC');


        $datas = DB::query()->fromSub($query_sale, 'financials_purchase_saletax_invoice')
            ->where('psi_clg_id', $user->user_clg_id)
            ->select('id', 'party_code', 'party_name', 'product_code', 'product_name', 'qty', 'rate', 'amount', 'day_end_date', 'type', 'update_datetime')
            ->groupBy('product_code')
            ->latest('update_datetime')
            ->first();

        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
                'margin-top' => 24,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports/product_last_sale_rate_verification', compact('datas', 'search', 'accounts', 'search_account', 'search_product', 'pro_code', 'pro_name', 'search_to', 'search_from'));
        }
    }
    // update code by shahzaib end

    // update code by nabeel start
    public function party_last_sale_rate_verification(Request $request, $array = null, $str = null)
    {
        //        $accounts = AccountRegisterationModel::whereIn('account_parent_code', explode(',', config('global_variables.payable_receivable_cash')))->orderBy('account_name', 'ASC')->get();
        $user = Auth::user();
        $accounts = $this->get_account_query('sale')[0];

        $products = ProductModel::where('pro_clg_id', $user->user_clg_id)->orderBy('pro_id', 'ASC')->get();
        $pro_code = '';
        $pro_name = '';

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_account = (!isset($request->account) && empty($request->account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->account;
        $search_product = (!isset($request->product) && empty($request->product)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.product_last_sale_rate_verification.product_last_sale_rate_verification';
        $pge_title = 'Product Last Sale Rate Verification List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_account, $search_product, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        foreach ($products as $product) {
            $selected = $product->pro_code == $search_product ? 'selected' : '';
            $pro_code .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' $selected>$product->pro_code</option>";
            $pro_name .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' $selected>$product->pro_title</option>";
        }

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query_saletax = DB::table('financials_sale_saletax_invoice')
            ->where('ssi_clg_id', $user->user_clg_id)
            ->join('financials_sale_saletax_invoice_items', 'financials_sale_saletax_invoice.ssi_id', '=', 'financials_sale_saletax_invoice_items.ssii_invoice_id')
            ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_sale_saletax_invoice_items.ssii_product_code')
            ->where('pro_clg_id', $user->user_clg_id);
        //            ->where(function ($query) {
        //                $query->where('ssi_party_code', 'like', config('global_variables.receivable') . '%')
        //                    ->orWhere('ssi_party_code', 'like', config('global_variables.payable') . '%');
        //            });

        $query = DB::table('financials_sale_invoice')
            ->where('si_clg_id', $user->user_clg_id)
            ->join('financials_sale_invoice_items', 'financials_sale_invoice.si_id', '=', 'financials_sale_invoice_items.sii_invoice_id')
            ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_sale_invoice_items.sii_product_code')
            ->where('pro_clg_id', $user->user_clg_id);

        if (!empty($request->search)) {
            $query->where(function ($query) use ($search) {
                $query->where('si_party_name', 'like', $search . '%')
                    ->orWhere('sii_product_name', 'like', $search . '%');
            });
            $query_saletax->where(function ($query_saletax) use ($search) {
                $query_saletax->where('ssi_party_name', 'like', $search . '%')
                    ->orWhere('ssii_product_name', 'like', $search . '%');
            });
        }

        if (!empty($search_account)) {
            $query->where('si_party_code', $search_account);
            $query_saletax->where('ssi_party_code', $search_account);
        }

        if (!empty($search_product)) {
            $get_p_id = SaleInvoiceItemsModel::where('ssi_clg_id', $user->user_clg_id)->where('sii_product_code', $search_product)->pluck('sii_invoice_id')->all();
            $get_ps_id = SaleSaletaxInvoiceItemsModel::where('ssii_clg_id', $user->user_clg_id)->where('ssii_product_code', $search_product)->pluck('ssii_invoice_id')->all();
            $query->whereIn('si_id', $get_p_id);
            $query_saletax->whereIn('ssi_id', $get_ps_id);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereBetween('si_day_end_date', [$start, $end]);
            $query_saletax->whereBetween('ssi_day_end_date', [$start, $end]);
        } elseif (!empty($search_to)) {
            $query->where('si_day_end_date', $start);
            $query_saletax->where('ssi_day_end_date', $start);
        } elseif (isset($search_from) && !empty($search_from)) {
            $query->where('si_day_end_date', $end);
            $query_saletax->where('ssi_day_end_date', $end);
        }

        $query_saletax->select(DB::raw('ssi_id as id, ssi_party_code as party_code, ssi_party_name as party_name, ssii_product_code as product_code, ssii_product_name as product_name, ssii_qty as qty, ssii_rate as rate, ssii_amount as amount, ssi_day_end_date as day_end_date, ssii_created_at as update_datetime, "Sale Tax" as type'));

        $query_sale = $query->select(DB::raw('si_id as id, si_party_code as party_code, si_party_name as party_name, sii_product_code as product_code, sii_product_name as product_name, sii_qty as qty, sii_rate as rate, sii_amount as amount, si_day_end_date as day_end_date, sii_created_at as update_datetime, "Without Sale Tax" as type'))
            ->union($query_saletax)
            ->orderBy('update_datetime', 'DESC');


        $datas = DB::query()->fromSub($query_sale, 'financials_purchase_saletax_invoice')
            ->where('psi_clg_id', $user->user_clg_id)
            ->select('id', 'party_code', 'party_name', 'product_code', 'product_name', 'qty', 'rate', 'amount', 'day_end_date', 'type', 'update_datetime')
            ->groupBy('product_code')
            ->latest('update_datetime')
            ->get();

        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
                'margin-top' => 24,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports/party_last_sale_rate_verification', compact('datas', 'search', 'accounts', 'search_account', 'search_product', 'pro_code', 'pro_name', 'search_to', 'search_from'));
        }
    }
    // update code by nabeel end


    // update code by shahzaib start
    public function account_receivable_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $regions = RegionModel::where('reg_clg_id', $user->user_clg_id)->orderBy('reg_title', 'ASC')->get();
        $areas = AreaModel::where('area_clg_id', $user->user_clg_id)->orderBy('area_title', 'ASC')->get();
        $sectors = SectorModel::where('sec_clg_id', $user->user_clg_id)->orderBy('sec_title', 'ASC')->get();
        $groups = AccountGroupModel::where('ag_clg_id', $user->user_clg_id)->orderBy('ag_title', 'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_region = (!isset($request->region) && empty($request->region)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->region;
        $search_area = (!isset($request->area) && empty($request->area)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->area;
        $search_sector = (!isset($request->sector) && empty($request->sector)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->sector;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->group;
        $account_type = (!isset($request->account_type) && empty($request->account_type)) ? '' : $request->account_type;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.account_receivable_list.account_receivable_list';
        $pge_title = 'Account Receivable List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_region, $search_area, $search_sector, $search_group);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_accounts')
            ->where('account_clg_id', $user->user_clg_id)
            ->leftJoin('financials_region', 'financials_accounts.account_region_id', 'financials_region.reg_id')
            ->leftJoin('financials_sectors', 'financials_accounts.account_sector_id', 'financials_sectors.sec_id')
            ->leftJoin('financials_areas', 'financials_accounts.account_area', 'financials_areas.area_id')
            ->leftJoin('financials_account_group', 'financials_account_group.ag_id', 'financials_accounts.account_group_id')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_accounts.account_createdby')
            ->where('reg_clg_id', $user->user_clg_id)
            ->where('area_clg_id', $user->user_clg_id)
            ->where('sec_clg_id', $user->user_clg_id)
            ->where('ag_clg_id', $user->user_clg_id);

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('account_uid', 'like', '%' . $search . '%')
                    ->orWhere('account_name', 'like', '%' . $search . '%')
                    ->orWhere('financials_region.reg_title', 'like', '%' . $search . '%')
                    ->orWhere('financials_sectors.sec_title', 'like', '%' . $search . '%')
                    ->orWhere('financials_areas.area_title', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_region)) {
            $query->where('account_region_id', $search_region);
        }

        if (!empty($search_area)) {
            $query->where('account_area', $search_area);
        }

        if (!empty($search_sector)) {
            $query->where('account_sector_id', $search_sector);
        }

        if (!empty($search_group)) {
            $query->where('account_group_id', $search_group);
        }

        if (!empty($account_type)) {
            $query->where('account_type', $account_type);
        } else {
            $query->where('account_type', '!=', 0);
        }

        if (!empty($search_by_user)) {
            $query->where('account_createdby', $search_by_user);
        }

        if ($user->user_level !== 100) {
            $query->whereIn('account_group_id', explode(',', $user->user_group_id));
        }

        $datas = $query
            ->where('account_parent_code', config('global_variables.receivable'))
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->select('financials_accounts.*', 'financials_region.reg_title', 'financials_sectors.sec_title', 'financials_areas.area_title', 'financials_users.user_id', 'financials_users.user_name',
                'financials_users.user_designation', 'financials_account_group.ag_title')
            ->paginate($pagination_number);


        $query_lst = DB::table('financials_accounts')
            ->where('account_clg_id', $user->user_clg_id);
        if ($user->user_level !== 100) {
            $query_lst->whereIn('account_group_id', explode(',', $user->user_group_id));
        }
        $account_list = $query_lst->where('account_parent_code', config('global_variables.receivable'))
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->pluck('account_name')
            ->all();


        $balance = [];
        foreach ($datas as $account) {
            $default = 0;
            $default = BalancesModel::where('bal_clg_id', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();
            if (empty($default)) {
                $balance[] = 0;
            } else {
                $balance[] = $default;
            }
        }


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'balance', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $balance), $pge_title . '_x.xlsx');
            }
        } else {
            return view('account_receivable_list', compact('datas', 'balance', 'account_list', 'search', 'search_by_user', 'search_region', 'search_area', 'search_sector', 'search_group', 'account_type', 'regions', 'areas', 'sectors', 'groups'));
        }
    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function account_payable_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $regions = RegionModel::where('reg_clg_id', $user->user_clg_id)->orderBy('reg_title', 'ASC')->get();
        $areas = AreaModel::where('area_clg_id', $user->user_clg_id)->orderBy('area_title', 'ASC')->get();
        $sectors = SectorModel::where('sec_clg_id', $user->user_clg_id)->orderBy('sec_title', 'ASC')->get();
        $groups = AccountGroupModel::where('ag_clg_id', $user->user_clg_id)->orderBy('ag_title', 'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_region = (!isset($request->region) && empty($request->region)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->region;
        $search_area = (!isset($request->area) && empty($request->area)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->area;
        $search_sector = (!isset($request->sector) && empty($request->sector)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->sector;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->group;
        $account_type = (!isset($request->account_type) && empty($request->account_type)) ? '' : $request->account_type;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.account_receivable_list.account_receivable_list';
        $pge_title = 'Account Payable List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_region, $search_area, $search_sector, $search_group);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_accounts')
            ->where('ag_clg_id', $user->user_clg_id)
            ->leftJoin('financials_region', 'financials_accounts.account_region_id', 'financials_region.reg_id')
            ->leftJoin('financials_sectors', 'financials_accounts.account_sector_id', 'financials_sectors.sec_id')
            ->leftJoin('financials_areas', 'financials_accounts.account_area', 'financials_areas.area_id')
            ->leftJoin('financials_account_group', 'financials_account_group.ag_id', 'financials_accounts.account_group_id')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_accounts.account_createdby')
            ->where('reg_clg_id', $user->user_clg_id)
            ->where('area_clg_id', $user->user_clg_id)
            ->where('sec_clg_id', $user->user_clg_id)
            ->where('ag_clg_id', $user->user_clg_id);


        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('account_uid', 'like', '%' . $search . '%')
                    ->orWhere('account_name', 'like', '%' . $search . '%')
                    ->orWhere('financials_region.reg_title', 'like', '%' . $search . '%')
                    ->orWhere('financials_sectors.sec_title', 'like', '%' . $search . '%')
                    ->orWhere('financials_areas.area_title', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_region)) {
            $query->where('account_region_id', $search_region);
        }

        if (!empty($search_area)) {
            $query->where('account_area', $search_area);
        }

        if (!empty($search_sector)) {
            $query->where('account_sector_id', $search_sector);
        }

        if (!empty($search_group)) {
            $query->where('account_group_id', $search_group);
        }

        if (!empty($account_type)) {
            $query->where('account_type', $account_type);
        } else {
            $query->where('account_type', '!=', 0);
        }

        if (!empty($search_by_user)) {
            $query->where('account_createdby', $search_by_user);
        }

        if ($user->user_level !== 100) {
            $query->whereIn('account_group_id', explode(',', $user->user_group_id));
        }

        $datas = $query
            ->where('account_parent_code', config('global_variables.payable'))
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->select('financials_accounts.*', 'financials_region.reg_title', 'financials_sectors.sec_title', 'financials_areas.area_title', 'financials_users.user_id', 'financials_users.user_name', 'financials_users.user_designation', 'financials_account_group.ag_title')
            ->paginate($pagination_number);


        $query_lst = DB::table('financials_accounts')
            ->where('account_clg_id', $user->user_clg_id);
        if ($user->user_level !== 100) {
            $query_lst->whereIn('account_group_id', explode(',', $user->user_group_id));
        }
        $account_list = $query_lst->where('account_parent_code', config('global_variables.payable'))
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->pluck('account_name')
            ->all();

        $balance = [];
        foreach ($datas as $account) {
            $default = 0;
            $default = BalancesModel::where('bal_clg_id', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();
            if (empty($default)) {
                $balance[] = 0;
            } else {
                $balance[] = $default;
            }
        }

        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'balance', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $balance), $pge_title . '_x.xlsx');
            }
        } else {
            return view('account_payable_list', compact('datas', 'balance', 'account_list', 'search', 'search_region', 'search_area', 'search_sector', 'search_group', 'account_type', 'search_by_user', 'regions', 'areas', 'sectors', 'groups'));
        }
    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function party_wise_opening_closing(Request $request, $array = null, $str = null)
    {
        //        $first_query = DB::table('financials_balances')
        //            ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_balances.bal_account_id')
        //            ->select('account_uid', 'account_name', 'account_balance as opening', DB::raw('MAX(0) AS dr'), DB::raw('MAX(0) AS cr'), 'bal_total as closing')
        //            ->whereIn('bal_id', DB::table('financials_balances')->select(DB::raw('MAX(bal_id) AS bal_id'))->groupBy('bal_account_id')->pluck('bal_id')->all())
        //            ->groupBy('account_uid')
        //            ->get();
        //
        //
        //        $second_query = DB::table('financials_balances')
        //            ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_balances.bal_account_id')
        //            ->select('account_uid', 'account_name', DB::raw('MAX(0) AS opening'), DB::raw('SUM(bal_dr) AS dr'), DB::raw('SUM(bal_cr) AS cr'), DB::raw('MAX(0) AS closing'))
        //            ->groupBy('account_uid')
        //            ->get();
        //
        //        $results = $first_query->merge($second_query);
        //
        ////        dd($results);
        //
        //        DB::enableQueryLog();
        //        $query = DB::raw($results)
        //            ->select('account_uid', 'account_name', DB::raw('SUM(opening)'), DB::raw('SUM(dr)'), DB::raw('SUM(cr)'), DB::raw('SUM(closing)'))
        ////            ->groupBy('account_uid')
        //            ->get();
        //
        //        dd(DB::getQueryLog());

        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $prnt_page_dir = 'print.party_wise_opening_closing.party_wise_opening_closing';
        $pge_title = 'Party Wise Opening Closing List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);


        if (!empty($search)) {
            $datas = DB::select(
                DB::raw("select account_uid, account_name, sum(opening) as opening, sum(dr) as dr, sum(cr) as cr, sum(closing) as closing from (
                          (select account_uid, account_name, account_balance as opening, 0 as dr, 0 as cr,  bal_total as closing
                           from financials_balances
                             join financials_accounts on account_uid = bal_account_id
                           where account_parent_code in (11014, 21011) AND bal_clg_id = '$user->user_clg_id.' AND account_clg_id = '$user->user_clg_id.' And bal_id in (select max(bal_id) from financials_balances where bal_clg_id = '$user->user_clg_id.' group by bal_account_id)
                          and  account_name like '%" . $search . "%'
                           group by account_uid)

                          union all

                          (select account_uid, account_name, 0 as opening, sum(bal_dr) as dr, sum(bal_cr) as cr, 0 as closing
                           from financials_balances
                             join financials_accounts on account_uid = bal_account_id
                             where account_parent_code in (11014, 21011)
                             AND bal_clg_id = '$user->user_clg_id.'
                             AND account_clg_id = '$user->user_clg_id.'
                             and  account_name like '%" . $search . "%'
                           group by account_uid)
                        ) aa
                        group by account_uid")
            );
        } else {
            $datas = DB::select(
                DB::raw("select account_uid, account_name, sum(opening) as opening, sum(dr) as dr, sum(cr) as cr, sum(closing) as closing from (
              (select account_uid, account_name, account_balance as opening, 0 as dr, 0 as cr,  bal_total as closing
               from financials_balances
                 join financials_accounts on account_uid = bal_account_id
               where account_parent_code in (11014, 21011) AND bal_clg_id = '$user->user_clg_id.' AND account_clg_id = '$user->user_clg_id.' And bal_id in (select max(bal_id) from financials_balances where bal_clg_id = '$user->user_clg_id.' group by bal_account_id)
               group by account_uid)

              union all

              (select account_uid, account_name, 0 as opening, sum(bal_dr) as dr, sum(bal_cr) as cr, 0 as closing
               from financials_balances
                 join financials_accounts on account_uid = bal_account_id
                 where account_parent_code in (11014, 21011)
                 AND account_clg_id = '$user->user_clg_id.'
                 AND bal_clg_id = '$user->user_clg_id.'
               group by account_uid)
            ) aa
            group by account_uid")
            );
        }

        $heads = explode(',', config('global_variables.payable_receivable'));
        $party = AccountRegisterationModel::whereIn('account_parent_code', $heads)->where('account_clg_id', $user->user_clg_id)->orderBy('account_name', 'ASC')->pluck('account_name')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports/party_wise_opening_closing', compact('datas', 'party', 'search'));
        }
    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function product_ledger_stock_wise(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_product = (!isset($request->product_code) && empty($request->product_code)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->product_code;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.product_ledger_stock_wise.product_ledger_stock_wise';
        $pge_title = 'Product Ledger Stock Wise List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_product, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_from));
        $end = date('Y-m-d', strtotime($search_to));

        $query = StockMovementModels::query()
            ->where('sm_clg_id', $user->user_clg_id)
            ->leftJoin('financials_stock_movement_child', 'financials_stock_movement_child.smc_sm_id', 'financials_stock_movement.sm_id');

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('sm_product_name', 'like', '%' . $search . '%')
                    ->orWhere('sm_type', 'like', '%' . $search . '%')
                    ->orWhere('sm_product_code', 'like', '%' . $search . '%');
            });
        }
        if (!empty($search_product)) {
            $query->where('sm_product_code', $search_product);
        }
        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereBetween('sm_day_end_date', [$start, $end]);
        } elseif (!empty($search_from) && empty($search_to)) {
            $query->where('sm_day_end_date', $start);
        } elseif (!empty($search_to) && empty($search_from)) {
            $query->where('sm_day_end_date', $end);
        }

        //        if( !empty($search) || !empty($search_to) || !empty($search_from) ) {
        //            $datas = $query->paginate($pagination_number);
        //        }
        //        else {
        $datas = $query->orderBy('sm_id', 'ASC')->paginate($pagination_number);

        //        $products = ProductModel::orderBy('pro_id', 'ASC')->get();
        $products = ProductModel::where('pro_clg_id', $user->user_clg_id)->orderBy('pro_id', 'ASC')->get();

        $product = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_delete_status', '!=', 1)->orderBy('pro_title', 'ASC')->pluck('pro_title')->all();
        // dd($pro_name);

        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports/product_ledger_stock_wise', compact('datas', 'search', 'search_product', 'search_to', 'search_from', 'products', 'product'));
        }
    }
    // update code by shahzaib end

    // update code by shahzaib start
    public function product_wise_ledger(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_product = (!isset($request->product_code) && empty($request->product_code)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->product_code;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.product_ledger_stock_wise.product_ledger_stock_wise';
        $pge_title = 'Product Ledger Stock Wise List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_product, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_from));
        $end = date('Y-m-d', strtotime($search_to));

        $products_details = DB::table('financials_products')
            ->where('pro_clg_id', $user->user_clg_id)
            ->leftJoin('financials_categories', 'financials_categories.cat_id', '=', 'financials_products.pro_category_id')
            ->leftJoin('financials_groups', 'financials_groups.grp_id', '=', 'financials_products.pro_group_id')
            ->leftJoin('financials_brands', 'financials_brands.br_id', '=', 'financials_products.pro_brand_id')
            ->where('pro_p_code', '=', $search_product)
            ->select('financials_products.pro_id', 'financials_products.pro_p_code', 'financials_products.pro_title', 'financials_categories.cat_title', 'financials_groups.grp_title', 'financials_brands.br_title')
            ->first();

        $query = StockMovementModels::query();

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('sm_product_name', 'like', '%' . $search . '%')
                    ->orWhere('sm_type', 'like', '%' . $search . '%')
                    ->orWhere('sm_product_code', 'like', '%' . $search . '%');
            });
        }
        if (!empty($search_product)) {
            $query->where('sm_product_code', $search_product);
        }
        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereBetween('sm_day_end_date', [$start, $end]);
        } elseif (!empty($search_from) && empty($search_to)) {
            $query->where('sm_day_end_date', $start);
        } elseif (!empty($search_to) && empty($search_from)) {
            $query->where('sm_day_end_date', $end);
        }

        //        if( !empty($search) || !empty($search_to) || !empty($search_from) ) {
        //            $datas = $query->paginate($pagination_number);
        //        }
        //        else {
        $datas = $query->where('sm_clg_id', $user->user_clg_id)->where('sm_product_code', $search_product)->paginate($pagination_number);

        //        $products = ProductModel::orderBy('pro_id', 'ASC')->get();
        $products = ProductModel::where('pro_clg_id', $user->user_clg_id)->orderBy('pro_id', 'ASC')->get();

        $product = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_delete_status', '!=', 1)->orderBy('pro_title', 'ASC')->pluck('pro_title')->all();
        // dd($pro_name);

        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports/product_wise_ledger', compact('datas', 'search', 'search_product', 'search_to', 'search_from', 'products', 'product', 'products_details'));
        }
    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function product_ledger_amount_wise(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_product = (!isset($request->product_code) && empty($request->product_code)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product_code;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->to;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.product_ledger_amount_wise.product_ledger_amount_wise';
        $pge_title = 'Product Ledger Amount Wise List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_product, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_from));
        $end = date('Y-m-d', strtotime($search_to));

        $products_details = DB::table('financials_products')
            ->where('pro_clg_id', $user->user_clg_id)
            ->leftJoin('financials_categories', 'financials_categories.cat_id', '=', 'financials_products.pro_category_id')
            ->leftJoin('financials_groups', 'financials_groups.grp_id', '=', 'financials_products.pro_group_id')
            ->leftJoin('financials_brands', 'financials_brands.br_id', '=', 'financials_products.pro_brand_id')
            ->where('pro_p_code', '=', $search_product)
            ->select('financials_products.pro_id', 'financials_products.pro_p_code', 'financials_products.pro_title', 'financials_categories.cat_title', 'financials_groups.grp_title', 'financials_brands.br_title')
            ->first();

        //        dd($products_details,$search_product,$products);
        //        $type=[];
        //        $trans_id='';
        //        $id=[];
        //        $query = StockMovementModels::where('sm_product_code', $search_product)->where('sm_voucher_code','!=','')->pluck('sm_id','sm_voucher_code','sm_type');
        //        $querys = StockMovementModels::where('sm_product_code', $search_product)->where('sm_voucher_code','=','')->pluck('sm_id','sm_voucher_code','sm_type');
        //        dd($query,$querys);
        //        foreach ($query as $ids){
        //
        //            $trans_id = explode('-', $ids);
        //
        //            $type[] = $trans_id[0] . '-';
        //            dump($id[] = $trans_id[1]);
        //        }

        //        $trans_id = explode('-', $query);
        //        $type = $trans_id[0] . '-';
        //        $id = $trans_id[1];
        //        dd($trans_id);
        //        dd($query,$type,$id,$trans_id);
        //        dd($query,$trans_id,$type,$id);
        $query = StockMovementModels::query();


        //        if (!empty($search)) {
        //            $query->where(function ($query) use ($search) {
        //                $query->where('sm_product_name', 'like', '%' . $search . '%')
        //                    ->orWhere('sm_type', 'like', '%' . $search . '%')
        //                    ->orWhere('sm_product_code', 'like', '%' . $search . '%');
        //            });
        //        }
        //        if (!empty($search_product)) {
        //            $query->where('sm_product_code', $search_product);
        //        }
        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereBetween('sm_day_end_date', [$start, $end]);
        } elseif (!empty($search_from) && empty($search_to)) {
            $query->where('sm_day_end_date', $start);
        } elseif (!empty($search_to) && empty($search_from)) {
            $query->where('sm_day_end_date', $end);
        }


        $datas = $query
            ->where('sm_clg_id', $user->user_clg_id)
            ->where('sm_product_code', $search_product)
            ->paginate($pagination_number);

        $products = ProductModel::where('pro_clg_id', $user->user_clg_id)->orderBy('pro_id', 'ASC')->get();

        //        $pro_code = '';
        //        $pro_name = '';
        //
        //        foreach ($products as $product) {
        //            $selected = $product->pro_code == $search_product ? 'selected' : '';
        //            $pro_code .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' $selected>$product->pro_code</option>";
        //            $pro_name .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' $selected>$product->pro_title</option>";
        //        }

        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports/product_ledger_amount_wise', compact('datas', 'products', 'products_details', 'search_product', 'search_to', 'search_from', 'search'));
        }
    }

    // update code by shahzaib end


    public function warehouse_stock(Request $request)
    {
        $user = Auth::user();
        $products = ProductModel::where('pro_clg_id', $user->user_clg_id)->orderBy('pro_title', 'ASC')->get();
        $warehouses = WarehouseModel::where('wh_clg_id', $user->user_clg_id)->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_warehouse = (!isset($request->warehouse) && empty($request->warehouse)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->warehouse;
        $search_pro_code = (!isset($request->pro_name) && empty($request->pro_name)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->pro_name;

        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.warehouse_stock_list.warehouse_stock_list';
        $pge_title = 'Warehouse Stock';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_warehouse, $search_pro_code);


        $pagination_number = 30;

        $query = DB::table('financials_warehouse_stock')
            ->where('whs_clg_id', $user->user_clg_id)
            ->leftJoin('financials_products', 'financials_products.pro_p_code', '=', 'financials_warehouse_stock.whs_product_code')
            ->leftJoin('financials_warehouse', 'financials_warehouse.wh_id', '=', 'financials_warehouse_stock.whs_warehouse_id')
            ->where('pro_clg_id', $user->user_clg_id)
            ->where('wh_clg_id', $user->user_clg_id)
            ->select('pro_title', 'pro_code', 'pro_average_rate', 'wh_title', 'whs_stock');

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('wh_title', 'like', '%' . $search . '%')
                    //                    ->orWhere('wh_type', 'like', '%' . $search . '%')
                    ->orWhere('whs_product_code', 'like', '%' . $search . '%');
            });
        }

        if (isset($search_pro_code) && !empty($search_pro_code)) {
            $pagination_number = 1000000;
            $query->where('whs_product_code', $search_pro_code);
        }

        if (isset($search_warehouse) && !empty($search_warehouse)) {
            $pagination_number = 1000000;
            $query->where('whs_warehouse_id', $search_warehouse);
        }

        $datas = $query->orderBy('pro_title', 'ASC')
            //->groupBy('pro_title')
            ->paginate($pagination_number);
        $warehousess = WarehouseModel::where('wh_clg_id', $user->user_clg_id)->orderBy('wh_title', 'ASC')->pluck('wh_title')->all();
        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports/warehouse_stock', compact('datas', 'products', 'search_pro_code', 'search_warehouse', 'warehouses', 'warehousess'));
        }
    }


    // update code by shahzaib start
    public function balance_sheet(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $prnt_page_dir = 'print.balance_sheet.balance_sheet';
        $pge_title = 'Balance Sheet';
        $srch_fltr = [];
        $balance = 0;
        $cshBkDate = 0;
        $opening_balance = 0;
        $income_statement = 0;
        $datas = 0;


        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $your_date = strtotime("-1 day", strtotime($day_end->de_datetime));
        $new_date = date("Y-m-d", $your_date);

        $balance_sheet = BalanceSheetModel::where('bal_clg_id', $user->user_clg_id)->where('bs_day_end_date', $new_date)->first();

        if ($balance_sheet) {
            $assets_items = BalanceSheetItemsModel::where('bsi_balance_sheet_id', $balance_sheet->bs_id)->where('bsi_type', 'ASSETS')->get();
            $liabilities_items = BalanceSheetItemsModel::where('bsi_balance_sheet_id', $balance_sheet->bs_id)->where('bsi_type', 'LIABILITIES')->get();
            $equities_items = BalanceSheetItemsModel::where('bsi_balance_sheet_id', $balance_sheet->bs_id)->where('bsi_type', 'EQUITIES')->get();
        } else {
            $assets_items = [];
            $liabilities_items = [];
            $equities_items = [];
        }


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
                'margin-top' => 24,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'balance_sheet', 'assets_items', 'liabilities_items', 'equities_items'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $balance, $cshBkDate, $opening_balance, $income_statement, $balance_sheet, $assets_items, $liabilities_items, $equities_items), $pge_title . '_x.xlsx');
            }
        } else {
            return view('balance_sheet', compact('balance_sheet', 'assets_items', 'liabilities_items', 'equities_items'));
        }
    }

    // update code by shahzaib end


    public function walk_in_customers_report(Request $request)
    {
        $user = Auth::user();
        $pagination_number = 30;
        //        $pagination_number = 1000000;
        $walk_in_customers = SaleInvoiceModel::where('si_clg_id', $user->user_clg_id)->where('si_phone_number', '!=', '')->orwhere('si_email', '!=', '')->where('si_whatsapp', '!=', '')->paginate($pagination_number);

        return view('reports/walk_in_customer_report', compact('walk_in_customers'));
    }

    public function force_offline_user(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $groups = AccountGroupModel::where('ag_clg_id', $user->user_clg_id)->orderBy('ag_title', 'ASC')->get();
        $roles = RolesModel::orderBy('user_role_id', 'ASC')->get();
        $modular_groups = Role::where('clg_id', $user->user_clg_id)->where('id', '!=', 1)->orderby('name', 'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_salary_account = (!isset($request->salary_account) && empty($request->salary_account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->salary_account;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->group;
        $search_modular_group = (!isset($request->modular_group) && empty($request->modular_group)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->modular_group;
        $search_user_type = (!isset($request->user_type) && empty($request->user_type)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->user_type;
        $search_role = (!isset($request->role) && empty($request->role)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->role;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';


        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.employee_list.employee_list';
        $pge_title = 'Employee List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_salary_account, $search_group, $search_modular_group, $search_user_type, $search_role);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        //        $query = User::query()
        $query = DB::table('financials_users as usrs')
            ->where('usrs.user_clg_id', $user->user_clg_id)
            ->leftJoin('financials_account_group', 'financials_account_group.ag_id', 'usrs.user_account_reporting_group_ids')
            ->where('ag_clg_id', $user->user_clg_id)
            ->leftJoin('financials_users as usr_crtd_info', 'usr_crtd_info.user_id', 'usrs.user_createdby');


        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('usrs.user_account_uid', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_name', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_username', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_email', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_mobile', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_cnic', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_salary', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_address', 'like', '%' . $search . '%')
                    ->orWhere('usr_crtd_info.user_designation', 'like', '%' . $search . '%')
                    ->orWhere('usr_crtd_info.user_name', 'like', '%' . $search . '%')
                    ->orWhere('usr_crtd_info.user_username', 'like', '%' . $search . '%')
                    ->orWhere('ag_title', 'like', '%' . $search . '%');
            });
        }

        //        if (!empty($search_salary_account)) {
        //            $query->where('usrs.user_account_uid', $search_salary_account);
        //        }

        if (!empty($search_group)) {
            $query->whereRaw('FIND_IN_SET(' . $search_group . ',usrs.user_group_id)');
        }

        if (!empty($search_role)) {
            $query->where('usrs.user_role_id', $search_role);
        }

        if (!empty($search_modular_group)) {
            $query->where('usrs.user_modular_group_id', $search_modular_group);
        }

        if (!empty($search_user_type)) {
            $query->where('usrs.user_level', $search_user_type);
        }

        if (isset($search_by_user) && !empty($search_by_user)) {
            $query->where('usrs.user_createdby', $search_by_user);
        }


        $datas = $query->where('usrs.user_desktop_status', config('global_variables.online'))
            ->select('usrs.*', 'usr_crtd_info.user_name as usr_crtd', 'usr_crtd_info.user_designation as usr_crtd_desig', 'financials_account_group.ag_title')
            ->orderBy('usrs.user_id', 'DESC')
            ->paginate($pagination_number);

        $employee = User::where('user_clg_id', $user->user_clg_id)->where('user_id', '!=', 1)->orderBy('user_name', 'ASC')->pluck('user_name')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports/force_offline_user', compact(
                'datas',
                'search',
                'employee',
                'groups',
                'roles',
                'modular_groups',
                'search_group',
                'search_role',
                'search_modular_group',
                'search_user_type'
            ));
        }
    }
    public function force_offline_user_web(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $groups = AccountGroupModel::where('ag_clg_id', $user->user_clg_id)->orderBy('ag_title', 'ASC')->get();
        $roles = RolesModel::orderBy('user_role_id', 'ASC')->get();
        $modular_groups = Role::where('clg_id', $user->user_clg_id)->where('id', '!=', 1)->orderby('name', 'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_salary_account = (!isset($request->salary_account) && empty($request->salary_account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->salary_account;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->group;
        $search_modular_group = (!isset($request->modular_group) && empty($request->modular_group)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->modular_group;
        $search_user_type = (!isset($request->user_type) && empty($request->user_type)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->user_type;
        $search_role = (!isset($request->role) && empty($request->role)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->role;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';


        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.employee_list.employee_list';
        $pge_title = 'Employee List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_salary_account, $search_group, $search_modular_group, $search_user_type, $search_role);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        //        $query = User::query()
        $query = DB::table('financials_users as usrs')
            ->where('usrs.user_clg_id', $user->user_clg_id);
        // ->get();
        // dd($query);
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('usrs.user_account_uid', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_name', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_username', 'like', '%' . $search . '%');
            });
        }

        //        if (!empty($search_salary_account)) {
        //            $query->where('usrs.user_account_uid', $search_salary_account);
        //        }

        if (!empty($search_group)) {
            $query->whereRaw('FIND_IN_SET(' . $search_group . ',usrs.user_group_id)');
        }

        if (!empty($search_role)) {
            $query->where('usrs.user_role_id', $search_role);
        }

        if (!empty($search_modular_group)) {
            $query->where('usrs.user_modular_group_id', $search_modular_group);
        }

        if (!empty($search_user_type)) {
            $query->where('usrs.user_level', $search_user_type);
        }

        if (isset($search_by_user) && !empty($search_by_user)) {
            $query->where('usrs.user_createdby', $search_by_user);
        }


        $datas = $query->where('usrs.session_id', '!=', 'NULL')
            ->select('usrs.*', 'usrs.user_name as usr_crtd', 'usrs.user_designation as usr_crtd_desig')
            ->orderBy('usrs.user_id', 'DESC')
            ->paginate($pagination_number);
        // ->get();
        // dd($datas);

        $employee = User::where('user_clg_id', $user->user_clg_id)->where('user_id', '!=', 1)->orderBy('user_name', 'ASC')->pluck('user_name')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports.force_offline_user_web', compact(
                'datas',
                'search',
                'employee',
                'groups',
                'roles',
                'modular_groups',
                'search_group',
                'search_role',
                'search_modular_group',
                'search_user_type'
            ));
        }
    }

    // update code by shahzaib start
    public function stock_activity_report(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $main_units = MainUnitModel::where('mu_clg_id', $user->user_clg_id)->where('mu_delete_status', '!=', 1)->where('mu_disabled', '!=', 1)->orderby('mu_title', 'ASC')->get();
        $units = UnitInfoModel::where('unit_clg_id', $user->user_clg_id)->where('unit_delete_status', '!=', 1)->where('unit_disabled', '!=', 1)->orderBy('unit_title', 'ASC')->get();
        $groups = GroupInfoModel::where('grp_clg_id', $user->user_clg_id)->where('grp_delete_status', '!=', 1)->where('grp_disabled', '!=', 1)->orderBy('grp_title', 'ASC')->get();
        $categories = CategoryInfoModel::where('cat_clg_id', $user->user_clg_id)->where('cat_delete_status', '!=', 1)->where('cat_disabled', '!=', 1)->orderBy('cat_title', 'ASC')->get();
        $product_groups = ProductGroupModel::where('pg_clg_id', $user->user_clg_id)->where('pg_delete_status', '!=', 1)->where('pg_disabled', '!=', 1)->orderBy('pg_title', 'ASC')->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_main_unit = (!isset($request->main_unit) && empty($request->main_unit)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->main_unit;
        $search_unit = (!isset($request->unit) && empty($request->unit)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->unit;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->group;
        $search_category = (!isset($request->category) && empty($request->category)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->category;
        $search_product_group = (!isset($request->product_group) && empty($request->product_group)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->product_group;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[7]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[8]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.stock_activity_report.stock_activity_report';
        $pge_title = 'Stock Activity';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_main_unit, $search_unit, $search_group, $search_category, $search_product_group, $search_to, $search_from);

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));
        //        $start = '2021-11-13';
        $query = DB::table('financials_products')
            ->where('pro_clg_id', $user->user_clg_id)
            ->rightJoin('financials_stock_movement', 'financials_stock_movement.sm_product_code', '=', 'financials_products.pro_p_code')
            ->where('sm_clg_id', $user->user_clg_id);
        if (!empty($search)) {
            $query->where('pro_code', 'like', '%' . $search . '%')
                ->orWhere('pro_title', 'like', '%' . $search . '%');
        }

        if (!empty($search_main_unit)) {
            $query->where('pro_main_unit_id', $search_main_unit);
        }

        if (!empty($search_unit)) {
            $query->where('pro_unit_id', $search_unit);
        }

        if (!empty($search_group)) {
            $query->where('pro_group_id', $search_group);
        }

        if (!empty($search_category)) {
            $query->where('pro_category_id', $search_category);
        }

        if (!empty($search_product_group)) {
            $query->where('pro_reporting_group_id', $search_product_group);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            //            $query->whereBetween('si_day_end_date', [$start, $end]);
            $query->whereDate('sm_day_end_date', '>=', $start)
                ->whereDate('sm_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('sm_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('sm_day_end_date', $end);
        }

        ////        if (!empty($search)) {
        $datas = $query->select('pro_p_code', 'pro_title', 'pro_last_purchase_rate', 'pro_average_rate', DB::raw("SUM(sm_in_qty) as in_qty"), DB::raw("SUM(sm_out_qty) as out_qty"), DB::raw("SUM(sm_in_bonus) as in_bonus_qty"), DB::raw("SUM(sm_out_bonus) as out_bonus_qty"), DB::raw(
            "(SELECT
    IF( (SELECT sm_bal_total_qty FROM financials_stock_movement WHERE sm_clg_id = '$user->user_clg_id' AND sm_product_code = pro_p_code AND sm_day_end_date < '$start' ORDER BY sm_id ASC LIMIT 1) >= 0,
     (SELECT sm_bal_total_qty FROM financials_stock_movement WHERE sm_clg_id = '$user->user_clg_id' AND sm_product_code = pro_p_code AND sm_day_end_date < '$start' ORDER BY sm_id DESC LIMIT 1),
      (SELECT sm_bal_total_qty FROM financials_stock_movement WHERE sm_clg_id = '$user->user_clg_id' AND sm_product_code = pro_p_code AND sm_day_end_date <= '$start' ORDER BY sm_id ASC LIMIT 1) ))
as opening_stock"
        ))
            ->groupBy('sm_product_code')
            ->orderBy('pro_title', 'ASC')->get();

        //        } else {
        //            $datas = DB::table('financials_products')
        //                ->rightJoin('financials_stock_movement', 'financials_stock_movement.sm_product_code', '=', 'financials_products.pro_p_code')
        //                ->select('pro_p_code', 'pro_title', 'pro_last_purchase_rate', 'pro_average_rate', DB::raw("SUM(sm_in_qty) as in_qty"), DB::raw("SUM(sm_out_qty) as out_qty"), DB::raw("SUM(sm_in_bonus) as in_bonus_qty"), DB::raw("SUM(sm_out_bonus) as out_bonus_qty"), DB::raw(
        //                    "(SELECT
        //    IF( (SELECT sm_bal_total_qty FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date < '$start' ORDER BY sm_id ASC LIMIT 1) >= 0,
        //     (SELECT sm_bal_total_qty FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date < '$start' ORDER BY sm_id DESC LIMIT 1),
        //      (SELECT sm_bal_total_qty FROM financials_stock_movement WHERE sm_product_code = pro_p_code AND sm_day_end_date <= '$start' ORDER BY sm_id ASC LIMIT 1) ))
        //as opening_stock"))
        //                ->groupBy('sm_product_code')
        //                ->orderBy('pro_title', 'ASC')->get();
        //                ->paginate($pagination_number);
        //        }
        //dd($datas);

        //        $balance = [];
        //        foreach ($datas as $account) {
        //            $default = 0;
        //
        //            $defaults = StockMovementModels::where('sm_product_code', $account->pro_p_code);
        //            if (!empty($search_from)) {
        //                $defaults->where('sm_day_end_date', '=', $end);
        //            }
        //            $default = $defaults->orderBy('sm_id', 'DESC')->first();
        //            if (empty($default)) {
        //                $balance[] = 0;
        //            } else {
        //                $balance[] = $default;
        //            }
        //        }

        $products = ProductModel::where('pro_clg_id', $user->user_clg_id)->orderBy('pro_title', 'ASC')->pluck('pro_title')->all();

        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('reports/stock_activity_report', compact('datas', 'search', 'products', 'main_units', 'units', 'groups', 'categories', 'product_groups', 'search_main_unit', 'search_unit', 'search_group', 'search_category', 'search_by_user', 'search_product_group', 'search_to', 'search_from'));
            //            return view('reports/stock_activity_report', compact('datas', 'products', 'search'));
        }
    }
    // update code by shahzaib end

}
