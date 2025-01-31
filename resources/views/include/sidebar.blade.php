<div class="left-side-bar">
    <div class="brand-logo">
        <a href={{route("index" )}}>
            <img src={{asset("public/vendors/images/my_logo.png")}} alt="">
        </a>
    </div>
    @php
        use App\Models\SystemConfigModel;
        use App\Models\PackagesModel;
        use Illuminate\Support\Facades\DB;
        use \Spatie\Permission\Models\Permission;


        $user=Auth::user();

        $permission_ids = DB::table('model_has_roles')
         ->leftJoin('roles','roles.id','=','model_has_roles.role_id')
        ->where('roles.clg_id','=',$user->user_clg_id)
        ->where('roles.disabled','!=',1)
        ->where('roles.delete_status','!=',1)
        ->where('model_id',$user->user_id)
        ->leftJoin('role_has_permissions','role_has_permissions.role_id','=','roles.id')
        ->pluck('permission_id');


        $softaware_pakge=PackagesModel::where('pak_clg_id',$user->user_clg_id)->pluck('pak_name')->first();
        if($user->user_id==1){
            $systm_cnfg_mdl = SystemConfigModel::where('sc_clg_id',$user->user_clg_id)->where('sc_all_done','0')->first();
        if( $systm_cnfg_mdl === null ):
            $side_bar_values = Permission::whereIn('id',$permission_ids)->where('parent_code', '=', 0)->where('after_config', '=', 1)->get();
        $side_bar_childs = Permission::whereIn('id',$permission_ids)->where('after_config', '=', 1)->get();
            $sidebar_menu_lists = Permission::whereIn('id',$permission_ids)->where('level', 3)->where('after_config', '1')->orderby('code', 'ASC')->get();

        elseif(isset($systm_cnfg_mdl) && $systm_cnfg_mdl->sc_all_done === 0):
            $side_bar_values = Permission::whereIn('id',$permission_ids)->where('parent_code', '=', 0)->where('before_config', '1')->get();
            $sidebar_menu_lists = Permission::whereIn('id',$permission_ids)->where('level', 3)->where('before_config', '1')->orderby('code', 'ASC')->get();
        endif;
        }
        elseif($softaware_pakge == 'Basic'){
             $systm_cnfg_mdl = SystemConfigModel::where('sc_clg_id',$user->user_clg_id)->where('sc_all_done','0')->first();
        if( $systm_cnfg_mdl === null ):
            $side_bar_values = Permission::whereIn('id',$permission_ids)->where('parent_code', '=', 0)->where('after_config', '=', 1)->where('package', '=','Basic')->get();

            $sidebar_menu_lists = Permission::whereIn('id',$permission_ids)->where('level', 3)->where('after_config', '1')->where('package', '=','Basic')->orderby('code', 'ASC')
            ->get();
        elseif(isset($systm_cnfg_mdl) && $systm_cnfg_mdl->sc_all_done === 0):
            $side_bar_values = Permission::whereIn('id',$permission_ids)->where('parent_code', '=', 0)->where('before_config', '1')->where('package', '=','Basic')->get();
            $sidebar_menu_lists = Permission::whereIn('id',$permission_ids)->where('level', 3)->where('before_config', '1')->where('package', '=','Basic')->orderby('code', 'ASC')
            ->get();

        endif;
        }elseif($softaware_pakge=='Advance'){
             $systm_cnfg_mdl = SystemConfigModel::where('sc_clg_id',$user->user_clg_id)->where('sc_all_done','0')->first();
       if( $systm_cnfg_mdl === null ):
            $side_bar_values = Permission::whereIn('id',$permission_ids)->where('parent_code', '=', 0)->where('after_config', '=', 1)->whereIn('package', ['Basic','Advance'])->get();
            $sidebar_menu_lists = Permission::whereIn('id',$permission_ids)->where('level', 3)->where('after_config', '1')->whereIn('package', ['Basic','Advance'])->orderby('code',
            'ASC')->get();
        elseif(isset($systm_cnfg_mdl) && $systm_cnfg_mdl->sc_all_done === 0):
            $side_bar_values = Permission::whereIn('id',$permission_ids)->where('parent_code', '=', 0)->where('before_config', '1')->whereIn('package', ['Basic','Advance'])->get();
            $sidebar_menu_lists = Permission::whereIn('id',$permission_ids)->where('level', 3)->where('before_config', '1')->whereIn('package', ['Basic','Advance'])->orderby('code',
           'ASC')->get();

       endif;
       }elseif($softaware_pakge=='Premium'){
            $systm_cnfg_mdl = SystemConfigModel::where('sc_clg_id',$user->user_clg_id)->where('sc_all_done','0')->first();
       if( $systm_cnfg_mdl === null ):
           $side_bar_values = Permission::whereIn('id',$permission_ids)->where('parent_code', '=', 0)->where('after_config', '=', 1)->whereIn('package', ['Basic','Advance','Premium'])->get();
           $sidebar_menu_lists = Permission::whereIn('id',$permission_ids)->where('level', 3)->where('after_config', '1')->whereIn('package', ['Basic','Advance','Premium'])->orderby('code', 'ASC')->get();

        elseif(isset($systm_cnfg_mdl) && $systm_cnfg_mdl->sc_all_done === 0):
           $side_bar_values = Permission::whereIn('id',$permission_ids)->where('parent_code', '=', 0)->where('before_config', '1')->whereIn('package', ['Basic','Advance','Premium'])->get();
           $sidebar_menu_lists = Permission::whereIn('id',$permission_ids)->where('level', 3)->where('before_config', '1')->whereIn('package', ['Basic','Advance','Premium'])->orderby('code', 'ASC')->get();

       endif;
       }


    $user=Auth::user();
        $query = Permission::whereIn('id',$permission_ids)->where('level', '=', 2)->where('after_config', '=', 1);
        if($softaware_pakge=='Premium'){
            $side_bar_childs = $query->whereIn('package', ['Basic','Advance','Premium'])->get();
        }elseif($softaware_pakge=='Advance'){
            $side_bar_childs = $query->whereIn('package', ['Basic','Advance'])->get();
        }elseif($softaware_pakge=='Basic'){
            $side_bar_childs = $query->where('package', '=','Basic')->get();
        }

    $count=0;
    $isChild = false;
    @endphp

    <div class="sidebar-search" style="margin: 15px 3px 0">
        <input placeholder="Search Menu" type="text" name="sidemenu" id="sidemenu" style="width: 100%" list="searchbar_sidemenu" autocomplete="off">
        <datalist id="searchbar_sidemenu">
            @forelse($sidebar_menu_lists as  $sidebar_menu_list)
                <option value="{{$sidebar_menu_list->name}}" data-url="{{$sidebar_menu_list->web_route}}"></option>
            @empty
            @endforelse
        </datalist>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu" class="accordion-menu">
                {{--                <li class="dropdown border_main">--}}
                {{--                    <a class="dropdown-toggle">--}}
                {{--                        <span class="fa fa-folder"></span><span--}}
                {{--                            class="mtext">Dashboard</span>--}}
                {{--                    </a>--}}
                {{--                    <ul class="submenu child">--}}
                {{--                        <li><a class="last_menu" href="{{route("index")}}">Dashboard</a></li>--}}
                {{--                        <li><a class="last_menu" href="{{route("dashboard")}}">Admin Dashboard</a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                <li class="border_main">
                    <a href="{{route("index")}}" class="dropdown-toggle no-arrow">
                        <span class="fa fa-home"></span><span class="mtext">Home</span>
                    </a>
                </li>

                @if($user->user_status == 'Non Employee')
                    <li class="border_main">
                        <a href="{{route("personal_account_ledger")}}" class="dropdown-toggle no-arrow">
                            <span class="fa fa-home"></span><span class="mtext">Personal Account ledger</span>
                        </a>
                    </li>
                    <li class="border_main">
                        <a href="{{route("sale_order_list")}}" class="dropdown-toggle no-arrow">
                            <span class="fa fa-home"></span><span class="mtext">Order List</span>
                        </a>
                    </li>
                    <li class="border_main">
                        <a href="{{route("dispatch_list")}}" class="dropdown-toggle no-arrow">
                            <span class="fa fa-home"></span><span class="mtext">Dispatch List</span>
                        </a>
                    </li>
                @endif
                @foreach($side_bar_values as $index => $side_bar_value)

                    <li class="dropdown border_main">
                        <a class="dropdown-toggle">
                            <span class="fa fa-folder"></span><span
                                class="mtext">{{$side_bar_value->name}}</span>
                        </a>
                        <ul class="submenu child">
                            @foreach($side_bar_childs as $value)
                                @if($value->parent_code == $side_bar_value->code)
                                    <li class="dropdown border_main">
                                        <a class="dropdown-toggle">
                                            <span class="fa fa-folder"></span><span class="mtext">{{$value->name}}</span>
                                        </a>
                                        <ul class="submenu child">
                                            @php
                                                $query = Permission::whereIn('id',$permission_ids)->where('parent_code',$value->code)->where('after_config', '=', 1);
                                            if($softaware_pakge=='Premium'){
                                                $side_bar_childs3 = $query->whereIn('package', ['Basic','Advance','Premium'])->get();
                                            }elseif($softaware_pakge=='Advance'){
                                                $side_bar_childs3 = $query->whereIn('package', ['Basic','Advance'])->get();
                                            }elseif($softaware_pakge=='Basic'){
                                                $side_bar_childs3 = $query->where('package', '=','Basic')->get();
                                            }
                                            @endphp
                                            @foreach($side_bar_childs3 as $child)
                                                <li><a class="last_menu" href="{{url($child->web_route)}}">{{$child->name}}</a></li>
                                                {{--                                                <li><a class="last_menu" href="{{$child->web_route}}">{{$child->name}}</a></li>--}}
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
