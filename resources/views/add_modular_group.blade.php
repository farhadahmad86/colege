@extends('extend_index')

@section('styles_get')
    <link href="{{asset("public/css/treeview.css" )}}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Modular Group</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('modular_group_list') }}" role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->


            <form name="f1" class="f1" id="f1" action="{{ route('submit_modular_group') }}" onsubmit="return checkForm()" method="post" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="input_bx form-group col-lg-12 col-md-12 col-sm-12"><!-- start input box -->
                                <label class="required">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                       data-placement="bottom" data-html="true"
                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.configurations.add_modular_group.modular_group_name.description')}}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a> Modular Group Name</label>
                                <input tabindex=1 autofocus type="text" name="group_name" id="group_name" data-rule-required="true" data-msg-required="Please Enter Modular Group"
                                       class="inputs_up form-control" value="{{old('group_name')}}" placeholder="Modular Group Name" autofocus/>
                                <span id="demo1" class="validate_sign"> </span>
                            </div><!-- end input box -->
                            <div class="input_bx form-group col-lg-12 col-md-12 col-sm-12"><!-- start input box -->
                                <label class="">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Remarks</label>
                                <textarea tabindex="2" name="remarks" id="remarks" rows="8" class="remarks inputs_up form-control" placeholder="Remarks">{{old('remarks')}}</textarea>
                                <span id="demo2" class="validate_sign"> </span>
                            </div><!-- end input box -->
                            <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                                <button tabindex="3" type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-secondary">
                                    <i class="fa fa-eraser"></i> Cancel
                                </button>
                                <button tabindex="4 " type="submit" name="save" id="save" class="save_button btn btn-sm btn-success">
                                    <i class="fa fa-floppy-o"></i> Save
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 marg-top-10"> {{-- container --}}
                        <div class="card card-success">
                            <div class="card-heading" style="background-color: #2a88ad;border-color: #2a88ad;font-size: 18px;color: white;padding: 7px 15px">
                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                   data-placement="bottom" data-html="true"
                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.configurations.add_modular_group.select_module.description')}}</p>">
                                    <i class="fa fa-info-circle"></i>
                                </a>
                                Select Module
                                <label style="float: right;display: flex;align-items: center;">
                                    <input tabindex="5" type="checkbox" name="check_all" id="check_all" checked="checked">Check All
                                </label>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3 style="color: #0099ff!important;">Modules</h3>
                                        <ul id="tree1">
                                            @php
                                                $count=0;

                                            global $first_level_counter;
                                                $first_level_counter=0;

                                            @endphp
                                            @foreach($modules as $index => $module)

                                                <li class="heads head-{{$index+1}}">
                                                    @php
                                                        //    $index += 1;
                                                    @endphp
                                                    {{--                                                    <input tabindex="6" type="hidden" name="first_level_config[{{$first_level_counter}}]" value="0">--}}
                                                    <input tabindex="7" type="checkbox" name="first_level_config[{{$first_level_counter}}]" value="{{$module->mcd_code}}" checked="checked"
                                                           class="head-{{$index+1}} check_all">{{  $module->mcd_title }}
                                                    @if(count($module->childs))
                                                        {{--                                                        @include('manage_child_modular_group',['childs' => $module->childs ,'count' =>$count, 'index' => $index, 'field_counter'=>$field_counter])--}}

                                                        @php
                                                            echo childNodes($module->childs, $index, $count);
                                                            $first_level_counter++;
                                                        @endphp

                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!--  main row ends here -->
            </form>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection
@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let group_name = document.getElementById("group_name"),
                validateInputIdArray = [
                    group_name.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script src="{{asset("public/js/treeview.js")}}"></script>

    @php

        //$field_counter_global = 0;

            function childNodes($childs, $index, $count) {
        global $field_counter_global;
        global $numbers;

                $count++;

                $html = '<ul>';

                    foreach($childs as $child) {

                     if($numbers==null)
                                {
                                    $numbers=0;
                                }

                        $html .= '<li class="head-' . ($index+1) . '" style="cursor: pointer">';

                            if($count<=1) {

                                //$html .= '<input type="hidden" name="second_level_config[' . $numbers . ']" value="0">';
                                $html .= '<input type="checkbox"  name="second_level_config[' . $numbers . ']" value="'.$child->mcd_code.'" data-level="second" data-value="second_'.($index+1).'" data-valueNumber="'.($index+1).'" checked="checked" class="head-' . ($index+1) . ' check_all">' . $child->mcd_title;

                                if(count($child->childs)) {

                                    $html .= childNodes($child->childs, $index, $count);
                                }


                            } else {

                            if($field_counter_global==null)
                            {
                            $field_counter_global=0;
                            }

                                //$html .= '<input type="hidden" name="modular_config[' . $field_counter_global . ']" value="0">';
                                $html .= '<input type="checkbox" data-level="third" data-valueOne="'.($index+1).'" data-valueTwo="'.($numbers).'" name="modular_config[' . $field_counter_global . ']"  value="'.$child->mcd_code.'" checked="checked" class="head-' . ($index+1) . ' check_all">' . $child->mcd_title;

                                $field_counter_global++;

                            }

                        $html .= '</li>';

                    }

                    $numbers++;
                $html .= '</ul>';

                return $html;
            }

    @endphp

    <script type="text/javascript">

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });


        jQuery("#check_all").change(function () {
            if (this.checked) {
                jQuery('.check_all').prop('checked', true);
            } else {
                jQuery('.check_all').prop('checked', false);
            }
        });

        jQuery("input[type='checkbox']").change(function () {
            if ($(this).is(':checked')) {
                $(this).parent().find('input[type="checkbox"]').prop("checked", true);
            } else {
                $(this).parent().find('input[type="checkbox"]').prop("checked", false);
            }
        });


        jQuery("input[type='checkbox'][data-level='third']").change(function () {
            if ($(this).is(':checked')) {
                var checkbox = $(this).parent().parent().prev();
                checkbox.prop("checked", true);
                checkbox.parent().parent().prev().prop("checked", true);
            } else {
                var level = $(this).attr('data-level');
                var value1 = $(this).attr('data-valueOne');
                var value2 = $(this).attr('data-valueTwo');

                if (level === 'third') {
                    var check = true;
                    $('[data-valueOne=' + value1 + '][data-valueTwo=' + value2 + ']').each(function () {
                        if ($(this).is(':checked')) {
                            check = false;
                        }
                    })
                    if (check) {
                        checkbox = $(this).parent().parent().prev();
                        checkbox.prop("checked", false);
                        $(this).parent().parent().prev().trigger('change');
                    }
                }
            }
        });

        jQuery("input[type='checkbox'][data-level='second']").change(function () {
            if ($(this).is(':checked')) {
                var checkbox = $(this).parent().parent().prev();
                checkbox.prop("checked", true);
            } else {
                var level = $(this).attr('data-level');
                var value = $(this).attr('data-value');
                var valueNumber = $(this).attr('data-valueNumber');

                if (level === 'second') {
                    var check2 = true;
                    $('[data-valueNumber=' + valueNumber + ']').each(function () {
                        if ($(this).is(':checked')) {
                            check2 = false;
                        }
                    });
                    if (check2) {
                        checkbox = $(this).parent().parent().prev();
                        checkbox.prop("checked", false);
                    }
                }
            }
        });

        function form_validation() {
            var group_name = document.getElementById("group_name").value;
            var remarks = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;

            // if(group_name.trim() == "")
            // {
            //     document.getElementById("demo1").innerHTML = "Required";
            //     if (focus_once == 0) { jQuery("#group_name").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //     document.getElementById("demo1").innerHTML = "";
            // }

            // if(remarks.trim() == "")
            // {
            //     document.getElementById("demo2").innerHTML = "Required";
            //     if (focus_once == 0) { jQuery("#remarks").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //     document.getElementById("demo2").innerHTML = "";
            // }
            return flag_submit;
        }

    </script>

@endsection


