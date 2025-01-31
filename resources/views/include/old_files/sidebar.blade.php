<div class="left-side-bar">
    <div class="brand-logo">
        <a href={{route("index" )}}>
            <img src={{asset("public/vendors/images/my_logo.png")}} alt="">

        </a>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu" class="accordion-menu">
                <li>
                    <a href="{{route("index")}}" class="dropdown-toggle no-arrow">
                        <span class="fa fa-home"></span><span class="mtext">Home</span>
                    </a>
                </li>

                @php
                    use App\Models\ModularConfigDefinitionModel;
                    $side_bar_values = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->get();

                $user=Auth::user();
                $first_level_modules = Session::get('first_level_modules');
                $second_level_modules = Session::get('second_level_modules');
                $third_level_modules = Session::get('third_level_modules');

                $count=0;
                $isChild = false;
                @endphp
                @foreach($side_bar_values as $index => $side_bar_value)

                    @if(in_array($side_bar_value->mcd_code,$first_level_modules) || $user->user_level==100)
{{--                        style="border-bottom: 1px solid #1c93e6 !important;"--}}
                        <li class="dropdown">
                            <a class="dropdown-toggle">
                                <span class="fa fa-user-circle-o"></span><span
                                        class="mtext">{{$side_bar_value->mcd_title}}</span>
                            </a>

                            @if(count($side_bar_value->childs))
                                <ul class="submenu">
                                    @include('include/manage_sidebar_child',['childs' => $side_bar_value->childs,'count' =>$count, 'isChild' => $isChild])
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach

            </ul>
        </div>
    </div>
</div>
{{--<script src="{{asset("public/js/treeview.js")}}"></script>--}}