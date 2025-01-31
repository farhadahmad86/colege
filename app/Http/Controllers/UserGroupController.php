<?php

namespace App\Http\Controllers;

use App\Models\UserGroupModel;
use Auth;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
//    public function add_account_group()
//    {
//        return view('add_account_group', compact(''));
//    }
//
//    public function submit_account_group(Request $request)
//    {
//
//        $this->account_group_validation($request);
//
//        $group = new UserGroupModel();
//
//        $group = $this->AssignUserGroupValues($request, $group);
//
//        $group->save();
//
//
//        return redirect('add_account_group')->with('success', 'Successfully Saved');
//    }
//
//    public function account_group_validation($request)
//    {
//        return $this->validate($request, [
//            'group_name' => ['required', 'string', 'unique:financials_user_group,ug_title'],
//            'remarks' => ['nullable', 'string'],
//        ]);
//
//    }
//
//    protected function AssignUserGroupValues($request, $group)
//    {
//        $user = Auth::User();
//
//        $get_day_end = new DayEndController();
//        $day_end = $get_day_end->day_end();
//
//        $group->ug_title = ucwords($request->group_name);
//        $group->ug_remarks = ucfirst($request->remarks);
//        $group->ug_created_by = $user->user_id;
//        $group->ug_day_end_id = $day_end->de_id;
//        $group->ug_day_end_date = $day_end->de_datetime;
//
//        return $group;
//    }
//
//
//    public function account_group_list(Request $request)
//    {
//        if (isset($request->search) && !empty($request->search)) {
//
//            $search = $request->search;
//
//            $groups = UserGroupModel::where('ug_title', 'like', '%' . $search . '%')
//                ->orWhere('ug_remarks', 'like', '%' . $search . '%')
//                ->orWhere('ug_id', 'like', '%' . $search . '%')
////                ->orderBy('reg_title', 'ASC')
//                ->orderBy('ug_id', 'DESC')
//                ->paginate(20);
//        } else {
//            $groups = UserGroupModel::orderBy('ug_id', 'DESC')->paginate(20);
//        }
//
//        return view('account_group_list', compact('groups', 'search'));
//    }
//
//
//    public function edit_account_group(Request $request)
//    {
//        return view('edit_account_group', compact('request'));
//    }
//
//    public function update_account_group(Request $request)
//    {
//        $this->validate($request, [
//            'group_id' => ['required', 'numeric'],
//            'group_name' => ['required', 'string', 'unique:financials_user_group,ug_title,' . $request->group_id . ',ug_id'],
//            'remarks' => ['nullable', 'string'],
//        ]);
//
//        $group = UserGroupModel::where('ug_id', $request->group_id)->first();
//
//        $group = $this->AssignUserGroupValues($request, $group);
//
//        if ($group->save()) {
//            return redirect('account_group_list')->with('success', 'Successfully Saved');
//        } else {
//            return redirect('account_group_list')->with('fail', 'Failed Try Again!');
//        }
//
//    }
}
