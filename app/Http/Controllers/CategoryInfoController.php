<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Imports\ExcelDataImport;
use App\Models\CategoryInfoModel;
use App\Models\GroupInfoModel;
use App\Models\ProductModel;
use App\Models\SystemConfigModel;
use Auth;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CategoryInfoController extends ExcelForm\CategoryForm\CategoryFormController
{
    public function add_category()
    {$user = Auth::User();
        $groups = GroupInfoModel::where('grp_clg_id',$user->user_clg_id)->where('grp_delete_status', '!=', 1)->where('grp_disabled', '!=', 1)->orderBy('grp_title', 'ASC')->get();
        return view('add_category', compact('groups'));
    }

    public function submit_category_excel(Request $request)
    {

        $rules = [
            'add_create_category_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_create_category_excel.max' => "Your File size too long.",
            'add_create_category_excel.required' => "Please select your Category Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_create_category_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();



            $path = $request->file('add_create_category_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode (json_encode ($data), FALSE);
            foreach ($data as $key => $value) {
                foreach ($excelData as $rows) {
                    foreach ($rows as $row) {
                        $rowData = (array) $row;
                        $request->merge($rowData);
                        $this->excel_category_validation($request);

                        $rollBack = self::excel_form_category($row);

                        if ($rollBack) {
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Failed Try Again');
                        }
                        else {
                            DB::commit();
                        }
                    }
                }
            }

            return redirect()->back()->with(['success' => 'File Uploaded successfully.']);
        } else {
            return redirect()->back()->with(['errors' => $validator]);
        }

    }

    public function submit_category(Request $request)
    {
        return self::simple_form_category($request);

//        $this->category_validation($request);
//
//        $category = new CategoryInfoModel();
//
//        $category = $this->AssignCategoryValues($request, $category);
//
//        $category->save();
//
//        $user = Auth::User();
//
//        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Category With Id: ' . $category->cat_id . ' And Name: ' . $category->cat_title);
//
//        // WizardController::updateWizardInfo(['category'], ['main_unit', 'product']);
//
//        return redirect('add_category')->with('success', 'Successfully Saved');
    }

    public function category_validation($request)
    {$user = Auth::User();
        return $this->validate($request, [
            'group_name' => ['required', 'numeric'],
            'category_name' => ['required', 'string', 'unique:financials_categories,cat_title,NULL,cat_id,cat_group_id,' . $request->group_name.',cat_clg_id,'.$user->user_clg_id],
            'remarks' => ['nullable', 'string'],
            'tax' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'retailer' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'wholesaler' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'loyalty_card' => ['nullable', 'regex:/^\d*\.?\d*$/'],
        ]);
    }

    protected function AssignCategoryValues($request, $category)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $category->cat_group_id = $request->group_name;
        $category->cat_title = ucwords($request->category_name);
        $category->cat_remarks = ucfirst($request->remarks);
        $category->cat_createdby = $user->user_id;
        $category->cat_clg_id = $user->user_clg_id;
        $category->cat_day_end_id = $day_end->de_id;
        $category->cat_day_end_date = $day_end->de_datetime;

        $category->cat_tax = (isset($request->tax) || !empty($request->tax)) ? $request->tax : 0;
        $category->cat_retailer_discount = (isset($request->retailer) || !empty($request->retailer)) ? $request->retailer : 0;
        $category->cat_whole_seller_discount = (isset($request->wholesaler) || !empty($request->wholesaler)) ? $request->wholesaler : 0;
        $category->cat_loyalty_card_discount = (isset($request->loyalty_card) || !empty($request->loyalty_card)) ? $request->loyalty_card : 0;
        $category->cat_use_group_fields = (isset($request->check_group) || !empty($request->check_group)) ? $request->check_group : 0;


        // coding from shahzaib start
        $tbl_var_name = 'category';
        $prfx = 'cat';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end

        return $category;
    }

    public function get_category(Request $request)
    {$user = Auth::User();
        $grp_id = $request->grp_id;

        $cat_id = $request->cat_id;

        $cats = CategoryInfoModel::where('cat_clg_id',$user->user_clg_id)->where('cat_group_id', $grp_id)->orderBy('cat_title', 'ASC')->get();

        $get_cat = "<option value=''>Select Product Category Title</option>";
        foreach ($cats as $cat) {
            $selected = $cat->cat_id == $cat_id ? 'selected' : '';
            $get_cat .= "<option value='$cat->cat_id'  data-tax='$cat->cat_tax' data-retailer='$cat->cat_retailer_discount' data-wholesaler='$cat->cat_whole_seller_discount' data-loyalty_card='$cat->cat_loyalty_card_discount' $selected>$cat->cat_title</option>";
        }

        return response()->json($get_cat);
    }

    // update code by shahzaib start
    public function category_list(Request $request, $array = null, $str = null)
    {$user = Auth::User();
        $groups = GroupInfoModel::where('grp_clg_id',$user->user_clg_id)->orderby('grp_title', 'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->group;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.category_list.category_list';
        $pge_title = 'Category List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_group);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_categories')
            ->join('financials_groups', 'financials_groups.grp_id', '=', 'financials_categories.cat_group_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_categories.cat_createdby');


        if (!empty($search)) {
            $query->orWhere('grp_title', 'like', '%' . $search . '%')
                ->orWhere('cat_id', 'like', '%' . $search . '%')
                ->orWhere('cat_title', 'like', '%' . $search . '%')
                ->orWhere('cat_remarks', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_group)) {
            $query->where('cat_group_id', $search_group);
        }

        if (!empty($search_by_user)) {
            $query->where('cat_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1)
        {
            $query->where('cat_delete_status', '=', 1);
        } else {
            $query->where('cat_delete_status', '!=', 1);
        }


        $datas = $query
//            ->where('cat_delete_status', '!=', 1)
            ->orderBy('cat_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $category = CategoryInfoModel::
        where('cat_clg_id',$user->user_clg_id)->
        where('cat_delete_status', '!=', 1)->
        orderBy('cat_title', 'ASC')->pluck('cat_title')->all();


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

        } else {
            return view('category_list', compact('datas', 'search', 'category', 'groups', 'search_group', 'search_by_user','restore_list'));
        }
    }

    // update code by shahzaib end


    public function edit_category(Request $request)
    {$user = Auth::User();
        $groups = GroupInfoModel::where('grp_clg_id',$user->user_clg_id)->where('grp_delete_status', '!=', 1)->where('grp_disabled', '!=', 1)->orderBy('grp_title', 'ASC')->get();

        $category = CategoryInfoModel::where('cat_id', $request->category_id)->first();
        return view('edit_category', compact('category', 'groups'));
    }

    public function update_category(Request $request)
    {$user = Auth::User();
        $this->validate($request, [
            'group_name' => ['required', 'numeric'],
            'category_id' => ['required', 'numeric'],
            'category_name' => ['required', 'string', 'unique:financials_categories,cat_title,' . $request->category_id . ',cat_id,cat_group_id,' . $request->group_name.',cat_clg_id,'
                .$user->user_clg_id],
//            'group_name' => ['required', 'string'],
            'remarks' => ['nullable', 'string'],
            'tax' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'retailer' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'wholesaler' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'loyalty_card' => ['nullable', 'regex:/^\d*\.?\d*$/'],
        ]);

        $category = CategoryInfoModel::where('cat_id', $request->category_id)->first();

        $category->cat_group_id = $request->group_name;
        $category->cat_title = ucwords($request->category_name);
        $category->cat_remarks = ucfirst($request->remarks);

        $category->cat_tax = (isset($request->tax) || !empty($request->tax)) ? $request->tax : 0;
        $category->cat_retailer_discount = (isset($request->retailer) || !empty($request->retailer)) ? $request->retailer : 0;
        $category->cat_whole_seller_discount = (isset($request->wholesaler) || !empty($request->wholesaler)) ? $request->wholesaler : 0;
        $category->cat_loyalty_card_discount = (isset($request->loyalty_card) || !empty($request->loyalty_card)) ? $request->loyalty_card : 0;
        $category->cat_use_group_fields = (isset($request->check_group) || !empty($request->check_group)) ? $request->check_group : 0;

        // coding from shahzaib start
        $tbl_var_name = 'category';
        $prfx = 'cat';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        if ($category->save()) {

            ProductModel::where('pro_clg_id',$user->user_clg_id)->where('pro_category_id', $category->cat_id)->where('pro_use_cat_fields', 1)->update(['pro_tax' => $category->cat_tax, 'pro_retailer_discount' =>
                $category->cat_retailer_discount, 'pro_whole_seller_discount' => $category->cat_whole_seller_discount, 'pro_loyalty_card_discount' => $category->cat_loyalty_card_discount]);



            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Category With Id: ' . $category->cat_id . ' And Name: ' . $category->cat_title);

            return redirect()->back()->with('success', 'Successfully Saved');
        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_category(Request $request)
    {
        $user = Auth::User();

        $delete = CategoryInfoModel::where('cat_id', $request->category_id)->first();

        if ($delete->cat_delete_status == 1) {
            $delete->cat_delete_status = 0;
        } else {
            $delete->cat_delete_status = 1;
        }

        $delete->cat_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->cat_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Category With Id: ' . $delete->cat_id . ' And Name: ' . $delete->cat_title);

                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Category With Id: ' . $delete->cat_id . ' And Name: ' . $delete->cat_title);

                return redirect()->back()->with('success', 'Successfully Deleted');
            }


            return redirect()->back()->with('success', 'Successfully Saved');
        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }
}
