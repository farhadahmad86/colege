<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Imports\ExcelDataImport;
use App\Models\AreaModel;
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

class GroupInfoController extends ExcelForm\GroupForm\GroupFormController
{
    public function add_group()
    {
        return view('add_group');
    }

    public function submit_group_excel(Request $request)
    {

        $rules = [
            'add_group_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_group_excel.max' => "Your File size too long.",
            'add_group_excel.required' => "Please select your Unit Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_group_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();


            $path = $request->file('add_group_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);
            foreach ($data as $key => $value) {
                foreach ($excelData as $rows) {
                    foreach ($rows as $row) {
                        $rowData = (array)$row;
                        $request->merge($rowData);
                        $this->excel_group_validation($request);

                        $rollBack = self::excel_form_group($row);

                        if ($rollBack) {
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Failed Try Again');
                        } else {
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


    public function submit_group(Request $request)
    {
        return self::simple_form_group($request);
    }


    // update code by shahzaib start
    public function group_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.group_list.group_list';
        $pge_title = 'Group List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_groups')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_groups.grp_createdby')
            ->where('grp_clg_id', $user->user_clg_id);

        if (!empty($search)) {
            $query->where('grp_title', 'like', '%' . $search . '%')
                ->orWhere('grp_remarks', 'like', '%' . $search . '%')
                ->orWhere('grp_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('grp_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('grp_delete_status', '=', 1);
        } else {
            $query->where('grp_delete_status', '!=', 1);
        }


        $datas = $query
//            ->where('grp_delete_status', '!=', 1)
            ->orderBy('grp_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $group_title = GroupInfoModel::
        where('grp_clg_id', $user->user_clg_id)->
        where('grp_delete_status', '!=', 1)->
        orderBy('grp_title', 'ASC')->pluck('grp_title')->all();


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
            return view('group_list', compact('datas', 'group_title', 'search', 'search_by_user', 'restore_list'));
        }
    }

    // update code by shahzaib end


    public function edit_group(Request $request)
    {
        $group = GroupInfoModel::where('grp_id', $request->group_id)->first();
        return view('edit_group', compact('group'));
    }

    public function update_group(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'group_id' => ['required', 'numeric'],
            'group_name' => ['required', 'string', 'unique:financials_groups,grp_title,' . $request->group_id . ',grp_id'.',grp_clg_id,' . $user->user_clg_id],

            'remarks' => ['nullable', 'string'],
            'tax' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'retailer' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'wholesaler' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'loyalty_card' => ['nullable', 'regex:/^\d*\.?\d*$/'],
        ]);

        $group = GroupInfoModel::where('grp_id', $request->group_id)->first();

        $group = $this->AssignGroupValues($request, $group);

        if ($group->save()) {

            CategoryInfoModel::where('cat_clg_id',$user->user_clg_id)->where('cat_group_id', $group->grp_id)->where('cat_use_group_fields', 1)->update(['cat_tax' => $group->grp_tax, 'cat_retailer_discount' =>
                $group->grp_retailer_discount, 'cat_whole_seller_discount' => $group->grp_whole_seller_discount, 'cat_loyalty_card_discount' => $group->grp_loyalty_card_discount]);

            $cat_ids = CategoryInfoModel::where('cat_clg_id',$user->user_clg_id)->where('cat_group_id', $group->grp_id)->pluck('cat_id')->all();

            if (count($cat_ids) > 0) {

                ProductModel::where('pro_cld_id',$user->user_clg_id)->whereIn('pro_category_id', $cat_ids)->where('pro_use_cat_fields', 1)->update(['pro_tax' => $group->grp_tax, 'pro_retailer_discount' =>
                    $group->grp_retailer_discount, 'pro_whole_seller_discount' => $group->grp_whole_seller_discount, 'pro_loyalty_card_discount' => $group->grp_loyalty_card_discount]);
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Product Group With Id: ' . $group->grp_id . ' And Name: ' . $group->grp_title);

            return redirect('group_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('group_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_group(Request $request)
    {
        $user = Auth::User();

        $delete = GroupInfoModel::where('grp_id', $request->group_id)->first();


        if ($delete->grp_delete_status == 1) {
            $delete->grp_delete_status = 0;
        } else {
            $delete->grp_delete_status = 1;
        }

        $delete->grp_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->grp_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Product Group With Id: ' . $delete->grp_id . ' And Name: ' . $delete->grp_title);

                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Product Group With Id: ' . $delete->grp_id . ' And Name: ' . $delete->grp_title);

                return redirect()->back()->with('success', 'Successfully Deleted');
            }


        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }

    }


}
