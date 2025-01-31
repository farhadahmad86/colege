<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;

use App\Models\PackagesModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionController extends Controller
{
    public function add_role_permission()
    {
        $user = Auth::user();

        $softaware_pakge = PackagesModel::where('pak_clg_id', $user->user_clg_id)->pluck('pak_name')->first();
        $permission_ids = DB::table('model_has_roles')
            ->where('model_id', $user->user_id)
            ->leftJoin('role_has_permissions', 'role_has_permissions.role_id', '=', 'model_has_roles.role_id')
            ->pluck('permission_id');

//        $query = Permission::whereIn('id', $permission_ids)->where('level', '=', 1)->where('after_config', '=', 1);
        $query = Permission::where('level', '=', 1)->where('after_config', '=', 1)->where('code', '!=', 18);
        if ($user->user_type == 'Master') {
            $query = Permission::where('level', '=', 1)->where('after_config', '=', 1);
        }else{
            $query->whereIn('id', $permission_ids);
        }
        if ($softaware_pakge == 'Basic') {
            $modules_lev_1 = $query->where('package', '=', $softaware_pakge)->get();
        } elseif ($softaware_pakge == 'Advance') {
            $modules_lev_1 = $query->whereIn('package', ['Basic', 'Advance'])->get();
        } elseif ($softaware_pakge == 'Premium') {
            $modules_lev_1 = $query->whereIn('package', ['Basic', 'Advance', 'Premium'])->get();
        }


        return view('role_permission/add_role_permission', compact('modules_lev_1', 'softaware_pakge', 'user'));
    }

    public function submit_role_permission(Request $request)
    {
        $user = Auth::User();
        $this->modular_group_validation($request);
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $modular_group = Role::create(['name' => ucwords($request->group_name),
            'remarks' => ucfirst($request->remarks),
            'created_by' => $user->user_id,
            'clg_id' => $user->user_clg_id,
            'brwsr_info' => $brwsr_rslt,
            'ip_adrs' => $ip_rslt,
        ]);
        $permissions = array_map('intval', $request->permission);
        $modular_group->syncPermissions($permissions);

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Modular Group With Id: ' . $modular_group->id . ' And Name: ' . $modular_group->name);

        return redirect()->back()->with('success', 'Successfully Saved');
    }

    public function modular_group_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'group_name' => ['required', 'string', 'unique:roles,name,' . $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);

    }

    // update code by shahzaib start
    public function role_permission_list(Request $request, $array = null, $str = null)
    {
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.modular_group_list.modular_group_list';
        $pge_title = 'Modular Group List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $users = Auth::user();
        if ($users->user_type == 'Master') {
            $query = DB::table('roles')->where('clg_id', $users->user_clg_id)
                ->leftJoin('financials_users', 'financials_users.user_id', 'roles.created_by');
        } else {
            $query = DB::table('roles')
                ->where('type', '!=', 1)
                ->leftJoin('financials_users', 'financials_users.user_id', 'roles.created_by')
                ->where('clg_id', $users->user_clg_id);
//                ->where('created_by', '!=', 0);
        }

//            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_modular_groups.mg_created_by');


        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('remarks', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            });
        }

//        $restore_list = $request->restore_list;
//        if ($restore_list == 1)
//        {
//            $query->where('mg_delete_status', '=', 1);
//        } else {
//            $query->where('mg_delete_status', '!=', 1);
//        }


        $datas = $query
//            ->where('mg_delete_status', '!=', 1)
            ->orderBy('id', 'DESC')->paginate($pagination_number);//->where('mg_id', '!=', 1)

        $group_title = Role::
        where('clg_id', $users->user_clg_id)->
//        where('mg_delete_status', '!=', 1)->
        orderBy('id', 'DESC')->pluck('name')->all();//where('mg_id', '!=', 1)->


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
            return view('role_permission/role_n_permission_list', compact('datas', 'group_title', 'search'));
        }


    }

    // update code by shahzaib end

    public function edit_role_permission(Request $request)
    {
        $user = Auth::user();
        $softaware_pakge = PackagesModel::where('pak_clg_id', $user->user_clg_id)->pluck('pak_name')->first();
        $permission_ids = DB::table('model_has_roles')
            ->where('model_id', $user->user_id)
            ->leftJoin('role_has_permissions', 'role_has_permissions.role_id', '=', 'model_has_roles.role_id')
            ->pluck('permission_id');
//        $query = Permission::whereIn('id', $permission_ids)->where('parent_code', '=', 0)->where('after_config', '=', 1);
        $query = Permission::where('level', '=', 1)->where('after_config', '=', 1)->where('code', '!=', 18);
        if ($user->user_type == 'Master') {
            $query = Permission::where('parent_code', '=', 0)->where('after_config', '=', 1);
        }else{
            $query->whereIn('id', $permission_ids);
        }
        if ($softaware_pakge == 'Basic') {
            $modules_lev_1 = $query->where('package', '=', $softaware_pakge)->get();

        } elseif ($softaware_pakge == 'Advance') {
            $modules_lev_1 = $query->whereIn('package', ['Basic', 'Advance'])->get();

        } elseif ($softaware_pakge == 'Premium') {
            $modules_lev_1 = $query->whereIn('package', ['Basic', 'Advance', 'Premium'])->get();

        }
        $group = Role::where('clg_id', $user->user_clg_id)->where('id', $request->group_id)->first();
        $permissions_ids = DB::table('role_has_permissions')->where('role_id', $request->group_id)->pluck('permission_id')->toArray();

        return view('role_permission/edit_role_n_permission', compact('group', 'modules_lev_1', 'permissions_ids', 'permission_ids', 'softaware_pakge', 'user'));
    }

    public function update_role_permission(Request $request)
    {
        $user = Auth::User();
        $this->validate($request, [
            'group_id' => ['required', 'numeric'],
            'group_name' => ['required', 'string', 'unique:roles,name,' . $request->group_id . ',id,clg_id,' . $user->user_clg_id],
            'permission' => 'required',
        ]);

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();


        $role = Role::find($request->group_id);
        $role->name = ucwords($request->group_name);
        $role->remarks = ucfirst($request->remarks);
        $role->created_by = $user->user_id;
        $role->brwsr_info = $brwsr_rslt;
        $role->ip_adrs = $ip_rslt;

        $role->save();
        $permissions = array_map('intval', $request->permission);
        $role->syncPermissions($permissions);

        return redirect('role_permission_list')->with('success', 'Updated Successfully!');
    }

    public function delete_role_permission(Request $request)
    {
        $user = Auth::User();

        $delete = Role::where('clg_id', $user->user_clg_id)->where('id', $request->group_id)->first();

//        $delete->mg_delete_status = 1;

        if ($delete->delete_status == 1) {
            $delete->delete_status = 0;
        } else {
            $delete->delete_status = 1;
        }

        $delete->deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Modular Group With Id: ' . $delete->id . ' And Name: ' . $delete->title);

                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Modular Group With Id: ' . $delete->id . ' And Name: ' . $delete->title);

                return redirect()->back()->with('success', 'Successfully Deleted');
            }


        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }

    }
}
