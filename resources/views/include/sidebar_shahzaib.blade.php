<div class="left-side-bar">
    <div class="brand-logo">
        <a href={{route("index" )}}>
            <img src={{asset("public/vendors/images/my_logo.png")}} alt="">

        </a>
    </div>


    @php
        use App\Models\ModularConfigDefinitionModel;
        use App\Models\SystemConfigModel;
        use App\Models\PackagesModel;

        $user=Auth::user();
        $softaware_pakge=PackagesModel::where('pak_id',1)->pluck('pak_name')->first();
        if($user->user_id==1){
            $systm_cnfg_mdl = SystemConfigModel::where('sc_all_done','0')->first();
        if( $systm_cnfg_mdl === null ):
            $side_bar_values = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->where('mcd_after_config', '=', 1)->get();
            $sidebar_menu_lists = ModularConfigDefinitionModel::where('mcd_level', 3)->where('mcd_after_config', '1')->orderby('mcd_code', 'ASC')->get();
        elseif(isset($systm_cnfg_mdl) && $systm_cnfg_mdl->sc_all_done === 0):
            $side_bar_values = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->where('mcd_before_config', '1')->get();
            $sidebar_menu_lists = ModularConfigDefinitionModel::where('mcd_level', 3)->where('mcd_before_config', '1')->orderby('mcd_code', 'ASC')->get();
        endif;
        }
        elseif($softaware_pakge == 'Basic'){
             $systm_cnfg_mdl = SystemConfigModel::where('sc_all_done','0')->first();
        if( $systm_cnfg_mdl === null ):
            $side_bar_values = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->where('mcd_after_config', '=', 1)->where('mcd_package', '=','Basic')->get();

            $sidebar_menu_lists = ModularConfigDefinitionModel::where('mcd_level', 3)->where('mcd_after_config', '1')->where('mcd_package', '=','Basic')->orderby('mcd_code', 'ASC')->get();
        elseif(isset($systm_cnfg_mdl) && $systm_cnfg_mdl->sc_all_done === 0):
            $side_bar_values = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->where('mcd_before_config', '1')->where('mcd_package', '=','Basic')->get();
            $sidebar_menu_lists = ModularConfigDefinitionModel::where('mcd_level', 3)->where('mcd_before_config', '1')->where('mcd_package', '=','Basic')->orderby('mcd_code', 'ASC')->get();
        endif;
        }elseif($softaware_pakge=='Advance'){
             $systm_cnfg_mdl = SystemConfigModel::where('sc_all_done','0')->first();
        if( $systm_cnfg_mdl === null ):
            $side_bar_values = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->where('mcd_after_config', '=', 1)->whereIn('mcd_package', ['Basic','Advance'])->get();
            $sidebar_menu_lists = ModularConfigDefinitionModel::where('mcd_level', 3)->where('mcd_after_config', '1')->whereIn('mcd_package', ['Basic','Advance'])->orderby('mcd_code', 'ASC')->get();
        elseif(isset($systm_cnfg_mdl) && $systm_cnfg_mdl->sc_all_done === 0):
            $side_bar_values = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->where('mcd_before_config', '1')->whereIn('mcd_package', ['Basic','Advance'])->get();
            $sidebar_menu_lists = ModularConfigDefinitionModel::where('mcd_level', 3)->where('mcd_before_config', '1')->whereIn('mcd_package', ['Basic','Advance'])->orderby('mcd_code', 'ASC')->get();
        endif;
        }elseif($softaware_pakge=='Premium'){
             $systm_cnfg_mdl = SystemConfigModel::where('sc_all_done','0')->first();
        if( $systm_cnfg_mdl === null ):
            $side_bar_values = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->where('mcd_after_config', '=', 1)->whereIn('mcd_package', ['Basic','Advance','Premium'])->get();
            $sidebar_menu_lists = ModularConfigDefinitionModel::where('mcd_level', 3)->where('mcd_after_config', '1')->whereIn('mcd_package', ['Basic','Advance','Premium'])->orderby('mcd_code', 'ASC')->get();
        elseif(isset($systm_cnfg_mdl) && $systm_cnfg_mdl->sc_all_done === 0):
            $side_bar_values = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->where('mcd_before_config', '1')->whereIn('mcd_package', ['Basic','Advance','Premium'])->get();
            $sidebar_menu_lists = ModularConfigDefinitionModel::where('mcd_level', 3)->where('mcd_before_config', '1')->whereIn('mcd_package', ['Basic','Advance','Premium'])->orderby('mcd_code', 'ASC')->get();
        endif;
        }


    $user=Auth::user();

    $first_level_modules = Session::get('first_level_modules');
    $second_level_modules = Session::get('second_level_modules');
    $third_level_modules = Session::get('third_level_modules');



//print_r($first_level_modules);
//print_r($second_level_modules);


    $count=0;
    $isChild = false;
    @endphp

{{--    <div class="sidebar-search" style="margin: 15px 3px 0">--}}

{{--        <input placeholder="Search Menu" type="text" name="sidemenu" id="sidemenu" style="width: 100%" list="searchbar_sidemenu" autocomplete="off">--}}

{{--        <datalist id="searchbar_sidemenu">--}}
{{--            @forelse($sidebar_menu_lists as  $sidebar_menu_list)--}}
{{--                @if(in_array($sidebar_menu_list->mcd_code, $third_level_modules) || $user->user_level==100)--}}
{{--                    <option value="{{$sidebar_menu_list->mcd_title}}" data-url="{{$sidebar_menu_list->mcd_web_route}}"></option>--}}
{{--                @endif--}}
{{--            @empty--}}
{{--            @endforelse--}}

{{--        </datalist>--}}


{{--    </div>--}}
{{--    <div class="menu-block customscroll">--}}
{{--        <div class="sidebar-menu">--}}
{{--            <ul id="accordion-menu" class="accordion-menu">--}}
{{--                <li class="border_main">--}}
{{--                    <a href="{{route("index")}}" class="dropdown-toggle no-arrow">--}}
{{--                        <span class="fa fa-home"></span><span class="mtext">Home</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                @if($user->user_status == 'Non Employee')--}}
{{--                    <li class="border_main">--}}
{{--                        <a href="{{route("personal_account_ledger")}}" class="dropdown-toggle no-arrow">--}}
{{--                            <span class="fa fa-home"></span><span class="mtext">Personal Account ledger</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="border_main">--}}
{{--                        <a href="{{route("sale_order_list")}}" class="dropdown-toggle no-arrow">--}}
{{--                            <span class="fa fa-home"></span><span class="mtext">Order List</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="border_main">--}}
{{--                        <a href="{{route("dispatch_list")}}" class="dropdown-toggle no-arrow">--}}
{{--                            <span class="fa fa-home"></span><span class="mtext">Dispatch List</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endif--}}

{{--                @foreach($side_bar_values as $index => $side_bar_value)--}}

{{--                    @if(in_array($side_bar_value->mcd_code,$first_level_modules) || $user->user_level==100 )--}}
{{--                        --}}{{--                        style="border-bottom: 1px solid #1c93e6 !important;"--}}
{{--                        @if($user->user_id != 1 && $side_bar_value->mcd_code != 18)--}}
{{--                        <li class="dropdown border_main">--}}
{{--                            <a class="dropdown-toggle">--}}
{{--                                <span class="fa fa-folder"></span><span--}}
{{--                                    class="mtext">{{$side_bar_value->mcd_title}}</span>--}}
{{--                            </a>--}}

{{--                            @if(count($side_bar_value->childs))--}}
{{--                                <ul class="submenu child">--}}
{{--                                    @include('include/manage_sidebar_child',['childs' => $side_bar_value->childs,'count' =>$count, 'isChild' => $isChild])--}}
{{--                                </ul>--}}
{{--                            @endif--}}

{{--                        </li>--}}
{{--                            @elseif($user->user_id == 1)--}}
{{--                            <li class="dropdown border_main">--}}
{{--                                <a class="dropdown-toggle">--}}
{{--                                    <span class="fa fa-folder"></span><span--}}
{{--                                        class="mtext">{{$side_bar_value->mcd_title}}</span>--}}
{{--                                </a>--}}

{{--                                @if(count($side_bar_value->childs))--}}
{{--                                    <ul class="submenu child">--}}
{{--                                        @include('include/manage_sidebar_child',['childs' => $side_bar_value->childs,'count' =>$count, 'isChild' => $isChild])--}}
{{--                                    </ul>--}}
{{--                                @endif--}}

{{--                            </li>--}}
{{--                        @endif--}}
{{--                    @endif--}}
{{--                @endforeach--}}





{{--                --}}{{--                <li class="dropdown">--}}
{{--                --}}{{--                    <a class="dropdown-toggle">--}}
{{--                --}}{{--                        <span class="fa fa-user-circle-o"></span><span class="mtext">PSO</span>--}}
{{--                --}}{{--                    </a>--}}
{{--                --}}{{--                    <ul class="submenu">--}}

{{--                --}}{{--                        <li class="dropdown">--}}
{{--                --}}{{--                            <a class="dropdown-toggle">--}}
{{--                --}}{{--                                <span class="fa fa-area-chart"></span><span class="mtext">PSO's Menu</span>--}}
{{--                --}}{{--                            </a>--}}
{{--                --}}{{--                            <ul class="submenu child">--}}
{{--                --}}{{--                                <li><a href="{{route("tank_list")}}">Tank List</a></li>--}}
{{--                --}}{{--                                <li><a href="{{route("add_nozzle")}}">Create Nozzle</a></li>--}}
{{--                --}}{{--                                <li><a href="{{route("nozzle_list")}}">Nozzle List</a></li>--}}
{{--                --}}{{--                                <li><a href="{{route("add_dip_reading")}}">Dip Reading</a></li>--}}
{{--                --}}{{--                                <li><a href="{{route("dip_reading_list")}}">Dip Reading List</a></li>--}}
{{--                --}}{{--                                <li><a href="{{route("add_tank_receiving")}}">Tanker Receiving</a></li>--}}
{{--                --}}{{--                                <li><a href="{{route("add_pso_product")}}">Products</a></li>--}}
{{--                --}}{{--                                <li><a href="{{route("pso_product_list")}}">Product List</a></li>--}}
{{--                --}}{{--                                <li><a href="{{route("add_nozzle_reading")}}">Nozzle Reading</a></li>--}}
{{--                --}}{{--                                <li><a href="{{route("add_pso_sale")}}">Sale</a></li>--}}
{{--                --}}{{--                            </ul>--}}
{{--                --}}{{--                        </li>--}}
{{--                --}}{{--                    </ul>--}}
{{--                --}}{{--                </li>--}}


{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
{{--<script src="{{asset("js/treeview.js")}}"></script>--}}
