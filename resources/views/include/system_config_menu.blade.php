@php
    $count +=1; $child_i = 1;
@endphp
    @if($isChild)
        <ul class="list-group border-0 systm_cnfg_lst_itms">
    @endif


        @foreach($childs as $child)

            @if($count<=1)
                @if(in_array($child->mcd_code,$second_level_modules) || $user->user_level==100)
                    <li class="list-group-item gnrl-bg-trnsprnt gnrl-mrgn-pdng  border-0">
                        <div class="panel panel-default gnrl-bg-trnsprnt systm_cnfg_lst"><!-- system config list start -->
                            <div class="panel-heading gnrl-mrgn-pdng gnrl-bg-trnsprnt" role="tab" id="headingchild{{ $i }}{{ $child_i }}One">
                                <h4 class="panel-title">
                                    <a class="systm_cnfg_lst_ttl collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsechild{{ $i }}{{ $child_i }}One" aria-expanded="true" aria-controls="collapsechild{{ $i }}{{ $child_i }}One">
                                        <i class="fa fa-folder"></i> {{$child->mcd_title}}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapsechild{{ $i }}{{ $child_i }}One" class="panel-collapse collapse systm_cnfg_lst_cntnt" role="tabpanel" aria-labelledby="headingchild{{ $i }}{{ $child_i }}One">
                                @if(count($child->childs))
                                    @php
                                        $isChild = true;
                                    @endphp
                                    @include('include/system_config_menu',['childs' => $child->childs,'count' =>$count, 'isChild' => $isChild])
                                    @php
                                        $isChild = false;
                                    @endphp
                                @endif
                            </div>
                        </div>
                    </li>
                @endif
            @else
                @if(in_array($child->mcd_code,$third_level_modules) || $user->user_level==100)
                    <li class="list-group-item gnrl-bg-trnsprnt gnrl-mrgn-pdng border-0">
                        <a href="javascript: avoid();" class="systm_cnfg_lst_lnk" data-target="{{$child->mcd_web_route}}">
                            <i class="fa fa-file-text"></i> {{$child->mcd_title}}
                        </a>
                    </li>
                @endif
            @endif
            @php $child_i++ @endphp
        @endforeach


        @if($isChild)
    </ul>
@endif
