@php
    $count +=1;
@endphp
@if($isChild)
    <ul class="submenu child">
@endif


@foreach($childs as $child)

    @if($count<=1)
        @if(in_array($child->mcd_code,$second_level_modules) || $user->user_level==100)
            <li class="dropdown border_main">
                <a class="dropdown-toggle">
                    <span class="fa fa-folder"></span><span class="mtext">{{$child->mcd_title}}</span>
                </a>
                @if(count($child->childs))
                    @php
                        $isChild = true;
                    @endphp
                    @include('include/manage_sidebar_child',['childs' => $child->childs,'count' =>$count, 'isChild' => $isChild])
                    @php
                        $isChild = false;
                    @endphp
                @endif
            </li>
        @endif
    @else
        @if(in_array($child->mcd_code,$third_level_modules) || $user->user_level==100)
                <li><a class="last_menu" href="{{route("$child->mcd_web_route")}}">{{$child->mcd_title}}</a></li>
        @endif
    @endif

@endforeach


@if($isChild)
    </ul>
@endif
