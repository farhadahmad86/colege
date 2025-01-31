@extends('extend_index')

@section('styles_get')
    <link href="{{asset("public/css/treeview.css" )}}" rel="stylesheet">
@endsection

@section('content')
    @php
        use Spatie\Permission\Models\Permission;
    @endphp
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Edit Role n Permission</h4>
                        </div>
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" action="{{ route('update_role_permission') }}" onsubmit="return checkForm()"
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
                                               placeholder="Modular Group Name" autofocus value="{{$group->name}}"/>
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
                                        <textarea name="remarks" id="remarks" rows="8" class="inputs_up remarks form-control" placeholder="Remarks">{{$group->remarks}}</textarea>
                                        <span id="demo2" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <input type="hidden" value="{{$group->id}}" name="group_id">
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
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h3 style="color: #0099ff!important;">Modules</h3>
                                                        <ul id="tree1">
                                                            @php
                                                                $numbers =0;

                                                            @endphp

                                                            @foreach($modules_lev_1 as $index => $level_1)
                                                                <li class="heads head-{{$index+1}}">
                                                                    <input tabindex="7" type="checkbox" name="permission[]" value="{{$level_1->id}}"
                                                                           {{ in_array($level_1->id, $permissions_ids) ? 'checked' : '' }}
                                                                           class="head-{{$index+1}} check_all">{{  $level_1->name }}
                                                                    @php

                                                                        @endphp
                                                                    <ul>
                                                                        @php

                                                                            $query = Permission::where('level', '=', 2)->where('after_config', '=', 1)->where('parent_code','=',$level_1->code);
 //$query = Permission::whereIn('id',$permission_ids)->where('level', '=', 2)->where('after_config', '=', 1)->where('parent_code','=',$level_1->code);
                                                                            if($user->user_id == 1){
                                                                                $query = Permission::where('level', '=', 2)->where('after_config', '=', 1)->where('parent_code','=',$level_1->code);
                                                                            }

                                    if ($softaware_pakge == 'Premium') {
                                                $modules_lev_22 = $query->whereIn('package', ['Basic', 'Advance', 'Premium'])->get();
                                    }elseif ($softaware_pakge == 'Advance') {
                                                $modules_lev_22 = $query->whereIn('package', ['Basic', 'Advance'])->get();
                                    }elseif ($softaware_pakge == 'Basic') {
                                                $modules_lev_22 = $query->where('package', $softaware_pakge)->get();
                                                                    }
                                                                        @endphp
                                                                        @foreach($modules_lev_22 as $level_2)
                                                                            <li id="Edit_Property" class="head-{{$index+1}}" style="cursor: pointer">
                                                                                <input type="checkbox" class="head-{{$index+1}} check_all" data-level="second" data-value="second_{{$index+1}}"
                                                                                       data-valueNumber="{{$index+1}}"
                                                                                       id="id-edit-property" name="permission[]" value="{{$level_2->id}}" {{ in_array($level_2->id,
                                                                                        $permissions_ids) ? 'checked' : '' }}/>{{$level_2->name}}
                                                                                <ul>
                                                                                    @php
                                                                                        //$modules_lev_33 = Permission::where('level', '=', 3)->where('code', '!=', 18)->where('after_config', '=', 1)
                                                                                        //->where('parent_code','=',
                                                                                        // $level_2->code)->get();

                                                                     $query = Permission::where('level', '=', 3)->where('after_config', '=', 1)->where('parent_code','=',$level_2->code);
                                                                     //$query = Permission::whereIn('id',$permission_ids)->where('level', '=', 3)->where('after_config', '=', 1)->where('parent_code',
                                                                     //'=',$level_2->code);
                                                                     if($user->user_id == 1){
                                                                         $query = Permission::where('level', '=', 3)->where('after_config', '=', 1)->where('parent_code','=',$level_2->code);
                                                                     }

                                                                    if ($softaware_pakge == 'Premium') {
                                                                        $modules_lev_33 = $query->whereIn('package', ['Basic', 'Advance', 'Premium'])->get();
                                                                    }elseif ($softaware_pakge == 'Advance') {
                                                                        $modules_lev_33 = $query->whereIn('package', ['Basic', 'Advance'])->get();
                                                                    }elseif ($softaware_pakge == 'Basic') {
                                                                        $modules_lev_33 = $query->where('package', $softaware_pakge)->get();
                                                                    }
                                                                                    @endphp
                                                                                    @foreach($modules_lev_33 as $level_3)
                                                                                        <li>
                                                                                            <input type="checkbox" data-level="third" data-valueOne="{{$index+1}}" data-valueTwo="{{$numbers}}"
                                                                                                   class="head-{{$index+1}} check_all"
                                                                                                   id="id_abc"
                                                                                                   name="permission[]" value="{{$level_3->id}}" {{ in_array($level_3->id, $permissions_ids) ?
                                                                                                   'checked' : '' }}>{{$level_3->name}}</li>
                                                                                    @endforeach

                                                                                </ul>
                                                                            </li>
                                                                        @endforeach
                                                                        @php
                                                                            $numbers++;
                                                                        @endphp
                                                                    </ul>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
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
            let check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            } else {
                return validateInventoryInputs(validateInputIdArray);
            }
        }
    </script>
    {{-- end of required input validation --}}
    <script src="{{asset("public/js/treeview.js")}}"></script>



    <script type="text/javascript">


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
    </script>

@endsection

