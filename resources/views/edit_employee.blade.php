@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="container-fluid search-filter form-group form_manage">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Edit Employee</h4>
                        </div>
                        {{--                        <div class="list_btn"> --}}
                        {{--                            <a class="btn list_link add_more_button" href="{{ route('employee_list') }}" role="button"> --}}
                        {{--                                <i class="fa fa-list"></i> view list --}}
                        {{--                            </a> --}}
                        {{--                        </div><!-- list btn --> --}}
                    </div>
                </div><!-- form header close -->

                <form action="{{ route('update_employee') }}" id="f1" onsubmit="return checkForm()" method="post"
                      enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="tab form-group">
                                <ul class="nav nav-tabs customtab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active text-blue" data-toggle="tab" href="#personal"
                                           role="tab" aria-selected="true">Personal Info</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-blue" data-toggle="tab" href="#salary" role="tab"
                                           aria-selected="false">Salary Info</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-blue" data-toggle="tab" href="#credentials"
                                           role="tab" aria-selected="false">Credentials</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="personal" role="tabpanel">
                                        <div class="pd-20">
                                            <div class="row">
                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="required">
                                                            Department</label>
                                                        {{-- <input type="hidden" name="user_department_id" id="user_department_id" value="{{$employee->user_department_id}}"> --}}
                                                        {{--                                                            <input type="text" name="user_department_name"  id="user_department_name" class="inputs_up form-control" --}}
                                                        {{--                                                                   placeholder="Deparment Name" value="{{isset($setParentHead) ? $setParentHead->coa_head_name:''}}" readonly> --}}

                                                        <select tabindex="4" name="user_department_id"
                                                                class="inputs_up form-control" data-rule-required="true"
                                                                data-msg-required="Please Enter Department"
                                                                id="user_department_id" readonly>
                                                            <option value="">Select Department</option>
                                                            @foreach ($departments as $department)
                                                                <option
                                                                    value="{{ $department->dep_id }}"{{ $department->dep_id == $employee->user_department_id ? 'selected' : '' }}>
                                                                    {{ $department->dep_title }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span id="user_type_error_msg" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>
                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="required">
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.user_type.description') }}</p>
                                            <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.user_type.benefits') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            User Type</label>
                                                        <select name="user_type" class="inputs_up form-control"
                                                                data-rule-required="true"
                                                                data-msg-required="Please Enter User Type" id="user_type">
                                                            <option value="">Select User Type</option>
                                                            @if ($employee->user_level == 100)
                                                                <option value="100"
                                                                    {{ 100 == $employee->user_level ? 'selected' : '' }}>
                                                                    Super Admin
                                                                </option>
                                                            @endif
                                                            <option value="30"
                                                                {{ 30 == $employee->user_level ? 'selected' : '' }}>
                                                                Admin
                                                            </option>
                                                            <option value="20"
                                                                {{ 20 == $employee->user_level ? 'selected' : '' }}>
                                                                Manager
                                                            </option>
                                                            <option value="10"
                                                                {{ 10 == $employee->user_level ? 'selected' : '' }}>
                                                                Operator
                                                            </option>
                                                        </select>
                                                        <span id="user_type_error_msg" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>
                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="required">
                                                            Branch
                                                        </label>
                                                        <select tabindex=42 autofocus name="branch[]"
                                                                class="inputs_up form-control" data-rule-required="true"
                                                                data-msg-required="Please Enter Branch" id="branch"
                                                                multiple>
                                                            @foreach ($branches as $branch)
                                                                @php
                                                                    $branch_id = explode(',', $employee->user_branch_id);
                                                                @endphp

                                                                <option value="{{ $branch->branch_id }}"
                                                                    {{ in_array($branch->branch_id, $branch_id) ? 'selected' : '' }}>
                                                                    {{ $branch->branch_name }}</option>
                                                            @endforeach


                                                        </select>
                                                        <span id="group_error_msg" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>
                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="required">
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.role.description') }}</p>
                                            <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.role.benefits') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Role</label>
                                                        <select readonly name="role" class="inputs_up form-control"
                                                                data-rule-required="true"
                                                                data-msg-required="Please Enter Role" id="role">
                                                            <option value="">Select Role</option>
                                                            @foreach ($roles as $role)
                                                                <option
                                                                    value="{{ $role->user_role_id }}"{{ $role->user_role_id == $employee->user_role_id ? 'selected' : '' }}>
                                                                    {{ $role->user_role_title }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span id="role_error_msg" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="required">
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.designation.description') }}</p>
                                            <h6>Example</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.designation.example') }}</p>
                                            <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.designation.benefits') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Designation</label>
                                                        <select readonly name="designation"
                                                                class="inputs_up form-control" data-rule-required="true"
                                                                data-msg-required="Please Enter Designation"
                                                                id="designation">
                                                            <option value="">Select Designation</option>
                                                            @foreach ($designations as $designation)
                                                                <option
                                                                    value="{{ $designation->desig_id }}"{{ $designation->desig_id == $employee->user_designation ? 'selected' : '' }}>
                                                                    {{ $designation->desig_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        {{--                                                            <input type="text" name="designation" data-rule-required="true" data-msg-required="Please Enter Designation" id="designation" class="inputs_up form-control" --}}
                                                        {{--                                                                   placeholder="Designation" value="{{$employee->user_designation}}"> --}}
                                                        <span id="designation_error_msg" class="validate_sign">
                                                            </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="required">
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.name.description') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Name</label>
                                                        <input type="text" name="name" id="name"
                                                               data-rule-required="true"
                                                               data-msg-required="Please Enter Name"
                                                               class="inputs_up form-control" placeholder="Name"
                                                               value="{{ $employee->user_name }}">
                                                        <span id="name_error_msg" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>


                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="required">
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.father_name.description') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Father Name</label>
                                                        <input type="text" name="fname"
                                                               data-rule-required="true"
                                                               data-msg-required="Please Enter Father Name"
                                                               id="fname" class="inputs_up form-control"
                                                               placeholder="Father Name"
                                                               value="{{ $employee->user_father_name }}">
                                                        <span id="fname_error_msg" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->

                                                        <label class="required">
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.mobile.description') }}</p>
                                            <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.mobile.benefits') }}</p>
                                            <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.mobile.example') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Mobile Number</label>
                                                        <input type="text" name="mobile"
                                                               data-rule-required="true"
                                                               data-msg-required="Please Enter Mobile Number"
                                                               id="mobile" class="inputs_up form-control"
                                                               placeholder="Mobile Number"
                                                               value="{{ $employee->user_mobile }}"
                                                               onkeypress="return isNumberWithHyphen(event)">
                                                        <span id="mobile_error_msg" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="">
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.emergency_contact.description') }}</p>
                                            <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.emergency_contact.benefits') }}</p>
                                             <h6>Example</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.emergency_contact.example') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Emergency Contact</label>
                                                        <input type="text" name="emergency_contact"
                                                               id="emergency_contact"
                                                               value="{{ $employee->user_emergency_contact }}"
                                                               class="inputs_up form-control"
                                                               placeholder="Emergency Contact">
                                                        <span id="emergency_contact_error_msg" class="validate_sign">
                                                            </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="">
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.cnic.description') }}</p>
                                            <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.cnic.benefits') }}</p>
                                            <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.cnic.example') }}</p>
                                            <h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.cnic.validations') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Cnic</label>
                                                        <input type="text" name="cnic" id="cnic"
                                                               value="{{ $employee->user_cnic }}"
                                                               class="inputs_up form-control" placeholder="Cnic"
                                                               onkeypress="return isNumberWithHyphen(event)">
                                                        <span id="cnic_error_msg" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="">
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.family_code.description') }}</p>
                                            <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.family_code.benefits') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Family Code</label>
                                                        <input type="text" name="family_code" id="family_code"
                                                               value="{{ $employee->user_family_code }}"
                                                               class="inputs_up form-control" placeholder="Family Code">
                                                        <span id="family_code_error_msg" class="validate_sign">
                                                            </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="">
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.marital_status.description') }}</p>
                                            <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.marital_status.benefits') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Marital Status</label>
                                                        <div class="custom-control custom-radio mb-10 mt-1">
                                                            <input type="radio" name="marital"
                                                                   class="custom-control-input marital" id="marital1"
                                                                   value="1"
                                                                {{ $employee->user_marital_status == 1 ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="marital1">
                                                                Married
                                                            </label>
                                                        </div>
                                                        <div class="custom-control custom-radio mb-10 mt-1">
                                                            <input type="radio" name="marital"
                                                                   class="custom-control-input marital" id="marital2"
                                                                   value="2"
                                                                {{ $employee->user_marital_status == 2 ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="marital2">
                                                                Unmarried
                                                            </label>
                                                        </div>
                                                        {{-- <input type="radio" name="marital" style="display: inline !important; width: 50px !important;" class="inputs_up form-control marital"
                                                               id="marital1" value="1" {{ $employee->user_marital_status == 1  ? 'checked' : '' }}>Married
                                                        <input type="radio" name="marital" style="display: inline !important; width: 50px !important;" class="inputs_up form-control marital"
                                                               id="marital2" value="2" {{ $employee->user_marital_status == 2  ? 'checked' : '' }}>Unmarried --}}
                                                        <span id="marital_error_msg" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>


                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="">
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.city.description') }}</p>
                                      ">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            City</label>
                                                        <select name="city" class="inputs_up form-control"
                                                                id="city">
                                                            <option value="">Select City</option>
                                                            @foreach ($cities as $city)
                                                                <option
                                                                    value="{{ $city->city_id }}"{{ $city->city_id == $employee->user_city ? 'selected' : '' }}>
                                                                    {{ $city->city_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span id="city_error_msg" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="">Blood Group</label>
                                                        <select name="blood_group" class="inputs_up form-control"
                                                                id="blood_group">
                                                            <option value="">Select Blood Group</option>
                                                            <option value="A +"
                                                                {{ 'A +' == $employee->user_blood_group ? 'selected' : '' }}>
                                                                A +
                                                            </option>
                                                            <option value="A -"
                                                                {{ 'A -' == $employee->user_blood_group ? 'selected' : '' }}>
                                                                A -
                                                            </option>
                                                            <option value="B +"
                                                                {{ 'B +' == $employee->user_blood_group ? 'selected' : '' }}>
                                                                B +
                                                            </option>
                                                            <option value="B -"
                                                                {{ 'B -' == $employee->user_blood_group ? 'selected' : '' }}>
                                                                B -
                                                            </option>
                                                            <option value="AB +"
                                                                {{ 'AB +' == $employee->user_blood_group ? 'selected' : '' }}>
                                                                AB +
                                                            </option>
                                                            <option value="AB -"
                                                                {{ 'AB -' == $employee->user_blood_group ? 'selected' : '' }}>
                                                                AB -
                                                            </option>
                                                            <option value="O +"
                                                                {{ 'O +' == $employee->user_blood_group ? 'selected' : '' }}>
                                                                O +
                                                            </option>
                                                            <option value="O -"
                                                                {{ 'O -' == $employee->user_blood_group ? 'selected' : '' }}>
                                                                O -
                                                            </option>
                                                        </select>
                                                        <span id="blood_group_error_msg" class="validate_sign">
                                                            </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="">Nationality</label>
                                                        <select id="nationality" name="nationality"
                                                                class="inputs_up form-control">
                                                            <option value="">Select Country</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->c_id }}"
                                                                    {{ $country->c_id == $employee->user_nationality ? 'selected' : '' }}>
                                                                    {{ $country->c_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span id="nationality_code_error_msg" class="validate_sign">
                                                            </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="">Religion</label>
                                                        <div class="custom-control custom-radio mb-10 mt-1">
                                                            <input type="radio" name="religion"
                                                                   class="custom-control-input religion" id="religion1"
                                                                   value="1"
                                                                {{ $employee->user_religion == 1 ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="religion1">
                                                                Muslim
                                                            </label>
                                                        </div>
                                                        <div class="custom-control custom-radio mb-10 mt-1">
                                                            <input type="radio" name="religion"
                                                                   class="custom-control-input religion" id="religion2"
                                                                   value="2"
                                                                {{ $employee->user_religion == 2 ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="religion2">
                                                                Non-Muslim
                                                            </label>
                                                        </div>
                                                        {{-- <input type="radio" name="religion" style="display: inline !important; width: 50px !important;" class="inputs_up form-control religion"
                                                               id="religion1" value="1" {{ $employee->user_religion == 1  ? 'checked' : '' }}>Muslim
                                                        <input type="radio" name="religion" style="display: inline !important; width: 50px !important;" class="inputs_up form-control religion"
                                                               id="religion2" value="2" {{ $employee->user_religion == 2  ? 'checked' : '' }}>Non-Muslim --}}
                                                        <span id="religion_error_msg" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>


                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="">D.O.J</label>
                                                        <input type="text" name="doj" id="doj"
                                                               class="inputs_up form-control date-picker"
                                                               value="{{ $employee->user_d_o_j }}" placeholder="D.O.J">
                                                        <span id="doj_error_msg" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12" hidden>
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="">Grade</label>
                                                        <input type="text" name="grade" id="grade"
                                                               class="inputs_up form-control" value=""
                                                               placeholder="Grade">
                                                        <span id="grade_error_msg" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>


                                                {{--                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> --}}

                                                {{--                                                        <div class="row"> --}}
                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="">Commission</label>
                                                        <input type="text" name="commission" id="commission"
                                                               value="{{ $employee->user_commission_per }}"
                                                               class="inputs_up form-control" placeholder="Commission"
                                                               onfocus="this.select();"
                                                               onkeypress="return allow_only_number_and_decimals(this,event);">
                                                        <span id="commission_error_msg" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="">Target Amount</label>
                                                        <input type="text" name="target_amount"
                                                               value="{{ $employee->user_target_amount }}"
                                                               id="target_amount" class="inputs_up form-control"
                                                               placeholder="Target Amount" onfocus="this.select();"
                                                               onkeypress="return allow_only_number_and_decimals(this,event);">
                                                        <span id="target_amount_error_msg" class="validate_sign">
                                                            </span>
                                                    </div><!-- end input box -->
                                                </div>


                                            </div>
                                            <div class="row">
                                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="">
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.description') }}</p>
                                            <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.benefits') }}</p>
                                            <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.example') }}</p>
                                            <h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.validations') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Address 1</label>
                                                        <textarea name="address" id="address" class="remarks inputs_up form-control" placeholder="Address 1"
                                                                  style="height: 107px">{{ $employee->user_address }}</textarea>
                                                        <span id="address_error_msg" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="">
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.description') }}</p>
                                            <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.benefits') }}</p>
                                            <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.example') }}</p>
                                            <h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.validations') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Address 2</label>
                                                        <textarea name="address2" id="address2" class="remarks inputs_up form-control" placeholder="Address 2"
                                                                  style="height: 107px">{{ $employee->user_address_2 }}</textarea>
                                                        <span id="address2_error_msg" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="">Profile Image</label>
                                                        <input type="file" name="pimage" id="pimage"
                                                               class="inputs_up form-control" accept=".png,.jpg,.jpeg"
                                                               style="width: 100px !important; background-color: #eee; border:none; box-shadow: none !important; display: none;">
                                                        <span id="pimage_error_msg" class="validate_sign"> </span>

                                                        <div class="db">

                                                            <div class="db">
                                                                <label id="image1"
                                                                       style="display: none; cursor:pointer; color:blue; text-decoration:underline;">
                                                                    <i style=" color:#04C1F3"
                                                                       class="fa fa-window-close"></i>
                                                                </label>
                                                            </div>
                                                            <div>
                                                                <img id="imagePreview1"
                                                                     style="border-radius:50%; position:relative; cursor:pointer;  width: 100px; height: 100px;"
                                                                     src="{{ isset($employee->user_profilepic) && !empty($employee->user_profilepic) ? $employee->user_profilepic : asset('public/src/upload_btn.jpg') }}"/>
                                                            </div>
                                                        </div>


                                                    </div><!-- end input box -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="salary" role="tabpanel">
                                        <div class="pd-20">


                                            <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher">
                                                <!-- invoice container start -->
                                                <div id="invoice_bx"
                                                     class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate">
                                                    <!-- invoice box start -->
                                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                                        <!-- invoice scroll box start -->
                                                        <div class="invoice_cntnt p-1">
                                                            <!-- invoice content start -->
                                                            <div class="invoice_row">
                                                                <div class="input_bx form-group col-lg-2 col-md-3 col-sm-12">
                                                                    <div class="custom-control custom-checkbox mb-10 mt-1"
                                                                         style="float: left">
                                                                        <input tabindex="27" type="checkbox"
                                                                               name="make_salary_account"
                                                                               class="custom-control-input" id="make_salary_account"
                                                                               value="1"
                                                                            {{ $employee->user_salary_person == 1 ? 'checked' : '' }}>
                                                                        <label class="custom-control-label"
                                                                               for="make_salary_account">Make Salary Account</label>
                                                                    </div>
                                                                </div>
                                                                <div class="input_bx form-group col-lg-2 col-md-3 col-sm-12">
                                                                    <div class="custom-control custom-checkbox mb-10 mt-1"
                                                                         style="float: left">
                                                                        <input tabindex="27" type="checkbox"
                                                                               name="make_loan_account" class="custom-control-input"
                                                                               id="make_loan_account" value="1"
                                                                            {{ $employee->user_loan_person == 1 ? 'checked' : '' }}>
                                                                        <label class="custom-control-label"
                                                                               for="make_loan_account">Make Loan Account</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="invoice_row row">
                                                                <div
                                                                    class="invoice_col from_group col-lg-3 col-md-4 col-sm-12">
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="invoice_col_ttl required">
                                                                            <!-- invoice column title start -->
                                                                            <a data-container="body"
                                                                               data-toggle="popover"
                                                                               data-trigger="hover"
                                                                               data-placement="bottom"
                                                                               data-html="true"
                                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.account_registration.reporting_group.account_viewing_group_name.description') }}</p>
                                                                        <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.account_registration.reporting_group.account_viewing_group_name.benefits') }}</p>
                                                                        <h6>Example</h6><p>{{ config('fields_info.about_form_fields.account_registration.reporting_group.account_viewing_group_name.example') }}</p>
                                                                        <h6>Validation</h6><p>{{ config('fields_info.about_form_fields.account_registration.reporting_group.account_viewing_group_name.validations') }}</p>">
                                                                                <i class="fa fa-info-circle"></i>
                                                                            </a>
                                                                            Account Ledger Access Group
                                                                        </div><!-- invoice column title end -->
                                                                        <div
                                                                            class="invoice_col_input refresh-addition">
                                                                            <!-- invoice column input start -->
                                                                            <div class="invoice_col_short">
                                                                                <!-- invoice column short start -->
                                                                                <a href="{{ route('add_account_group') }}"
                                                                                   class="col_short_btn col_short_btn btn btn-sm btn-info add"
                                                                                   target="_blank"
                                                                                   data-container="body"
                                                                                   data-toggle="popover"
                                                                                   data-trigger="hover"
                                                                                   data-placement="bottom"
                                                                                   data-html="true"
                                                                                   data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                                                                    <i class="fa fa-plus"></i>
                                                                                </a>
                                                                                <a id="refresh_group"
                                                                                   class="col_short_btn col_short_btn btn btn-sm btn-info refresh"
                                                                                   data-container="body"
                                                                                   data-toggle="popover"
                                                                                   data-trigger="hover"
                                                                                   data-placement="bottom"
                                                                                   data-html="true"
                                                                                   data-content="{{ config('fields_info.about_form_fields.refresh.description') }}">
                                                                                    <l class="fa fa-refresh"></l>
                                                                                </a>
                                                                            </div><!-- invoice column short end -->
                                                                            <select tabindex="4" name="group_id"
                                                                                    id="group_id"
                                                                                    class="inputs_up form-control"
                                                                                    data-rule-required="true"
                                                                                    data-msg-required="Please
                                                                Enter Account Ledger Access Group">
                                                                                <option value="">Select Account
                                                                                    Ledger Access Group
                                                                                </option>
                                                                                @foreach ($groups as $group)
                                                                                    <option
                                                                                        value="{{ $group->ag_id }}"
                                                                                        {{ $group->ag_id == $group_id ? 'selected="selected"' : '' }}>
                                                                                        {{ $group->ag_title }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div>
                                                            </div>
                                                            <h6 style="margin: 10px 0;">Expense Head</h6>

                                                            <div class="invoice_row salary_div">
                                                                <!-- invoice row start -->
                                                                <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->
                                                                            <a data-container="body"
                                                                               data-toggle="popover"
                                                                               data-trigger="hover"
                                                                               data-placement="bottom"
                                                                               data-html="true"
                                                                               ata-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.description') }}</p> <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits') }}</p> <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.example') }}</p> <h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                                                <i class="fa fa-info-circle"></i>
                                                                            </a>
                                                                            Basic Salary
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->
                                                                            <input type="text" name="basic_salary"
                                                                                   id="basic_salary"
                                                                                   data-rule-required="true"
                                                                                   data-msg-required="Please Enter Basic Salary"
                                                                                   value="{{ isset($salary_info->si_basic_salary) ? $salary_info->si_basic_salary : '' }}"
                                                                                   class="inputs_up
                                                                                form-control"
                                                                                   placeholder="Basic Salary"
                                                                                   onfocus="this.select();"
                                                                                   onkeypress="return allow_only_number_and_decimals(this,event);">
                                                                            <span id="basic_salary_error_msg"
                                                                                  class="validate_sign"> </span>
                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->

                                                                <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->
                                                                            <a data-container="body"
                                                                               data-toggle="popover"
                                                                               data-trigger="hover"
                                                                               data-placement="bottom"
                                                                               data-html="true"
                                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.child_account.description') }}</p> <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.child_account.benefits') }}</p> <h6>Example</h6><p>{{ config('fields_info.about_form_fields.child_account.example') }}</p>">
                                                                                <i class="fa fa-info-circle"></i>
                                                                            </a>
                                                                            Salary Period
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->
                                                                            <select name="salary_period"
                                                                                    class="inputs_up form-control"
                                                                                    id="salary_period">
                                                                                <option value="0">Select Salary
                                                                                    Period
                                                                                </option>
                                                                                <option value="1"
                                                                                    {{ isset($salary_info->si_basic_salary_period)
                                                                                        ? ($salary_info->si_basic_salary_period == 1
                                                                                            ? 'selected'
                                                                                            : '')
                                                                                        : '' }}>
                                                                                    Per Hour
                                                                                </option>
                                                                                <option value="2"
                                                                                    {{ isset($salary_info->si_basic_salary_period)
                                                                                        ? ($salary_info->si_basic_salary_period == 2
                                                                                            ? 'selected'
                                                                                            : '')
                                                                                        : '' }}>
                                                                                    Daily
                                                                                </option>
                                                                                <option value="3"
                                                                                    {{ isset($salary_info->si_basic_salary_period)
                                                                                        ? ($salary_info->si_basic_salary_period == 3
                                                                                            ? 'selected'
                                                                                            : '')
                                                                                        : '' }}>
                                                                                    Monthly
                                                                                </option>
                                                                            </select>
                                                                            <span id="salary_period_error_msg"
                                                                                  class="validate_sign"> </span>
                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->

                                                                <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->
                                                                            <a data-container="body"
                                                                               data-toggle="popover"
                                                                               data-trigger="hover"
                                                                               data-placement="bottom"
                                                                               data-html="true"
                                                                               ata-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.description') }}</p> <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits') }}</p> <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.example') }}</p> <h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                                                <i class="fa fa-info-circle"></i>
                                                                            </a>

                                                                            Working
                                                                            Hours/Day{{ isset($salary_info->si_working_hours_per_day) }}
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->
                                                                            <input type="text" name="hour_per_day"
                                                                                   id="hour_per_day"
                                                                                   class="inputs_up form-control"
                                                                                   data-rule-required="true"
                                                                                   data-msg-required="Please Choose Days"
                                                                                   value="{{ isset($salary_info->si_working_hours_per_day) ? $salary_info->si_working_hours_per_day : '' }}"
                                                                                   placeholder="Working Hours/Day"
                                                                                   onfocus="this.select();"
                                                                                   onkeypress="return allow_only_number_and_decimals(this,event);">
                                                                            <span id="hour_per_day_error_msg"
                                                                                  class="validate_sign"> </span>
                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->

                                                                <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->
                                                                            <a data-container="body"
                                                                               data-toggle="popover"
                                                                               data-trigger="hover"
                                                                               data-placement="bottom"
                                                                               data-html="true"
                                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.child_account.description') }}</p> <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.child_account.benefits') }}</p> <h6>Example</h6><p>{{ config('fields_info.about_form_fields.child_account.example') }}</p>">
                                                                                <i class="fa fa-info-circle"></i>
                                                                            </a>
                                                                            Off Days
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->
                                                                            <select name="holidays[]"
                                                                                    class="inputs_up form-control"
                                                                                    id="holidays" multiple>
                                                                                <option value="1"
                                                                                    {{ in_array(1, explode(',', isset($salary_info->si_off_days) ? $salary_info->si_off_days : ''))
                                                                                        ? 'selected'
                                                                                        : '' }}>
                                                                                    Monday
                                                                                </option>
                                                                                <option value="2"
                                                                                    {{ in_array(2, explode(',', isset($salary_info->si_off_days) ? $salary_info->si_off_days : ''))
                                                                                        ? 'selected'
                                                                                        : '' }}>
                                                                                    Tuesday
                                                                                </option>
                                                                                <option value="3"
                                                                                    {{ in_array(3, explode(',', isset($salary_info->si_off_days) ? $salary_info->si_off_days : ''))
                                                                                        ? 'selected'
                                                                                        : '' }}>
                                                                                    Wednesday
                                                                                </option>
                                                                                <option value="4"
                                                                                    {{ in_array(4, explode(',', isset($salary_info->si_off_days) ? $salary_info->si_off_days : ''))
                                                                                        ? 'selected'
                                                                                        : '' }}>
                                                                                    Thursday
                                                                                </option>
                                                                                <option value="5"
                                                                                    {{ in_array(5, explode(',', isset($salary_info->si_off_days) ? $salary_info->si_off_days : ''))
                                                                                        ? 'selected'
                                                                                        : '' }}>
                                                                                    Friday
                                                                                </option>
                                                                                <option value="6"
                                                                                    {{ in_array(6, explode(',', isset($salary_info->si_off_days) ? $salary_info->si_off_days : ''))
                                                                                        ? 'selected'
                                                                                        : '' }}>
                                                                                    Saturday
                                                                                </option>
                                                                                <option value="7"
                                                                                    {{ in_array(7, explode(',', isset($salary_info->si_off_days) ? $salary_info->si_off_days : ''))
                                                                                        ? 'selected'
                                                                                        : '' }}>
                                                                                    Sunday
                                                                                </option>
                                                                            </select>
                                                                            <span id="holidays_error_msg"
                                                                                  class="validate_sign"> </span>
                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->

                                                                <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->
                                                                            Payment Type
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->
                                                                            <select tabindex="32" name="payment_type"
                                                                                    class="inputs_up form-control" id="payment_type"
                                                                                    data-rule-required="true"
                                                                                    data-msg-required="Please Choose Type"
                                                                            >
                                                                                <option value="">Select Type</option>
                                                                                <option value="1" {{ isset($salary_info->si_payment_type)? $salary_info->si_payment_type === 1 ?  'selected' : '':'' }}>
                                                                                    Bank
                                                                                </option>
                                                                                <option value="2" {{ isset($salary_info->si_payment_type)? $salary_info->si_payment_type === 2 ?  'selected' : '':'' }}>
                                                                                    Cheque
                                                                                </option>
                                                                                <option value="3" {{ isset($salary_info->si_payment_type)? $salary_info->si_payment_type === 3 ?  'selected' : '':'' }}>
                                                                                    Cash
                                                                                </option>
                                                                            </select>
                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->

                                                                <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->
                                                                            Branch Code
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->
                                                                            <input type="text" name="branch_code"
                                                                                   class="inputs_up form-control" id="branch_code" value="{{ isset($salary_info->si_branch_code)? $salary_info->si_branch_code : ''}}"
                                                                                   data-rule-required="true"
                                                                                   data-msg-required="Please Enter Branch Code"
                                                                            />

                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->

                                                                <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->
                                                                            Account Number
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->
                                                                            <input type="text" name="account_no"
                                                                                   class="inputs_up form-control" id="account_no" value="{{ isset($salary_info->si_account_number)
                                                                                   ? $salary_info->si_account_number : ''}}"
                                                                                   data-rule-required="true"
                                                                                   data-msg-required="Please Enter Account Number"
                                                                            />

                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->

                                                            </div><!-- invoice row end -->

                                                            <h6 style="margin: 10px 0;">Allowances / Deductions</h6>
                                                            <div class="invoice_row salary_div">
                                                                <!-- invoice row start -->
                                                                <div class="invoice_col basis_col_15">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->
                                                                            <a data-container="body" data-toggle="popover"
                                                                               data-trigger="hover" data-placement="bottom"
                                                                               data-html="true"
                                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.code.description') }}</p>">
                                                                                <i class="fa fa-info-circle"></i>
                                                                            </a>
                                                                            Account
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_short">
                                                                            <!-- invoice column short start -->
                                                                            <a tabindex="-1"
                                                                               href="{{ url('account_registration') }}"
                                                                               class="col_short_btn" target="_blank"
                                                                               data-container="body" data-toggle="popover"
                                                                               data-trigger="hover" data-placement="bottom"
                                                                               data-html="true"
                                                                               data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                                                                <l class="fa fa-plus"></l>
                                                                            </a>
                                                                        </div><!-- invoice column short end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->
                                                                            <select tabindex="33" name="account_code"
                                                                                    class="inputs_up form-control" id="account_code">
                                                                                <option value="0">Account</option>
                                                                                @foreach ($accounts as $account)
                                                                                    <option value="{{ $account->account_uid }}">
                                                                                        {{ $account->account_uid }} - {{ $account->account_name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->

                                                                <div class="invoice_col basis_col_20">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class=" invoice_col_ttl">
                                                                            <!-- invoice column title start -->
                                                                            <a data-container="body" data-toggle="popover"
                                                                               data-trigger="hover" data-placement="bottom"
                                                                               data-html="true"
                                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.description') }}</p>
                                                                                    <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits') }}</p>
                                                                                    <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.example') }}</p>
                                                                                    <h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                                                <i class="fa fa-info-circle"></i>
                                                                            </a>
                                                                            Transaction Remarks
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->
                                                                            <input tabindex="35" type="text"
                                                                                   name="account_remarks"
                                                                                   class="inputs_up form-control"
                                                                                   id="account_remarks" placeholder="Remarks"/>
                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->
                                                                <div class="invoice_col basis_col_11">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->
                                                                            <a data-container="body" data-toggle="popover"
                                                                               data-trigger="hover" data-placement="bottom"
                                                                               data-html="true"
                                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.account_title.description') }}</p>">
                                                                                <i class="fa fa-info-circle"></i>
                                                                            </a>
                                                                            Allow./Deduc.
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->
                                                                            <select tabindex="36" name="allowance_deduction"
                                                                                    class="inputs_up form-control"
                                                                                    id="allowance_deduction">
                                                                                <option value="0">Select</option>
                                                                                <option value="1">Allowance</option>
                                                                                <option value="2">Deduction</option>
                                                                            </select>
                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->

                                                                <div class="invoice_col basis_col_11">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->
                                                                            <a data-container="body" data-toggle="popover"
                                                                               data-trigger="hover" data-placement="bottom"
                                                                               data-html="true"
                                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description') }}</p>">
                                                                                <i class="fa fa-info-circle"></i>
                                                                            </a>
                                                                            Amount
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->
                                                                            <input tabindex="37" type="text" name="amount"
                                                                                   class="inputs_up text-right form-control"
                                                                                   id="amount" placeholder="Amount"
                                                                                   onfocus="this.select();"
                                                                                   onkeypress="return allow_only_number_and_decimals(this,event);">
                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->

                                                                <div class="invoice_col basis_col_11">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->
                                                                            Start Month
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->
                                                                            <input tabindex="38" type="text" name="start_month" id="start_month" class="inputs_up form-control month-picker"
                                                                                   autocomplete="off" value="" data-rule-required="true" data-msg-required="Please Enter Month"
                                                                                   placeholder="Start Month ......">
                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->
                                                                <div class="invoice_col basis_col_11">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->
                                                                            End Month
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->
                                                                            <input tabindex="39" type="text" name="end_month" id="end_month" class="inputs_up form-control month-picker"
                                                                                   autocomplete="off" value="" data-rule-required="true" data-msg-required="Please Enter Month"
                                                                                   placeholder="End Month ......">
                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->
                                                                <div class="invoice_col basis_col_15">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_txt for_voucher_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="invoice_col_txt with_cntr_jstfy">
                                                                            <div
                                                                                class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                                <button tabindex="40" id="first_add_more"
                                                                                        class="invoice_frm_btn"
                                                                                        onclick="add_account()" type="button">
                                                                                    <i class="fa fa-plus"></i> Add
                                                                                </button>
                                                                            </div>
                                                                            <div
                                                                                class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                                <button tabindex="41" style="display: none;"
                                                                                        id="cancel_button" class="invoice_frm_btn"
                                                                                        onclick="cancel_all()" type="button">
                                                                                    <i class="fa fa-times"></i> Cancel
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->
                                                            </div><!-- invoice row end -->
                                                            <div class="invoice_row salary_div">
                                                                <!-- invoice row start -->
                                                                <div class="invoice_col basis_col_100">
                                                                    <!-- invoice column start -->
                                                                    <div class="pro_tbl_con for_voucher_tbl">
                                                                        <!-- product table container start -->
                                                                        <div class="table-responsive pro_tbl_bx">
                                                                            <!-- product table box start -->
                                                                            <table class="table table-bordered table-sm"
                                                                                   id="category_dynamic_table">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th class="text-center tbl_srl_4"> Sr#
                                                                                    </th>
                                                                                    <th class="text-center tbl_txt_20"> Title
                                                                                    </th>
                                                                                    <th class="text-center tbl_txt_30">
                                                                                        Transaction Remarks
                                                                                    </th>
                                                                                    <th class="text-center tbl_txt_12">
                                                                                        Allow./Deduc
                                                                                    </th>
                                                                                    <th class="text-center tbl_txt_10">
                                                                                        Start Month
                                                                                    </th>
                                                                                    <th class="text-center tbl_txt_10">
                                                                                        End Month
                                                                                    </th>

                                                                                    <th class="text-center tbl_srl_12"> Amount
                                                                                    </th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody id="table_body">
                                                                                </tbody>
                                                                                <tfoot class="">
                                                                                <tr>
                                                                                    <th colspan="3" class="text-right">
                                                                                        Total
                                                                                    </th>
                                                                                    <td class="text-center tbl_srl_12">
                                                                                        <div class="invoice_col_txt">
                                                                                            <!-- invoice column box start -->
                                                                                            <div class="invoice_col_input">
                                                                                                <!-- invoice column input start -->
                                                                                                <input type="number"
                                                                                                       name="total_amount"
                                                                                                       class="inputs_up text-right form-control grand-total-field"
                                                                                                       id="total_amount"
                                                                                                       placeholder="0.00"
                                                                                                       readonly/>
                                                                                            </div>
                                                                                            <!-- invoice column input end -->
                                                                                        </div><!-- invoice column box end -->
                                                                                    </td>
                                                                                </tr>
                                                                                </tfoot>
                                                                            </table>
                                                                        </div><!-- product table box end -->
                                                                    </div><!-- product table container end -->
                                                                </div><!-- invoice column end -->
                                                            </div><!-- invoice row end -->

                                                        </div><!-- invoice content end -->
                                                    </div><!-- invoice scroll box end -->

                                                    <input type="hidden" name="accounts_array" id="accounts_array">
                                                    <input value="{{ $employee->user_id }}" name="employee_id"
                                                           type="hidden">

                                                </div><!-- invoice box end -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="credentials" role="tabpanel">
                                        <div class="pd-20">

                                            <div class="row">
                                                <div class="row">
                                                    <div class="input_bx form-group col-lg-12 col-md-12 col-sm-12">
                                                        <div class="custom-control custom-checkbox mb-10 mt-1" style="float: left">
                                                            <input tabindex="27" type="checkbox" name="make_credentials"
                                                                   class="custom-control-input" id="make_credentials" value="1"
                                                                {{ $employee->user_have_credentials == 1 ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="make_credentials">Make Credentials</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row credentials_div">

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="required">
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.account_ledger_access_group.description') }}</p><h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.account_ledger_access_group.benefits') }}</p><h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.account_ledger_access_group.example') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Account Ledger Access Group
                                                            <a href="{{ route('add_account_group') }}"
                                                               class="add_btn" target="_blank" data-container="body"
                                                               data-toggle="popover" data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a id="refresh_group" class="add_btn"
                                                               data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="{{ config('fields_info.about_form_fields.refresh.description') }}">
                                                                <l class="fa fa-refresh"></l>
                                                            </a>
                                                        </label>
                                                        <select name="group[]" class="inputs_up form-control"
                                                                id="group" multiple data-rule-required="true"
                                                                data-msg-required="Please Enter Account Ledger Access Group">
                                                            @foreach ($groups as $group)
                                                                @php
                                                                    $group_id = explode(',', $employee->user_account_reporting_group_ids);
                                                                @endphp

                                                                <option value="{{ $group->ag_id }}"
                                                                    {{ in_array($group->ag_id, $group_id) ? 'selected' : '' }}>
                                                                    {{ $group->ag_title }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span id="group_error_msg" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>


                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="required">
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.new.Product_Reporting_Group.Product_Handling_Group_Title.description') }}</p>
                                                    <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.new.Product_Reporting_Group.Product_Handling_Group_Title.benefits') }}</p>
<h6>Example</h6><p>{{ config('fields_info.about_form_fields.new.Product_Reporting_Group.Product_Handling_Group_Title.example') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Product Handling Group
                                                            <a href="{{ route('product_group') }}" class="add_btn"
                                                               target="_blank" data-container="body"
                                                               data-toggle="popover" data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a id="refresh_product_group" class="add_btn"
                                                               data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="{{ config('fields_info.about_form_fields.refresh.description') }}">
                                                                <l class="fa fa-refresh"></l>
                                                            </a>
                                                        </label>
                                                        <select name="product_reporting_group[]"
                                                                class="inputs_up form-control"
                                                                id="product_reporting_group" multiple
                                                                data-rule-required="true"
                                                                data-msg-required="Please Enter Product Handling Group">
                                                            @foreach ($product_groups as $product_group)
                                                                @php
                                                                    $product_group_id = explode(',', $employee->user_product_reporting_group_ids);
                                                                @endphp

                                                                <option value="{{ $product_group->pg_id }}"
                                                                    {{ in_array($product_group->pg_id, $product_group_id) ? 'selected' : '' }}>
                                                                    {{ $product_group->pg_title }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span id="product_reporting_group_error_msg"
                                                              class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="required">
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.modular_group.description') }}</p>
                                            <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.modular_group.benefits') }}</p>">
                                                                <l class=" fa fa-info-circle"></l>
                                                            </a>
                                                            Modular Group
                                                            <a href="{{ route('add_modular_group') }}"
                                                               class="add_btn" target="_blank" data-container="body"
                                                               data-toggle="popover" data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a id="refresh_modular_group" class="add_btn"
                                                               data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="{{ config('fields_info.about_form_fields.refresh.description') }}">
                                                                <l class="fa fa-refresh"></l>
                                                            </a>
                                                        </label>
                                                        <select name="modular_group" class="inputs_up form-control"
                                                                id="modular_group" data-rule-required="true"
                                                                data-msg-required="Please Enter Modular Group">
                                                            <option value="">Select Modular Group</option>
                                                            @foreach ($modular_groups as $modular_group)
                                                                <option value="{{ $modular_group->id }}"
                                                                    {{ $modular_group->id == $employee->user_modular_group_id ? 'selected' : '' }}>
                                                                    {{ $modular_group->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span id="modular_group_error_msg" class="validate_sign">
                                                            </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="required">
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.username.description') }}</p>
                                            <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.username.benefits') }}</p>
                                             <h6>Example</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.username.example') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            User Name</label>
                                                        <input type="text" name="username"
                                                               data-rule-required="true"
                                                               data-msg-required="Please Enter UserName" id="username"
                                                               class="inputs_up form-control" placeholder="User Name"
                                                               onBlur="check_username()"
                                                               value="{{ $employee->user_username }}"
                                                            {{ $employee->user_have_credentials == 1 ? 'disabled' : '' }}>
                                                        <span id="username_error_msg" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="required">
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.email.description') }}</p>
                                            <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.email.benefits') }}</p>
                                            <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.email.example') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Email</label>
                                                        <input type="email" name="email" id="email"
                                                               data-rule-required="true"
                                                               data-msg-required="Please Enter Email"
                                                               class="inputs_up form-control" placeholder="Email"
                                                               onBlur="check_email()"
                                                               value="{{ $employee->user_email }}"
                                                            {{ $employee->user_have_credentials == 1 ? 'disabled' : '' }}>
                                                        <span id="email_error_msg" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                @if ($employee->user_have_credentials == 0)
                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx">
                                                            <!-- start input box -->
                                                            <label class="required">
                                                                <a data-container="body" data-toggle="popover"
                                                                   data-trigger="hover" data-placement="bottom"
                                                                   data-html="true"
                                                                   data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.email.description') }}</p>
                                            <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.email.benefits') }}</p>
                                            <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.email.example') }}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Confirm Email</label>
                                                            <input type="email" name="email_confirmation"
                                                                   id="email_confirmation" data-rule-required="true"
                                                                   data-msg-required="Please Enter Email Confirmation"
                                                                   class="inputs_up form-control"
                                                                   placeholder="Email Confirmation" value="">
                                                            <span id="email_confirmation_error_msg"
                                                                  class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    {{--                                        <button type="reset" name="cancel" id="cancel" class="cancel_button form-control"> --}}
                                    {{--                                            <i class="fa fa-eraser"></i> Cancel --}}
                                    {{--                                        </button> --}}
                                    <button type="submit" name="save" id="save"
                                            class="save_button form-control">
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div> <!-- left column ends here -->
                    </div>
                    <!--  main row ends here -->
                </form>
            </div> <!-- white column form ends here -->
        </div>
    </div>
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {

            let user_department_id = document.getElementById("user_department_id"),
                user_type = document.getElementById("user_type"),
                branch = document.getElementById("branch"),
                role = document.getElementById("role"),
                designation = document.getElementById("designation"),
                name = document.getElementById("name"),
                fname = document.getElementById("fname"),
                mobile = document.getElementById("mobile"),
                basic_salary = document.getElementById("basic_salary"),
                salary_period = document.getElementById("salary_period"),
                hour_per_day = document.getElementById("hour_per_day"),
                holidays = document.getElementById("holidays"),
                group = document.getElementById("group"),
                product_reporting_group = document.getElementById("product_reporting_group"),
                modular_group = document.getElementById("modular_group"),
                username = document.getElementById("username"),
                email = document.getElementById("email"),
                email_confirmation = document.getElementById("email_confirmation"),

                validateInputIdArray = [
                    user_department_id.id,
                    user_type.id,
                    branch.id,
                    role.id,
                    designation.id,
                    name.id,
                    fname.id,
                    mobile.id,
                    basic_salary.id,
                    salary_period.id,
                    hour_per_day.id,
                    holidays.id,
                    group.id,
                    product_reporting_group.id,
                    modular_group.id,
                    username.id,
                    email.id,
                    email_confirmation.id,
                ];
            // return validateInventoryInputs(validateInputIdArray);
            var check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");

            }
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script>
        $('#user_department_id').change(function () {
            var department_id = $(this).val();
            var department_name = jQuery("#user_department_id option:selected").text();
            var child_account = jQuery("#user_department_id option:selected").attr('data-child_account');

            $('#department').val(department_name);
            $('#parent_head').select2('destroy');
            jQuery('#parent_head option[value="' + child_account + '"]').prop('selected', true);
            $('#parent_head').select2();

        });
    </script>
    <script>
        jQuery("#refresh_group").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_second_head",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#group").html(" ");
                    jQuery("#group").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_product_group").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_product_group",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#product_reporting_group").html(" ");
                    jQuery("#product_reporting_group").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_modular_group").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_modular_group",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#modular_group").html(" ");
                    jQuery("#modular_group").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>
    <script type="text/javascript">
        // jQuery('#user_department_id').select2();
        jQuery("#user_department_id").select2();
        jQuery("#designation").select2();
        jQuery("#branch").select2();
        jQuery("#account").select2();
        jQuery("#group").select2();
        jQuery("#group_id").select2();
        jQuery("#product_reporting_group").select2();
        jQuery("#user_type").select2();
        jQuery("#role").select2();
        jQuery("#modular_group").select2();
        jQuery("#city").select2();
        jQuery("#blood_group").select2();
        jQuery("#nationality").select2();

        jQuery("#allowance_deduction").select2();

        jQuery("#account_code").select2();
        // jQuery("#account_name").select2();
        jQuery("#parent_head").select2();

        jQuery("#salary_period").select2();
        jQuery("#holidays").select2();

        var vusername = false;
        var flag = "true";
        var flag1 = "true";

        function check_username() {
            var focus_once = 0;
            var username = document.getElementById("username").value;

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({

                url: "check_employee_username",
                data: {
                    username: username
                },
                type: "POST",
                dataType: 'json',

                success: function (data) {

                    if (data == "yes") {
                        flag = "false";
                        document.getElementById("username_error_msg").innerHTML = "Choose Another User Name";
                        // jQuery("#username").focus();

                    } else {

                        if (!validateusername(username)) {
                            document.getElementById("username_error_msg").innerHTML =
                                "Alphanumeric & Min.Length (6)";
                            //					if (focus_once == 0) { jQuery("#username").focus(); focus_once = 1;  }
                            flag = "false";
                        } else {

                            document.getElementById("username_error_msg").innerHTML = "";
                            flag = "true";
                            vusername = true;
                        }

                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    flag = "false";
                }
            });
            return flag;
        }


        function check_email() {
            var focus_once = 0;
            var email = document.getElementById("email").value;

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({

                url: "check_employee_email",
                data: {
                    email: email
                },
                type: "POST",
                dataType: 'json',
                success: function (data) {

                    if (data == "yes") {
                        flag1 = "false";

                        document.getElementById("email_error_msg").innerHTML = "Choose Another Email Address";
                        // jQuery("#email").focus();

                    } else {

                        if (!checkemail(email)) {
                            document.getElementById("email_error_msg").innerHTML = "(example@example.com)";
                            //    if (focus_once == 0) { jQuery("#email").focus(); focus_once = 1;  }
                            flag1 = "false";
                        } else {
                            document.getElementById("email_error_msg").innerHTML = "";
                            flag1 = "true";
                            vusername = false;
                        }
                    }
                },

                error: function (xhr, textStatus, errorThrown) {
                    flag1 = "false";
                }

            });
            return flag1;
        }
    </script>

    <script type="text/javascript">
        jQuery("#account").change(function () {

            var name = jQuery('option:selected', this).attr('data-name');
            var cnic = jQuery('option:selected', this).attr('data-cnic');
            var email = jQuery('option:selected', this).attr('data-email');
            var mobile = jQuery('option:selected', this).attr('data-mobile');
            var address = jQuery('option:selected', this).attr('data-address');

            jQuery("#name").val(name);
            jQuery("#cnic").val(cnic);
            jQuery("#email").val(email);
            jQuery("#mobile").val(mobile);
            jQuery("#address").val(address);
        });


        function isNumberWithHyphen(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 32 || charCode == 45 || charCode == 43) {
                return true
            } else if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }


        jQuery("#imagePreview1").click(function () {
            jQuery("#pimage").click();
        });
        var image1RemoveBtn = document.querySelector("#image1");
        var imagePreview1 = document.querySelector("#imagePreview1");


        $(document).ready(function () {
            $('#email_confirmation, #email').on("cut copy paste", function (e) {
                e.preventDefault();
            });


            $('input[type=file]').change(function () {
                var file = this.files[0],
                    val = $(this).val().trim().toLowerCase();
                if (!file || $(this).val() === "") {
                    return;
                }

                var fileSize = file.size / 1024 / 1024,
                    regex = new RegExp("(.*?)\.(jpeg|png|jpg)$"),
                    errors = 0;

                if (fileSize > 2) {
                    errors = 1;

                    document.getElementById("pimage_error_msg").innerHTML =
                        "Only png.jpg,jpeg files & max size:2 mb";
                }
                if (!(regex.test(val))) {
                    errors = 1;

                    document.getElementById("pimage_error_msg").innerHTML =
                        "Only png.jpg,jpegs files & max size:2 mb";
                }

                var fileInput = document.getElementById('pimage');
                var reader = new FileReader();

                if (errors == 1) {
                    $(this).val('');

                    image1RemoveBtn.style.display = "none";
                    document.getElementById("imagePreview1").src = 'public/src/upload_btn.jpg';

                } else {

                    image1RemoveBtn.style.display = "block";
                    imagePreview1.style.display = "block";

                    reader.onload = function (e) {
                        document.getElementById("imagePreview1").src = e.target.result;
                    };
                    reader.readAsDataURL(fileInput.files[0]);

                    document.getElementById("pimage_error_msg").innerHTML = "";
                }
                // document.getElementById("").innerHTML = "";
            });

            $("#make_salary_account").trigger("change");
            $("#make_credentials").trigger("change");
        });


        image1RemoveBtn.onclick = function () {

            var pimage = document.querySelector("#pimage");
            pimage.value = null;
            var pimagea = document.querySelector("#imagePreview1");
            pimagea.value = null;

            image1RemoveBtn.style.display = "none";
            //imagePreview1.style.display = "none";
            document.getElementById("imagePreview1").src = "public/src/upload_btn.jpg";

        }
    </script>

    <script type="text/javascript">
        jQuery("#make_salary_account").change(function () {

            if ($(this).is(':checked')) {
                $(".salary_div *").prop('disabled', false);
            } else {
                $(".salary_div *").prop('disabled', true);
            }
        });

        jQuery("#make_credentials").change(function () {

            if ($(this).is(':checked')) {
                $(".credentials_div *").prop('disabled', false);
            } else {
                $(".credentials_div *").prop('disabled', true);
            }
        });


        // function validate_form() {
        // var product_reporting_group = document.getElementById("product_reporting_group").value;
        // var group = document.getElementById("group").value;
        // var name = document.getElementById("name").value;
        // var fname = document.getElementById("fname").value;
        // var username = document.getElementById("username").value;
        // var email = document.getElementById("email").value;
        // var mobile = document.getElementById("mobile").value;
        // var cnic = document.getElementById("cnic").value;
        // // var address = document.getElementById("address").value;
        // // var pimage = document.getElementById("pimage").value;
        // // var salary = document.getElementById("salary").value;
        // var user_type = document.getElementById("user_type").value;
        // var designation = document.getElementById("designation").value;
        // var commission = document.getElementById("commission").value;
        // var target_amount = document.getElementById("target_amount").value;
        // var role = document.getElementById("role").value;
        // var modular_group = document.getElementById("modular_group").value;
        //
        // var flag_submit = true;
        // var focus_once = 0;
        //
        //
        // if (group.trim() == "") {
        //     document.getElementById("group_error_msg").innerHTML = "Required";
        //     if (focus_once == 0) {
        //         jQuery("#group").focus();
        //         focus_once = 1;
        //     }
        //     flag_submit = false;
        // } else {
        //     document.getElementById("group_error_msg").innerHTML = "";
        // }
        //
        // if (product_reporting_group.trim() == "") {
        //     document.getElementById("product_reporting_group_error_msg").innerHTML = "Required";
        //     if (focus_once == 0) {
        //         jQuery("#product_reporting_group").focus();
        //         focus_once = 1;
        //     }
        //     flag_submit = false;
        // } else {
        //     document.getElementById("product_reporting_group_error_msg").innerHTML = "";
        // }
        //
        //
        // if (modular_group.trim() == "") {
        //     document.getElementById("modular_group_error_msg").innerHTML = "Required";
        //     if (focus_once == 0) {
        //         jQuery("#modular_group").focus();
        //         focus_once = 1;
        //     }
        //     flag_submit = false;
        // } else {
        //     document.getElementById("modular_group_error_msg").innerHTML = "";
        // }
        //
        // if (user_type.trim() == "") {
        //     document.getElementById("user_type_error_msg").innerHTML = "Required";
        //     if (focus_once == 0) {
        //         jQuery("#user_type").focus();
        //         focus_once = 1;
        //     }
        //     flag_submit = false;
        // } else {
        //     document.getElementById("user_type_error_msg").innerHTML = "";
        // }
        //
        // if (role.trim() == "") {
        //     document.getElementById("role_error_msg").innerHTML = "Required";
        //     if (focus_once == 0) {
        //         jQuery("#role").focus();
        //         focus_once = 1;
        //     }
        //     flag_submit = false;
        // } else {
        //     document.getElementById("role_error_msg").innerHTML = "";
        // }
        //
        // if (designation.trim() == "") {
        //     document.getElementById("designation_error_msg").innerHTML = "Required";
        //     if (focus_once == 0) {
        //         jQuery("#designation").focus();
        //         focus_once = 1;
        //     }
        //     flag_submit = false;
        // } else {
        //     document.getElementById("designation_error_msg").innerHTML = "";
        // }
        //
        // if (name == "") {
        //     document.getElementById("name_error_msg").innerHTML = "Required";
        //     if (focus_once == 0) {
        //         jQuery("#name").focus();
        //         focus_once = 1;
        //     }
        //     flag_submit = false;
        // } else {
        //     if (!onlyAlphabets(name)) {
        //         document.getElementById("name_error_msg").innerHTML = "Only Characters & Hyphen(-)";
        //         if (focus_once == 0) {
        //             jQuery("#name").focus();
        //             focus_once = 1;
        //         }
        //         flag_submit = false;
        //     } else {
        //         document.getElementById("name_error_msg").innerHTML = "";
        //     }
        // }
        //
        //
        // if (fname == "") {
        //     document.getElementById("fname_error_msg").innerHTML = "Required";
        //     if (focus_once == 0) {
        //         jQuery("#fname").focus();
        //         focus_once = 1;
        //     }
        //     flag_submit = false;
        // } else {
        //     if (!onlyAlphabets(fname)) {
        //         document.getElementById("fname_error_msg").innerHTML = "Only Characters & Hyphen(-)";
        //         if (focus_once == 0) {
        //             jQuery("#fname").focus();
        //             focus_once = 1;
        //         }
        //         flag_submit = false;
        //     } else {
        //         document.getElementById("fname_error_msg").innerHTML = "";
        //     }
        // }
        //
        // if (username == "") {
        //     document.getElementById("username_error_msg").innerHTML = "Required";
        //     if (focus_once == 0) {
        //         jQuery("#username").focus();
        //         focus_once = 1;
        //     }
        //     flag_submit = false;
        // } else {
        //
        //     if (!validateusername(username)) {
        //         document.getElementById("username_error_msg").innerHTML = "Alphanumeric & Min.Length (6)";
        //         if (focus_once == 0) {
        //             jQuery("#username").focus();
        //             focus_once = 1;
        //         }
        //         flag_submit = false;
        //     } else {
        //
        //         if (check_username() == "false") {
        //             if (focus_once == 0) {
        //                 jQuery("#username").focus();
        //                 focus_once = 1;
        //             }
        //             flag_submit = false;
        //         } else {
        //             document.getElementById("username_error_msg").innerHTML = "";
        //         }
        //
        //     }
        // }
        //
        //
        // if (email == "") {
        //     document.getElementById("email_error_msg").innerHTML = "Required";
        //     if (focus_once == 0) {
        //         jQuery("#email").focus();
        //         focus_once = 1;
        //     }
        //     flag_submit = false;
        // } else {
        //
        //     if (!checkemail(email)) {
        //         document.getElementById("email_error_msg").innerHTML = "(example@example.com)";
        //         if (focus_once == 0) {
        //             jQuery("#email").focus();
        //             focus_once = 1;
        //         }
        //         flag_submit = false;
        //     } else {
        //
        //         if (check_email() == "false") {
        //             if (focus_once == 0) {
        //                 jQuery("#email").focus();
        //                 focus_once = 1;
        //             }
        //             flag_submit = false;
        //         } else {
        //
        //             document.getElementById("email_error_msg").innerHTML = "";
        //         }
        //     }
        // }
        //
        //
        // if (mobile == "") {
        //     document.getElementById("mobile_error_msg").innerHTML = "Required";
        //     if (focus_once == 0) {
        //         jQuery("#mobile").focus();
        //         focus_once = 1;
        //     }
        //     flag_submit = false;
        // } else {
        //
        //     if (!validatephone(mobile)) {
        //         document.getElementById("mobile_error_msg").innerHTML = "(03123456789) or (+923123456789)";
        //         if (focus_once == 0) {
        //             jQuery("#mobile").focus();
        //             focus_once = 1;
        //         }
        //         flag_submit = false;
        //     } else {
        //         document.getElementById("mobile_error_msg").innerHTML = "";
        //
        //     }
        // }
        //
        //
        // if (cnic != "") {
        //     //     document.getElementById("cnic_error_msg").innerHTML = "Required";
        //     //     if (focus_once == 0) {
        //     //         jQuery("#cnic").focus();
        //     //         focus_once = 1;
        //     //     }
        //     //     flag_submit = false;
        //     // } else {
        //
        //     if (!validatecnic(cnic)) {
        //         document.getElementById("cnic_error_msg").innerHTML = "(36000-1234567-8) or (3600012345678)";
        //         if (focus_once == 0) {
        //             jQuery("#cnic").focus();
        //             focus_once = 1;
        //         }
        //         flag_submit = false;
        //     } else {
        //         document.getElementById("cnic_error_msg").innerHTML = "";
        //     }
        // }

        // if (salary == "") {
        //     document.getElementById("salary_error_msg").innerHTML = "Required";
        //     if (focus_once == 0) {
        //         jQuery("#salary").focus();
        //         focus_once = 1;
        //     }
        //     flag_submit = false;
        // } else {
        //     document.getElementById("salary_error_msg").innerHTML = "";
        // }


        // if (address.trim() == "") {
        //     document.getElementById("address_error_msg").innerHTML = "Required";
        //     if (focus_once == 0) {
        //         jQuery("#address").focus();
        //         focus_once = 1;
        //     }
        //     flag_submit = false;
        // } else {
        //     document.getElementById("address_error_msg").innerHTML = "";
        // }


        // if (pimage == "") {
        //
        //     document.getElementById("pimage_error_msg").innerHTML = "Required";
        //     //  alert_message("Branch Address Is Required");
        //     if (focus_once == 0) {
        //         jQuery("#pimage").focus();
        //         focus_once = 1;
        //     }
        //     flag_submit = false;
        // } else {
        //     document.getElementById("pimage_error_msg").innerHTML = "";
        // }
        //     return flag_submit;
        // }


        // validating ID card
        function validatecnic(cnic_num) {
            myRegExp = new RegExp(/^\d{5}-\d{7}-\d$|^\d{13}$/);

            if (myRegExp.test(cnic_num)) {
                //if true
                return true;
            } else {
                //if false
                return false;
            }
        }


        function checkemail(email_address) {

            if (/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                .test(email_address)) {
                return true;
            } else {
                return false;
            }
        }


        // validate phone number
        function validatephone(phone_num) {
            var ph = /^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/;
            if (ph.test(phone_num)) {
                return true;
            } else {
                return false;
            }
        }


        //USER NAME
        function validateusername(username) {
            var uname = /^[a-zA-Z0-9]{6,40}$/; //Alphanumeric without spaces
            if (uname.test(username)) {
                return true;
            } else {
                return false;
            }
        }


        // added for alphabets only check
        function onlyAlphabets(alphabets_value) {
            //  /^[a-zA-Z]+$/
            var regex = /^[^-\s][a-zA-Z\s-]+$/;
            if (regex.test(alphabets_value)) {

                return true;
            } else {
                return false;
            }
        }
    </script>



    {{-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
    {{-- ////////////////////////////////////////////////// Allowances / Dedcution Script /////////////////////////////////////////////////// --}}
    {{-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}

    <script>
        // jQuery("#account_code").change(function () {
        //
        //     var account_code = jQuery('option:selected', this).val();
        //
        //     jQuery("#account_name").select2("destroy");
        //     jQuery('#account_name option[value="' + account_code + '"]').prop('selected', true);
        //     jQuery("#account_name").select2();
        // });
        //
        // jQuery("#account_name").change(function () {
        //
        //     var account_name = jQuery('option:selected', this).val();
        //
        //     jQuery("#account_code").select2("destroy");
        //     jQuery('#account_code option[value="' + account_name + '"]').prop('selected', true);
        //     jQuery("#account_code").select2();
        // });


        // jQuery("#allowance_deduction").change(function () {
        //
        //     var selected_value = jQuery('option:selected', this).val();
        //
        //     if (selected_value == 2) {
        //         jQuery('#taxable').prop('checked', false);
        //         $("#taxable").attr("disabled", true);
        //     } else {
        //         // jQuery('#taxable').prop('checked', false);
        //         $("#taxable").attr("disabled", false);
        //     }
        // });
    </script>

    <script>
        // adding packs into table
        var numberofaccounts = 0;
        var counter = 0;
        var accounts = {};
        var global_id_to_edit = 0;
        var edit_account_value = '';

        function add_account() {

            var account_code = $("#account_code").val();
            // var account_name = $("#account_name").val();
            var account_name_text = jQuery("#account_code option:selected").text();
            var allowance_deduction = $("#allowance_deduction").val();
            var allowance_deduction_text = jQuery("#allowance_deduction option:selected").text();
            var amount = $("#amount").val();
            var account_remarks = $("#account_remarks").val();
            var start_month = $("#start_month").val();
            var end_month = $("#end_month").val();
            console.log(start_month, end_month);
            var flag_submit1 = true;
            var focus_once1 = 0;

            if (account_code == "0") {

                if (focus_once1 == 0) {
                    jQuery("#account_code").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            // if (account_name == "0") {
            //
            //     if (focus_once1 == 0) {
            //         jQuery("#account_name").focus();
            //         focus_once1 = 1;
            //     }
            //     flag_submit1 = false;
            // }

            if (allowance_deduction == "0") {

                if (focus_once1 == 0) {
                    jQuery("#allowance_deduction").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (amount == "" || amount == '0') {

                if (focus_once1 == 0) {
                    jQuery("#amount").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            if (start_month == "" || start_month == '0') {

                if (focus_once1 == 0) {
                    jQuery("#start_month").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            if (end_month == "" || end_month == '0') {

                if (focus_once1 == 0) {
                    jQuery("#end_month").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete accounts[global_id_to_edit];
                }

                counter++;

                jQuery("#account_code").select2("destroy");
                // jQuery("#account_name").select2("destroy");
                jQuery("#allowance_deduction").select2("destroy");

                numberofaccounts = Object.keys(accounts).length;

                if (numberofaccounts == 0) {
                    jQuery("#table_body").html("");
                }


                accounts[counter] = {
                    'account_code': account_code,
                    'account_name': account_name_text,
                    'allowance_deduction': allowance_deduction,
                    'account_amount': amount,
                    'account_remarks': account_remarks,
                    'start_month': start_month,
                    'end_month': end_month,
                };

                jQuery("#account_code option[value=" + account_code + "]").attr("disabled", "true");
                // jQuery("#account_name option[value=" + account_code + "]").attr("disabled", "true");
                numberofaccounts = Object.keys(accounts).length;


                var remarks_var = '';
                if (account_remarks != '') {
                    var remarks_var = '' + account_remarks + '';
                }

                jQuery("#table_body").append('<tr id=' + counter +
                    ' class="edit_update"><td class="text-center tbl_srl_4">' + counter +
                    '</td><td class="text-left tbl_txt_20">' + account_name_text +
                    '</td><td class="text-left tbl_txt_30">' + remarks_var + '</td><td class="text-left tbl_txt_12">' +
                    allowance_deduction_text + '</td><td class="text-left tbl_txt_10" >' + start_month +
                    '</td><td class="text-left tbl_txt_10" >' + end_month +
                    '</td><td class="text-right tbl_srl_12">' + amount +
                    '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_account(' +
                    counter +
                    ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_account(' +
                    counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');

                jQuery('#account_code option[value="' + 0 + '"]').prop('selected', true);
                // jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#allowance_deduction option[value="' + 0 + '"]').prop('selected', true);

                jQuery("#amount").val("");
                jQuery("#account_remarks").val("");


                jQuery("#accounts_array").val(JSON.stringify(accounts));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');

                jQuery("#account_code").select2();
                // jQuery("#account_name").select2();
                jQuery("#allowance_deduction").select2();

                total_calculation();

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();
            }
        }

        function total_calculation() {
            var total_amount = 0;

            jQuery.each(accounts, function (index, value) {
                total_amount = +total_amount + +value['account_amount'];
            });

            jQuery("#total_amount").val(total_amount);
        }

        function delete_account(current_item) {
            jQuery("#" + current_item).remove();
            var temp_accounts = accounts[current_item];
            jQuery("#account_code option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);
            // jQuery("#account_name option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);

            delete accounts[current_item];

            jQuery("#accounts_array").val(JSON.stringify(accounts));

            if (isEmpty(accounts)) {
                numberofaccounts = 0;
            }

            jQuery("#account_code").select2("destroy");
            // jQuery("#account_name").select2("destroy");

            jQuery("#account_code").select2();
            // jQuery("#account_name").select2();
        }


        function edit_account(current_item) {
            // jQuery(".table-responsive").attr("style", "display:none");
            jQuery("#" + current_item).attr("style", "display:none");
            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();

            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;

            var temp_accounts = accounts[current_item];

            edit_account_value = temp_accounts['account_code'];

            jQuery("#account_code").select2("destroy");
            // jQuery("#account_name").select2("destroy");
            jQuery("#allowance_deduction").select2("destroy");

            jQuery("#account_code option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);
            // jQuery("#account_name option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);

            jQuery('#account_code option[value="' + temp_accounts['account_code'] + '"]').prop('selected', true);
            // jQuery('#account_name option[value="' + temp_accounts['account_code'] + '"]').prop('selected', true);

            jQuery('#allowance_deduction option[value="' + temp_accounts['allowance_deduction'] + '"]').prop('selected',
                true);


            jQuery("#start_month").val(temp_accounts['start_month']);
            jQuery("#end_month").val(temp_accounts['end_month']);
            jQuery("#amount").val(temp_accounts['account_amount']);
            jQuery("#account_remarks").val(temp_accounts['account_remarks']);


            jQuery("#account_code").select2();
            // jQuery("#account_name").select2();
            jQuery("#allowance_deduction").select2();

            $("#allowance_deduction").trigger("change");

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {
            // var newvaltohide = jQuery("#account_code").val();
            var newvaltohide = edit_account_value;

            jQuery("#account_code option[value=" + newvaltohide + "]").attr("disabled", "true");
            // jQuery("#account_name option[value=" + newvaltohide + "]").attr("disabled", "true");

            jQuery('#account_code option[value="' + 0 + '"]').prop('selected', true);
            // jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#allowance_deduction option[value="' + 0 + '"]').prop('selected', true);

            jQuery("#account_code").select2("destroy");
            // jQuery("#account_name").select2("destroy");
            jQuery("#allowance_deduction").select2("destroy");

            jQuery("#account_remarks").val("");
            jQuery("#amount").val("");

            jQuery("#account_code").select2();
            // jQuery("#account_name").select2();
            jQuery("#allowance_deduction").select2();

            jQuery("#cancel_button").hide();

            // jQuery(".table-responsive").show();
            jQuery("#" + global_id_to_edit).show();

            jQuery("#save").show();

            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');
            global_id_to_edit = 0;

            jQuery(".edit_link").show();
            jQuery(".delete_link").show();

            edit_account_value = '';
        }

        function formatDate(inputDate) {
            const months = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            const dateParts = inputDate.split('-');
            const year = parseInt(dateParts[0]);
            const month = parseInt(dateParts[1]);

            if (isNaN(year) || isNaN(month) || month < 1 || month > 12) {
                return 'Invalid date format';
            }

            const monthName = months[month - 1];
            return `${monthName} ${year}`;
        }
    </script>

    <script>
            @forelse($allowance_deduction as $salary_ad)

        var account_code = '{{ $salary_ad->ad_account_id }}';
        jQuery("#account_code").select2('destroy');
            jQuery("#account_code option[value=" + account_code + "]").prop("disabled", "true");
            jQuery("#account_code option[value=" + account_code + "]").attr("disabled", "true");

        jQuery('#account_code option[value="' + account_code + '"]').prop('selected', true);
        var account_name_text = jQuery("#account_code option:selected").text();

        var allowance_deduction = '{{ $salary_ad->ad_allowance_deduction }}';

        jQuery('#allowance_deduction option[value="' + allowance_deduction + '"]').prop('selected', true);

        var amount = 0;
        var allowance_deduction_text = jQuery("#allowance_deduction option:selected").text();
        if (allowance_deduction == 1) {
            amount = '{{ $salary_ad->ad_allowance_amount }}';
        } else {
            amount = '{{ $salary_ad->ad_deduction_amount }}';
        }
        var account_remarks = '{{ $salary_ad->ad_remarks }}';

        var start_month = formatDate('{{ $salary_ad->ad_start_month }}');
        var end_month = formatDate('{{ $salary_ad->ad_end_month }}');


        if (global_id_to_edit != 0) {
            jQuery("#" + global_id_to_edit).remove();

            delete accounts[global_id_to_edit];
        }

        counter++;

        // jQuery("#account_code").select2("destroy");
        // jQuery("#account_name").select2("destroy");
        jQuery("#allowance_deduction").select2("destroy");

        numberofaccounts = Object.keys(accounts).length;

        if (numberofaccounts == 0) {
            jQuery("#table_body").html("");
        }

        accounts[counter] = {
            'account_code': account_code,
            'account_name': account_name_text,
            'allowance_deduction': allowance_deduction,
            'start_month': start_month,
            'end_month': end_month,
            'account_amount': amount,
            'account_remarks': account_remarks,
        };

        jQuery("#account_code option[value=" + account_code + "]").prop("disabled", "true");
        jQuery("#account_code option[value=" + account_code + "]").attr("disabled", "true");
        // jQuery("#account_name option[value=" + account_code + "]").attr("disabled", "true");
        numberofaccounts = Object.keys(accounts).length;


        var remarks_var = '';
        if (account_remarks != '') {
            var remarks_var = '<div class="max_txt"> <blockquote> ' + account_remarks + ' </blockquote> </div>';
        }

        jQuery("#table_body").append('<tr id=' + counter +
            ' class="edit_update"><td class="text-center tbl_srl_4">' + counter +
            '</td><td class="text-left tbl_txt_20">' + account_name_text +
            '</td><td class="text-left tbl_txt_30">' + remarks_var + '</td><td class="text-left tbl_txt_12">' +
            allowance_deduction_text + '</td><td class="text-left tbl_txt_10" >' + start_month +
            '</td><td class="text-left tbl_txt_10" >' + end_month +
            '</td><td class="text-right tbl_srl_12">' + amount +
            '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_account(' +
            counter +
            ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_account(' +
            counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');


        jQuery('#account_code option[value="' + 0 + '"]').prop('selected', true);
        // jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);
        jQuery('#allowance_deduction option[value="' + 0 + '"]').prop('selected', true);

        jQuery("#amount").val("");
        jQuery("#account_remarks").val("");

        jQuery("#accounts_array").val(JSON.stringify(accounts));
        jQuery("#cancel_button").hide();
        jQuery(".table-responsive").show();
        jQuery("#save").show();
        jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');

        jQuery("#account_code").select2();
        // jQuery("#account_name").select2();
        jQuery("#allowance_deduction").select2();
        total_calculation();
        jQuery(".edit_link").show();
        jQuery(".delete_link").show();
        @empty
        @endforelse
    </script>
@endsection
