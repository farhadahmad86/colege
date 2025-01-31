<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Models\ModularConfigDefinitionModel;
use App\Models\ModularGroupModel;
use App\Models\PackagesModel;
use App\Models\SystemConfigModel;
use App\User;
use Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ModularGroupController extends Controller
{
    public function add_modular_group()
    {
       $user_id = Auth::user();
        $softaware_pakge=PackagesModel::where('pak_id',1)->pluck('pak_name')->first();


        if ($user_id->user_id == 1){
            $modules = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->where('mcd_code','!=',18)->where('mcd_after_config', '=', 1)->get();
        }
        elseif($softaware_pakge=='Basic'){
            $modules = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->where('mcd_code','!=',18)->where('mcd_after_config', '=', 1)->where('mcd_package', '=', $softaware_pakge)->get();

        }elseif ($softaware_pakge=='Advance'){
            $modules = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->where('mcd_code','!=',18)->where('mcd_after_config', '=', 1)->whereIn('mcd_package', ['Basic','Advance'])->get();

        }elseif($softaware_pakge=='Premium'){
            $modules = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->where('mcd_code','!=',18)->where('mcd_after_config', '=', 1)->whereIn('mcd_package', ['Basic','Advance','Premium'])->get();

        }


        return view('add_modular_group', compact('modules'));
    }

    public function submit_modular_group(Request $request)
    {
        $this->modular_group_validation($request);

        $modular_group = new ModularGroupModel();

        $modular_group = $this->assign_modular_group_values($request, $modular_group);

        $modular_group->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Modular Group With Id: ' . $modular_group->mg_id . ' And Name: ' . $modular_group->mg_title);

        // WizardController::updateWizardInfo(['add_modular_group'], ['warehouse']);

        return redirect('add_modular_group')->with('success', 'Successfully Saved');
    }

    public function modular_group_validation($request)
    {
        return $this->validate($request, [
            'group_name' => ['required', 'string', 'unique:financials_modular_groups,mg_title'],
            'first_level_config' => ['required', 'array'],
            'second_level_config' => ['required', 'array'],
            'modular_config' => ['required', 'array'],
            'remarks' => ['nullable', 'string'],
        ]);

    }

    protected function assign_modular_group_values($request, $modular_group)
    {
        $user = Auth::User();

        $modular_group->mg_title = ucwords($request->group_name);
        $modular_group->mg_config = implode(',', $request->modular_config);
        $modular_group->mg_first_level_config = implode(',', $request->first_level_config);
        $modular_group->mg_second_level_config = implode(',', $request->second_level_config);
        $modular_group->mg_remarks = ucfirst($request->remarks);
        $modular_group->mg_created_by = $user->user_id;
        $modular_group->mg_datetime = Carbon::now()->toDateTimeString();

        // coding from shahzaib start
        $tbl_var_name = 'modular_group';
        $prfx = 'mg';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now()->toDateTimeString();
        // coding from shahzaib end


        return $modular_group;
    }

    // update code by shahzaib start
    public function modular_group_list(Request $request, $array = null, $str = null)
    {


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.modular_group_list.modular_group_list';
        $pge_title = 'Modular Group List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_modular_groups')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_modular_groups.mg_created_by');


        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('mg_title', 'like', '%' . $search . '%')
                    ->orWhere('mg_remarks', 'like', '%' . $search . '%')
                    ->orWhere('mg_id', 'like', '%' . $search . '%');
            });
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1)
        {
            $query->where('mg_delete_status', '=', 1);
        } else {
            $query->where('mg_delete_status', '!=', 1);
        }


        $datas = $query
//            ->where('mg_delete_status', '!=', 1)
            ->orderBy('mg_id', 'DESC')->paginate($pagination_number);//->where('mg_id', '!=', 1)

        $group_title = ModularGroupModel::
        where('mg_delete_status', '!=', 1)->
        orderBy('mg_id', 'DESC')->pluck('mg_title')->all();//where('mg_id', '!=', 1)->


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
            return view('modular_group_list', compact('datas', 'group_title', 'search','restore_list'));
        }


    }

    // update code by shahzaib end

    public function edit_modular_group(Request $request)
    {
        $user_id = Auth::user();
        $softaware_pakge=PackagesModel::where('pak_id',1)->pluck('pak_name')->first();

        if ($user_id->user_id == 1){
            $modules = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->where('mcd_after_config', '=', 1)->get();
        }
        elseif($softaware_pakge=='Basic'){
            $modules = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->where('mcd_after_config', '=', 1)->where('mcd_package', '=', $softaware_pakge)->get();

        }elseif ($softaware_pakge=='Advance'){
            $modules = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->where('mcd_after_config', '=', 1)->whereIn('mcd_package', ['Basic','Advance'])->get();

        }elseif($softaware_pakge=='Premium'){
            $modules = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->where('mcd_after_config', '=', 1)->whereIn('mcd_package', ['Basic','Advance','Premium'])->get();

        }
//        $modules = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->where('mcd_after_config', '=', 1)->get();

        $group = ModularGroupModel::where('mg_id', $request->group_id)->first();

        return view('edit_modular_group', compact('group', 'modules'));
    }

    public function update_modular_group(Request $request)
    {
        $this->validate($request, [
            'group_id' => ['required', 'numeric'],
            'group_name' => ['required', 'string', 'unique:financials_modular_groups,mg_title,' . $request->group_id . ',mg_id'],
            'remarks' => ['nullable', 'string'],
            'first_level_config' => ['required', 'array'],
            'second_level_config' => ['required', 'array'],
            'modular_config' => ['required', 'array'],
        ]);

        $modular_group = ModularGroupModel::where('mg_id', $request->group_id)->first();

        $modular_group = $this->assign_modular_group_values($request, $modular_group);

        if ($modular_group->save()) {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Modular Group With Id: ' . $modular_group->mg_id . ' And Name: ' . $modular_group->mg_title);

            return redirect('modular_group_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('modular_group_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_modular_group(Request $request)
    {
        $user = Auth::User();

        $delete = ModularGroupModel::where('mg_id', $request->group_id)->first();

//        $delete->mg_delete_status = 1;

        if ($delete->mg_delete_status == 1) {
            $delete->mg_delete_status = 0;
        } else {
            $delete->mg_delete_status = 1;
        }

        $delete->mg_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->mg_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Modular Group With Id: ' . $delete->mg_id . ' And Name: ' . $delete->mg_title);

                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Modular Group With Id: ' . $delete->mg_id . ' And Name: ' . $delete->mg_title);

                return redirect()->back()->with('success', 'Successfully Deleted');
            }


        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }

    }


}


