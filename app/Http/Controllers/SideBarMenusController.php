<?php

namespace App\Http\Controllers;

use App\Models\ModularConfigDefinitionModel;
use function foo\func;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SideBarMenusController extends Controller
{
    public function side_bar_menus(){
        $side_bar_values = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->with('childs')->with(['childs'=>function($query){
            $query->with('childs');
        }])->get();
        $sidebar_menu_lists = ModularConfigDefinitionModel::where('mcd_level', 3)->get();

        $user_level = Auth::user()->only('user_level');
        $user = $user_level['user_level'];
        $first_level_modules = Session::get('first_level_modules');
        $second_level_modules = Session::get('second_level_modules');
        $third_level_modules = Session::get('third_level_modules');

        return response()->json( ['status'=>true, 'message'=>'Success', 'side_bar_values'=>$side_bar_values, 'sidebar_menu_lists'=>$sidebar_menu_lists, 'first_level_modules'=>$first_level_modules, 'second_level_modules'=>$second_level_modules, 'third_level_modules'=>$third_level_modules, 'user'=>$user], 200);
    }
}
