<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Exports\OpeningExcelExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Imports\ExcelDataImport;
use App\Models\AccountHeadsModel;
use App\Models\AccountRegisterationModel;
use App\Models\AreaModel;
use App\Models\BalancesModel;
use App\Models\DayEndModel;
use App\Models\OpeningTrialBalanceModel;
use App\Models\ProductModel;
use App\Models\RegionModel;
use App\Models\SectorModel;
use App\Models\StockMovementModels;
use App\Models\SystemConfigModel;
use Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AccountOpeningBalancesController extends ExcelForm\AccountOpeningBalanceForm\AccountOpeningBalancesController
{


    // update code by shahzaib start
    public function account_opening_balance(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();

        $count = DayEndModel::where('de_clg_id',$user->user_clg_id)->count();
        if ($count == 0) {
            $stock_amount = ProductModel::where('pro_clg_id',$user->user_clg_id)->where('pro_type', config('global_variables.parent_product_type'))
                ->select(DB::raw('(pro_purchase_price * pro_quantity) as total'))->get();

            $total_stock = $stock_amount->sum('total');

            $exist_stock_account = OpeningTrialBalanceModel::where('tb_clg_id',$user->user_clg_id)->where('tb_account_id', config('global_variables.stock_in_hand'))->first();

            if ($exist_stock_account) {
                $exist_stock_account->tb_total_debit = $total_stock;

                $exist_stock_account->save();
            } else {
                $new_data[] = $this->assign_opening_trial_values(config('global_variables.stock_in_hand'), config('global_variables.stock_account_name'), $total_stock, 0);

                DB::table('financials_opening_trial_balance')->insert($new_data);
            }


            $regions = RegionModel::where('reg_clg_id',$user->user_clg_id)->orderBy('reg_title', 'ASC')->get();
            $areas = AreaModel::where('area_clg_id',$user->user_clg_id)->orderBy('area_title', 'ASC')->get();
            $sectors = SectorModel::where('sec_clg_id',$user->user_clg_id)->orderBy('sec_title', 'ASC')->get();


            $search_region = $request->region;
            $search_area = $request->area;
            $search_sector = $request->sector;


            $title = 'Account';
            $balance = $title;

            $first_heads = AccountHeadsModel::where('coa_clg_id',$user->user_clg_id)->where('coa_level', 1)->orderBy('coa_id', 'ASC')->get();

// $first_heads = AccountHeadsModel::where('coa_clg_id',$user->user_clg_id)->where('coa_level', 1)->where('coa_code', '!=', config('global_variables.revenue'))->where('coa_code', '!=',
//                config('global_variables.expense'))->orderBy('coa_id', 'ASC')->get();

            $second_heads = AccountHeadsModel::where('coa_clg_id',$user->user_clg_id)
                //->where('coa_parent', '!=', config('global_variables.revenue'))
                //->where('coa_parent', '!=', config('global_variables.expense'))
                ->where('coa_level', 2)
                ->orderBy('coa_id', 'ASC')
                ->get();

            $third_heads = AccountHeadsModel::where('coa_clg_id',$user->user_clg_id)->where('coa_parent', 'like', 1 . '%')
                ->orwhere('coa_parent', 'like', 2 . '%')
                ->orwhere('coa_parent', 'like', 5 . '%')
                ->where('coa_level', 3)
                ->orderBy('coa_id', 'ASC')
                ->get();

            $route = 'account_opening_balance';

            $ar = json_decode($request->array);
            $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
            $search_first_head = (!isset($request->first_head) && empty($request->first_head)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->first_head;
            $search_second_head = (!isset($request->second_head) && empty($request->second_head)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->second_head;
            $search_third_head = (!isset($request->third_head) && empty($request->third_head)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->third_head;
            $search_account_name = (!isset($request->account_name) && empty($request->account_name)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->account_name;
            $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
            $prnt_page_dir = 'print.' . $route . '.' . $route;
            $pge_title = $title . '_opening_balance';
            $srch_fltr = [];
            array_push($srch_fltr, $search, $search_first_head, $search_second_head, $search_third_head);

            $pagination_number = (empty($ar)) ? 100000000 : 100000000;

            $query = DB::table('financials_accounts')
                ->where('account_clg_id',$user->user_clg_id)
                ->leftJoin('financials_opening_trial_balance', 'financials_opening_trial_balance.tb_account_id', 'financials_accounts.account_uid')
                ->leftJoin('financials_coa_heads as parent_account', 'parent_account.coa_code', 'financials_accounts.account_parent_code')
                ->leftJoin('financials_coa_heads as group_account', 'group_account.coa_code', 'parent_account.coa_parent')
                ->leftJoin('financials_coa_heads as control_account', 'control_account.coa_code', 'group_account.coa_parent')
                ->wherenotIn('financials_accounts.account_uid',['410101','410111','	410121'])
                // ->where('financials_opening_trial_balance.tb_clg_id',$user->user_clg_id)
                ->where('parent_account.coa_clg_id',$user->user_clg_id)
                ->where('control_account.coa_clg_id',$user->user_clg_id)
                ->where('group_account.coa_clg_id',$user->user_clg_id);


            if (!empty($search)) {
                $query->where(function ($query) use ($search) {
                    $query->where('account_uid', 'like', '%' . $search . '%')
                        ->orWhere('account_name', 'like', '%' . $search . '%')
                        ->orWhere('control_account.coa_head_name', 'like', '%' . $search . '%')
                        ->orWhere('group_account.coa_head_name', 'like', '%' . $search . '%')
                        ->orWhere('parent_account.coa_head_name', 'like', '%' . $search . '%')
                        ->orWhere('control_account.coa_code', 'like', '%' . $search . '%')
                        ->orWhere('group_account.coa_code', 'like', '%' . $search . '%')
                        ->orWhere('parent_account.coa_code', 'like', '%' . $search . '%');
                });
            }

            if (!empty($search_first_head)) {
                $query->where('control_account.coa_code', '=', $search_first_head);
            }

            if (!empty($search_second_head)) {
                $query->where('group_account.coa_code', '=', $search_second_head);
            }

            if (!empty($search_third_head)) {
                $query->where('parent_account.coa_code', '=', $search_third_head);
            }

            if (!empty($search_account_name)) {
                $query->where('financials_accounts.account_name', '=', $search_account_name);
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

            if (!empty($search_region) && !empty($search_area) && !empty($search_sector)) {
                if (!empty($search_first_head) && !empty($search_second_head) && !empty($search_third_head) && !empty($search_account_name)) {
                    $query->where('account_uid', 'like', 1 . '%')
                        ->orWhere('account_uid', 'like', 2 . '%')
                        ->orWhere('account_uid', 'like', 5 . '%');
                }
            }

            //->whereNotIn('account_uid', $account_not_in)

            $datas = $query->select('financials_accounts.*', 'financials_opening_trial_balance.*', 'parent_account.coa_head_name as parnt_acnt_name', 'group_account.coa_head_name as grp_acnt_name')
                ->orderBy('account_parent_code', 'ASC')
                ->orderBy('account_uid', 'ASC')
                ->paginate($pagination_number);


            $sumQuery = DB::table('financials_accounts')
                ->leftJoin('financials_opening_trial_balance', 'financials_opening_trial_balance.tb_account_id', 'financials_accounts.account_uid')
                ->leftJoin('financials_coa_heads as parent_account', 'parent_account.coa_code', 'financials_accounts.account_parent_code')
                ->leftJoin('financials_coa_heads as group_account', 'group_account.coa_code', 'parent_account.coa_parent')
                ->leftJoin('financials_coa_heads as control_account', 'control_account.coa_code', 'group_account.coa_parent')
                ->where('account_clg_id',$user->user_clg_id)
                // ->where('financials_opening_trial_balance.tb_clg_id',$user->user_clg_id)
                ->where('parent_account.coa_clg_id',$user->user_clg_id)
                ->where('control_account.coa_clg_id',$user->user_clg_id)
                ->where('group_account.coa_clg_id',$user->user_clg_id)
                ->select('financials_opening_trial_balance.tb_total_debit', 'financials_opening_trial_balance.tb_total_credit')
                ->orderBy('account_parent_code', 'ASC')
                ->orderBy('account_uid', 'ASC');

            $drBalanceSum = $sumQuery->sum("tb_total_debit");
            $crBalanceSum = $sumQuery->sum("tb_total_credit");


            $account_names = AccountRegisterationModel::where('account_clg_id',$user->user_clg_id)->
//        whereNotIn('account_parent_code', $heads)
//            ->whereNotIn('account_uid', $account_not_in)
            where('account_uid', 'like', 1 . '%')
                ->orWhere('account_uid', 'like', 2 . '%')
                ->orWhere('account_uid', 'like', 5 . '%')
                ->orderBy('account_parent_code', 'ASC')
                ->orderBy('account_name', 'ASC')
                ->pluck('account_name')
                ->all();
            if ($request->ajax()) {
                if ($datas != null) {
                    $view = view('infinite_scroll.account_opening_balance_data', compact('datas', 'title', 'route', 'account_names', 'first_heads', 'total_stock', 'drBalanceSum', 'crBalanceSum'))->render();
                    return response()->json(['html' => $view, 'message' => 'Loading More data']);
                }
                return response()->json(['html' => ' ', 'message' => 'No More data']);
            }
            if (isset($request->array) && !empty($request->array)) {

                $type = (isset($request->str)) ? $request->str : '';

                $footer = view('print._partials.pdf_footer')->render();
                $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
                $options = [
                    'footer-html' => $footer,
                    'header-html' => $header,
                ];

                $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'balance', 'total_stock'));
                $pdf->setOptions($options);


                if ($type === 'pdf') {
                    return $pdf->stream($pge_title . '_x.pdf');
                } else if ($type === 'download_pdf') {
                    return $pdf->download($pge_title . '_x.pdf');
                } else if ($type === 'download_excel') {
                    return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $balance), $pge_title . '_x.xlsx');
//                return Excel::download(new OpeningExcelExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $balance, "", "", "", "", "", "", "", $total_stock), $pge_title . '_x.xlsx');
                }

            } else {

                WizardController::updateWizardInfo(['opening_party_balance'], ['opening_trail']);
                return view('account_opening_balance', compact('datas', 'title', 'route', 'account_names', 'first_heads', 'second_heads', 'third_heads', 'search', 'search_first_head', 'search_second_head', 'search_third_head', 'search_account_name', 'total_stock', 'areas', 'sectors', 'regions', 'search_region', 'search_area', 'search_sector', 'drBalanceSum', 'crBalanceSum'));
            }
        } else {
            return redirect()->route('home')->with("fail", "Can not proceed again ");
        }
    }

    // update code by shahzaib end


    public function update_account_opening_balance_excel(Request $request)
    {

        $rules = [
            'add_account_opening_balance_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_account_opening_balance_excel.max' => "Your File size too long.",
            'add_account_opening_balance_excel.required' => "Please select your Opening Balance Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_account_opening_balance_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();


            $path = $request->file('add_account_opening_balance_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);

            foreach ($excelData as $rows) {
                foreach ($rows as $row) {
                    $rowData = (array)$row;
                    $request->merge($rowData);
                    $rollBack = false;
                    $this->excel_account_opening_balance_validation($request);
                    if ($request->account_id != null) {
                        if ($request->cr != null) {
                            $rollBack = self::excel_form_account_opening_balance($row);
                        } else if ($request->dr != null) {
                            $rollBack = self::excel_form_account_opening_balance($row);
                        }
                    }
                    if ($rollBack) {
                        DB::rollBack();
//                        dd('main');
//                        return redirect()->back()->with('fail', 'Failed Try Again');
                    } else {
                        DB::commit();
                    }
                }
            }


            return redirect()->back()->with(['success' => 'File Uploaded successfully.']);
        } else {
            return redirect()->back()->with(['errors' => $validator]);
        }

    }

    public function update_account_opening_balance(Request $request)
    {
        return self::simple_form_account_opening_balance($request);

    }



//    public
//    function update_account_opening_balance(Request $request)
//    {
//        $this->account_opening_balance_validation($request);
//
//        $user = Auth::User();
//        $rollBack = false;
//
//        $account_ids = $request->id;
//        $account_names = $request->name;
//        $dr_balances = $request->dr_balances;
//        $cr_balances = $request->cr_balances;
//
//
//        DB::beginTransaction();
//
////        OpeningTrialBalanceModel::where('tb_id', '>', 0)->delete();
//
//        $new_data = [];
//
//        foreach ($account_ids as $index => $id) {
//
//            $account_id = $id;
//            $account_name = $account_names[$index];
//            // $dr_balance = $dr_balances[$index];
//            // $cr_balance = $cr_balances[$index];
//            $account_balance = AccountRegisterationModel::where('account_uid', '=', $account_id)->first();
//            if ($dr_balances[$index] != null) {
//                $account_balance->account_today_opening_type = 'DR';
//                $account_balance->account_today_opening = $dr_balances[$index];
//            } else if ($cr_balances[$index] != null) {
//                $account_balance->account_today_opening_type = 'CR';
//                $account_balance->account_today_opening = $cr_balances[$index];
//            }
//            $account_balance->save();
//
//
//            $dr_balance = ($dr_balances[$index] === null || $dr_balances[$index] === "null") ? 0.00 : $dr_balances[$index];
//            $cr_balance = ($cr_balances[$index] === null || $cr_balances[$index] === "null") ? 0.00 : $cr_balances[$index];
//
//
//            OpeningTrialBalanceModel::where('tb_account_id', $account_id)->delete();
//
//            $new_data[] = $this->assign_opening_trial_values($account_id, $account_name, $dr_balance, $cr_balance);
//        }
//
//        foreach (array_chunk($new_data, 1000) as $t) {
//            if (!DB::table('financials_opening_trial_balance')->insert($t)) {
//                $rollBack = true;
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed Try Again');
//            }
//        }
//
////        if (!DB::table('financials_opening_trial_balance')->insert($new_data)) {
////            $rollBack = true;
////            DB::rollBack();
////            return redirect()->back()->with('fail', 'Failed Try Again');
////        }
//
//        if ($rollBack) {
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed Try Again');
//        } else {
//
//            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Opening Trial Balances');
//            DB::commit();
//            return redirect()->back()->with('success', 'Successfully Saved');
//        }
//    }
//
//    public
//    function assign_opening_trial_values($account_id, $account_name, $dr_balance, $cr_balance)
//    {
//        $brwsr_rslt = $this->getBrwsrInfo();
//        $ip_rslt = $this->getIp();
//
//        $data = ['tb_account_id' => $account_id, 'tb_account_name' => $account_name, 'tb_total_debit' => $dr_balance, 'tb_total_credit' => $cr_balance, 'tb_datetime' => Carbon::now()->toDateTimeString(), 'tb_ip_adrs' => $ip_rslt, 'tb_brwsr_info' => $brwsr_rslt, 'tb_update_datetime' => Carbon::now()->toDateTimeString()];
//
//        return $data;
//    }
//
//    public
//    function account_opening_balance_validation($request)
//    {
//        return $this->validate($request, [
//            'id' => ['required', 'array'],
//            'id.*' => ['required', 'numeric'],
//            'dr_balances' => ['required', 'array'],
//            'dr_balances.*' => ['nullable', 'numeric'],
//            'cr_balances' => ['required', 'array'],
//            'cr_balances.*' => ['nullable', 'numeric'],
//        ]);
//    }

    public
    function view_account_opening_balance(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $products = ProductModel::where('pro_clg_id',$user->user_clg_id)->count();
        $stockOpen = StockMovementModels::where('sm_clg_id',$user->user_clg_id)->count();
        $count = DayEndModel::where('de_clg_id',$user->user_clg_id)->count();

        if ($products == $stockOpen) {

            if ($count == 0) {

                $title = 'Account';
                $balance = $title;

                $regions = RegionModel::where('reg_clg_id',$user->user_clg_id)->orderBy('reg_title', 'ASC')->get();
                $areas = AreaModel::where('area_clg_id',$user->user_clg_id)->orderBy('area_title', 'ASC')->get();
                $sectors = SectorModel::where('sec_clg_id',$user->user_clg_id)->orderBy('sec_title', 'ASC')->get();

                $first_heads = AccountHeadsModel::where('coa_clg_id',$user->user_clg_id)->where('coa_level', 1)->where('coa_code', '!=', config('global_variables.revenue'))->where('coa_code', '!=',
                    config('global_variables.expense'))->orderBy('coa_id', 'ASC')->get();

                $second_heads = AccountHeadsModel::where('coa_clg_id',$user->user_clg_id)->where('coa_parent', '!=', config('global_variables.revenue'))
                    ->where('coa_parent', '!=', config('global_variables.expense'))
                    ->where('coa_level', 2)
                    ->orderBy('coa_id', 'ASC')
                    ->get();

                $third_heads = AccountHeadsModel::where('coa_clg_id',$user->user_clg_id)->where('coa_parent', 'like', 1 . '%')
                    ->orwhere('coa_parent', 'like', 2 . '%')
                    ->orwhere('coa_parent', 'like', 5 . '%')
                    ->where('coa_level', 3)
                    ->orderBy('coa_id', 'ASC')
                    ->get();

                $route = 'view_account_opening_balance';


                $search_region = $request->region;
                $search_area = $request->area;
                $search_sector = $request->sector;

                $ar = json_decode($request->array);
                $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
                $search_first_head = (!isset($request->first_head) && empty($request->first_head)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->first_head;
                $search_second_head = (!isset($request->second_head) && empty($request->second_head)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->second_head;
                $search_third_head = (!isset($request->third_head) && empty($request->third_head)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->third_head;
                $search_account_name = (!isset($request->account_name) && empty($request->account_name)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->account_name;
                $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
                $prnt_page_dir = 'print.' . $route . '.' . $route;
                $pge_title = $title . ' Opening Balance';
                $srch_fltr = [];
                array_push($srch_fltr, $search, $search_first_head, $search_second_head, $search_third_head);

                $pagination_number = (empty($ar)) ? 100000000 : 100000000;

                $query = DB::table('financials_accounts')
                    ->where('account_clg_id',$user->user_clg_id)
                    ->leftJoin('financials_opening_trial_balance', 'financials_opening_trial_balance.tb_account_id', 'financials_accounts.account_uid')
                    ->leftJoin('financials_coa_heads as parent_account', 'parent_account.coa_code', 'financials_accounts.account_parent_code')
                    ->leftJoin('financials_coa_heads as group_account', 'group_account.coa_code', 'parent_account.coa_parent')
                    ->leftJoin('financials_coa_heads as control_account', 'control_account.coa_code', 'group_account.coa_parent')

                    ->wherenotIn('financials_accounts.account_uid',['410101','410111','	410121'])

                    ->where('financials_opening_trial_balance.tb_clg_id',$user->user_clg_id)
                    ->where('parent_account.coa_clg_id',$user->user_clg_id)
                    ->where('control_account.coa_clg_id',$user->user_clg_id)
                    ->where('group_account.coa_clg_id',$user->user_clg_id);


                if (!empty($search)) {
                    $query->where(function ($query) use ($search) {
                        $query->where('account_uid', 'like', '%' . $search . '%')
                            ->orWhere('account_name', 'like', '%' . $search . '%')
                            ->orWhere('control_account.coa_head_name', 'like', '%' . $search . '%')
                            ->orWhere('group_account.coa_head_name', 'like', '%' . $search . '%')
                            ->orWhere('parent_account.coa_head_name', 'like', '%' . $search . '%')
                            ->orWhere('control_account.coa_code', 'like', '%' . $search . '%')
                            ->orWhere('group_account.coa_code', 'like', '%' . $search . '%')
                            ->orWhere('parent_account.coa_code', 'like', '%' . $search . '%');
                    });
                }

                if (!empty($search_first_head)) {
                    $query->where('control_account.coa_code', '=', $search_first_head);
                }

                if (!empty($search_second_head)) {
                    $query->where('group_account.coa_code', '=', $search_second_head);
                }

                if (!empty($search_third_head)) {
                    $query->where('parent_account.coa_code', '=', $search_third_head);
                }

                if (!empty($search_account_name)) {
                    $query->where('financials_accounts.account_name', '=', $search_account_name);
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

//                if (empty($search_region) && empty($search_area) && empty($search_sector)) {
//                    if (empty($search_first_head) && empty($search_second_head) && empty($search_third_head) && empty($search_account_name)) {
//                        $query->where('account_uid', 'like', 1 . '%')
//                            ->orWhere('account_uid', 'like', 2 . '%')
//                            ->orWhere('account_uid', 'like', 5 . '%');
//                    }
//                }
                ///////////
//        if (empty($search_first_head) && empty($search_second_head) && empty($search_third_head) && empty($search_account_name)) {
//            $query->where('account_uid', 'like', 1 . '%')
//                ->orWhere('account_uid', 'like', 2 . '%')
//                ->orWhere('account_uid', 'like', 5 . '%');
//        }

                //->whereNotIn('account_uid', $account_not_in)

                $datas = $query->select('financials_accounts.*', 'financials_opening_trial_balance.*', 'parent_account.coa_head_name as parnt_acnt_name', 'group_account.coa_head_name as grp_acnt_name')
                    ->orderBy('account_parent_code', 'ASC')
                    ->orderBy('account_uid', 'ASC')
                    ->paginate($pagination_number);

                $account_names = AccountRegisterationModel::
                where('account_clg_id',$user->user_clg_id)->
//        whereNotIn('account_parent_code', $heads)
//            ->whereNotIn('account_uid', $account_not_in)
                where('account_uid', 'like', 1 . '%')
                    ->orWhere('account_uid', 'like', 2 . '%')
                    ->orWhere('account_uid', 'like', 5 . '%')
                    ->orderBy('account_parent_code', 'ASC')
                    ->orderBy('account_name', 'ASC')
                    ->pluck('account_name')
                    ->all();

                if (isset($request->array) && !empty($request->array)) {

                    $type = (isset($request->str)) ? $request->str : '';

                    $footer = view('print._partials.pdf_footer')->render();
                    $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
                    $options = [
                        'footer-html' => $footer,
                        'header-html' => $header,
                    ];

                    $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'balance'));
                    $pdf->setOptions($options);


                    if ($type === 'pdf') {
                        return $pdf->stream($pge_title . '_x.pdf');
                    } else if ($type === 'download_pdf') {
                        return $pdf->download($pge_title . '_x.pdf');
                    } else if ($type === 'download_excel') {
                        return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $balance), $pge_title . '_x.xlsx');
                    }

                } else {
                    return view('view_account_opening_balance', compact('datas', 'title', 'route', 'account_names', 'first_heads', 'second_heads', 'third_heads', 'search', 'search_first_head', 'search_second_head', 'search_third_head', 'search_account_name', 'areas', 'sectors', 'regions', 'search_region', 'search_area', 'search_sector'));
                }
                return redirect()->route('home')->with("fail", "Can not proceed again ");
            }
        } else {
            return redirect()->route('home')->with("fail", "Please Enter opening stock first ");
        }
    }

    public
    function submit_account_opening_balance()
    {

        $user = Auth::User();
        $rollBack = false;

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $system_config = SystemConfigModel::where('sc_clg_id',$user->user_clg_id)->first();

        if ($system_config->sc_admin_capital_added != 1 || $system_config->sc_first_date_added != 1) {
            return redirect()->back()->with('fail', 'Capital or First Date is not selected');
        }

        $opening_trial_balances = OpeningTrialBalanceModel::where('tb_clg_id',$user->user_clg_id)->get();

        $total_debit = $opening_trial_balances->sum('tb_total_debit');
        $total_credit = $opening_trial_balances->sum('tb_total_credit');

        DB::beginTransaction();

        if ($total_debit == $total_credit) {

            foreach ($opening_trial_balances as $opening_trial_balance) {

                $account_id = $opening_trial_balance->tb_account_id;
                $account_name = $opening_trial_balance->tb_account_name;
                $dr_balance = $opening_trial_balance->tb_total_debit;
                $cr_balance = $opening_trial_balance->tb_total_credit;

//                $delete_balances = BalancesModel::where('bal_account_id', $account_id)->first();
                $delete_balances = BalancesModel::where('bal_clg_id',$user->user_clg_id)->where('bal_account_id', $account_id)->delete();

                $balances = new BalancesModel;

                $balances->bal_account_id = $account_id;
                $balances->bal_transaction_type = 'OPENING_BALANCE';
                $balances->bal_remarks = '';
                $balances->bal_detail_remarks = 'OPENING_BALANCE';
                $balances->bal_dr = $dr_balance;
                $balances->bal_cr = $cr_balance;
                // $balances->bal_total = $dr_balance != 0 ? $dr_balance : $cr_balance;
                $balances->bal_total = $dr_balance != 0 ? $dr_balance : -($cr_balance);
                $balances->bal_user_id = $user->user_id;
                $balances->bal_day_end_id = 1;
                $balances->bal_day_end_date = $system_config->sc_first_date;
                $balances->bal_ip_adrs = $ip_rslt;
                $balances->bal_brwsr_info = $brwsr_rslt;
                $balances->bal_update_datetime = Carbon::now()->toDateTimeString();
                $balances->bal_clg_id = $user->user_clg_id;
                $balances->bal_year_id = $this->getYearEndId();
                $balances->bal_v_year_id = $this->getYearEndId();

                if ($balances->save()) {

                    $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Enter Opening Balances of Account id: ' . $account_id . ' and Account Name: ' . $account_name . ' with Opening Balance: ' . $balances->bal_total);

                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            }


            $insert_day_end = new DayEndModel();

            $insert_day_end->de_first_day_of_month = 1;
            $insert_day_end->de_datetime = $system_config->sc_first_date;
            $insert_day_end->de_current_datetime = Carbon::now()->toDateTimeString();
            $insert_day_end->de_createdby = $user->user_id;
            $insert_day_end->de_ip_adrs = $ip_rslt;
            $insert_day_end->de_brwsr_info = $brwsr_rslt;
            $insert_day_end->de_update_datetime = Carbon::now()->toDateTimeString();
            $insert_day_end->de_clg_id = $user->user_clg_id;

            if (!$insert_day_end->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $system_config->sc_all_done = 1;

            if (!$system_config->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $notes = 'OPENING_BALANCE';

            $products = ProductModel::where('pro_clg_id',$user->user_clg_id)->where('pro_type', config('global_variables.parent_product_type'))->get();

            DB::beginTransaction();

            // mustafa comment this code start

//            $warehouse_stock = $this->UpdateWarehouseStocksValues($products, 1);
//
//            foreach (array_chunk($warehouse_stock, 1000) as $t) {
//                if (!DB::table('financials_warehouse_stock')->insert($t)) {
//                    $rollBack = true;
//                    DB::rollBack();
//                    return redirect()->back()->with('fail', 'Failed Try Again');
//                }
//            }
// mustafa comment this code end

            //            if (!DB::table('financials_warehouse_stock')->insert($warehouse_stock)) {
//                $rollBack = true;
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed Try Again');
//            }
// mustafa comment this code start

//            StockMovementModels::where('sm_id', '>', 0)->delete();

//            $opening_stock = $this->UpdateStockMovementValues($products, 0, $notes, '', $notes);
//
//            foreach (array_chunk($opening_stock, 1000) as $t) {
//                if (!DB::table('financials_stock_movement')->insert($t)) {
//                    $rollBack = true;
//                    DB::rollBack();
//                    return redirect()->back()->with('fail', 'Failed Try Again');
//                }
//            }
// mustafa comment this code end

            $system_config_bank_payment_voucher_number = $system_config->sc_bank_payment_voucher_number + 1;
            $system_config_bank_receipt_voucher_number = $system_config->sc_bank_receipt_voucher_number + 1;
            $system_config_cash_payment_voucher_number = $system_config->sc_cash_payment_voucher_number + 1;
            $system_config_cash_receipt_voucher_numer = $system_config->sc_cash_receipt_voucher_numer + 1;
            $system_config_expense_payment_voucher_number = $system_config->sc_expense_payment_voucher_number + 1;
            $system_config_journal_voucher_number = $system_config->sc_journal_voucher_number + 1;
            $system_config_purchase_invoice_number = $system_config->sc_purchase_invoice_number + 1;
            $system_config_purchase_return_invoice_number = $system_config->sc_purchase_return_invoice_number + 1;
            $system_config_purchase_st_invoice_number = $system_config->sc_purchase_st_invoice_number + 1;
            $system_config_purchase_return_st_invoice_number = $system_config->sc_purchase_return_st_invoice_number + 1;
            $system_config_salary_payment_voucher_number = $system_config->sc_salary_payment_voucher_number + 1;
            $system_config_salary_slip_voucher_number = $system_config->sc_salary_slip_voucher_number + 1;
            $system_config_advance_salary_voucher_number = $system_config->sc_advance_salary_voucher_number + 1;
            $system_config_sale_invoice_number = $system_config->sc_sale_invoice_number + 1;
            $system_config_sale_return_invoice_number = $system_config->sc_sale_return_invoice_number + 1;
            $system_config_sale_tax_invoice_number = $system_config->sc_sale_tax_invoice_number + 1;
            $system_config_sale_tax_return_invoice_number = $system_config->sc_sale_tax_return_invoice_number + 1;
            $system_config_service_invoice_number = $system_config->sc_service_invoice_number + 1;
            $system_config_service_tax_invoice_number = $system_config->sc_service_tax_invoice_number + 1;

            $bank_payment_voucher_number = DB::statement("ALTER TABLE financials_bank_payment_voucher AUTO_INCREMENT = $system_config_bank_payment_voucher_number");

            if (!$bank_payment_voucher_number) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $bank_receipt_voucher_number = DB::statement("ALTER TABLE financials_bank_receipt_voucher AUTO_INCREMENT = $system_config_bank_receipt_voucher_number");

            if (!$bank_receipt_voucher_number) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $cash_payment_voucher_number = DB::statement("ALTER TABLE financials_cash_payment_voucher AUTO_INCREMENT = $system_config_cash_payment_voucher_number");

            if (!$cash_payment_voucher_number) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $cash_receipt_voucher_numer = DB::statement("ALTER TABLE financials_cash_receipt_voucher AUTO_INCREMENT = $system_config_cash_receipt_voucher_numer");

            if (!$cash_receipt_voucher_numer) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $expense_payment_voucher_number = DB::statement("ALTER TABLE financials_expense_payment_voucher AUTO_INCREMENT = $system_config_expense_payment_voucher_number");

            if (!$expense_payment_voucher_number) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $journal_voucher_number = DB::statement("ALTER TABLE financials_journal_voucher AUTO_INCREMENT = $system_config_journal_voucher_number");

            if (!$journal_voucher_number) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $purchase_invoice_number = DB::statement("ALTER TABLE financials_purchase_invoice AUTO_INCREMENT = $system_config_purchase_invoice_number");

            if (!$purchase_invoice_number) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $purchase_return_invoice_number = DB::statement("ALTER TABLE financials_purchase_return_invoice AUTO_INCREMENT = $system_config_purchase_return_invoice_number");

            if (!$purchase_return_invoice_number) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $purchase_st_invoice_number = DB::statement("ALTER TABLE financials_purchase_saletax_invoice AUTO_INCREMENT = $system_config_purchase_st_invoice_number");

            if (!$purchase_st_invoice_number) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $purchase_return_st_invoice_number = DB::statement("ALTER TABLE financials_purchase_return_saletax_invoice AUTO_INCREMENT = $system_config_purchase_return_st_invoice_number");

            if (!$purchase_return_st_invoice_number) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $salary_payment_voucher_number = DB::statement("ALTER TABLE financials_salary_payment AUTO_INCREMENT = $system_config_salary_payment_voucher_number");

            if (!$salary_payment_voucher_number) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $salary_slip_voucher_number = DB::statement("ALTER TABLE financials_salary_slip_voucher AUTO_INCREMENT = $system_config_salary_slip_voucher_number");

            if (!$salary_slip_voucher_number) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $advance_salary_voucher_number = DB::statement("ALTER TABLE financials_advance_salary AUTO_INCREMENT = $system_config_advance_salary_voucher_number");

            if (!$advance_salary_voucher_number) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $sale_invoice_number = DB::statement("ALTER TABLE financials_sale_invoice AUTO_INCREMENT = $system_config_sale_invoice_number");

            if (!$sale_invoice_number) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $sale_return_invoice_number = DB::statement("ALTER TABLE financials_sale_return_invoice AUTO_INCREMENT = $system_config_sale_return_invoice_number");

            if (!$sale_return_invoice_number) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $sale_tax_invoice_number = DB::statement("ALTER TABLE financials_sale_saletax_invoice AUTO_INCREMENT = $system_config_sale_tax_invoice_number");

            if (!$sale_tax_invoice_number) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $sale_tax_return_invoice_number = DB::statement("ALTER TABLE financials_sale_return_saletax_invoice AUTO_INCREMENT = $system_config_sale_tax_return_invoice_number");

            if (!$sale_tax_return_invoice_number) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $service_invoice_number = DB::statement("ALTER TABLE financials_service_invoice AUTO_INCREMENT = $system_config_service_invoice_number");

            if (!$service_invoice_number) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $service_tax_invoice_number = DB::statement("ALTER TABLE financials_service_saletax_invoice AUTO_INCREMENT = $system_config_service_tax_invoice_number");

            if (!$service_tax_invoice_number) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            if ($rollBack) {
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            } else {
//                dd(1);
                DB::commit();
                WizardController::updateWizardInfo(['opening_trail'], []);
                return redirect('index')->with('success', 'Successfully Saved. System Started');
            }
        } else {
            DB::rollBack();
            return redirect('account_opening_balance')->with('fail', 'Failed Try Again! Debit And Credit Balance Are Not Equal');
        }
    }

    public
    function submit_product_opening_stock()
    {
        $notes = 'OPENING_BALANCE';
        $rollBack = false;
        $user = Auth::User();

        $products = ProductModel::where('pro_clg_id',$user->user_clg_id)->where('pro_type', config('global_variables.parent_product_type'))->get();

        DB::beginTransaction();

        $warehouse_stock = $this->UpdateWarehouseStocksValues($products, 1);

        foreach (array_chunk($warehouse_stock, 1000) as $t) {
            if (!DB::table('financials_warehouse_stock')->insert($t)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }
        }


//        if (!DB::table('financials_warehouse_stock')->insert($warehouse_stock)) {
//            $rollBack = true;
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed Try Again');
//        }


        $opening_stock = $this->UpdateStockMovementValues($products, 0, $notes, '', $notes);

        foreach (array_chunk($opening_stock, 1000) as $t) {
            if (!DB::table('financials_stock_movement')->insert($t)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }
        }

//        if (!DB::table('financials_stock_movement')->insert($opening_stock)) {
//            $rollBack = true;
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed Try Again');
//        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' Of Products');
            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    public
    function UpdateWarehouseStocksValues($array, $warehouse_id)
    {
        $user = Auth::user();
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $data = [];
        foreach ($array as $key) {

            $pro_code = $key->pro_p_code;
            $current_stock = $key->pro_quantity;

            $data[] = ['whs_product_code' => $pro_code, 'whs_stock' => $current_stock, 'whs_warehouse_id' => $warehouse_id, 'whs_datetime' => Carbon::now()->toDateTimeString(), 'whs_brwsr_info' =>
                $brwsr_rslt, 'whs_ip_adrs' => $ip_rslt, 'whs_update_datetime' => Carbon::now()->toDateTimeString(), 'whs_clg_id' => $user->user_clg_id];

        }
        return $data;
    }

    public
    function UpdateStockMovementValues($array, $account_uid, $account_name, $invoice_id, $notes)
    {
        $user = Auth::user();

        $data = [];

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        foreach ($array as $value) {

            $product_code = $value->pro_p_code;
            $product_name = $value->pro_title;
            $product_remarks = $value->pro_remarks;
            $product_bal_qty = $value->pro_quantity;
            $product_bal_rate = $value->pro_purchase_price;
            $product_bal_total = $product_bal_qty * $product_bal_rate;

            $data[] = [
                'sm_product_code' => $product_code,
                'sm_product_name' => $product_name,
//                'sm_pur_qty' => 0,
//                'sm_pur_rate' => 0,
//                'sm_pur_total' => 0,
//                'sm_sale_qty' => 0,
//                'sm_sale_rate' => 0,
//                'sm_sale_total' => 0,
                'sm_bal_total_qty_wo_bonus' => $product_bal_qty,
                'sm_bal_qty_for_sale' => $product_bal_qty,
                'sm_bal_total_qty' => $product_bal_qty,
//                'sm_bal_qty' => $product_bal_total,
                'sm_bal_rate' => $product_bal_rate,
                'sm_bal_total' => $product_bal_total,
                'sm_type' => $notes,
                'sm_day_end_id' => 1,
                'sm_day_end_date' => $day_end->de_datetime,
//                'sm_voucher_code' => 0,
                'sm_remarks' => $product_remarks,
                'sm_user_id' => $user->user_id,
                'sm_date_time' => Carbon::now()->toDateTimeString(),
                'sm_clg_id' => $user->user_clg_id,
            ];
        }

        return $data;
    }
}





