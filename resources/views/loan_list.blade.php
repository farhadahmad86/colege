@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">{{$title}} List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                {{--                    <!-- <div class="search_form  {{ ( !empty($search) || !empty($search_account) || !empty($search_region) ) ? '' : 'search_form_hidden' }}"> --> --}}

                <div class="search_form m-0 p-0">

                    <form class="highlight prnt_lst_frm" action="{{ route($route) }}" name="form1" id="form1"
                          method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autfocus type="search" list="browsers"
                                           class="inputs_up form-control all_clm_srch" name="search" id="search"
                                           placeholder="Search ..." value="{{ isset($search) ? $search : '' }}"
                                           autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach ($loan_title as $value)
                                            <option value="{{ $value }}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12">
                                <div class="row">

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Select Department
                                            </label>
                                            <select tabindex="2" class="inputs_up form-control cstm_clm_srch"
                                                    name="department" id="department">
                                                <option value="">Select Department</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->dep_id }}"
                                                        {{ $department->dep_id == $search_department ? 'selected="selected"' : '' }}>
                                                        {{ $department->dep_title }}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important">
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Select Account Name
                                            </label>
                                            <select tabindex="3" class="inputs_up form-control cstm_clm_srch"
                                                    name="account" id="account">
                                                <option value="">Select Account Name</option>
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->account_uid }}"
                                                        {{ $account->account_uid == $search_account ? 'selected="selected"' : '' }}>
                                                        {{ $account->account_name }}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important">
                                            </span>
                                        </div>
                                    </div>
                                    <x-year-end-component search="{{$search_year}}"/>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12 text-right mt-4">

                                    @include('include.clear_search_button')
                                    <!-- Call add button component -->
                                        <x-add-button tabindex="9" href="{{ route('add_loan') }}"/>

                                        @include('include/print_button')

                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                    </div>

                                </div><!-- end row -->
                            </div>
                        </div><!-- end row -->
                    </form>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" class=" tbl_srl_4">
                                Sr#
                            </th>

                            <th scope="col" class=" tbl_txt_20">
                                Department Title
                            </th>
                            <th scope="col" class=" tbl_txt_20">
                                Account Title
                            </th>
                            <th scope="col" class=" tbl_txt_12">
                                Loan Amount
                            </th>
                            <th scope="col" class=" tbl_txt_12">
                                Remaining Amount
                            </th>
                            <th scope="col" class=" tbl_txt_8">
                                Number Of Installment
                            </th>
                            <th scope="col" class=" tbl_txt_8">
                                Installment Amount
                            </th>
                            <th scope="col" class=" tbl_txt_8">
                                First Payment Month
                            </th>
                            <th scope="col" class=" tbl_txt_8">
                                Last Payment Month
                            </th>

                            <th scope="col" class=" tbl_txt_8">
                                Status
                            </th>
                            @if($route == "loan_list")
                                <th scope="col" class=" tbl_txt_8">
                                    Edit
                                </th>
                            @endif
                            <th scope="col" class=" tbl_txt_12">
                                Created By
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                            $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                            $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                        @endphp
                        @forelse($datas as $loan)
                            <tr>

                                <th class="tbl_srl_4">
                                    {{ $sr }}
                                </th>
                                <td class="align_left text-left tbl_txt_20">
                                    {{ $loan->dep_title }}
                                </td>
                                <td class="align_left text-left tbl_txt_20">
                                    {{ $loan->account_name }}
                                </td>
                                <td class="align-right text-right tbl_txt_12">
                                    {{ $loan->loan_total_amount }}
                                </td>
                                <td class="align-right text-right tbl_txt_12">
                                    {{ $loan->loan_remaining_amount }}
                                </td>
                                <td class="text-center text-center tbl_txt_8">
                                    {{ $loan->loan_total_instalment }}
                                </td>
                                <td class="align-right text-right tbl_txt_8">
                                    {{ $loan->loan_instalment_amount }}
                                </td>
                                <td class="align_left text-left tbl_txt_8">
                                    {{ $loan->loan_first_payment_month }}
                                </td>
                                <td class="align_left text-left tbl_txt_8">
                                    {{ $loan->loan_last_payment_month }}
                                </td>
                                @if($route == "loan_list")
                                    <td class="align_center text-center tbl_txt_8">
                                        {{$loan->loan_status}}
                                    </td>
                                    <td class="align_center text-center tbl_txt_8">
                                        @if($loan->loan_paid_status == 1)
                                            <a href="{{  route('edit_loan',$loan->loan_id) }}" class=""
                                               data-toggle="tooltip" data-placement="left" title=""
                                               data-original-title="Are you sure want to Edit loan?">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @else
                                            {{$loan->loan_paid_status == 2 ? 'Paid': 'Not Paid'}}
                                        @endif
                                    </td>
                                @else
                                    <td class="align_center text-center tbl_txt_8">
                                        @if($loan->loan_status == 'Pending')
                                            <a href="{{  route('loan_approved',$loan->loan_id) }}" class="approve"
                                               data-toggle="tooltip" data-placement="left" title=""
                                               data-original-title="Are you sure want to approve loan?">
                                                <i class="fa fa-check"></i>
                                            </a>
                                            <span class="px-1">|</span>
                                            <a href="{{  route('loan_reject',$loan->loan_id) }}"
                                               class="delete text-danger"
                                               data-toggle="tooltip" data-placement="left" title=""
                                               data-original-title="Are you sure want to reject loan?">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        @else
                                            {{$loan->loan_status}}
                                        @endif

                                    </td>
                                @endif
                                @php
                                    $ip_browser_info = '' . $loan->loan_ip_adrs . ',' . str_replace(' ', '-', $loan->loan_brwsr_info) . '';
                                @endphp

                                <td class="align_left text-left usr_prfl tbl_txt_12" data-usr_prfl="{{ $loan->user_id }}"
                                    data-user_info="{!! $ip_browser_info !!}"
                                    title="Click To See User
                                        Detail">
                                    {{ $loan->user_name }}
                                </td>
                            </tr>
                            @php
                                $sr++;
                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center>
                                        <h3 style="color:#554F4F">No Loan</h3>
                                    </center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                    </div>
                    <div class="col-md-9 text-right">
                <span class="hide_column">
            {{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search, 'account' => $search_account, 'department' => $search_department])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->
        </div><!-- col end -->
    </div><!-- row end -->
@endsection

@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route($route) }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    <script>
        jQuery("#cancel").click(function () {

            $("#department").select2().val(null).trigger("change");
            $("#department > option").removeAttr('selected');

            $("#account").select2().val(null).trigger("change");
            $("#account > option").removeAttr('selected');


            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#department").select2();
            jQuery("#account").select2();

        });
    </script>
@endsection
