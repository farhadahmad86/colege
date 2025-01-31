<ul>
    @php
        $count +=1;
    $field_counter=0;
    @endphp


    @foreach($childs as $child)
        <li class="head-{{$index+1}}" style="cursor: pointer">
            @if($count<=1)

                <input type="checkbox" checked="checked" class="head-{{$index+1}} check_all">{{$child->mcd_title}}
                @if(count($child->childs))
                    @include('manage_child_modular_group',['childs' => $child->childs,'count' =>$count, 'field_counter'=>$field_counter])

                @endif
            @else
                <input type="hidden" name="modular_config[{{$field_counter}}]" value="0">
                <input type="checkbox" name="modular_config[{{$field_counter}}]" value="1" checked="checked"
                       class="head-{{$index+1}} check_all">{{$child->mcd_title}}
                        @php
                                $field_counter ++;
                        @endphp
            @endif
        </li>

    @endforeach
</ul>