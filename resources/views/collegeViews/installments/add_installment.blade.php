@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Booked Student Package Details</h4>
                        </div>
                        <div class="list_btn">
                            <a class="btn list_link add_more_button"
                               href="{{ route('finalized_package_posting_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="pd-20 bg-white border-radius-4 box-shadow">
                            <table>
                                <tr>
                                    <td class="tbl_txt_70" colspan="4">
                                        <table>
                                            <tr>
                                                <th class="tbl_txt_20"><img src="{{ $student->profile_pic }}"
                                                                            style="border-radius:50%; position:relative; cursor:pointer;  width: 100px; height: 100px;
                                                        ">
                                                </th>
                                                <th class="tbl_txt_80 pl-2"><b
                                                        style="color: #6610f2">{{ $student->full_name }} |
                                                        {{ $student->registration_no }} | {{ $student->status }}</b>
                                                    <br/>
                                                    {{ $student->class_name }} - {{$student->section_name}}
                                                    <br/>
                                                    @if ($student->hostel == 'Yes')
                                                        <span
                                                            class="badge rounded-pill bg-success text-white">Hostel</span>
                                                    @endif
                                                    @if ($student->transport == 'Yes')
                                                        <span
                                                            class="badge rounded-pill bg-success text-white">Transport</span>
                                                    @endif
                                                    @if ($student->zakat == 'Yes')
                                                        <span
                                                            class="badge rounded-pill bg-success text-white">Zakat</span>
                                                    @endif

                                                </th>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="tbl_txt_30">
                                        <table>
                                            <tr>
                                                <th class="tbl_txt_50">Contact</th>
                                                <th class="tbl_txt_50 text-right">{{ $student->contact }}</th>
                                            <tr>
                                            <tr>
                                                <th class="tbl_txt_50">Parent</th>
                                                <th class="tbl_txt_50 text-right">{{ $student->father_name }}</th>
                                            <tr>
                                                <th class="tbl_txt_50">Religion</th>
                                                <th class="tbl_txt_50 text-right">{{ $student->religion }}</th>
                                            </tr>
                                            <tr>
                                                <th class="tbl_txt_50">Date Of Admission</th>
                                                <th class="tbl_txt_50 text-right">{{ $student->admission_date }}</th>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Date of Birth</th>
                                    <th>{{ $student->dob }}</th>
                                    <th>Registration</th>
                                    <th>{{ $student->registration_no }}</th>
                                    <th>City</th>
                                    <th>{{ $student->city }}</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <hr/>

                <form name="reverse_voucher " id="reverse_voucher" action="{{ route('reverse_advance_fee_voucher') }}"
                      method="post" onsubmit="return confirmReverse()">
                    @csrf
                    <input name="adv_id" id="adv_id" type="hidden">
                    <input name="reg_no" id="reg_no" type="hidden">
                </form>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="pd-20 bg-white border-radius-4 box-shadow">
                            <h4>
                                Booked Package:
                                <table class="table table-striped table-bordered mb-0" style="display:block;">
                                    <thead>
                                    <tr>
                                        <th>Booked</th>
                                        <th>Increase</th>
                                        <th>Discount</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{ number_format($student->package,2) }}</td>
                                        <td>{{number_format($student_packages->sum('sp_increase'),2)}}</td>
                                        <td>{{number_format($student_packages->sum('sp_discount'),2)}}</td>
                                        <td>{{ number_format(($student->package + $student_packages->sum('sp_increase') + $student_packages->sum('sp_discount')),2) }}</td>
                                    </tr>
                                    </tbody>
                                </table>

                            </h4>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="pd-20 bg-white border-radius-4 box-shadow">
                            <div class="tab">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link text-blue" data-toggle="tab" href="#personal"
                                           role="tab" aria-selected="true">Package</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-blue" data-toggle="tab" href="#fee_installments"
                                           role="tab"
                                           aria-selected="false">Fee Installments</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active text-blue" data-toggle="tab" href="#fee_payment"
                                           role="tab"
                                           aria-selected="false">Fee Payment</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-blue" data-toggle="tab" href="#custom_voucher"
                                           role="tab"
                                           aria-selected="false">Custom Voucher</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-blue" data-toggle="tab" href="#transport_voucher"
                                           role="tab"
                                           aria-selected="false">Transport Voucher</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-blue" data-toggle="tab" href="#advance_voucher"
                                           role="tab"
                                           aria-selected="false">Advance Voucher</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-blue" data-toggle="tab" href="#attendance" role="tab"
                                           aria-selected="false">Attendance</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-blue" data-toggle="tab" href="#exams" role="tab"
                                           aria-selected="false">Exams</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane fade " id="personal" role="tabpanel">
                                        <div class="pd-20">
                                            <!-- start Package details list code  -->
                                            <h3 class="bg-light py-2">Package Details</h3>
                                            <hr>
                                            <div class="row">
                                                <ul class="col-12">
                                                    @php
                                                        $use_package_amount=0;
                                                    @endphp
                                                    @foreach ($student_packages as $package)
                                                        @php
                                                            $use_package_amount = $package->sp_package_amount;
                                                        @endphp
                                                        <div
                                                            class="my-2 col-lg-12 col-md-12 col-sm-12 col-xs-12 bg-light">
                                                            <li><a
                                                                    onclick="package_detail('{{ $package->sp_finalized }}',{{ $package->sp_id }})"><b
                                                                        style="color:orange"></b>
                                                                    <b>{{$package->sp_package_type == 1 ? '(Regular)':'(Arrears)'}} {{$package->semester_name}}  </b> {{ number_format
                                                                    ($package->sp_package_amount) }}

                                                                </a>
                                                                {{ $package->sp_start_m }}-{{ $package->sp_start_y }} -
                                                                {{ $package->sp_end_m }}-{{ $package->sp_end_y }} <b
                                                                    class="badge rounded-pill
                                                                {{$package->sp_finalized == 'Finalized' ? 'bg-success text-white':'bg-warning'}} "> {{
                                                                                                                        $package->sp_finalized }}</b>
                                                                @if($package->sp_finalized == 'Finalized')
                                                                    <button type="button"
                                                                            class="btn btn-sm {{$package->sp_installment_status == 0 ? 'btn-primary': 'btn-success'}} float-right"
                                                                            onclick="installment_detail({{$package->sp_id}})
                                                                                ">{{$package->sp_installment_status == 0 ? 'Add Installment': 'Already Created'}}
                                                                    </button>
                                                                @endif
                                                            </li>
                                                        </div>
                                                    @endforeach
                                                    @php
                                                        $total_adv_amount = $advance_vouchers->sum('afv_total_amount');
                                                        $grand_fee_amount = $total_adv_amount + $use_package_amount;
                                                    @endphp
                                                    <div class="my-2 col-lg-12 col-md-12 col-sm-12 col-xs-12 bg-light">
                                                        <li>
                                                            <b>Advance fee: </b> {{ number_format
                                                                    ($total_adv_amount,2) }}
                                                            </b>
                                                        </li>
                                                    </div>
                                                    <hr/>
                                                    <div class="my-2 col-lg-12 col-md-12 col-sm-12 col-xs-12 bg-light">
                                                        <li>

                                                            <b>Total fee: </b> {{ number_format
                                                                    ($grand_fee_amount,2 )}}

                                                            </b>

                                                        </li>
                                                    </div>
                                                    <hr/>
                                                    <input type="hidden" id="term_amount">
                                                </ul>
                                            </div>
                                            <!-- end Package details code  -->
                                            <!-- start Package discount and increse list code  -->
                                            <h3 class="bg-light py-2">Increase Decrease Package</h3>
                                            <hr>
                                            <div class="row">
                                                <ul class="col-12">
                                                    @foreach ($increase_discounts as $item)
                                                        <div
                                                            class="my-2 col-lg-12 col-md-12 col-sm-12 col-xs-12 bg-light">
                                                            <li><a href="{{$item->di_image}}" target="_blank"><img
                                                                        src="{{$item->di_image}}"
                                                                        style="height: 25px;"/></a>
                                                                <b>{{$item->semester_name}} </b> <b
                                                                    class="badge rounded-pill bg-info text-white">{{$item->di_entry_type == 1 ? 'Discount':'Increase'}}
                                                                </b>
                                                                <b>Created By </b><b
                                                                    class="badge rounded-pill bg-info text-white">{{$item->created }}
                                                                </b>
                                                                <b>Created Date </b><b
                                                                    class="badge rounded-pill bg-info text-white">{{$item->di_created_datetime }}
                                                                </b>
                                                                <b>Posted By </b><b
                                                                    class="badge rounded-pill bg-success text-white">{{$item->posted }}
                                                                </b><b>Posted Date </b><b
                                                                    class="badge rounded-pill bg-info text-white">{{$item->di_update_datetime }}
                                                                </b>
                                                                <b
                                                                    class="badge rounded-pill
                                                                {{$item->di_status_update == 1 ? 'bg-success text-white':'bg-warning'}} ">
                                                                    {{$item->di_status_update == 1 ? 'Posted':'Pending'}}</b> {{ number_format($item->di_amount) }}

                                                            </li>
                                                        </div>
                                                    @endforeach
                                                    <input type="hidden" id="term_amount">
                                                </ul>
                                            </div>
                                            <!-- end Package discount and increase list code  -->
                                            <!-- start make and installments code  -->
                                            <div class="row" id="main_voucher_div" style="display: block">
                                                <div id="invoice_con" class="invoice_con for_voucher">
                                                    <!-- invoice container start -->
                                                    <div id="invoice_bx" class="invoice_bx show_scale show_rotate">
                                                        <!-- invoice box start -->
                                                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                                            <!-- invoice scroll box start -->
                                                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                                                <!-- invoice content start -->
                                                                <div class="invoice_row bg-white">
                                                                    <!-- invoice row start -->
                                                                    <!-- start create packge form  -->
                                                                    <form name="f1" class="f1" id="f1"
                                                                          action="{{ route('submit_student_package') }}"
                                                                          onsubmit="return checkForm()" method="post"
                                                                          autocomplete="off" style="width: 100%">
                                                                        @csrf
                                                                        <input type="hidden" name="package_id"
                                                                               id="package_id">
                                                                        <div class="invoice_row ">
                                                                            <input type="hidden" name="std_id"
                                                                                   value="{{ $student->id }}">

                                                                            <div
                                                                                class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                                                <div class="input_bx">
                                                                                    <!-- start input box -->

                                                                                    <div
                                                                                        class="custom-control custom-radio mb-10 mt-1">
                                                                                        <input tabindex="17"
                                                                                               type="radio"
                                                                                               name="package_type"
                                                                                               class="custom-control-input package_type"
                                                                                               id="regular"
                                                                                               value="1" {{ old('package_type') == 1 ? 'checked' : '' }}>
                                                                                        <label
                                                                                            class="custom-control-label"
                                                                                            for="regular">
                                                                                            <strong>Regular</strong>
                                                                                        </label>
                                                                                    </div>

                                                                                    <div
                                                                                        class="custom-control custom-radio mb-10 mt-1">
                                                                                        <input tabindex="18"
                                                                                               type="radio"
                                                                                               name="package_type"
                                                                                               class="custom-control-input package_type"
                                                                                               id="arrears"
                                                                                               value="2"{{ old('package_type') == 2 ? 'checked' : '' }}>
                                                                                        <label
                                                                                            class="custom-control-label"
                                                                                            for="arrears">
                                                                                            <strong>Arrears</strong>
                                                                                        </label>
                                                                                    </div>
                                                                                    <span id="package_type_error_msg"
                                                                                          class="validate_sign"> </span>
                                                                                </div><!-- end input box -->
                                                                            </div>
                                                                            <table
                                                                                class="table table-striped table-bordered mb-0"
                                                                                id="student_package">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th class="required">SEMESTER</th>
                                                                                    <th class="required">START MONTH
                                                                                    </th>
                                                                                    <th class="required">END MONTH</th>
                                                                                    <th class="required">TUITION FEE
                                                                                    </th>
                                                                                    <th class="required">PAPER FUND</th>
                                                                                    <th class="required">ANNUAL FUND
                                                                                    </th>
                                                                                    <th class="required">ZAKAT FUND</th>
                                                                                    <th>Package</th>
                                                                                    <td>Action</td>
                                                                                </tr>
                                                                                </thead>
                                                                                <tr>
                                                                                    <td>
                                                                                        <select
                                                                                            class="inputs_up form-control"
                                                                                            type="text"
                                                                                            name="semester_master"
                                                                                            id="semester_master"
                                                                                            data-rule-required="true"
                                                                                            data-msg-required="Semester">
                                                                                            <option value="" selected
                                                                                                    disabled>Select
                                                                                            </option>
                                                                                            @foreach($semesters as $semester)
                                                                                                <option
                                                                                                    value="{{$semester->semester_id}}">{{$semester->semester_name}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        <input type="hidden"
                                                                                               name="recindex" value=""
                                                                                               data-rule-required="true"
                                                                                               data-msg-required="Please Add">
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex">
                                                                                            <select
                                                                                                style="height:30px; width:80px; float:left;"
                                                                                                name="start_m"
                                                                                                id="start_m"
                                                                                                class="inputs_up form-control"
                                                                                                data-rule-required="true"
                                                                                                data-msg-required="Start Month">
                                                                                                <option value=""
                                                                                                        selected
                                                                                                        disabled>...
                                                                                                </option>
                                                                                                <option value="01">Jan
                                                                                                </option>
                                                                                                <option value="02">Feb
                                                                                                </option>
                                                                                                <option value="03">Mar
                                                                                                </option>
                                                                                                <option value="04">Apr
                                                                                                </option>
                                                                                                <option value="05">May
                                                                                                </option>
                                                                                                <option value="06">Jun
                                                                                                </option>
                                                                                                <option value="07">Jul
                                                                                                </option>
                                                                                                <option value="08">Aug
                                                                                                </option>
                                                                                                <option value="09">Sep
                                                                                                </option>
                                                                                                <option value="10">Oct
                                                                                                </option>
                                                                                                <option value="11">Nov
                                                                                                </option>
                                                                                                <option value="12">Dec
                                                                                                </option>
                                                                                            </select>

                                                                                            @php
                                                                                                $mid_year=$currentYear + 10;
                                                                                            @endphp
                                                                                            <select name="start_y"
                                                                                                    id="start_y"
                                                                                                    style="height:30px; width:80px;"
                                                                                                    class="inputs_up form-control"
                                                                                                    data-rule-required="true"
                                                                                                    data-msg-required="Start Year">
                                                                                                <option value=""
                                                                                                        selected
                                                                                                        disabled>...
                                                                                                </option>
                                                                                                @for($y=$currentYear-1; $y<$mid_year; $y++)
                                                                                                    <option
                                                                                                        value="{{$y}}"> {{$y}}</option>
                                                                                                @endfor
                                                                                            </select>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex">
                                                                                            <select
                                                                                                style="height:30px; width:80px; float:left;"
                                                                                                name="end_m" id="end_m"
                                                                                                class="inputs_up form-control"
                                                                                                data-rule-required="true"
                                                                                                data-msg-required="End Month">
                                                                                                <option value=""
                                                                                                        selected
                                                                                                        disabled>...
                                                                                                </option>
                                                                                                <option value="01">Jan
                                                                                                </option>
                                                                                                <option value="02">Feb
                                                                                                </option>
                                                                                                <option value="03">Mar
                                                                                                </option>
                                                                                                <option value="04">Apr
                                                                                                </option>
                                                                                                <option value="05">May
                                                                                                </option>
                                                                                                <option value="06">Jun
                                                                                                </option>
                                                                                                <option value="07">Jul
                                                                                                </option>
                                                                                                <option value="08">Aug
                                                                                                </option>
                                                                                                <option value="09">Sep
                                                                                                </option>
                                                                                                <option value="10">Oct
                                                                                                </option>
                                                                                                <option value="11">Nov
                                                                                                </option>
                                                                                                <option value="12">Dec
                                                                                                </option>
                                                                                            </select>

                                                                                            <select id="end_y"
                                                                                                    name="end_y"
                                                                                                    style="height:30px; width:80px;"
                                                                                                    class="inputs_up form-control"
                                                                                                    data-rule-required="true"
                                                                                                    data-msg-required="End Year">
                                                                                                <option value="">...
                                                                                                </option>
                                                                                                @for($y=$currentYear-2; $y<$mid_year; $y++)
                                                                                                    <option
                                                                                                        value="{{$y}}"> {{$y}}</option>
                                                                                                @endfor
                                                                                            </select>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input
                                                                                            class="inputs_up form-control"
                                                                                            type="text"
                                                                                            id="T_package_amount"
                                                                                            name="T_package_amount"
                                                                                            value=""
                                                                                            data-rule-required="true"
                                                                                            data-msg-required="Tuition Fee"
                                                                                            onkeyup="calculate_package_amount();">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input
                                                                                            class="inputs_up form-control"
                                                                                            type="text"
                                                                                            id="P_package_amount"
                                                                                            name="P_package_amount"
                                                                                            value=""
                                                                                            data-rule-required="true"
                                                                                            data-msg-required="Paper Fund"
                                                                                            onkeyup="calculate_package_amount();">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input
                                                                                            class="inputs_up form-control"
                                                                                            type="text"
                                                                                            id="A_package_amount"
                                                                                            name="A_package_amount"
                                                                                            value=""
                                                                                            data-rule-required="true"
                                                                                            data-msg-required="Annual Fund"
                                                                                            onkeyup="calculate_package_amount();"><input
                                                                                            class="inputs_up form-control"
                                                                                            type="hidden"
                                                                                            id="E_package_amount"
                                                                                            name="E_package_amount"
                                                                                            required value="0"
                                                                                            onkeyup="calculate_package_amount();">
                                                                                    </td>
                                                                                    <td><input
                                                                                            class="inputs_up form-control"
                                                                                            type="text"
                                                                                            id="Z_package_amount"
                                                                                            name="Z_package_amount"
                                                                                            {{$student->zakat == 'Yes' ? '': 'readonly'}}
                                                                                            value=""
                                                                                            onkeyup="calculate_package_amount();">
                                                                                    </td>
                                                                                    <input type="hidden"
                                                                                           id="total_package_value"
                                                                                           name="total_package_value"
                                                                                           readonly>
                                                                                    <td class="total_package_value">

                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="hidden"
                                                                                               name="sessionid" required
                                                                                               value="">

                                                                                        <button tabindex="8"
                                                                                                type="submit"
                                                                                                name="save" id="save"
                                                                                                class="invoice_frm_btn btn btn-sm btn-success">
                                                                                            <i class="fa fa-floppy-o"></i>
                                                                                            Save
                                                                                        </button>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </form>
                                                                    <!-- end create packge form  -->
                                                                </div>
                                                                <h4 class="bg-white pt-3">
                                                                    <button class="btn btn-sm btn-info" type="button"
                                                                            data-toggle="collapse"
                                                                            data-target="#collapseExample"
                                                                            aria-expanded="false"
                                                                            aria-controls="collapseExample">+
                                                                    </button>
                                                                    Discount / Increase
                                                                </h4>
                                                                <div class="collapse" id="collapseExample">
                                                                    <div class="card card-body">
                                                                        <!-- start create discount and increase form  -->
                                                                        <form name="f2" class="f2" id="f2"
                                                                              action="{{ route('submit_discount_increase_package') }}"
                                                                              onsubmit="return checkDisIncForm()"
                                                                              style="width: 100%" method="post"
                                                                              enctype="multipart/form-data">
                                                                            @csrf
                                                                            <div class="invoice_row ">
                                                                                <h5 class="text-danger"><b>Note:</b>
                                                                                    Discount & Increase amount apply
                                                                                    only last package</h5>
                                                                            </div>
                                                                            <div class="invoice_row ">
                                                                                <input type="hidden" name="disc_std_id"
                                                                                       value="{{ $student->id }}">
                                                                                <div
                                                                                    class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                                                    <div class="input_bx">
                                                                                        <label class="required">Entry
                                                                                            Type</label>
                                                                                        <div
                                                                                            class="custom-control custom-radio mb-10 mt-1">
                                                                                            <input tabindex="12"
                                                                                                   type="radio"
                                                                                                   name="entry_type"
                                                                                                   class="custom-control-input entry_type"
                                                                                                   id="discount"
                                                                                                   value="1"
                                                                                                   data-msg-required="Check Entry Type"
                                                                                                   data-rule-required="true">
                                                                                            <label
                                                                                                class="custom-control-label"
                                                                                                for="discount">Discount</label>
                                                                                        </div>
                                                                                        <div
                                                                                            class="custom-control custom-radio mb-10 mt-1">
                                                                                            <input tabindex="13"
                                                                                                   type="radio"
                                                                                                   name="entry_type"
                                                                                                   class="custom-control-input entry_type"
                                                                                                   id="increase"
                                                                                                   value="2"
                                                                                                   data-msg-required="Check Entry Type"
                                                                                                   data-rule-required="true">
                                                                                            <label
                                                                                                class="custom-control-label"
                                                                                                for="increase">
                                                                                                Increase
                                                                                            </label>
                                                                                        </div>
                                                                                        <span id="entry_type_error_msg"
                                                                                              class="validate_sign"> </span>
                                                                                    </div><!-- end input box -->
                                                                                </div>
                                                                                <div
                                                                                    class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                                                    <div class="input_bx">
                                                                                        <!-- start input box -->
                                                                                        <label class="required">
                                                                                            Amount</label>
                                                                                        <input type="text" name="amount"
                                                                                               id="amount" value=""
                                                                                               class="inputs_up form-control"
                                                                                               placeholder="Amount"
                                                                                               onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                                               data-msg-required="Please Enter Amount"
                                                                                               data-rule-required="true">

                                                                                    </div><!-- end input box -->
                                                                                </div>
                                                                                <div
                                                                                    class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                                                    <x-upload-image title="Upload"/>
                                                                                </div>
                                                                                <div
                                                                                    class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-4">
                                                                                    <button tabindex="8" type="submit"
                                                                                            name="save" id="di_save"
                                                                                            class="invoice_frm_btn btn btn-sm btn-success">
                                                                                        <i class="fa fa-floppy-o"></i>
                                                                                        Save
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                        <!-- end create discount and increase form  -->
                                                                    </div>
                                                                </div>
                                                                <!-- start create installments form  -->
                                                                <h4 class="bg-white pt-3">Installments</h4>
                                                                <div class="invoice_row ">
                                                                    <table
                                                                        class="table table-striped table-bordered mb-0">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>TYPE</th>
                                                                            <th>SEMESTER</th>
                                                                            <th>DURATION</th>
                                                                            <th>TUITION FEE</th>
                                                                            <th>PAPER FUND</th>
                                                                            <th>ANNUAL FUND</th>
                                                                            <th>ZAKAT FUND</th>
                                                                            <th>TOTAL</th>

                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <th id="dis_type"></th>
                                                                            <th id="dis_semester"></th>
                                                                            <th id="dis_month"></th>
                                                                            <th id="dis_t_fee"></th>
                                                                            <th id="dis_p_fund"></th>
                                                                            <th id="dis_a_fund"></th>
                                                                            <th id="dis_z_fund"></th>
                                                                            <th id="dis_total"></th>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="invoice_row ">
                                                                    <form
                                                                        action="{{ route('submit_student_installment') }}"
                                                                        method="post" autocomplete="off"
                                                                        style="width: 100%"
                                                                        onsubmit="return checkInstallmentForm()">
                                                                        @csrf
                                                                        <input type="hidden" name="package_id"
                                                                               id="s_package_id">
                                                                        <div class="invoice_row d-block">
                                                                            <input type="hidden" name="student_id"
                                                                                   value="{{ $student->id }}">

                                                                            <table
                                                                                class="table table-striped table-bordered mb-0"
                                                                                id="dynamic-table">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>MONTH</th>
                                                                                    <th>TUITION FEE</th>
                                                                                    <th>PAPER FUND</th>
                                                                                    <th>ANNUAL FUND</th>
                                                                                    <th>ZAKAT FUND</th>
                                                                                    <th>TOTAL</th>
                                                                                    <th>SEMESTER</th>

                                                                                </tr>
                                                                                </thead>
                                                                                <tr class="bg-info text-white">
                                                                                    <th colspan="2">Total</th>
                                                                                    <th class="total_t_fee"></th>
                                                                                    <th class="total_p_fund"></th>
                                                                                    <th class="total_a_fund"></th>
                                                                                    <th class="total_z_fund"></th>
                                                                                    <th class="total_value"></th>
                                                                                    <th></th>
                                                                                </tr>
                                                                                <tbody id="ins_body">

                                                                                </tbody>
                                                                                <tfoot>
                                                                                <th colspan="2">Total</th>
                                                                                <th class="total_t_fee">
                                                                                    <input type="hidden"
                                                                                           id="total_t_fee"
                                                                                           name="total_t_fee">
                                                                                </th>
                                                                                <th class="total_p_fund">
                                                                                    <input type="hidden"
                                                                                           id="total_p_fund"
                                                                                           name="total_p_fund">
                                                                                </th>
                                                                                <th class="total_a_fund">
                                                                                    <input type="hidden"
                                                                                           id="total_a_fund"
                                                                                           name="total_a_fund">
                                                                                </th>
                                                                                <th class="total_z_fund">
                                                                                    <input type="hidden"
                                                                                           id="total_z_fund"
                                                                                           name="total_z_fund">
                                                                                </th>
                                                                                <input type="hidden" id="total_value"
                                                                                       name="total_value"
                                                                                       data-rule-required="true"
                                                                                       data-msg-required="Add Installment">
                                                                                <th class="total_value">

                                                                                </th>

                                                                                </tfoot>
                                                                            </table>

                                                                        </div>
                                                                        <div class="invoice_row bg-white">
                                                                            <div
                                                                                class="pro_tbl_con for_voucher_tbl col-lg-12 text-right">
                                                                                <div
                                                                                    class="alert alert-danger alert-dismissible fade show"
                                                                                    role="alert" id="myElement"
                                                                                    style="display: none">
                                                                                    <strong
                                                                                        id="error_installment"></strong>
                                                                                    {{--                                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
                                                                                    {{--                                                                                        <span aria-hidden="true">&times;</span>--}}
                                                                                    </button>
                                                                                </div>
                                                                                <button tabindex="8" type="submit"
                                                                                        name="save" id="si_save"
                                                                                        class="invoice_frm_btn btn btn-sm btn-success">
                                                                                    <i class="fa fa-floppy-o"></i> Save
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </form>

                                                                </div><!-- invoice row end -->
                                                                <!-- end create installments form  -->
                                                                <div class="invoice_row">
                                                                    <div class="pro_tbl_con for_voucher_tbl col-lg-12">
                                                                        <!-- product table container start -->
                                                                        <div class="table-responsive pro_tbl_bx">
                                                                            <!-- product table box start -->


                                                                        </div><!-- product table box end -->
                                                                    </div><!-- product table container end -->
                                                                </div><!-- invoice row end -->

                                                            </div><!-- invoice content end -->
                                                        </div><!-- invoice scroll box end -->
                                                    </div><!-- invoice box end -->
                                                </div><!-- invoice container end -->
                                            </div>
                                            <!-- end make and installments code  -->
                                        </div>
                                    </div>
                                    <!-- start installments list  -->
                                    <div class="tab-pane fade" id="fee_installments" role="tabpanel">
                                        <div class="pd-20">
                                            <!-- discount voucher start-->
                                            <h3 class="bg-light py-2">Fee Installments</h3>
                                            <hr>
                                            <div id="invoice_con" class="invoice_con for_voucher mt-1">
                                                <!-- invoice container start -->
                                                <div id="invoice_bx" class="show_scale show_rotate">
                                                    <!-- invoice box start -->
                                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                                        <!-- invoice scroll box start -->
                                                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                                            <!-- invoice content start -->
                                                            @php use App\Models\College\StudentInstallment; @endphp
                                                            @foreach($student_packages as $index=>$semester)
                                                                <h6>{{$semester->semester_name}}</h6>
                                                                <hr>
                                                                <p>
                                                                    <span
                                                                        class="badge rounded-pill bg-success text-white">Total*:{{$semester->sp_package_amount}}</span>
                                                                    <span class="badge rounded-pill text-white"
                                                                          style="background: #309286;"
                                                                    >Paid:<span
                                                                            id="paid_amount{{$index}}"></span></span>
                                                                    <span
                                                                        class="badge rounded-pill bg-warning text-dark">Pending:<span
                                                                            id="pending_amount{{$index}}"></span></span>
                                                                    <span
                                                                        class="badge rounded-pill bg-secondary text-white">Zakat:{{$semester->sp_Z_package_amount}}</span>
                                                                </p>

                                                                <table class="table table-striped table-bordered">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Type</th>
                                                                        <th>Month</th>
                                                                        <th>FID</th>
                                                                        <th>Tuition Fee</th>
                                                                        <th>Paper Fund</th>
                                                                        <th>Annual Fund</th>
                                                                        <th>Zakat Fund</th>
                                                                        <th>Payable</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                    </thead>


                                                                    @php $installments = StudentInstallment::where('si_semester_id',$semester->sp_semester)->where('si_std_id',$student->id)->get();
                                                                        $paid_amount =0;
                                                                        $pending_amount =0;
                                                                    @endphp
                                                                    <tbody>
                                                                    @foreach($installments as $installment)
                                                                        @php
                                                                            if( $installment->si_status_update==1){
                                                                                $paid_amount =$paid_amount + $installment->si_total_amount;
                                                                            }
                                                                            $pending_amount = $semester->sp_package_amount - $paid_amount;
                                                                        @endphp
                                                                        <tr>
                                                                            <td>{{$installment->si_instalment_no}}</td>
                                                                            <td>{{$installment->si_package_type == 1 ? 'Regular': 'Arrears'}}</td>
                                                                            <td>{{$installment->si_month_year}}</td>
                                                                            <td>{{$installment->si_fid}}</td>
                                                                            <td>{{$installment->si_t_fee}}</td>
                                                                            <td>{{$installment->si_p_fund}}</td>
                                                                            <td>{{$installment->si_a_fund}}</td>
                                                                            <td>{{$installment->si_z_fund}}</td>
                                                                            <td>{{$installment->si_total_amount}}</td>
                                                                            <td><span class="badge rounded-pill {{
                                                                            $installment->si_status_update==0 ? 'bg-secondary voucher ' : (
                                                                            ($installment->si_status_update == 3 ) ? 'bg-danger' :
                                                                            'bg-success')}} text-white" data-id="{{
                                                                            $installment->si_id }}" data-std_id="{{
                                                                            $installment->si_std_id }}" data-month="{{
                                                                            $installment->si_month_year }}">
                                                                            {{ $installment->si_status_update==0 ? 'Generate' : (($installment->si_status_update == 3 ) ? 'Pending' :
                                                                            'Paid')}}
                                                                                </span>
                                                                            </td>
                                                                            <script>
                                                                                $('#paid_amount{!! $index !!}').html('{!! $paid_amount !!}');
                                                                                $('#pending_amount{!! $index !!}').html('{!! $pending_amount !!}');
                                                                            </script>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end installments list  -->
                                    <!-- start fee voucher create and list  -->
                                    <div class="tab-pane fade show active" id="fee_payment" role="tabpanel">
                                        <div class="pd-20">
                                            <!-- discount voucher start-->
                                            <h3 class="bg-light py-2">Fee Voucher</h3>
                                            <hr>
                                            <div id="invoice_con" class="invoice_con for_voucher">
                                                <!-- invoice container start -->
                                                <div id="invoice_bx" class="show_scale show_rotate">
                                                    <!-- invoice box start -->
                                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                                        <!-- invoice scroll box start -->
                                                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                                            <!-- invoice content start -->
                                                            @php use App\Models\College\FeeVoucherModel;

                                                            @endphp
                                                            @foreach($student_packages as $index=>$semester)
                                                                <h6>{{$semester->semester_name}}</h6>
                                                                <hr>
                                                                <p>
                                                                    <span
                                                                        class="badge rounded-pill bg-success text-white">Total*:{{$semester->sp_package_amount}}</span>
                                                                    <span class="badge rounded-pill text-white"
                                                                          style="background: #309286;">Paid:<spna
                                                                            id="v_paid_amount{{$index}}"></spna></span>
                                                                    <span
                                                                        class="badge rounded-pill bg-warning text-dark">Pending:<spna
                                                                            id="v_pending_amount{{$index}}"></spna></span>
                                                                </p>
                                                                <table class="table table-striped table-bordered mb-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Month</th>
                                                                        <th>FID</th>
                                                                        <th>Issue Date</th>
                                                                        <th>Due Date</th>
                                                                        <th>Payable</th>
                                                                        <th>Status</th>
                                                                        <th>Paid At</th>
                                                                        <th>Action</th>
                                                                        <th>Change Due Date</th>
                                                                    </tr>
                                                                    </thead>


                                                                    @php $vouchers = FeeVoucherModel::where('fv_semester_id',$semester->sp_semester)->where('fv_std_id',$student->id)->get();
  $pending_amount=0;
                                                            $paid_amount=0;
 @endphp
                                                                    <tbody>
                                                                    @foreach($vouchers as $voucher)
                                                                        @php
                                                                            if( $voucher->fv_status_update==1){
                                                                                $paid_amount =$paid_amount + $voucher->fv_total_amount;
                                                                            }
                                                                            $pending_amount = $semester->sp_package_amount - $paid_amount;
                                                                        @endphp
                                                                        <tr>
                                                                            <td>{{$voucher->fv_month}}</td>
                                                                            <td>{{$voucher->fv_v_no}}</td>
                                                                            <td>{{ date('d-M-y', strtotime(str_replace('/', '-', $voucher->fv_issue_date))) }}</td>
                                                                            <td>{{ date('d-M-y', strtotime(str_replace('/', '-', $voucher->fv_due_date))) }}</td>
                                                                            <td>{{$voucher->fv_total_amount}}</td>
                                                                            <td class="text-center"><span class="badge rounded-pill {{$voucher->fv_status_update == 0 ? 'bg-warning' :
                                                                        'bg-success'}}">{{$voucher->fv_status_update == 0 ? 'Pending' : 'Paid'}}</span>
                                                                            </td>
                                                                            <td>{{$voucher->fv_paid_date}}</td>
                                                                            <td class="text-center">
                                                                                <span
                                                                                    class="badge rounded-pill text-dark {{$voucher->fv_status_update == 0 ? 'bg-warning fee_voucher_view' : 'bg-info fee_voucher_view'}}"
                                                                                    data-fee_id="{{ $voucher->fv_v_no }}"
                                                                                    data-reg_no="{{ $voucher->fv_std_reg_no }}">{{$voucher->fv_status_update == 0 ? 'Print Voucher' : 'View'}}
                                                                                    </span>
                                                                                {{--                                                                                <span class="badge rounded-pill bg-primary text-white">Edit</span>--}}
                                                                                {{--                                                                                <span class="badge rounded-pill bg-success text-white">Pay</span>--}}
                                                                                {{--                                                                                <span class="badge rounded-pill bg-danger text-white">Delete</span>--}}
                                                                                {{--                                                                                <span class="badge rounded-pill bg-info text-white">Invoice Generate</span>--}}
                                                                            </td>
                                                                            <td>
                                                                                @if($voucher->fv_status_update == 0)
                                                                                    <form
                                                                                        action="{{route('update_due_date',$voucher->fv_id)}}"
                                                                                        method="post">
                                                                                        @csrf
                                                                                        <input type="hidden" value="fv"
                                                                                               name="type">
                                                                                        <!-- start input box -->
                                                                                        <div class="d-flex">
                                                                                            <input type="hidden"
                                                                                                   name="student_id"
                                                                                                   value="{{$student->id}}">
                                                                                            <input tabindex="6"
                                                                                                   type="text"
                                                                                                   name="due_date"
                                                                                                   class="inputs_up form-control datepicker1"
                                                                                                   data-rule-required="true"
                                                                                                   data-msg-required="Please Enter Due Date"
                                                                                                   autocomplete="off"
                                                                                                   placeholder="Due Date ......"/>
                                                                                            <button tabindex="8"
                                                                                                    type="submit"
                                                                                                    name="save"
                                                                                                    id="due_save"
                                                                                                    class="invoice_frm_btn btn btn-sm btn-success">
                                                                                                <i class="fa fa-floppy-o"></i>
                                                                                                Save
                                                                                            </button>
                                                                                        </div>
                                                                                    </form>
                                                                                @endif
                                                                            </td>
                                                                            <script>
                                                                                $('#v_paid_amount{!! $index !!}').html('{!! $paid_amount !!}');
                                                                                $('#v_pending_amount{!! $index !!}').html('{!! $pending_amount !!}');
                                                                            </script>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end fee voucher create and list  -->
                                    <!-- start custom voucher create and list  -->
                                    <div class="tab-pane fade" id="custom_voucher" role="tabpanel">
                                        <div class="pd-20">
                                            <!-- discount voucher start-->
                                            <h3>Custom Voucher</h3>
                                            <hr/>
                                            <div id="invoice_con" class="invoice_con for_voucher p-2">
                                                <!-- invoice container start -->
                                                <div id="invoice_bx" class="invoice_bx show_scale show_rotate">
                                                    <!-- invoice box start -->
                                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                                        <!-- invoice scroll box start -->
                                                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                                            <!-- invoice content start -->
                                                            <form name="f1" class="f1 pd-20" id="f1"
                                                                  action="{{ route('submit_student_wise_custom_voucher') }}"
                                                                  method="post"
                                                                  onsubmit="return checkForms()">
                                                                @csrf
                                                                <input type="hidden" name="c_student_id"
                                                                       class="form-control" value="{{$student->id}}">
                                                                <input type="hidden" name="c_class_id"
                                                                       class="form-control"
                                                                       value="{{$student->class_id}}">
                                                                <input type="hidden" name="c_section_id"
                                                                       class="form-control"
                                                                       value="{{$student->section_id}}">
                                                                <div class="row">
                                                                    <div
                                                                        class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                                        <div class="input_bx">
                                                                            <!-- start input box -->
                                                                            <label class="required">Type</label>
                                                                            <div
                                                                                class="custom-control custom-radio mb-10 mt-1">

                                                                                <input tabindex="17" type="radio"
                                                                                       name="package_type_cv"
                                                                                       class="custom-control-input package_type_cv"
                                                                                       id="regular_cv"
                                                                                       value="1"
                                                                                       {{ old('package_type') == 1 ? 'checked' : '' }} onclick="cv_save()">
                                                                                <label class="custom-control-label"
                                                                                       for="regular_cv">
                                                                                    <strong>Regular</strong>
                                                                                </label>
                                                                            </div>

                                                                            <div
                                                                                class="custom-control custom-radio mb-10 mt-1">
                                                                                <input tabindex="18" type="radio"
                                                                                       name="package_type_cv"
                                                                                       class="custom-control-input package_type_cv"
                                                                                       id="arrears_cv"
                                                                                       value="2"
                                                                                       {{ old('package_type') == 2 ? 'checked' : '' }} onclick="cv_save()">
                                                                                <label class="custom-control-label"
                                                                                       for="arrears_cv">
                                                                                    <strong>Arrears</strong>
                                                                                </label>
                                                                            </div>
                                                                            <span id="package_type_cv_error_msg"
                                                                                  class="validate_sign"> </span>
                                                                        </div><!-- end input box -->
                                                                    </div>
                                                                    <div class="form-group col-md-3 col-md-3 col-sm-12">
                                                                        <div class="input_bx">
                                                                            <!-- start input box -->
                                                                            <label class="required">
                                                                                Issue Date
                                                                            </label>
                                                                            <input tabindex="6" type="text"
                                                                                   name="issue_date" id="issue_date"
                                                                                   class="inputs_up form-control datepicker1"
                                                                                   data-rule-required="true"
                                                                                   data-msg-required="Please Enter Issue Date"
                                                                                   autocomplete="off"
                                                                                   placeholder="Issue Date ......"
                                                                                   onchange="cv_save()"/>
                                                                            <span id="demo1"
                                                                                  class="validate_sign"> </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-3 col-md-3 col-sm-12">
                                                                        <div class="input_bx">
                                                                            <!-- start input box -->
                                                                            <label class="required">
                                                                                Due Date
                                                                            </label>
                                                                            <input tabindex="6" type="text"
                                                                                   name="due_date" id="due_date"
                                                                                   class="inputs_up form-control datepicker1"
                                                                                   data-rule-required="true"
                                                                                   data-msg-required="Please Enter Due Date"
                                                                                   autocomplete="off"
                                                                                   placeholder="Due Date ......"/>
                                                                            <span id="demo1"
                                                                                  class="validate_sign"> </span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                                                        <div class="input_bx">
                                                                            <!-- start input box -->
                                                                            <label class="required">
                                                                                Components
                                                                            </label>
                                                                            <select tabindex=42 autofocus
                                                                                    name="component[]"
                                                                                    class="form-control"
                                                                                    data-rule-required="true"
                                                                                    data-msg-required="Please Enter Component"
                                                                                    id="component" multiple>
                                                                                {{--                                <option value="" disabled>Select Component</option>--}}
                                                                                @foreach ($components as $component)
                                                                                    <option
                                                                                        value="{{ $component->sfc_id }}">
                                                                                        {{ $component->sfc_name }}
                                                                                        ({{ number_format($component->sfc_amount,2) }}
                                                                                        )
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <span id="demo1"
                                                                                  class="validate_sign"> </span>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="col-lg-1 col-md-1 col-sm-12 text-right mt-4">
                                                                        <button tabindex="1" type="submit" name="save_c"
                                                                                id="save_c"
                                                                                class="save_button btn btn-sm btn-success">
                                                                            <i class="fa fa-floppy-o"></i> Save
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>

                                                        </div>
                                                        <table class="table table-striped table-bordered mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th>Month</th>
                                                                <th>Type</th>
                                                                <th>FID</th>
                                                                <th>Issue Date</th>
                                                                <th>Due Date</th>
                                                                <th>Payable</th>
                                                                <th>Status</th>
                                                                <th>Paid At</th>
                                                                <th>Action</th>
                                                                <th>Change Due Date</th>
                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            @foreach($custom_vouchers as $voucher)
                                                                <tr>
                                                                    <td> {{ date('d-M-y', strtotime(str_replace('/', '-', $voucher->cv_created_datetime))) }}
                                                                    </td>
                                                                    <td>{{$voucher->cv_package_type == 1 ? 'Regular': 'Arrears'}}</td>
                                                                    <td>{{$voucher->cv_v_no}}</td>
                                                                    <td> {{ date('d-M-y', strtotime(str_replace('/', '-', $voucher->cv_issue_date))) }}</td>
                                                                    <td> {{ date('d-M-y', strtotime(str_replace('/', '-', $voucher->cv_due_date))) }}</td>
                                                                    <td>{{$voucher->cv_total_amount}}</td>
                                                                    <td class="text-center"><span class="badge rounded-pill {{$voucher->cv_status == 'Pending' ? 'bg-danger' :
                                                                        'bg-success'}}">{{$voucher->cv_status == 'Pending' ? $voucher->cv_status : 'Paid'}}</span>
                                                                    </td>

                                                                    <td>{{$voucher->cv_paid_date}}</td>
                                                                    <td class="text-center {{$voucher->cv_status == 'Pending' ? 'view':'view'}} "
                                                                        data-id="{{ $voucher->cv_v_no }}"
                                                                        data-reg_no="{{$voucher->cv_reg_no }}">
                                                                        <span
                                                                            class="badge rounded-pill text-dark {{$voucher->cv_status == 'Pending' ? 'bg-warning':'bg-info'}}">{{$voucher->cv_status == 'Pending' ? 'Print Voucher':'View'}}</span>
                                                                        {{--                                                                        <span class="badge rounded-pill bg-primary text-white">Edit</span>--}}
                                                                        {{--                                                                        <span class="badge rounded-pill bg-success text-white">Pay</span>--}}
                                                                        {{--                                                                        <span class="badge rounded-pill bg-danger text-white">Delete</span>--}}
                                                                    </td>
                                                                    <td>
                                                                        @if($voucher->cv_status == 'Pending')
                                                                            <form
                                                                                action="{{route('update_due_date',$voucher->cv_id)}}"
                                                                                method="post">
                                                                                @csrf
                                                                                <input type="hidden" value="cv"
                                                                                       name="type">
                                                                                <!-- start input box -->
                                                                                <div class="d-flex">
                                                                                    <input type="hidden"
                                                                                           name="student_id"
                                                                                           value="{{$student->id}}">
                                                                                    <input tabindex="6" type="text"
                                                                                           name="due_date"
                                                                                           class="inputs_up form-control datepicker1"
                                                                                           data-rule-required="true"
                                                                                           data-msg-required="Please Enter Due Date"
                                                                                           autocomplete="off"
                                                                                           placeholder="Due Date ......"/>
                                                                                    <button tabindex="8" type="submit"
                                                                                            name="save" id="due_save"
                                                                                            class="invoice_frm_btn btn btn-sm btn-success">
                                                                                        <i class="fa fa-floppy-o"></i>
                                                                                        Save
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end custom voucher create and list  -->

                                    <!-- start transport voucher create and list  -->
                                    <div class="tab-pane fade" id="transport_voucher" role="tabpanel">
                                        <div class="pd-20">
                                            <!-- discount voucher start-->
                                            <h3 class="bg-light py-2">Transport Voucher</h3>
                                            <hr>
                                            <div id="invoice_con" class="invoice_con for_voucher">
                                                <!-- invoice container start -->
                                                <div id="invoice_bx" class="show_scale show_rotate">
                                                    <!-- invoice box start -->
                                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                                        <!-- invoice scroll box start -->
                                                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                                            <!-- invoice content start -->
                                                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                                                <!-- invoice content start -->
                                                                @if(!empty($student->transport) && $student->transport=='Yes')
                                                                    <form name="f1" class="f1 pd-20" id="f1"
                                                                          action="{{ route('submit_student_wise_transport_voucher') }}"
                                                                          method="post"
                                                                          onsubmit="return checkFormTransport()">
                                                                        @csrf
                                                                        <input type="hidden" name="t_student_id"
                                                                               class="form-control"
                                                                               value="{{$student->id}}">
                                                                        <input type="hidden" name="t_class_id"
                                                                               class="form-control"
                                                                               value="{{$student->class_id}}">
                                                                        <input type="hidden" name="t_section_id"
                                                                               class="form-control"
                                                                               value="{{$student->section_id}}">
                                                                        <div class="row">
                                                                            <div
                                                                                class="form-group col-lg-3 col-md-3 col-sm-12">
                                                                                <div class="input_bx">
                                                                                    <!-- start input box -->
                                                                                    <label class="required">
                                                                                        Dr Account
                                                                                    </label>
                                                                                    <select tabindex=42 autofocus
                                                                                            name="dr_account"
                                                                                            class="form-control"
                                                                                            data-rule-required="true"
                                                                                            data-msg-required="Please Enter Dr Account"
                                                                                            id="dr_account">
                                                                                        <option value="">Select Dr
                                                                                            Account
                                                                                        </option>
                                                                                        @foreach($dr_accounts as $dr_account)
                                                                                            <option
                                                                                                value="{{$dr_account->account_uid}}">{{$dr_account->account_name}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <span id="demo1"
                                                                                          class="validate_sign"> </span>
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="form-group col-lg-3 col-md-3 col-sm-12">
                                                                                <div class="input_bx">
                                                                                    <!-- start input box -->
                                                                                    <label class="required">
                                                                                        Cr Account
                                                                                    </label>
                                                                                    <select tabindex=42 autofocus
                                                                                            name="cr_account"
                                                                                            class="form-control"
                                                                                            data-rule-required="true"
                                                                                            data-msg-required="Please Enter Cr Account"
                                                                                            id="cr_account">
                                                                                        <option value="">Select Cr
                                                                                            Account
                                                                                        </option>
                                                                                        @foreach($cr_accounts as $cr_account)
                                                                                            <option
                                                                                                value="{{$cr_account->account_uid}}">{{$cr_account->account_name}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <span id="demo1"
                                                                                          class="validate_sign"> </span>
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="invoice_col form-group col-lg-3 col-md-3 col-sm-12">
                                                                                <!-- invoice column start -->
                                                                                <div class="invoice_col_bx">
                                                                                    <!-- invoice column box start -->
                                                                                    <div class="invoice_col_ttl">
                                                                                        <!-- invoice column title start -->
                                                                                        Month
                                                                                    </div>
                                                                                    <!-- invoice column title end -->
                                                                                    <div class="invoice_col_input">
                                                                                        <!-- invoice column input start -->
                                                                                        <input tabindex="2" type="text"
                                                                                               name="month" id="t_month"
                                                                                               class="inputs_up form-control month-picker"
                                                                                               autocomplete="off"
                                                                                               value=""
                                                                                               data-rule-required="true"
                                                                                               data-msg-required="Please Enter Month"
                                                                                               placeholder="Start Month ......">
                                                                                        <span id="demo1"
                                                                                              class="validate_sign"
                                                                                              style="float: right !important"> </span>

                                                                                    </div>
                                                                                    <!-- invoice column input end -->
                                                                                </div><!-- invoice column box end -->
                                                                            </div><!-- invoice column end -->
                                                                            <div
                                                                                class="form-group col-md-3 col-md-3 col-sm-12">
                                                                                <div class="input_bx">
                                                                                    <!-- start input box -->
                                                                                    <label class="required">
                                                                                        Issue Date
                                                                                    </label>
                                                                                    <input tabindex="6" type="text"
                                                                                           name="issue_date"
                                                                                           id="t_issue_date"
                                                                                           class="inputs_up form-control datepicker1"
                                                                                           data-rule-required="true"
                                                                                           data-msg-required="Please Enter Issue Date"
                                                                                           autocomplete="off"
                                                                                           placeholder="Issue Date ......"/>
                                                                                    <span id="demo1"
                                                                                          class="validate_sign"> </span>
                                                                                </div>
                                                                            </div>

                                                                            <div
                                                                                class="form-group col-md-3 col-md-3 col-sm-12">
                                                                                <div class="input_bx">
                                                                                    <!-- start input box -->
                                                                                    <label class="required">
                                                                                        Due Date
                                                                                    </label>
                                                                                    <input tabindex="6" type="text"
                                                                                           name="due_date"
                                                                                           id="t_due_date"
                                                                                           class="inputs_up form-control datepicker1"
                                                                                           data-rule-required="true"
                                                                                           data-msg-required="Please Enter Due Date"
                                                                                           autocomplete="off"
                                                                                           placeholder="Due Date ......"/>
                                                                                    <span id="demo1"
                                                                                          class="validate_sign"> </span>
                                                                                </div>
                                                                            </div>

                                                                            <div
                                                                                class="form-group col-lg-3 col-md-3 col-sm-12">
                                                                                <div class="input_bx">
                                                                                    <!-- start input box -->
                                                                                    <label class="required">
                                                                                        Amount
                                                                                    </label>
                                                                                    <input tabindex=42 autofocus
                                                                                           name="amount"
                                                                                           class="form-control inputs_up "
                                                                                           data-rule-required="true"
                                                                                           data-msg-required="Please Enter Amount"
                                                                                           id="t_amount" value="{{$student->route_type==1 ?
                                                                                       $route_price->tr_single_route_amount:($student->route_type==2?$route_price->tr_double_route_amount:'')}}">

                                                                                    <span id="demo1"
                                                                                          class="validate_sign"> </span>
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="col-lg-1 col-md-1 col-sm-12 text-right mt-4">
                                                                                <button tabindex="1" type="submit"
                                                                                        name="save_c" id="save_c"
                                                                                        class="save_button btn btn-sm btn-success">
                                                                                    <i class="fa fa-floppy-o"></i> Save
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                @endif
                                                            </div>

{{--                                                            @foreach($student_packages as $index=>$semester)--}}
                                                                @php
                                                                    $pending_amount=0;
                                                                    $paid_amount=0;
                                                                    $total_amount=0;
                                                                @endphp
                                                                <h6>Transport Voucher
{{--                                                                    {{$semester->semester_name}}--}}
                                                                </h6>
                                                                <hr>

                                                                <p>
                                                                    <span
                                                                        class="badge rounded-pill bg-success text-white">Total*: <spna
                                                                            id="tv_total_amount"></spna></span>
                                                                    <span class="badge rounded-pill text-white"
                                                                          style="background: #309286;">Paid:<spna
                                                                            id="tv_paid_amount"></spna></span>
                                                                    <span
                                                                        class="badge rounded-pill bg-warning text-dark">Pending:<spna
                                                                            id="tv_pending_amount"></spna></span>
                                                                </p>
                                                                <table class="table table-striped table-bordered mb-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Month</th>
                                                                        <th>FID</th>
                                                                        <th>Issue Date</th>
                                                                        <th>Due Date</th>
                                                                        <th>Payable</th>
                                                                        <th>Status</th>
                                                                        <th>Paid At</th>
                                                                        <th>Action</th>
                                                                        <th>Change Due Date</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($transport_vouchers as $voucher)
                                                                        @php
                                                                            if( $voucher->tv_status==1){
                                                                                $paid_amount =$paid_amount + $voucher->tv_total_amount;
                                                                            }else{
                                                                            $pending_amount =$pending_amount + $voucher->tv_total_amount;
                                                                            }
                                                                            $total_amount = $total_amount+$voucher->tv_total_amount;
                                                                        @endphp
                                                                        <tr>
                                                                            <td>{{$voucher->tv_month}}</td>
                                                                            <td>{{$voucher->tv_v_no}}</td>
                                                                            <td>{{ date('d-M-y', strtotime(str_replace('/', '-', $voucher->tv_issue_date))) }}</td>
                                                                            <td>{{ date('d-M-y', strtotime(str_replace('/', '-', $voucher->tv_due_date))) }}</td>
                                                                            <td>{{$voucher->tv_total_amount}}</td>
                                                                            <td class="text-center"><span class="badge rounded-pill {{$voucher->tv_status == 0 ? 'bg-warning' :
                                                                        'bg-success'}}">{{$voucher->tv_status == 0 ? 'Pending' : 'Paid'}}</span>
                                                                            </td>
                                                                            <td>{{$voucher->tv_paid_date}}</td>
                                                                            <td class="text-center">
                                                                                <span
                                                                                    class="badge rounded-pill text-dark {{$voucher->tv_status == 0 ? 'bg-warning transport_voucher_view' : 'bg-info transport_voucher_view'}}"
                                                                                    data-fee_id="{{ $voucher->tv_v_no }}"
                                                                                    data-reg_no="{{ $voucher->tv_reg_no }}"
                                                                                    data-status="{{ $voucher->tv_status }}">{{$voucher->tv_status == 0 ? 'Print Voucher' : 'View'}}
                                                                                    </span>

                                                                            </td>
                                                                            <td>
                                                                                @if($voucher->tv_status == 0)
                                                                                    <form
                                                                                        action="{{route('update_due_date',$voucher->tv_id)}}"
                                                                                        method="post">
                                                                                        @csrf
                                                                                        <input type="hidden" value="tv"
                                                                                               name="type">
                                                                                        <!-- start input box -->
                                                                                        <div class="d-flex">
                                                                                            <input type="hidden"
                                                                                                   name="student_id"
                                                                                                   value="{{$student->id}}">
                                                                                            <input tabindex="6"
                                                                                                   type="text"
                                                                                                   name="due_date"
                                                                                                   class="inputs_up form-control datepicker1"
                                                                                                   data-rule-required="true"
                                                                                                   data-msg-required="Please Enter Due Date"
                                                                                                   autocomplete="off"
                                                                                                   placeholder="Due Date ......"/>
                                                                                            <button tabindex="8"
                                                                                                    type="submit"
                                                                                                    name="save"
                                                                                                    id="due_save"
                                                                                                    class="invoice_frm_btn btn btn-sm btn-success">
                                                                                                <i class="fa fa-floppy-o"></i>
                                                                                                Save
                                                                                            </button>
                                                                                        </div>
                                                                                    </form>
                                                                                @endif
                                                                            </td>
                                                                            <script>
                                                                                $('#tv_total_amount').html('{!! $total_amount !!}');
                                                                                $('#tv_paid_amount').html('{!! $paid_amount !!}');
                                                                                $('#tv_pending_amount').html('{!! $pending_amount !!}');
                                                                            </script>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
{{--                                                            @endforeach--}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end transport voucher create and list  -->

                                    <!-- start Advance voucher create and list  -->
                                    <div class="tab-pane fade" id="advance_voucher" role="tabpanel">
                                        <div class="pd-20">
                                            <!-- discount voucher start-->
                                            <h3>Advance Voucher</h3>
                                            <hr/>
                                            <div id="invoice_con" class="invoice_con for_voucher p-2">
                                                <!-- invoice container start -->
                                                <div id="invoice_bx" class="invoice_bx show_scale show_rotate">
                                                    <!-- invoice box start -->
                                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                                        <!-- invoice scroll box start -->
                                                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                                            <!-- invoice content start -->
                                                            <div class="invoice_row ">
                                                                <form action="{{ route('submit_advance_voucher') }}"
                                                                      method="post" autocomplete="off"
                                                                      style="width: 100%"
                                                                      onsubmit="return checkAdvanceFeeForm()">
                                                                    @csrf
                                                                    <div class="invoice_row d-block">
                                                                        <input type="hidden" name="adv_student_id"
                                                                               class="form-control"
                                                                               value="{{$student->id}}">

                                                                        <table
                                                                            class="table table-striped table-bordered mb-0"
                                                                            id="dynamic-table">
                                                                            <thead>
                                                                            <tr>
                                                                                <th class="required">Due Date</th>
                                                                                <th>Advance TUITION FEE</th>
                                                                                <th>Advance FUND</th>
                                                                                <th class="required">TOTAL</th>
                                                                                <th></th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <tr>
                                                                                <td>
                                                                                    <input tabindex="6"
                                                                                           type="text"
                                                                                           name="due_date"
                                                                                           id="afv_due_date"
                                                                                           class="inputs_up form-control datepicker1"
                                                                                           data-rule-required="true"
                                                                                           data-msg-required="Please Enter Due Date"
                                                                                           autocomplete="off"
                                                                                           placeholder="Due Date ......"/>
                                                                                </td>
                                                                                <td>
                                                                                    <input
                                                                                        class="inputs_up form-control"
                                                                                        type="text" id="adv_t_fee"
                                                                                        name="adv_t_fee"
                                                                                        onkeyup="calculate_adv_amount();"
                                                                                        onkeypress="return allow_only_number_and_decimals(this,event);">
                                                                                </td>
                                                                                <td>
                                                                                    <input
                                                                                        class="inputs_up form-control"
                                                                                        type="text" id="adv_fund"
                                                                                        name="adv_fund"
                                                                                        onkeyup="calculate_adv_amount();"
                                                                                        onkeypress="return allow_only_number_and_decimals(this,event);">
                                                                                </td>
                                                                                <td>
                                                                                    <input
                                                                                        class="inputs_up form-control"
                                                                                        type="text" id="adv_total_fee"
                                                                                        name="adv_total_fee"
                                                                                        onkeyup="calculate_adv_amount();"
                                                                                        onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                                        data-rule-required="true"
                                                                                        data-msg-required="Please Enter Fee"
                                                                                        readonly>
                                                                                </td>
                                                                                <td>
                                                                                    <button tabindex="8" type="submit"
                                                                                            name="save" id="adv_save"
                                                                                            class="invoice_frm_btn btn btn-sm btn-success">
                                                                                        <i class="fa fa-floppy-o"></i>
                                                                                        Save
                                                                                    </button>
                                                                                </td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </form>
                                                            </div><!-- invoice row end -->
                                                        </div>
                                                        <table class="table table-striped table-bordered mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th>Month</th>
                                                                <th>FID</th>
                                                                <th>Payable</th>
                                                                <th>Status</th>
                                                                <th>Due Date</th>
                                                                <th>Paid At</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            @foreach($advance_vouchers as $voucher)
                                                                <tr>
                                                                    <td> {{ date('d-M-y', strtotime(str_replace('/', '-', $voucher->afv_created_datetime))) }}
                                                                    </td>
                                                                    <td>{{$voucher->afv_v_no}}</td>
                                                                    <td>{{$voucher->afv_total_amount}}</td>
                                                                    <td class="text-center">
                                                                        <span class="badge rounded-pill {{($voucher->afv_status == 1 ? 'bg-danger' :($voucher->afv_status == 2 ?
                                                                        'bg-success':'bg-info'))}}">
                                                                            {{($voucher->afv_status == 1 ? 'Pending' :($voucher->afv_status == 2 ? 'Paid':'Reverse'))}}
                                                                        </span>
                                                                    </td>
                                                                    <style>
                                                                        .adv_voucher_action .badge {
                                                                            margin-right: 7px;
                                                                            cursor: pointer;
                                                                        }

                                                                        .adv_voucher_action .badge:last-child {
                                                                            margin-right: 0px;
                                                                        }
                                                                    </style>
                                                                    <td>{{$voucher->afv_due_date}}</td>
                                                                    <td>{{$voucher->afv_paid_date}}</td>
                                                                    <td>
                                                                        <div
                                                                            class="d-flex justify-content-center adv_voucher_action">

                                                                        <span
                                                                            class="badge rounded-pill {{$voucher->afv_status == 1 ? 'bg-warning adv_voucher_view':'bg-info adv_voucher_view'}} "
                                                                            data-adv_id="{{ $voucher->afv_v_no }}"
                                                                            data-adv_reg_no="{{$voucher->afv_reg_no }}">{{($voucher->afv_status == 1 ? 'Print Voucher':($voucher->afv_status == 2?'View':'View'))}}</span>

                                                                            @if($voucher->afv_status == 1)

                                                                                <span
                                                                                    class="badge rounded-pill bg-info {{$voucher->afv_status == 1 ? 'adv_reverse_voucher':''}} "
                                                                                    data-adv_id="{{ $voucher->afv_v_no }}"
                                                                                    data-adv_reg_no="{{$voucher->afv_reg_no }}">{{$voucher->afv_status == 1 ? 'Reverse':''}}</span>

                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                        <hr/>
                                                        <h3 class="mt-4 mb-3">Reverse Vouchers</h3>
                                                        <table class="table table-striped table-bordered mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th>Month</th>
                                                                <th>FID</th>
                                                                <th>Amount</th>
                                                                <th>Date</th>
                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            @foreach($advance_reverse_vouchers as $voucher)
                                                                <tr>
                                                                    <td> {{ date('d-M-y', strtotime(str_replace('/', '-', $voucher->afrv_created_datetime))) }}
                                                                    </td>
                                                                    <td>{{$voucher->afrv_v_no}}</td>
                                                                    <td>{{$voucher->afrv_total_amount}}</td>
                                                                    <td>{{$voucher->afrv_day_end_date}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end Advance voucher create and list  -->

                                    <!-- start attendance and list  -->
                                    <div class="tab-pane fade" id="attendance" role="tabpanel">
                                        <div class="pd-20">
                                            <!-- discount voucher start-->
                                            <h3>Attendance</h3>
                                            <hr/>
                                            <div id="invoice_con" class="invoice_con for_voucher p-2">
                                                <!-- invoice container start -->
                                                <div id="invoice_bx" class="invoice_bx show_scale show_rotate">
                                                    <!-- invoice box start -->
                                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                                        <!-- invoice scroll box start -->
                                                        <div class="row bg-white">
                                                            @foreach ($presents as $key => $monthCounts)
                                                                @foreach ($monthCounts as  $month => $count)
                                                                    <div class="col-md-2 mb-4">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <strong>{{$month}} </strong><b
                                                                                    class="float-right">{{$count}}</b>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end attendance and list  -->
                                    <!-- start exams and list  -->
                                    <div class="tab-pane fade" id="exams" role="tabpanel">
                                        <div class="pd-20">
                                            <!-- discount voucher start-->
                                            <h3>Exams</h3>
                                            <hr/>
                                            <div id="invoice_con" class="invoice_con for_voucher p-2">
                                                <!-- invoice container start -->
                                                <div id="invoice_bx" class="invoice_bx show_scale show_rotate">
                                                    <!-- invoice box start -->
                                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                                        <!-- invoice scroll box start -->
                                                        <div class="row bg-white">
                                                            @foreach ($exams as $exam)
                                                                <div class="col-md-3 mb-4">
                                                                    <div class="card">
                                                                        <div class="card-header"
                                                                             onclick="getMarks({{$exam->exam_id}},{{$student->id}},{{$student->class_id}},{{$student->group_id}},{{$student->section_id}})">
                                                                            <b>{{$exam->exam_name}} </b><input
                                                                                type="hidden"
                                                                                id="exam_name{{$student->id}}"
                                                                                value="{{$exam->exam_name}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="row bg-white">
                                                            <div class="card" id="result" style="width: 18rem;">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end exams and list  -->
                                </div>
                            </div>
                        </div>
                    </div> <!-- left column ends here -->
                </div>
            </div> <!-- white column form ends here -->
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Custom Voucher Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body padding: 1.5rem;">
                    <div class="itm_vchr form_manage">
                        <div class="form_header">
                            <h4 class="text-white file_name">
                                <span class="db sml_txt"> Voucher #: </span>
                            </h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" align="center" class="wdth_5">Account No.</th>
                                    <th scope="col" align="center" class="wdth_2">Account Name</th>
                                    <th scope="col" align="center" class="wdth_5 text-right">Amount</th>
                                </tr>
                                </thead>
                                <tbody id="table_body">
                                </tbody>
                                <tfoot id="table_foot">
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button"
                                    data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- voucher Custom Fee  Modal -->
    <div class="modal fade" id="myVoucherModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Generate Fee Voucher</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body padding: 1.5rem;">
                    <div class="itm_vchr form_manage">
                        <div class="form_header">
                            <h4 class="text-white file_name">
                                <span class="db sml_txt"> Fee Voucher</span>
                            </h4>
                        </div>
                        <form id="f1" action="{{ route('submit_single_fee_voucher') }}" method="post"
                              onsubmit="return checkFormFee()" autocomplete="off">
                            @csrf
                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                <!-- invoice scroll box start -->
                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                    <!-- invoice content start -->

                                    <div class="invoice_row">
                                        <!-- invoice row start -->
                                        <input type="hidden" name="gen_ins_std_id" id="gen_ins_std_id">
                                        <input type="hidden" name="gen_ins_id" id="gen_ins_id">

                                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="required">
                                                    Month</label>
                                                <input class="inputs_up form-control" type="text" name="month"
                                                       id="month" data-rule-required="true"
                                                       data-msg-required="Please Enter Month" readonly/>

                                            </div><!-- end input box -->
                                        </div>
                                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label>
                                                    Issue Date
                                                </label>
                                                <input tabindex="5" type="text" name="issue_date" id="fee_issue_date"
                                                       class="inputs_up form-control datepicker1"
                                                       data-rule-required="true" data-msg-required="Please Issue Date"
                                                       autocomplete="off"
                                                       value=""
                                                       placeholder="Issue Date ......"/>
                                                <span id="demo1" class="validate_sign" style="float: right !important">
                                        </span>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label>
                                                    Due Date
                                                </label>
                                                <input tabindex="5" type="text" name="due_date" id="fee_due_date"
                                                       class="inputs_up form-control datepicker1" autocomplete="off"
                                                       value="" data-rule-required="true"
                                                       data-msg-required="Please Enter Due Date"
                                                       placeholder="Due Date ......"/>
                                                <span id="demo1" class="validate_sign" style="float: right !important">
                                        </span>
                                            </div>
                                        </div>

                                    </div><!-- invoice row end -->

                                    <div class="invoice_row">
                                        <!-- invoice row start -->
                                        <div class="invoice_col col-lg-12">
                                            <!-- invoice column start -->
                                            <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns">
                                                <!-- invoice column box start -->
                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                    <button tabindex="8" type="submit" name="save" id="fee_save"
                                                            class="invoice_frm_btn btn btn-sm btn-success">
                                                        <i class="fa fa-floppy-o"></i> Save
                                                    </button>
                                                    <span id="demo28" class="validate_sign"></span>
                                                </div>
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->
                                    </div><!-- invoice row end -->
                                </div><!-- invoice content end -->
                            </div><!-- invoice scroll box end -->
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button"
                                    data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fee voucher Modal -->
    <div class="modal fade" id="myFeeModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Fee Voucher Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body padding: 1.5rem;">
                    <div class="itm_vchr form_manage">
                        <div class="form_header">
                            <h4 class="text-white file_name">
                                <span class="db sml_txt"> Voucher #: </span>
                            </h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" align="center" class="wdth_5">Account No.</th>
                                    <th scope="col" align="center" class="wdth_2">Account Name</th>
                                    <th scope="col" align="center" class="wdth_5 text-right">Amount</th>
                                </tr>
                                </thead>
                                <tbody id="table_body">
                                </tbody>
                                <tfoot id="table_foot">
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button"
                                    data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


    <!-- Advance Fee voucher Modal -->
    <div class="modal fade" id="myAdvanceFeeModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Fee Voucher Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body padding: 1.5rem;">
                    <div class="itm_vchr form_manage">
                        <div class="form_header">
                            <h4 class="text-white file_name">
                                <span class="db sml_txt"> Voucher #: </span>
                            </h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" align="center" class="wdth_5">Account No.</th>
                                    <th scope="col" align="center" class="wdth_2">Account Name</th>
                                    <th scope="col" align="center" class="wdth_5 text-right">Amount</th>
                                </tr>
                                </thead>
                                <tbody id="table_body">
                                </tbody>
                                <tfoot id="table_foot">
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button"
                                    data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- Transport Fee Modal -->
    <div class="modal fade" id="myTransportFeeModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Transport Voucher Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body padding: 1.5rem;">
                    <div class="itm_vchr form_manage">
                        <div class="form_header">
                            <h4 class="text-white file_name">
                                <span class="db sml_txt"> Voucher #: </span>
                            </h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" align="center" class="wdth_5">Account No.</th>
                                    <th scope="col" align="center" class="wdth_2">Account Name</th>
                                    <th scope="col" align="center" class="wdth_5 text-right">Amount</th>
                                </tr>
                                </thead>
                                <tbody id="table_body">
                                </tbody>
                                <tfoot id="table_foot">
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button"
                                    data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection

@section('scripts')

    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            var package_type = document.querySelector('input[name="package_type"]:checked');
            if (package_type != null) {
                document.getElementById("package_type_error_msg").innerHTML = '';
                let semester_master = document.getElementById("semester_master"),
                    start_m = document.getElementById("start_m"),
                    start_y = document.getElementById("start_y"),
                    end_m = document.getElementById("end_m"),
                    end_y = document.getElementById("end_y"),
                    T_package_amount = document.getElementById("T_package_amount"),
                    P_package_amount = document.getElementById("P_package_amount"),
                    A_package_amount = document.getElementById("A_package_amount"),
                    validateInputIdArray = [
                        semester_master.id,
                        start_m.id,
                        start_y.id,
                        end_m.id,
                        end_y.id,
                        T_package_amount.id,
                        P_package_amount.id,
                        A_package_amount.id,
                    ];
                let check = validateInventoryInputs(validateInputIdArray);
                if (check == true) {

                    jQuery(".pre-loader").fadeToggle("medium");
                }
                $('#fee_save').prop('disabled', false);
                return validateInventoryInputs(validateInputIdArray);
            } else {
                document.getElementById("package_type_error_msg").innerHTML = 'Please Select Package Type';
                return false;
            }
        }

        function getMarks(exam_id, std_id, class_id, group_id, section_id) {
            let exam_name = $(`#exam_name${std_id}`).val();
            jQuery(".pre-loader").fadeToggle("medium");
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_result",
                data: {
                    exam_id: exam_id,
                    std_id: std_id,
                    class_id: class_id,
                    group_id: group_id,
                    section_id: section_id
                },
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data, exam_name);
                    let total = 0;
                    let obtain = 0;
                    var result = `<div class="card-header bg-info">
                        <strong>${exam_name}</strong>
                        </div>
                        <div class="card-header">
                        <strong> Subjects <span class="float-right">Marks</span></strong>
                    </div>
                    <ul class="list-group list-group-flush">`;


                    $.each(data, function (index, value) {
                        obtain = +obtain + +value.obtain_marks;
                        total = +total + value.total_marks;
                        result += `<li class="list-group-item">${value.subject_name} <span class="float-right">${value.obtain_marks}/${value.total_marks}</span></li>`

                    });
                    result += `</ul>
                    <div class="card-header bg-info">
                        <strong> Obtain Marks <span class="float-right">${obtain}</span></strong>
                    </div>
                    <div class="card-header bg-info">
                        <strong> Total Marks <span class="float-right">${total}</span></strong>
                    </div>
                    <div class="card-header bg-info">
                        <strong> Percentage <span class="float-right">${((obtain / total) * 100).toFixed(2)}%</span></strong>
                    </div>`;
                    $('#result').html('');
                    $('#result').html(result);
                    jQuery(".pre-loader").fadeToggle("medium");
                }
            });


        }

        function checkForms() {
            var package_type = document.querySelector('input[name="package_type_cv"]:checked');
            if (package_type != null) {
                document.getElementById("package_type_cv_error_msg").innerHTML = '';
                let issue_date = document.getElementById("issue_date"),
                    due_date = document.getElementById("due_date"),
                    component = document.getElementById("component"),
                    validateInputIdArray = [
                        issue_date.id,
                        due_date.id,
                        component.id,
                    ];
                let check = validateInventoryInputs(validateInputIdArray);
                if (check == true) {
                    jQuery(".pre-loader").fadeToggle("medium");
                }
                return validateInventoryInputs(validateInputIdArray);
            } else {
                document.getElementById("package_type_cv_error_msg").innerHTML = 'Please Select Package Type';
                return false;
            }
        }

        function checkFormTransport() {

            let dr_account = document.getElementById("dr_account"),
                cr_account = document.getElementById("cr_account"),
                month = document.getElementById("t_month"),
                issue_date = document.getElementById("t_issue_date"),
                due_date = document.getElementById("t_due_date"),
                amount = document.getElementById("t_amount"),
                validateInputIdArray = [
                    dr_account.id,
                    cr_account.id,
                    month.id,
                    issue_date.id,
                    due_date.id,
                    amount.id,
                ];

            let check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }
            return validateInventoryInputs(validateInputIdArray);
        }

        function checkFormFee() {
            let issue_date = document.getElementById("fee_issue_date"),
                due_date = document.getElementById("fee_due_date"),
                validateInputIdArray = [
                    issue_date.id,
                    due_date.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }
            return validateInventoryInputs(validateInputIdArray);

        }

        function checkInstallmentForm() {
            let total_value = document.getElementById("total_value"),
                term_amount = document.getElementById("term_amount"),
                validateInputIdArray = [
                    total_value.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);

            if (check == true) {
                if (parseInt(total_value.value) == parseInt(term_amount.value)) {
                    jQuery(".pre-loader").fadeToggle("medium");
                    return validateInventoryInputs(validateInputIdArray);
                }
                const element = document.getElementById('myElement');
                element.style.display = 'block';
                document.getElementById('error_installment').innerHTML = 'Installment amount is equal to the package amount.';
                return false;
            }
            return false;
        }

        function checkAdvanceFeeForm() {
            let due_date = document.getElementById("afv_due_date"),
                total_value = document.getElementById("adv_total_fee"),
                validateInputIdArray = [
                    due_date.id,
                    total_value.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);

            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
                return validateInventoryInputs(validateInputIdArray);
            }
            return false;
        }

        function checkDisIncForm() {
            var entry_type = document.querySelector('input[name="entry_type"]:checked');
            if (entry_type != null) {
                let amount = document.getElementById("amount"),
                    validateInputIdArray = [
                        amount.id,
                    ];
                let check = validateInventoryInputs(validateInputIdArray);
                if (check == true) {
                    jQuery(".pre-loader").fadeToggle("medium");
                    return validateInventoryInputs(validateInputIdArray);
                } else {
                    return validateInventoryInputs(validateInputIdArray);
                }
            } else {
                document.getElementById("entry_type_error_msg").innerHTML = 'Please Select Entry Type';
                return false;
            }
        }

        $('#amount').keyup(function () {
            $('#di_save').attr('disabled', false);
        });
        $('.entry_type').click(function () {
            $('#di_save').attr('disabled', false);
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#component').select2();
            $('#dr_account').select2();
            $('#cr_account').select2();
        });

        function cv_save() {
            $('#save_c').attr('disabled', false);
        }

        document.addEventListener('keydown', function (e) {
            if (!e.target.matches('.cell-input')) return;

            var thisElement = e.target;
            var rowIndex = thisElement.closest('tr').rowIndex;
            var cellIndex = thisElement.closest('td').cellIndex;
            var numRows = document.querySelectorAll('#dynamic-table tr').length;
            var numCells = document.querySelectorAll('#dynamic-table tr:first-child td').length;

            if (e.which === 37) { // Left Arrow
                if (cellIndex > 0) {
                    var prevCell = thisElement.closest('td').previousElementSibling;
                    prevCell.querySelector('.cell-input').focus();
                }
            } else if (e.which === 38) { // Up Arrow
                if (rowIndex > 0) {
                    var prevRow = thisElement.closest('tr').previousElementSibling;
                    prevRow.querySelector('td:nth-child(' + (cellIndex + 1) + ') .cell-input').focus();
                }
            } else if (e.which === 39) { // Right Arrow
                if (cellIndex < numCells - 1) {
                    var nextCell = thisElement.closest('td').nextElementSibling;
                    nextCell.querySelector('.cell-input').focus();
                }
            } else if (e.which === 40) { // Down Arrow
                if (rowIndex < numRows - 1) {
                    var nextRow = thisElement.closest('tr').nextElementSibling;
                    nextRow.querySelector('td:nth-child(' + (cellIndex + 1) + ') .cell-input').focus();
                }
            }
        });
    </script>
    <script>
        function calculate_package_amount() {
            let tution_fee = $('#T_package_amount').val();
            let paper_fund = $('#P_package_amount').val();
            let annual_fund = $('#A_package_amount').val();
            let zakat = $('#Z_package_amount').val();

            let package_amount = +tution_fee + +paper_fund + +annual_fund + +zakat;
            $('#total_package_value').val(package_amount);
            $('.total_package_value').html(package_amount.toLocaleString());
        }

        function calculate_instalment_amount(id) {

            let tution_fee = $('#T_amount' + id).val();
            let paper_fund = $('#P_amount' + id).val();
            let annual_fund = $('#A_amount' + id).val();
            let zakat = $('#Z_amount' + id).val();

            let package_amount = +tution_fee + +paper_fund + +annual_fund + +zakat;
            $('#ins_total_amount' + id).val(package_amount);

            $('#si_save').attr('disabled', false);
            grand_total();

        }

        function calculate_adv_amount() {

            let adv_t_fee = $('#adv_t_fee').val();
            let adv_fund = $('#adv_fund').val();

            let adv_amount = +adv_t_fee + +adv_fund;
            $('#adv_total_fee').val(adv_amount);
            $('#adv_save').attr('disabled', false)
        }

        function calculation_focusout(id) {
            jQuery(".pre-loader").fadeToggle("medium");
            calculate_instalment_amount(id);
            jQuery(".pre-loader").fadeToggle("medium");
        }
    </script>

    <script>
        function package_detail(finalize, package_id) {
            if (finalize != 'Finalized') {
                Swal.fire({
                    title: 'Do you want to Edit this Semester Package?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: `No`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        jQuery(".pre-loader").fadeToggle("medium");
                        jQuery.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        jQuery.ajax({
                            url: "get_package",
                            data: {
                                package_id: package_id,
                            },
                            type: "GET",
                            cache: false,
                            dataType: 'json',
                            success: function (data) {
                                $('#package_id').val('');
                                $('#package_id').val(data.package.sp_id);

                                var total_package_value = data.package.sp_package_amount;

                                let options = `<option value="" selected disabled>Select</option>`;
                                $.each(data.semesters, function (index, value) {

                                    options += `<option value="${value.semester_id}">${value.semester_name}</option>`;
                                });
                                $('#semester_master').html("");
                                $('#semester_master').html(options);

                                if (data.package.sp_package_type == 1) {
                                    $("#regular").prop("checked", true);
                                } else {
                                    $("#arrears").prop("checked", true);
                                }

                                $('#T_package_amount').val(data.package.sp_T_package_amount);
                                $('#P_package_amount').val(data.package.sp_P_package_amount);
                                $('#A_package_amount').val(data.package.sp_A_package_amount);
                                $('#E_package_amount').val(data.package.sp_E_package_amount);
                                $('#Z_package_amount').val(data.package.sp_Z_package_amount);
                                $('#total_package_value').val(total_package_value);
                                $('.total_package_value').html(total_package_value.toLocaleString());

                                jQuery('#start_m').val(data.package.sp_start_m);
                                // jQuery('#end_m').val(data.sp_start_m);
                                jQuery('#start_y').val(data.package.sp_start_m);
                                jQuery('#end_y').val(data.package.sp_end_m);
                                if (data.package.sp_start_m >= 10) {
                                    jQuery('#start_m option[value="' + data.package.sp_start_m + '"]').prop('selected', true);
                                } else {
                                    jQuery('#start_m option[value="' + '0' + data.package.sp_start_m + '"]').prop('selected', true);
                                }
                                if (data.package.sp_end_m >= 10) {
                                    jQuery('#end_m option[value="' + data.package.sp_end_m + '"]').prop('selected', true);
                                } else {
                                    jQuery('#end_m option[value="' + '0' + data.package.sp_end_m + '"]').prop('selected', true);
                                }
                                jQuery('#semester_master option[value="' + data.package.sp_semester + '"]').prop('selected', true);

                                jQuery('#start_y option[value="' + data.package.sp_start_y + '"]').prop('selected', true);

                                jQuery('#end_y option[value="' + data.package.sp_end_y + '"]').prop('selected', true);
                                jQuery(".pre-loader").fadeToggle("medium");
                            }
                        });

                    }
                })
            } else {
                Swal.fire('You cant not changed the package because you finalized the package!');
            }
        }

        function installment_detail(package_id) {

            var monthNames = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            jQuery(".pre-loader").fadeToggle("medium");
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_instalment_details",
                data: {
                    package_id: package_id,
                },
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    let instalment_rows = '';
                    $('#s_package_id').val('');

                    $('#s_package_id').val(data.package.sp_id);
                    $('#term_amount').val("");
                    $('#term_amount').val(data.package.sp_package_amount);

                    var sr = 0;
                    if (data.count > 0) {

                        $.each(data.instalments, function (index, value) {
                            sr++;
                            if (value.si_status_update == 1) {
                                instalment_rows += `<tr>
                        <th>${sr}
                         <input class="inputs_up form-control" type="hidden" id="ins_id${sr}"  value="${value.si_id}" name="ins_id[]">
                        <input class="inputs_up form-control" type="hidden" id="package_type${sr}" name="ins_package_type[]"
                        value="${data.package.sp_package_type}">
                        </th>
                            <td> ${value.si_month_year}
                            <div class="d-flex" hidden>
                                    <select style="height:30px; width:80px; float:left;" name="ins_mm[]" id="ins_mm${sr}" class="inputs_up form-control"
                                data-rule-required="true" data-msg-required="Start Month" hidden>
                                    <option value="" selected disabled>...</option>
                                <option value="01">Jan</option>
                                    <option value="02">Feb</option>
                                    <option value="03">Mar</option>
                                    <option value="04">Apr</option>
                                    <option value="05">May</option>
                                    <option value="06">Jun</option>
                                    <option value="07">Jul</option>
                                    <option value="08">Aug</option>
                                    <option value="09">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                    </select>

                                    <select name="ins_yy[]" id="ins_yy${sr}" style="height:30px; width:80px;" class="inputs_up form-control"
                                data-rule-required="true" data-msg-required="Start Year" hidden>
                                    <option value="" selected disabled>...</option>
                                @for($y=2020; $y<2040; $y++)
                                <option value="{{$y}}" > {{$y}}</option>
                                    @endfor
                                </select>
                                </div>
                        </td>
                        <td>
                        <input class="inputs_up form-control total_ins_value cell-input" type="text" id="T_amount${sr}" name="T_amount[]"
                        value="${value.si_t_fee}" data-rule-required="true" data-msg-required="Tution Fee" onkeyup="calculate_instalment_amount(${sr});"  readonly>
                            </td>
                            <td>
                            <input class="inputs_up form-control total_ins_value cell-input" type="text" id="P_amount${sr}" name="P_amount[]"
                        value="${value.si_p_fund}" onkeyup="calculate_instalment_amount(${sr});" readonly>
                            </td>
                            <td>
                            <input class="inputs_up form-control total_ins_value cell-input" type="text" id="A_amount${sr}" name="A_amount[]"
                        value="${value.si_a_fund}"
                        onkeyup="calculate_instalment_amount(${sr});" onfocusout="calculation_focusout(${sr})" readonly>
                            </td>
                            <td><input class="inputs_up form-control total_ins_value cell-input" type="text" id="Z_amount${sr}" name="Z_amount[]"
                        value="${value.si_z_fund}" onkeyup="calculate_instalment_amount(${sr});" onfocusout="calculation_focusout(${sr})" readonly></td>
                            <td><input class="inputs_up form-control total_ins_value" type="text" id="ins_total_amount${sr}" name="ins_total_amount[]"
                        value="${value.si_total_amount}" readonly></td>

                            <td>
                            <select class="inputs_up form-control ins_semester" type="text" name="semester[]" id="semester${sr}" readonly>
                            <option value="" selected disabled>Select</option>
{{--                        @foreach($semesters as $semester)--}}
                                <option value="${data.semester.semester_id}" seleted>${data.semester.semester_name}</option>
{{--                            @endforeach--}}
                                </select>
                                    </td>

                                    </tr>`;
                            } else if (value.si_status_update == 3) {
                                instalment_rows += `<tr>
                        <th>${sr}
                         <input class="inputs_up form-control" type="hidden" id="ins_id${sr}"  value="${value.si_id}" name="ins_id[]">
                            <input class="inputs_up form-control" type="hidden" id="package_type${sr}"  name="ins_package_type[]"
                        value="${data.package.sp_package_type}">
                        </th>
                            <td> ${value.si_month_year}
                            <div class="d-flex" hidden>
                                    <select style="height:30px; width:80px; float:left;" name="ins_mm[]" id="ins_mm${sr}" class="inputs_up form-control"
                                data-rule-required="true" data-msg-required="Start Month" hidden>
                                    <option value="" selected disabled>...</option>
                                <option value="01">Jan</option>
                                    <option value="02">Feb</option>
                                    <option value="03">Mar</option>
                                    <option value="04">Apr</option>
                                    <option value="05">May</option>
                                    <option value="06">Jun</option>
                                    <option value="07">Jul</option>
                                    <option value="08">Aug</option>
                                    <option value="09">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                    </select>

                                    <select name="ins_yy[]" id="ins_yy${sr}" style="height:30px; width:80px;" class="inputs_up form-control"
                                data-rule-required="true" data-msg-required="Start Year" hidden>
                                    <option value="" selected disabled>...</option>
                                @for($y=2020; $y<2040; $y++)
                                <option value="{{$y}}" > {{$y}}</option>
                                    @endfor
                                </select>
                                </div>
                        </td>
                        <td>
                        <input class="inputs_up form-control total_ins_value cell-input" type="text" id="T_amount${sr}" name="T_amount[]"
                        value="${value.si_t_fee}" data-rule-required="true" data-msg-required="Tution Fee" onkeyup="calculate_instalment_amount(${sr});"  onfocusout="calculation_focusout(${sr})">
                            </td>
                            <td>
                            <input class="inputs_up form-control total_ins_value cell-input" type="text" id="P_amount${sr}" name="P_amount[]"
                        value="${value.si_p_fund}" onkeyup="calculate_instalment_amount(${sr});" onfocusout="calculation_focusout(${sr})">
                            </td>
                            <td>
                            <input class="inputs_up form-control total_ins_value cell-input" type="text" id="A_amount${sr}" name="A_amount[]"
                        value="${value.si_a_fund}"
                        onkeyup="calculate_instalment_amount(${sr});" onfocusout="calculation_focusout(${sr})">
                            </td>
                            <td><input class="inputs_up form-control total_ins_value cell-input" type="text" id="Z_amount${sr}" name="Z_amount[]"
                        value="${value.si_z_fund}" onkeyup="calculate_instalment_amount(${sr});" onfocusout="calculation_focusout(${sr})"></td>
                            <td><input class="inputs_up form-control total_ins_value" type="text" id="ins_total_amount${sr}" name="ins_total_amount[]"
                        value="${value.si_total_amount}" readonly></td>

                            <td>
                            <select class="inputs_up form-control ins_semester" type="text" name="semester[]" id="semester${sr}" readonly>
                            <option value="" selected disabled>Select</option>
{{--                        @foreach($semesters as $semester)--}}
                                <option value="${data.semester.semester_id}" seleted>${data.semester.semester_name}</option>
{{--                            @endforeach--}}
                                </select>
                                    </td>

                                    </tr>`;
                            } else {
                                instalment_rows += `<tr>
                        <th>${sr}
                         <input class="inputs_up form-control" type="hidden" id="ins_id${sr}"  value="${value.si_id}" name="ins_id[]">
                         <input class="inputs_up form-control" type="hidden" id="package_type${sr}"  name="ins_package_type[]"
                        value="${data.package.sp_package_type}">
                        </th>
                            <td> ${value.si_month_year}
                            <div class="d-flex" hidden>
                                    <select style="height:30px; width:80px; float:left;" name="ins_mm[]" id="ins_mm${sr}" class="inputs_up form-control"
                                data-rule-required="true" data-msg-required="Start Month" hidden>
                                    <option value="" selected disabled>...</option>
                                <option value="01">Jan</option>
                                    <option value="02">Feb</option>
                                    <option value="03">Mar</option>
                                    <option value="04">Apr</option>
                                    <option value="05">May</option>
                                    <option value="06">Jun</option>
                                    <option value="07">Jul</option>
                                    <option value="08">Aug</option>
                                    <option value="09">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                    </select>

                                    <select name="ins_yy[]" id="ins_yy${sr}" style="height:30px; width:80px;" class="inputs_up form-control"
                                data-rule-required="true" data-msg-required="Start Year" hidden>
                                    <option value="" selected disabled>...</option>
                                @for($y=2020; $y<2040; $y++)
                                <option value="{{$y}}" > {{$y}}</option>
                                    @endfor
                                </select>
                                </div>
                        </td>
                        <td>
                        <input class="inputs_up form-control total_ins_value cell-input" type="text" id="T_amount${sr}" name="T_amount[]"
                        value="${value.si_t_fee}" data-rule-required="true" data-msg-required="Tution Fee" onkeyup="calculate_instalment_amount(${sr});" onfocusout="calculation_focusout(${sr})">
                            </td>
                            <td>
                            <input class="inputs_up form-control total_ins_value cell-input" type="text" id="P_amount${sr}" name="P_amount[]"
                        value="${value.si_p_fund}" onkeyup="calculate_instalment_amount(${sr});" onfocusout="calculation_focusout(${sr})">
                            </td>
                            <td>
                            <input class="inputs_up form-control total_ins_value cell-input" type="text" id="A_amount${sr}" name="A_amount[]"
                        value="${value.si_a_fund}"
                        onkeyup="calculate_instalment_amount(${sr});" onfocusout="calculation_focusout(${sr})">
                            </td>
                            <td><input class="inputs_up form-control total_ins_value cell-input" type="text" id="Z_amount${sr}" name="Z_amount[]"
                        value="${value.si_z_fund}" onkeyup="calculate_instalment_amount(${sr});" onfocusout="calculation_focusout(${sr})"></td>
                            <td><input class="inputs_up form-control total_ins_value" type="text" id="ins_total_amount${sr}" name="ins_total_amount[]"
                        value="${value.si_total_amount}" readonly></td>

                            <td>
                            <select class="inputs_up form-control ins_semester" type="text" name="semester[]" id="semester${sr}" readonly>
                            <option value="" selected disabled>Select</option>
{{--                        @foreach($semesters as $semester)--}}
                                <option value="${data.semester.semester_id}" seleted>${data.semester.semester_name}</option>
{{--                            @endforeach--}}
                                </select>
                                    </td>

                                    </tr>`;
                            }
                        });
                    }
                    for (var i = data.count; i < 12; i++) {
                        sr++;
                        instalment_rows += `<tr>
                        <th>${sr}
                         <input class="inputs_up form-control" type="hidden" id="ins_id${sr}" name="ins_id[]">
                         <input class="inputs_up form-control" type="hidden" id="package_type${sr}"  name="ins_package_type[]"
                        value="${data.package.sp_package_type}">

                        </th>
                            <td>
                            <div class="d-flex">
                            <select style="height:30px; width:80px; float:left;" name="ins_mm[]" id="ins_mm${sr}" class="inputs_up form-control"
                        data-rule-required="true" data-msg-required="Start Month">
                            <option value="" selected disabled>...</option>
                        <option value="01">Jan</option>
                            <option value="02">Feb</option>
                            <option value="03">Mar</option>
                            <option value="04">Apr</option>
                            <option value="05">May</option>
                            <option value="06">Jun</option>
                            <option value="07">Jul</option>
                            <option value="08">Aug</option>
                            <option value="09">Sep</option>
                            <option value="10">Oct</option>
                            <option value="11">Nov</option>
                            <option value="12">Dec</option>
                            </select>

                            <select name="ins_yy[]" id="ins_yy${sr}" style="height:30px; width:80px;" class="inputs_up form-control"
                        data-rule-required="true" data-msg-required="Start Year">
                            <option value="" selected disabled>...</option>
                        @for($y=$currentYear - 2; $y<$currentYear + 10; $y++)
                        <option value="{{$y}}"> {{$y}}</option>
                            @endfor
                        </select>
                        </div>
                        </td>
                        <td>
                        <input class="inputs_up form-control total_ins_value cell-input" type="text" id="T_amount${sr}" name="T_amount[]"
                        value="" data-rule-required="true" data-msg-required="Tution Fee" onkeyup="calculate_instalment_amount(${sr});" onfocusout="calculation_focusout(${sr})">
                            </td>
                            <td>
                            <input class="inputs_up form-control total_ins_value cell-input" type="text" id="P_amount${sr}" name="P_amount[]"
                        value="" onkeyup="calculate_instalment_amount(${sr});" onfocusout="calculation_focusout(${sr})">
                            </td>
                            <td>
                            <input class="inputs_up form-control total_ins_value cell-input" type="text" id="A_amount${sr}" name="A_amount[]"
                        value=""
                        onkeyup="calculate_instalment_amount(${sr});" onfocusout="calculation_focusout(${sr})"><input class="inputs_up form-control" type="hidden" id="E_package_amount"
                        name="E_package_amount"
                        value="0"
                        onkeyup="calculate_instalment_amount(${sr});">
                            </td>
                            <td><input class="inputs_up form-control total_ins_value cell-input" type="text" id="Z_amount${sr}" name="Z_amount[]"
                        value="" onkeyup="calculate_instalment_amount(${sr});"  onfocusout="calculation_focusout(${sr})"></td>
                            <td><input class="inputs_up form-control total_ins_value" type="text" id="ins_total_amount${sr}" name="ins_total_amount[]"
                        value="" readonly></td>

                            <td>
                            <select class="inputs_up form-control ins_semester" type="text" name="semester[]" id="semester${sr}" readonly>
                            <option value="" selected disabled>Select</option>
{{--                        @foreach($semesters as $semester)--}}
                        <option value="${data.semester.semester_id}" seleted>${data.semester.semester_name}</option>
{{--                            @endforeach--}}
                        </select>
                            </td>

                            </tr>`;
                    }

                    $('#ins_body').html('');
                    $('#ins_body').html(instalment_rows);
                    // $('#ins_body').val(data.package.sp_T_package_amount);
                    var total_package_value = data.package.sp_package_amount;
                    $('#dis_t_fee').html(data.package.sp_T_package_amount);
                    $('#dis_p_fund').html(data.package.sp_P_package_amount);
                    $('#dis_a_fund').html(data.package.sp_A_package_amount);
                    // $('#E_package_amount').html(data.package.sp_E_package_amount);
                    $('#dis_z_fund').html(data.package.sp_Z_package_amount);
                    // $('#dis_total').val(total_package_value);

                    $('#dis_total').html(total_package_value.toLocaleString());

                    var start_month = monthNames[data.package.sp_start_m];
                    var end_month = monthNames[data.package.sp_end_m];

                    jQuery('#dis_month').html(start_month + '-' + data.package.sp_start_y + ' - ' + end_month + '-' + data.package.sp_end_y);
                    jQuery('#dis_semester').html(data.package.semester_name);

                    jQuery('#dis_type').html(data.package.sp_package_type == 1 ? 'Regular' : 'Arrears');

                    jQuery('.ins_semester option[value="' + data.package.sp_semester + '"]').prop('disabled', false);
                    jQuery('.ins_semester option[value="' + data.package.sp_semester + '"]').prop('selected', true);


                    if (data.count > 0) {
                        $.each(data.instalments, function (index, value) {
                            index++;
                            jQuery('#ins_mm' + index + ' option[value="' + value.si_month + '"]').prop('selected', true);
                            jQuery('#ins_yy' + index + ' option[value="' + value.si_year + '"]').prop('selected', true);
                        });
                    }
                    $("#save").prop('disabled', true);
                    var start_month = data.package.sp_start_m;
                    var start_year = data.package.sp_start_y;

                    var j = data.count;
                    if (data.count > 0) {
                        start_month = +start_month + +j;
                    }
                    for (var i = data.count; i < 12; i++) {
                        j++;

                        let start_months = '';
                        if (start_month < 10) {
                            start_months = '0' + start_month;
                        } else {
                            start_months = start_month;
                        }

                        jQuery('#ins_mm' + j + ' option[value="' + start_months + '"]').prop('selected', true);
                        jQuery('#ins_yy' + j + ' option[value="' + start_year + '"]').prop('selected', true);

                        if (start_month == 12) {
                            start_month = 0;
                            start_year++;
                        }
                        start_month++;

                    }

                    grand_total();
                    jQuery(".pre-loader").fadeToggle("medium");
                }
            });

        }

    </script>

    <script>
        function grand_total() {
            let total_t_amount = 0;
            let total_p_amount = 0;
            let total_a_amount = 0;
            let total_z_amount = 0;
            let total_value = 0;
            $('input[name="T_amount[]"]').each(function (pro_index) {
                let id = +pro_index + 1;
                total_t_amount = +total_t_amount + +$('#T_amount' + id).val();
            });

            $('input[name="P_amount[]"]').each(function (pro_index) {
                let id = +pro_index + 1;
                total_p_amount = +total_p_amount + +$('#P_amount' + id).val();
            });
            $('input[name="A_amount[]"]').each(function (pro_index) {
                let id = +pro_index + 1;
                total_a_amount = +total_a_amount + +$('#A_amount' + id).val();
            });
            $('input[name="Z_amount[]"]').each(function (pro_index) {
                let id = +pro_index + 1;
                total_z_amount = +total_z_amount + +$('#Z_amount' + id).val();
            });
            $('input[name="ins_total_amount[]"]').each(function (pro_index) {
                let id = +pro_index + 1;
                total_value = +total_value + +$('#ins_total_amount' + id).val();
            });

            $('.total_t_fee').html(total_t_amount);
            $('#total_t_fee').val(total_t_amount);

            $('.total_p_fund').html(total_p_amount);
            $('#total_p_fund').val(total_p_amount);

            $('.total_a_fund').html(total_a_amount);
            $('#total_a_fund').val(total_a_amount);

            $('.total_z_fund').html(total_z_amount);
            $('#total_z_fund').val(total_z_amount);

            $('.total_value').html(total_value);
            $('#total_value').val(total_value);

        }
    </script>

    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");
            var reg_no = jQuery(this).attr("data-reg_no");
            $(".modal-body").load('{{ url('custom_voucher_items_view_details/view/') }}/' + id + '/' + reg_no, function () {
                $("#myModal").modal({
                    show: true
                });
            });
        });

        jQuery(".fee_voucher_view").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-fee_id");
            var reg_no = jQuery(this).attr("data-reg_no");

            $(".modal-body").load('{{ url('fee_items_view_details/view/') }}/' + id + '/' + reg_no, function () {
                $("#myFeeModal").modal({
                    show: true
                });
            });
        });

        jQuery(".adv_voucher_view").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-adv_id");
            var reg_no = jQuery(this).attr("data-adv_reg_no");

            $(".modal-body").load('{{ url('adv_fee_items_view_details/view/') }}/' + id + '/' + reg_no, function () {
                $("#myAdvanceFeeModal").modal({
                    show: true
                });
            });
        });

        jQuery(".adv_reverse_voucher").click(function () {

            var id = jQuery(this).attr("data-adv_id");
            var reg_no = jQuery(this).attr("data-adv_reg_no");
            jQuery("#adv_id").val(id);
            jQuery("#reg_no").val(reg_no);
            jQuery("#reverse_voucher").submit();
        });

        function confirmReverse() {
            return confirm('Are you sure you want to reverse this voucher?');
        }

        jQuery(".transport_voucher_view").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-fee_id");
            var reg_no = jQuery(this).attr("data-reg_no");
            var status = jQuery(this).attr("data-status");

            $(".modal-body").load('{{ url('transport_items_view_details/view/') }}/' + id + '/' + reg_no + '/' + status, function () {
                $("#myTransportFeeModal").modal({
                    show: true
                });
            });
        });

        jQuery(".package").click(function () {

            var title = jQuery(this).parent('div').attr("data-title");
            var student_id = jQuery(this).parent('div').attr("data-student_id");
            jQuery("#name").val(title);
            jQuery("#std_id").val(std_id);
            jQuery("#package").submit();
        });

        jQuery(".voucher").click(function () {
            jQuery("#table_body").html("");

            var instalment_id = jQuery(this).attr("data-id");
            var student_id = jQuery(this).attr("data-std_id");
            var month = jQuery(this).attr("data-month");
            jQuery("#month").val(month);
            jQuery("#gen_ins_std_id").val(student_id);
            jQuery("#gen_ins_id").val(instalment_id);
            $("#myVoucherModal").modal({
                show: true
            });

        });
    </script>
@endsection
