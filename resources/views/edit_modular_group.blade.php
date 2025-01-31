@extends('extend_index')

@section('styles_get')
    <link href="{{asset("public/css/treeview.css" )}}" rel="stylesheet">
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Edit Modular Group</h4>
                        </div>
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" action="{{ route('update_modular_group') }}" onsubmit="return checkForm()"
                      method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">


                            <div class="row">

                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.configurations.add_modular_group.modular_group_name.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Modular Group Name
                                        </label>
                                        <input type="text" name="group_name" id="group_name" class="inputs_up form-control"
                                               data-rule-required="true" data-msg-required="Please Enter Name"
                                               placeholder="Modular Group Name" autofocus value="{{$group->mg_title}}"/>
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Remarks</label>
                                        <textarea name="remarks" id="remarks" rows="8" class="inputs_up remarks form-control" placeholder="Remarks">{{$group->mg_remarks}}</textarea>
                                        <span id="demo2" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <input type="hidden" value="{{$group->mg_id}}" name="group_id">
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button type="reset" name="cancel" id="cancel" class="cancel_button">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button type="submit" name="save" id="save" class="save_button"
                                    >
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                </div>
                            </div>

                        </div> <!-- left column ends here -->

                        <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 marg-top-10"> {{-- container --}}
                            <div class="card card-primary">
                                <div class="card-heading" style="background-color: #2a88ad;border-color: #2a88ad;font-size: 18px;color: white;padding: 7px 15px">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                       data-placement="bottom" data-html="true"
                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.configurations.add_modular_group.select_module.description')}}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Select Module
                                    <label style="float: right;display: flex;align-items: center;">
                                        <input type="checkbox" name="check_all" id="check_all">Check All
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

                                                $group_value=explode(',',$group->mg_config);

                                                @endphp
                                                @foreach($modules as $index => $module)
                                                    <li class="heads head-{{$index+1}}">
                                                        @php
                                                            //    $index += 1;
                                                        @endphp

                                                        <input type="checkbox" name="first_level_config[{{$first_level_counter}}]" value="{{$module->mcd_code}}"
                                                               class="head-{{$index+1}} check_all">{{  $module->mcd_title }}
                                                        @if(count($module->childs))

                                                            @php
                                                                echo childNodes($module->childs, $index, $count,$group_value);
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
        </div><!-- col end -->
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

            function childNodes($childs, $index, $count, $group_value) {
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

                              //  $html .= '<input type="hidden" name="second_level_config[' . $numbers . ']" value="0">';
                                $html .= '<input type="checkbox"  name="second_level_config[' . $numbers . ']" value="'.$child->mcd_code.'" data-level="second" data-value="second_'.($index+1).'" data-valueNumber="'.($index+1).'" class="head-' . ($index+1) . ' check_all">' . $child->mcd_title;

                                if(count($child->childs)) {

                                    $html .= childNodes($child->childs, $index, $count,$group_value);

                                }
                            } else {

                                if($field_counter_global==null)
                                {
                                $field_counter_global=0;
                                }

                                if(in_array($child->mcd_code,$group_value)){
                                $selected='checked="checked"';
                                }else{
                                    $selected='';
                                    }

                               // $html .= '<input type="hidden" name="modular_config[' . $field_counter_global . ']" value="0">';
                                $html .= '<input type="checkbox" data-level="third" data-valueOne="'.($index+1).'" data-valueTwo="'.($numbers).'" name="modular_config[' . $field_counter_global . ']" value="'.$child->mcd_code.'"  '.$selected.' class="head-' . ($index+1) . ' check_all">' . $child->mcd_title;

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

        jQuery("#check_all").change(function () {
            if (this.checked) {
                jQuery('.check_all').prop('checked', true);
            } else {
                jQuery('.check_all').prop('checked', false);
            }
        });

        jQuery("input[type='checkbox']").change(function () {
            if (jQuery(this).is(':checked')) {
                jQuery(this).parent().find('input[type="checkbox"]').prop("checked", true);
            } else {
                jQuery(this).parent().find('input[type="checkbox"]').prop("checked", false);
            }
        });

        jQuery("input[type='checkbox'][data-level='third']").change(function () {
            if (jQuery(this).is(':checked')) {
                var checkbox = jQuery(this).parent().parent().prev();
                checkbox.prop("checked", true);
                checkbox.parent().parent().prev().prop("checked", true);
            } else {
                var level = jQuery(this).attr('data-level');
                var value1 = jQuery(this).attr('data-valueOne');
                var value2 = jQuery(this).attr('data-valueTwo');

                if (level === 'third') {
                    var check = true;
                    jQuery('[data-valueOne=' + value1 + '][data-valueTwo=' + value2 + ']').each(function () {
                        if (jQuery(this).is(':checked')) {
                            check = false;
                        }
                    })
                    if (check) {
                        checkbox = jQuery(this).parent().parent().prev();
                        checkbox.prop("checked", false);
                        jQuery(this).parent().parent().prev().trigger('change');
                    }
                }
            }
        });

        jQuery("input[type='checkbox'][data-level='second']").change(function () {
            if (jQuery(this).is(':checked')) {
                var checkbox = jQuery(this).parent().parent().prev();
                checkbox.prop("checked", true);
            } else {
                var level = jQuery(this).attr('data-level');
                var value = jQuery(this).attr('data-value');
                var valueNumber = jQuery(this).attr('data-valueNumber');

                if (level === 'second') {
                    var check2 = true;
                    jQuery('[data-valueNumber=' + valueNumber + ']').each(function () {
                        if (jQuery(this).is(':checked')) {
                            check2 = false;
                        }
                    });
                    if (check2) {
                        checkbox = jQuery(this).parent().parent().prev();
                        checkbox.prop("checked", false);
                    }
                }
            }
        });


        jQuery(document).ready(function () {

            setTimeout(function () {

                jQuery("input[type='checkbox'][data-level='third']").trigger('change');

            }, 100);

        });


        function form_validation() {
            var group_name = document.getElementById("group_name").value;

            var flag_submit = true;
            var focus_once = 0;

            if (group_name.trim() == "") {
                document.getElementById("demo1").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#group_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo1").innerHTML = "";
            }

            return flag_submit;
        }

    </script>

@endsection

