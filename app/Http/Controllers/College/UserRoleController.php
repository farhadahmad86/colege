<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\College\Master;
use App\Models\College\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = UserRole::all();
        return view('collegeViews/user_role/user_role_list',compact('roles'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brwsr_rslt = $this->getBrwsrInfo();
        $clientIP = $this->get_ip();

        $master = Master::findOrNew(1);
        $master->full_name = 'Master';
        $master->username = 'Master';
        $master->email = 'master@gmail.com';
        $master->password = Hash::make('12345678');
        $master->created_by = 0;
        $master->enable_disable = 1;
        $master->save();

        $role = UserRole::pluck('role_name')->first();
        if (empty($role)) {
            $roles = collect((object)array(
                (object)['name' => 'Super Administrator'],
                (object)['name' => 'Coordinator'],
                (object)['name' => 'Inquire'],
                (object)['name' => 'Exam'],
                (object)['name' => 'Account'],
                (object)['name' => 'Administrator'],
                (object)['name' => 'Superintendent'],
            )
            );
            foreach ($roles as $item) {
                $role = new UserRole();
                $role->role_name = $item->name;
                $role->role_browser_info = $brwsr_rslt;
                $role->role_ip_address = $clientIP;
                $role->role_created_by = 0;
                $role->save();
            }
        }
        return redirect()->route('user_role.index')->with('success','User Role Create Successfully!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserRole $userRole)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserRole $userRole)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserRole $userRole)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserRole $userRole)
    {
        //
    }
}
