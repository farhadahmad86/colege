@extends('extend_index')

@section('styles_get')
    <link href="{{ asset('public/css/treeview.css') }}" rel="stylesheet">
@endsection
@section('content')
    @php
        use Spatie\Permission\Models\Permission;
    @endphp
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Role n Permission</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('role_permission_list') }}"
                            role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->


            <form name="f1" class="f1" id="f1" action="{{ route('submit_role_permission') }}"
                onsubmit="return checkForm()" method="post" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="input_bx form-group col-lg-12 col-md-12 col-sm-12">
                                <!-- start input box -->
                                <label class="required">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                        data-placement="bottom" data-html="true"
                                        data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.configurations.add_modular_group.modular_group_name.description') }}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a> Modular Group Name</label>
                                <input tabindex=1 autofocus type="text" name="group_name" id="group_name"
                                    data-rule-required="true" data-msg-required="Please Enter Modular Group"
                                    class="inputs_up form-control" value="{{ old('group_name') }}"
                                    placeholder="Modular Group Name" autofocus />
                                <span id="demo1" class="validate_sign"> </span>
                            </div><!-- end input box -->
                            <div class="input_bx form-group col-lg-12 col-md-12 col-sm-12">
                                <!-- start input box -->
                                <label class="">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                        data-placement="bottom" data-html="true"
                                        data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.description') }}</p>
                                <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits') }}</p>
                                <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.example') }}</p>
                                <h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Remarks</label>
                                <textarea tabindex="2" name="remarks" id="remarks" rows="8" class="remarks inputs_up form-control"
                                    placeholder="Remarks">{{ old('remarks') }}</textarea>
                                <span id="demo2" class="validate_sign"> </span>
                            </div><!-- end input box -->
                            <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                                <button tabindex="3" type="reset" name="cancel" id="cancel"
                                    class="cancel_button btn btn-sm btn-secondary">
                                    <i class="fa fa-eraser"></i> Cancel
                                </button>
                                <button tabindex="4 " type="submit" name="save" id="save"
                                    class="save_button btn btn-sm btn-success">
                                    <i class="fa fa-floppy-o"></i> Save
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 marg-top-10"> {{-- container --}}
                        <div class="card card-success">
                            <div class="card-heading"
                                style="background-color: #2a88ad;border-color: #2a88ad;font-size: 18px;color: white;padding: 7px 15px">
                                <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                    data-html="true"
                                    data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.configurations.add_modular_group.select_module.description') }}</p>">
                                    <i class="fa fa-info-circle"></i>
                                </a>
                                Select Module
                                <label style="float: right;display: flex;align-items: center;">
                                    <input tabindex="5" type="checkbox" name="check_all" id="check_all"
                                        checked="checked">Check All
                                </label>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 style="color: #0099ff!important;">Modules</h3>
                                        <ul id="tree1">
                                            @php
                                                $numbers = 0;
                                            @endphp

                                            @foreach ($modules_lev_1 as $index => $level_1)
                                                <li class="heads head-{{ $index + 1 }}">
                                                    <input tabindex="7" type="checkbox" name="permission[]"
                                                        value="{{ $level_1->id }}" checked="checked"
                                                        class="head-{{ $index + 1 }} check_all">{{ $level_1->name }}
                                                    @php

                                                    @endphp
                                                    <ul>
                                                        @php
                                                            $query = Permission::where('level', '=', 2)
                                                                ->where('after_config', '=', 1)
                                                                ->where('parent_code', '=', $level_1->code);
                                                            //$query = Permission::whereIn('id',$permission_ids)->where('level', '=', 2)->where('after_config', '=', 1)->where('parent_code','=',
                                                            //  $level_1->code);
                                                            if ($user->user_id == 1) {
                                                                $query = Permission::where('level', '=', 2)
                                                                    ->where('after_config', '=', 1)
                                                                    ->where('parent_code', '=', $level_1->code);
                                                            }
                                                            if ($softaware_pakge == 'Premium') {
                                                                $modules_lev_22 = $query->whereIn('package', ['Basic', 'Advance', 'Premium'])->get();
                                                            } elseif ($softaware_pakge == 'Advance') {
                                                                $modules_lev_22 = $query->whereIn('package', ['Basic', 'Advance'])->get();
                                                            } elseif ($softaware_pakge == 'Basic') {
                                                                $modules_lev_22 = $query->where('package', $softaware_pakge)->get();
                                                            }

                                                            //$modules_lev_22 = Permission::where('level', '=', 2)->where('code', '!=', 18)->where('after_config', '=', 1)->where('parent_code','=',
                                                            //$level_1->code)->get();

                                                        @endphp

                                                        @foreach ($modules_lev_22 as $level_2)
                                                            @if ($level_2->parent_code == $level_1->code)
                                                                <li id="Edit_Property" class="head-{{ $index + 1 }}"
                                                                    style="cursor: pointer">
                                                                    <input type="checkbox"
                                                                        class="head-{{ $index + 1 }} check_all"
                                                                        data-level="second"
                                                                        data-value="second_{{ $index + 1 }}"
                                                                        data-valueNumber="{{ $index + 1 }}"
                                                                        checked="checked" id="id-edit-property"
                                                                        name="permission[]"
                                                                        value="{{ $level_2->id }}" />{{ $level_2->name }}
                                                                    <ul>
                                                                        @php
                                                                            $query = Permission::where('level', '=', 3)
                                                                                ->where('after_config', '=', 1)
                                                                                ->where('parent_code', '=', $level_2->code);
                                                                            //$query = Permission::whereIn('id',$permission_ids)->where('level', '=', 3)->where('after_config', '=', 1)->where('parent_code','=',$level_2->code);
                                                                            if ($user->user_id == 1) {
                                                                                $query = Permission::where('level', '=', 3)
                                                                                    ->where('after_config', '=', 1)
                                                                                    ->where('parent_code', '=', $level_2->code);
                                                                            }

                                                                            if ($softaware_pakge == 'Premium') {
                                                                                $modules_lev_33 = $query->whereIn('package', ['Basic', 'Advance', 'Premium'])->get();
                                                                            } elseif ($softaware_pakge == 'Advance') {
                                                                                $modules_lev_33 = $query->whereIn('package', ['Basic', 'Advance'])->get();
                                                                            } elseif ($softaware_pakge == 'Basic') {
                                                                                $modules_lev_33 = $query->where('package', $softaware_pakge)->get();
                                                                            }

                                                                        @endphp
                                                                        @foreach ($modules_lev_33 as $level_3)
                                                                            @if ($level_3->parent_code == $level_2->code)
                                                                                <li>
                                                                                    <input type="checkbox"
                                                                                        data-level="third"
                                                                                        data-valueOne="{{ $index + 1 }}"
                                                                                        data-valueTwo="{{ $numbers }}"
                                                                                        class="head-{{ $index + 1 }} check_all"
                                                                                        id="id_abc" name="permission[]"
                                                                                        checked="checked"
                                                                                        value="{{ $level_3->id }}">{{ $level_3->name }}
                                                                                </li>
                                                                            @endif
                                                                        @endforeach

                                                                    </ul>
                                                                </li>
                                                            @endif
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
                </div> <!--  main row ends here -->
            </form>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection
@section('scripts')
    <script src="{{ asset('public/js/treeview.js') }}"></script>
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
    <script>
        jQuery("#check_all").change(function() {
            if (this.checked) {
                jQuery('.check_all').prop('checked', true);
            } else {
                jQuery('.check_all').prop('checked', false);
            }
        });

        jQuery("input[type='checkbox']").change(function() {

            if ($(this).is(':checked')) {
                $(this).parent().find('input[type="checkbox"]').prop("checked", true);
            } else {
                $(this).parent().find('input[type="checkbox"]').prop("checked", false);
            }
        });


        jQuery("input[type='checkbox'][data-level='third']").change(function() {
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
                    $('[data-valueOne=' + value1 + '][data-valueTwo=' + value2 + ']').each(function() {
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

        jQuery("input[type='checkbox'][data-level='second']").change(function() {
            if ($(this).is(':checked')) {
                var checkbox = $(this).parent().parent().prev();
                checkbox.prop("checked", true);
            } else {
                var level = $(this).attr('data-level');
                var value = $(this).attr('data-value');
                var valueNumber = $(this).attr('data-valueNumber');

                if (level === 'second') {
                    var check2 = true;
                    $('[data-valueNumber=' + valueNumber + ']').each(function() {
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
