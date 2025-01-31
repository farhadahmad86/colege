<ul>
    @php
        $count +=1;

    @endphp
    @foreach($childs as $child)
        <li class="head-{{$index+1}}" style="cursor: pointer">

            @if($count<=2)
                @if($child->coa_code != 11011)
                {{ $child->coa_code .' - '.$child->coa_head_name}}



                    {{--                                                nabeel panga--}}
                    {{-- <div class="col-md-6">
                        <form name="f1" class="f1" id="f1" action="store_chart_of_account2" method="post" onsubmit="return checkForm()">
                            @csrf
                            <div hidden class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <div class="input_bx">
                                        <label class="required">Code</label>
                                        <input type="number" name="code" id="code" value="{{$child->coa_code}}" class="inputs_up form-control" placeholder="Code" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div hidden class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <div class="input_bx">
                                        <label class="required">Name</label>
                                        <input type="text" name="name" id="name" value="{{$child->coa_head_name}}"  class="inputs_up form-control" placeholder="Name" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div hidden class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <div class="input_bx">
                                        <label class="required">Parent</label>
                                        <input type="number" name="parent" id="parent" value="{{$child->coa_parent}}"  class="inputs_up form-control" placeholder="Parent" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div hidden class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <div class="input_bx">
                                        <label class="required">Level</label>
                                        <input type="number" name="level" id="level" value="{{$child->coa_level}}" class="inputs_up form-control" placeholder="Quantity" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-group input-group-sm col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" name="account_name" id="account_name"
                                           class="border form-control" placeholder="Account Name"
                                           autocomplete="off" style="height: 30px;">

                                    <span class="input-group-append">
<button type="submit" name="save" id="save" type="button" style="background: #305a72;color: white;"
        class="btn btn-info btn-flat"><i class="fa fa-floppy-o"></i> Save</button>
</span>
                                </div>

                            </div>
                        </form>
                    </div> --}}



                @if(count($child->childs))
                    @include('manageChildChild',['childs' => $child->childs,'count' =>$count])
                @elseif (isset($child->accounts))
                    {{--{{$child->account_name}}--}}
                    @include('manageChildChild',['childs' => $child->accounts,'count' =>$count])
                @endif
                    @endif
            @else
                <a class="edit" data-account_id="{{$child->account_uid}}"
                   data-account_name="{{$child->account_name}}">{{$child->account_uid.' - '.$child->account_name}}</a>
            @endif





        </li>
    @endforeach
</ul>
