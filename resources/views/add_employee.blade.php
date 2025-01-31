@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="container-fluid search-filter form-group form_manage">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Create Employee</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('employee_list') }}"
                               role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <div class="excel_con gnrl-mrgn-pdng gnrl-blk">
                    <div class="excel_box gnrl-mrgn-pdng gnrl-blk">
                        <div class="excel_box_hdng gnrl-mrgn-pdng gnrl-blk">
                            <h2 class="gnrl-blk gnrl-mrgn-pdng gnrl-font-bold">
                                Upload Excel File
                            </h2>
                        </div>
                        <div class="excel_box_content gnrl-mrgn-pdng gnrl-blk">

                            <form action="{{ route('submit_employee_excel') }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label class="required">
                                                Select Excel File
                                            </label>
                                            <input tabindex="100" type="file" name="add_employee_excel"
                                                   id="add_employee_excel"
                                                   class="inputs_up form-control-file form-control height-auto"
                                                   accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        </div><!-- end input box -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                        <a href="{{ url('public/sample/employee/add_employee_pattern.xlsx') }}"
                                           tabindex="-1" type="reset" class="cancel_button btn btn-sm btn-info">
                                            Download Sample Pattern
                                        </a>
                                        <button tabindex="101" type="submit" name="save" id="save2"
                                                class="save_button btn btn-sm btn-success">
                                            <i class="fa fa-floppy-o"></i> Save
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <form name="f1" class="f1" id="f1" action="{{ route('submit_employee') }}" method="post"
                      onsubmit="return checkForm()" enctype="multipart/form-data">
                    @csrf
                    <div class="tab form-group">
                        <ul class="nav nav-tabs customtab double_line_tab" role="tablist">
                            <li class="nav-item">
                                <a tabindex="1" autofocus class="nav-link active text-blue" data-toggle="tab"
                                   href="#home" role="tab" aria-selected="true">Personal Info</a>
                            </li>
                            <li class="nav-item">
                                <a tabindex="2" class="nav-link text-blue" data-toggle="tab" href="#profile"
                                   role="tab" aria-selected="false">Salary Info</a>
                            </li>
                            <li class="nav-item">
                                <a tabindex="3" class="nav-link text-blue" data-toggle="tab" href="#credentials"
                                   role="tab" aria-selected="false">Credentials</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="home" role="tabpanel">
                                <div class="pd-20">
                                    <div class="row">
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="required">
                                                    Department
                                                    <a href="{{ route('departments.create') }}" class="add_btn"
                                                       target="_blank" data-container="body" data-toggle="popover"
                                                       data-trigger="hover" data-placement="bottom" data-html="true"
                                                       data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                    <a id="refresh_department" class="add_btn" data-container="body"
                                                       data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                       data-html="true"
                                                       data-content="{{ config('fields_info.about_form_fields.refresh.description') }}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </label>
                                                <select tabindex="4" name="user_department_id"
                                                        class="inputs_up form-control" data-rule-required="true"
                                                        data-msg-required="Please Enter Department" id="user_department_id">
                                                    <option value="">Select Department</option>
                                                    @foreach ($departments as $department)
                                                        <option
                                                            value="{{ $department->dep_id }}"{{ $department->dep_id == $employee->user_department_id ? 'selected' : '' }}>
                                                            {{ $department->dep_title }}</option>
                                                    @endforeach
                                                </select>
                                                <span id="modular_group_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="required">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.user_type.description') }}</p>
                                              <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.user_type.benefits') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    User Type</label>
                                                <select tabindex="4" name="user_type" class="inputs_up form-control"
                                                        data-rule-required="true" data-msg-required="Please Enter User Type"
                                                        id="user_type">
                                                    <option value="">Select User Type</option>
                                                    @if ($employee->user_level == 100)
                                                        <option value="100"
                                                            {{ 100 == $employee->user_level ? 'selected' : '' }}>Super
                                                            Admin
                                                        </option>
                                                    @endif
                                                    <option value="30"
                                                        {{ 30 == $employee->user_level ? 'selected' : '' }}>Admin
                                                    </option>
                                                    <option value="40"
                                                        {{ 40 == $employee->user_level ? 'selected' : '' }}>Owner
                                                    </option>
                                                    <option value="20"
                                                        {{ 20 == $employee->user_level ? 'selected' : '' }}>Manager
                                                    </option>
                                                    <option value="10"
                                                        {{ 10 == $employee->user_level ? 'selected' : '' }}>Operator
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
                                                <select tabindex=3 autofocus name="branch[]"
                                                        class="inputs_up form-control" data-rule-required="true"
                                                        data-msg-required="Please Enter Branch" id="branch" multiple>
                                                    @foreach ($branches as $branch)
                                                        <option value="{{ $branch->branch_id }}">
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
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.role.description') }}</p>
                                               <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.role.benefits') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    <a href="{{ route('departments.create') }}" class="add_btn"
                                                       target="_blank" data-container="body" data-toggle="popover"
                                                       data-trigger="hover" data-placement="bottom" data-html="true"
                                                       data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                    <a id="refresh_department" class="add_btn" data-container="body"
                                                       data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="{{ config('fields_info.about_form_fields.refresh.description') }}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                    Role</label>
                                                <select tabindex="5" name="role" class="inputs_up form-control"
                                                        data-rule-required="true" data-msg-required="Please Enter Role"
                                                        id="role">
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
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.designation.description') }}</p>
                                                            <h6>Example</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.designation.example') }}</p>
                                                            <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.designation.benefits') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    <a href="{{ route('add_desig') }}" class="add_btn" target="_blank"
                                                       data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                    <a id="refresh_designation" class="add_btn" data-container="body"
                                                       data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="{{ config('fields_info.about_form_fields.refresh.description') }}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                    Designation</label>
                                                <select tabindex="4" name="designation" class="inputs_up form-control"
                                                        data-rule-required="true" data-msg-required="Please Enter Designation"
                                                        id="designation">
                                                    <option value="">Select Designation</option>
                                                    @foreach ($designations as $designation)
                                                        <option
                                                            value="{{ $designation->desig_id }}"{{ $designation->desig_id == $employee->user_designation ? 'selected' : '' }}>
                                                            {{ $designation->desig_name }}</option>
                                                    @endforeach
                                                </select>
                                                {{-- <input tabindex="5" type="text" name="designation" id="designation"
                                                    data-rule-required="true" data-msg-required="Please Enter Designation"
                                                    class="inputs_up form-control" placeholder="Designation"
                                                    value="{{ old('designation') }}"> --}}
                                                {{-- <span id="designation_error_msg" class="validate_sign"> </span> --}}
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="required">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.name.description') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Name</label>
                                                <input tabindex="6" type="text" name="name" id="name"
                                                       data-rule-required="true" data-msg-required="Please Enter Name"
                                                       class="inputs_up form-control" placeholder="Name"
                                                       value="{{ old('name') }}">
                                                <span id="name_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="required">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.father_name.description') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Father Name</label>
                                                <input tabindex="7" type="text" name="fname" id="fname"
                                                       data-rule-required="true" data-msg-required="Please Enter Father Name"
                                                       class="inputs_up form-control" placeholder="Father Name"
                                                       value="{{ old('fname') }}">
                                                <span id="fname_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="required">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.mobile.description') }}</p>
                                                        <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.mobile.benefits') }}</p>
                                                        <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.mobile.example') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Mobile Number</label>
                                                <input tabindex="8" type="text" name="mobile" id="mobile"
                                                       data-rule-required="true"
                                                       data-msg-required="Please Enter Mobile Number"
                                                       class="inputs_up form-control" placeholder="Mobile Number"
                                                       value="{{ old('mobile') }}"
                                                       onkeypress="return isNumberWithHyphen(event)">
                                                <span id="mobile_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.emergency_contact.description') }}</p>
                                                        <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.emergency_contact.benefits') }}</p>
                                                        <h6>Example</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.emergency_contact.example') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Emergency Contact</label>
                                                <input tabindex="9" type="text" name="emergency_contact"
                                                       id="emergency_contact" value="{{ old('emergency_contact') }}"
                                                       class="inputs_up form-control" placeholder="Emergency Contact">
                                                <span id="emergency_contact_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.cnic.description') }}</p>
                                                        <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.cnic.benefits') }}</p>
                                                        <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.cnic.example') }}</p>
                                                        <h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.cnic.validations') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Cnic</label>
                                                <input tabindex="10" type="text" name="cnic" id="cnic"
                                                       value="{{ old('cnic') }}" class="inputs_up form-control"
                                                       placeholder="Cnic" onkeypress="return isNumberWithHyphen(event)">
                                                <span id="cnic_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.family_code.description') }}</p>
                                                        <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.family_code.benefits') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Family Code</label>
                                                <input tabindex="11" type="text" name="family_code" id="family_code"
                                                       value="{{ old('family_code') }}" class="inputs_up form-control"
                                                       placeholder="Family Code">
                                                <span id="family_code_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.marital_status.description') }}</p>
                                                        <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.marital_status.benefits') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Marital Status</label>
                                                <div class="custom-control custom-radio mb-10 mt-1">
                                                    <input tabindex="12" type="radio" name="marital"
                                                           class="custom-control-input marital" id="marital1"
                                                           value="1" {{ old('marital') == 1 ? 'checked' : '' }} checked>
                                                    <label class="custom-control-label" for="marital1">
                                                        Married
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-radio mb-10 mt-1">
                                                    <input tabindex="13" type="radio" name="marital"
                                                           class="custom-control-input marital" id="marital2"
                                                           value="2"{{ old('marital') == 2 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="marital2">
                                                        Unmarried
                                                    </label>
                                                </div>
                                                <span id="marital_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.city.description') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    City</label>
                                                <select tabindex="14" name="city" class="inputs_up form-control"
                                                        id="city">
                                                    <option value="">Select City</option>
                                                    @foreach ($cities as $city)
                                                        <option
                                                            value="{{ $city->city_id }}"{{ $city->city_id == old('city') ? 'selected' : '' }}>
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
                                                <select tabindex="15" name="blood_group" class="inputs_up form-control"
                                                        id="blood_group">
                                                    <option value="">Select Blood Group</option>
                                                    <option value="A +">A +</option>
                                                    <option value="A -">A -</option>
                                                    <option value="B +">B +</option>
                                                    <option value="B -">B -</option>
                                                    <option value="AB +">AB +</option>
                                                    <option value="AB -">AB -</option>
                                                    <option value="O +">O +</option>
                                                    <option value="O -">O -</option>
                                                </select>
                                                <span id="blood_group_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="">Nationality</label>
                                                <select tabindex="16" id="nationality" name="nationality"
                                                        class="inputs_up form-control">
                                                    <option value="">Select Country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->c_id }}"
                                                            {{ $country->c_id == config('global_variables.country_id') ? 'selected' : '' }}>
                                                            {{ $country->c_name }}</option>
                                                    @endforeach
                                                </select>
                                                <span id="nationality_code_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="">Religion</label>
                                                <div class="custom-control custom-radio mb-10 mt-1">
                                                    <input tabindex="17" type="radio" name="religion"
                                                           class="custom-control-input religion" id="religion1"
                                                           value="1" {{ old('religion') == 1 ? 'checked' : '' }}
                                                           checked>
                                                    <label class="custom-control-label" for="religion1">
                                                        Muslim
                                                    </label>
                                                </div>

                                                <div class="custom-control custom-radio mb-10 mt-1">
                                                    <input tabindex="18" type="radio" name="religion"
                                                           class="custom-control-input religion" id="religion2"
                                                           value="2"{{ old('religion') == 2 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="religion2">
                                                        Non-Muslim
                                                    </label>
                                                </div>
                                                <span id="religion_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="">D.O.J</label>
                                                <input tabindex="19" type="text" name="doj" id="doj"
                                                       class="inputs_up form-control date-picker"
                                                       value="{{ old('doj') }}" placeholder="D.O.J">
                                                <span id="doj_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12" hidden>
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="">Grade</label>
                                                <input tabindex="20" type="text" name="grade" id="grade"
                                                       class="inputs_up form-control" value="{{ old('grade') }}"
                                                       placeholder="Grade">
                                                <span id="grade_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="">Commission</label>
                                                <input tabindex="21" type="text" name="commission" id="commission"
                                                       value="{{ old('commission') }}" class="inputs_up form-control"
                                                       placeholder="Commission" onfocus="this.select();"
                                                       onkeypress="return allow_only_number_and_decimals(this,event);">
                                                <span id="commission_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="">Target Amount</label>
                                                <input tabindex="22" type="text" name="target_amount"
                                                       value="{{ old('target_amount') }}" id="target_amount"
                                                       class="inputs_up form-control" placeholder="Target Amount"
                                                       onfocus="this.select();"
                                                       onkeypress="return allow_only_number_and_decimals(this,event);">
                                                <span id="target_amount_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.description') }}</p>
                                                        <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.benefits') }}</p>
                                                        <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.example') }}</p>
                                                        <h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.validations') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Address 1</label>
                                                <textarea tabindex="23" name="address" id="address" class="remarks inputs_up form-control"
                                                          placeholder="Address 1" style="height: 107px;">{{ old('address') }}</textarea>
                                                <span id="address_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.description') }}</p>
                                                        <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.benefits') }}</p>
                                                        <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.example') }}</p>
                                                        <h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.validations') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Address 2</label>
                                                <textarea tabindex="24" name="address2" id="address2" class="remarks inputs_up form-control"
                                                          placeholder="Address 2" style="height: 107px;">{{ old('address2') }}</textarea>
                                                <span id="address2_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="">Profile Image</label>
                                                <input tabindex="25" type="file" name="pimage" id="pimage"
                                                       class="inputs_up form-control" accept=".png,.jpg,.jpeg"
                                                       style="width: 100px !important; background-color: #eee; border:none; box-shadow: none !important; display: none;">
                                                <span id="pimage_error_msg" class="validate_sign"> </span>
                                                <div class="db">
                                                    <div class="db">
                                                        <label id="image1"
                                                               style="display: none; cursor:pointer; color:blue; text-decoration:underline;">
                                                            <i style=" color:#04C1F3" class="fa fa-window-close"></i>
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <img id="imagePreview1"
                                                             style="border-radius:50%; position:relative; cursor:pointer;  width: 100px; height: 100px;"
                                                             src="{{ asset('public/src/upload_btn.jpg') }}"/>
                                                    </div>
                                                </div>
                                            </div><!-- end input box -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel">
                                <div class="pd-20">
                                    <div id="invoice_con" class="invoice_con for_voucher">
                                        <!-- invoice container start -->
                                        <div id="invoice_bx" class="invoice_bx show_scale show_rotate">
                                            <!-- invoice box start -->
                                            <div class="invoice_bx_scrl">
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
                                                        <div class="invoice_col from_group col-lg-3 col-md-4 col-sm-12">
                                                            <div class="invoice_col_bx">
                                                                <!-- invoice column box start -->
                                                                <div class="invoice_col_ttl required">
                                                                    <!-- invoice column title start -->
                                                                    <a data-container="body" data-toggle="popover"
                                                                       data-trigger="hover" data-placement="bottom"
                                                                       data-html="true"
                                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.account_registration.reporting_group.account_viewing_group_name.description') }}</p>
                                                                        <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.account_registration.reporting_group.account_viewing_group_name.benefits') }}</p>
                                                                        <h6>Example</h6><p>{{ config('fields_info.about_form_fields.account_registration.reporting_group.account_viewing_group_name.example') }}</p>
                                                                        <h6>Validation</h6><p>{{ config('fields_info.about_form_fields.account_registration.reporting_group.account_viewing_group_name.validations') }}</p>">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </a>
                                                                    Account Ledger Access Group
                                                                </div><!-- invoice column title end -->
                                                                <div class="invoice_col_input refresh-addition">
                                                                    <!-- invoice column input start -->
                                                                    <div class="invoice_col_short">
                                                                        <!-- invoice column short start -->
                                                                        <a href="{{ route('add_account_group') }}"
                                                                           class="col_short_btn col_short_btn btn btn-sm btn-info add"
                                                                           target="_blank" data-container="body"
                                                                           data-toggle="popover" data-trigger="hover"
                                                                           data-placement="bottom" data-html="true"
                                                                           data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                                                            <i class="fa fa-plus"></i>
                                                                        </a>
                                                                        <a id="refresh_group"
                                                                           class="col_short_btn col_short_btn btn btn-sm btn-info refresh"
                                                                           data-container="body" data-toggle="popover"
                                                                           data-trigger="hover" data-placement="bottom"
                                                                           data-html="true"
                                                                           data-content="{{ config('fields_info.about_form_fields.refresh.description') }}">
                                                                            <l class="fa fa-refresh"></l>
                                                                        </a>
                                                                    </div><!-- invoice column short end -->
                                                                    <select tabindex="4" name="group_id" id="group_id"
                                                                            class="inputs_up form-control"
                                                                            data-rule-required="true"
                                                                            data-msg-required="Please
                                                                Enter Account Ledger Access Group">
                                                                        <option value="">Select Account Ledger Access
                                                                            Group
                                                                        </option>
                                                                        @foreach ($groups as $group)
                                                                            <option value="{{ $group->ag_id }}"
                                                                                {{ $group->ag_id == old('group_id') ? 'selected="selected"' : '' }}>
                                                                                {{ $group->ag_title }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div><!-- invoice column input end -->
                                                            </div><!-- invoice column box end -->
                                                        </div>
                                                    </div>
                                                    <h6 class="mb-2;">Expense Head</h6>
                                                    <div class="invoice_row salary_div">
                                                        <!-- invoice row start -->
                                                        <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12">
                                                            <!-- invoice column start -->
                                                            <div class="invoice_col_bx">
                                                                <!-- invoice column box start -->
                                                                <div class="required invoice_col_ttl">
                                                                    <!-- invoice column title start -->
                                                                    <a data-container="body" data-toggle="popover"
                                                                       data-trigger="hover" data-placement="bottom"
                                                                       data-html="true"
                                                                       ata-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.description') }}</p> <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits') }}</p> <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.example') }}</p> <h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </a> Basic Salary
                                                                </div><!-- invoice column title end -->
                                                                <div class="invoice_col_input">
                                                                    <!-- invoice column input start -->
                                                                    <input tabindex="29" type="text"
                                                                           name="basic_salary" id="basic_salary"
                                                                           value="{{ old('basic_salary') }}"
                                                                           class="inputs_up form-control"
                                                                           data-rule-required="true"
                                                                           data-msg-required="Please Enter Basic Salary"
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
                                                                    <a data-container="body" data-toggle="popover"
                                                                       data-trigger="hover" data-placement="bottom"
                                                                       data-html="true"
                                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.child_account.description') }}</p> <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.child_account.benefits') }}</p> <h6>Example</h6><p>{{ config('fields_info.about_form_fields.child_account.example') }}</p>">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </a>
                                                                    Salary Period
                                                                </div><!-- invoice column title end -->
                                                                <div class="invoice_col_input">
                                                                    <!-- invoice column input start -->
                                                                    <select tabindex="30" name="salary_period"
                                                                            class="inputs_up form-control"
                                                                            data-rule-required="true"
                                                                            data-msg-required="Please Salary Period"
                                                                            id="salary_period">
                                                                        <option value="0">Select Salary Period
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
                                                                    <a data-container="body" data-toggle="popover"
                                                                       data-trigger="hover" data-placement="bottom"
                                                                       data-html="true"
                                                                       ata-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.description') }}</p> <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits') }}</p> <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.example') }}</p> <h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </a> Working Hours/Day
                                                                </div><!-- invoice column title end -->
                                                                <div class="invoice_col_input">
                                                                    <!-- invoice column input start -->
                                                                    <input tabindex="31" type="text"
                                                                           name="hour_per_day" id="hour_per_day"
                                                                           class="inputs_up form-control"
                                                                           value="{{ old('hour_per_day') }}"
                                                                           data-rule-required="true"
                                                                           data-msg-required="Please Choose Days"
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
                                                                    <a data-container="body" data-toggle="popover"
                                                                       data-trigger="hover" data-placement="bottom"
                                                                       data-html="true"
                                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.child_account.description') }}</p> <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.child_account.benefits') }}</p> <h6>Example</h6><p>{{ config('fields_info.about_form_fields.child_account.example') }}</p>">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </a> Off Days
                                                                </div><!-- invoice column title end -->
                                                                <div class="invoice_col_input">
                                                                    <!-- invoice column input start -->
                                                                    <select tabindex="32" name="holidays[]"
                                                                            class="inputs_up form-control" id="holidays"
                                                                            data-rule-required="true"
                                                                            data-msg-required="Please Choose Off Days"
                                                                            multiple>
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
                                                                    <span id="holidays_error_msg" class="validate_sign">
                                                                    </span>
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
                                                                        <option value="1" {{ isset($salary_info) && $salary_info->si_payment_type== 1 ?  'selected' : '' }}>
                                                                            Bank
                                                                        </option>
                                                                        <option value="2" {{ isset($salary_info) && $salary_info->si_payment_type== 2 ?  'selected' : '' }}>
                                                                            Cheque
                                                                        </option>
                                                                        <option value="3" {{ isset($salary_info) && $salary_info->si_payment_type== 3 ?  'selected' : '' }}>
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
                                                                           class="inputs_up form-control" id="branch_code"
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
                                                                           class="inputs_up form-control" id="account_no"
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
                                                                           autocomplete="off" value="" data-rule-required="true" data-msg-required="Please Enter Month" placeholder="End Month ......">
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
                                            <input type="hidden" name="accounts_array" id="accounts_array"
                                                   value="{{ old('accounts_array') }}">
                                        </div><!-- invoice box end -->
                                    </div><!-- invoice container end -->
                                </div>
                            </div>
                            <div class="tab-pane fade" id="credentials" role="tabpanel">
                                <div class="pd-20">
                                    <div class="row">
                                        <div class="input_bx form-group col-lg-2 col-md-3 col-sm-12">
                                            <div class="custom-control custom-checkbox mb-10 mt-1" style="float: left">
                                                <input tabindex="27" type="checkbox" name="make_credentials"
                                                       class="custom-control-input" id="make_credentials" value="1"
                                                    {{ $employee->user_have_credentials == 1 ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="make_credentials">Make Credentials</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row credentials_div">
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="required">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.account_ledger_access_group.description') }}</p><h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.account_ledger_access_group.benefits') }}</p><h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.account_ledger_access_group.example') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Account Ledger Access Group
                                                    <a href="{{ route('add_account_group') }}" class="add_btn"
                                                       target="_blank" data-container="body" data-toggle="popover"
                                                       data-trigger="hover" data-placement="bottom" data-html="true"
                                                       data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                    <a id="refresh_group" class="add_btn" data-container="body"
                                                       data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="{{ config('fields_info.about_form_fields.refresh.description') }}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </label>
                                                <select tabindex=42 autofocus name="group[]"
                                                        class="inputs_up form-control" data-rule-required="true"
                                                        data-msg-required="Please Enter Account Ledger Access Group"
                                                        id="group" multiple>
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
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.new.Product_Reporting_Group.Product_Handling_Group_Title.description') }}</p>
                                                        <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.new.Product_Reporting_Group.Product_Handling_Group_Title.benefits') }}</p>
                                                        <h6>Example</h6><p>{{ config('fields_info.about_form_fields.new.Product_Reporting_Group.Product_Handling_Group_Title.example') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Product Handling Group
                                                    <a href="{{ route('product_group') }}" class="add_btn"
                                                       target="_blank" data-container="body" data-toggle="popover"
                                                       data-trigger="hover" data-placement="bottom" data-html="true"
                                                       data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                    <a id="refresh_product_group" class="add_btn" data-container="body"
                                                       data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="{{ config('fields_info.about_form_fields.refresh.description') }}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </label>
                                                <select tabindex="43" name="product_reporting_group[]"
                                                        class="inputs_up form-control" data-rule-required="true"
                                                        data-msg-required="Please Enter Product Handling Group"
                                                        id="product_reporting_group" multiple>

                                                    @foreach ($product_groups as $product_group)
                                                        @php
                                                            $product_group_id = explode(',', $employee->user_product_reporting_group_ids);
                                                        @endphp

                                                        <option value="{{ $product_group->pg_id }}"
                                                            {{ in_array($product_group->pg_id, $product_group_id) ? 'selected' : '' }}>
                                                            {{ $product_group->pg_title }}</option>
                                                    @endforeach
                                                </select>
                                                <span id="product_reporting_group_error_msg" class="validate_sign">
                                                </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="required">
                                                    <a data-container="body" data-toggle="popover"
                                                       data-trigger="hover" data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.modular_group.description') }}</p>
                                                        <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.modular_group.benefits') }}</p>">
                                                        <l class=" fa fa-info-circle"></l>
                                                    </a>
                                                    Modular Group
                                                    <a href="{{ route('add_modular_group') }}" class="add_btn"
                                                       target="_blank" data-container="body" data-toggle="popover"
                                                       data-trigger="hover" data-placement="bottom" data-html="true"
                                                       data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                    <a id="refresh_modular_group" class="add_btn"
                                                       data-container="body" data-toggle="popover"
                                                       data-trigger="hover" data-placement="bottom" data-html="true"
                                                       data-content="{{ config('fields_info.about_form_fields.refresh.description') }}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </label>
                                                <select tabindex="44" name="modular_group"
                                                        class="inputs_up form-control" data-rule-required="true"
                                                        data-msg-required="Please Enter Modular Group" id="modular_group">
                                                    <option value="">Select Modular Group</option>
                                                    @foreach ($modular_groups as $modular_group)
                                                        <option value="{{ $modular_group->id }}"
                                                            {{ $modular_group->id == $employee->user_modular_group_id ? 'selected' : '' }}>
                                                            {{ $modular_group->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span id="modular_group_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="required">
                                                    <a data-container="body" data-toggle="popover"
                                                       data-trigger="hover" data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.username.description') }}</p>
                                                        <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.username.benefits') }}</p>
                                                        <h6>Example</h6><p>{{ config('fields_info.about_form_fields.general_registration.employee.username.example') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    User Name</label>
                                                <input tabindex="45" type="text" name="username" id="username"
                                                       data-rule-required="true" data-msg-required="Please Enter UserName"
                                                       class="inputs_up form-control" placeholder="User Name"
                                                       onBlur="check_username()" value="{{ old('username') }}">
                                                <span id="username_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="required">
                                                    <a data-container="body" data-toggle="popover"
                                                       data-trigger="hover" data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.email.description') }}</p>
                                                        <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.email.benefits') }}</p>
                                                        <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.email.example') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Email</label>
                                                <input tabindex="46" type="email" name="email" id="email"
                                                       data-rule-required="true" data-msg-required="Please Enter Email"
                                                       class="inputs_up form-control" placeholder="Email"
                                                       onBlur="check_email()" value="{{ old('email') }}">
                                                <span id="email_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="required">
                                                    <a data-container="body" data-toggle="popover"
                                                       data-trigger="hover" data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.email.description') }}</p>
                                                        <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.email.benefits') }}</p>
                                                        <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.email.example') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Confirm Email</label>
                                                <input tabindex="47" type="email" name="email_confirmation"
                                                       id="email_confirmation" data-rule-required="true"
                                                       data-msg-required="Please Enter Email Confirmation"
                                                       class="inputs_up form-control" placeholder="Email Confirmation"
                                                       value="{{ old('email_confirmation') }}">
                                                <span id="email_confirmation_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                        <button tabindex="48" type="submit" name="save" id="save"
                                class="btn btn-sm btn-success">
                            <i class="fa fa-floppy-o"></i> Save
                        </button>
                        <span id="demo28" class="validate_sign"></span>
                    </div>
                </form>
            </div> <!-- white column form ends here -->


        </div>


    </div>
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkFormExcel() {
            let excel = document.getElementById("add_employee_excel"),
                validateInputIdArray = [
                    excel.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }

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
    {{--    <script> --}}
    {{--        $('.save_button').click(function () { --}}
    {{--            jQuery(".pre-loader").fadeToggle("medium"); --}}
    {{--        }); --}}
    {{--    </script> --}}
    {{-- end of required input validation --}}
    {{--    <script> --}}
    {{--        $("#save").click(function () { --}}
    {{--            checkForm(); --}}
    {{--        }); --}}
    {{--    </script> --}}

    <script>
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        jQuery("#refresh_department").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_department",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#user_department_id").html(" ");
                    jQuery("#user_department_id").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
        jQuery("#refresh_designation").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_designation",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#designation").html(" ");
                    jQuery("#designation").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_parent_head").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_parent_head",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#parent_head").html(" ");
                    jQuery("#parent_head").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_group").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_accounting_group",
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
        jQuery('#user_department_id').select2();
        jQuery('#designation').select2();
        jQuery('#branch').select2();
        jQuery("#parent_head").select2();
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

            $('#pimage').change(function () {
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
                $('#make_loan_account').prop("checked", false);
            }
        });

        jQuery("#make_credentials").change(function () {

            if ($(this).is(':checked')) {
                $(".credentials_div *").prop('disabled', false);
            } else {
                $(".credentials_div *").prop('disabled', true);
            }
        });


        function validate_form() {
            // var account = document.getElementById("account").value;
            var parent_head = document.getElementById("parent_head").value;
            var product_reporting_group = document.getElementById("product_reporting_group").value;
            var group = document.getElementById("group").value;
            var name = document.getElementById("name").value;
            var fname = document.getElementById("fname").value;
            var username = document.getElementById("username").value;
            var email = document.getElementById("email").value;
            var mobile = document.getElementById("mobile").value;
            var cnic = document.getElementById("cnic").value;
            // var address = document.getElementById("address").value;
            // var pimage = document.getElementById("pimage").value;
            // var salary = document.getElementById("salary").value;
            var user_type = document.getElementById("user_type").value;
            var designation = document.getElementById("designation").value;
            var commission = document.getElementById("commission").value;
            var target_amount = document.getElementById("target_amount").value;
            var role = document.getElementById("role").value;
            var modular_group = document.getElementById("modular_group").value;

            var flag_submit = true;
            var focus_once = 0;


            if (cnic != "") {


                if (!validatecnic(cnic)) {
                    document.getElementById("cnic_error_msg").innerHTML = "(36000-1234567-8) or (3600012345678)";
                    if (focus_once == 0) {
                        jQuery("#cnic").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("cnic_error_msg").innerHTML = "";
                }
            }


            return flag_submit;
        }


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
            var uname = /^[a-zA-Z0-9]{2,40}$/; //Alphanumeric without spaces
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

    {{--    <script>--}}
    {{--        jQuery("#account_code").change(function() {--}}

    {{--            var account_code = jQuery('option:selected', this).val();--}}

    {{--            jQuery("#account_name").select2("destroy");--}}
    {{--            jQuery('#account_name option[value="' + account_code + '"]').prop('selected', true);--}}
    {{--            jQuery("#account_name").select2();--}}
    {{--        });--}}

    {{--        jQuery("#account_name").change(function() {--}}

    {{--            var account_name = jQuery('option:selected', this).val();--}}

    {{--            jQuery("#account_code").select2("destroy");--}}
    {{--            jQuery('#account_code option[value="' + account_name + '"]').prop('selected', true);--}}
    {{--            jQuery("#account_code").select2();--}}
    {{--        });--}}

    {{--    </script>--}}

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
    </script>
@endsection
