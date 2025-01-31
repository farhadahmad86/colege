@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Custom Voucher List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

            <!-- <div class="search_form {{ !empty($search) || !empty($search_to) || !empty($search_from) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('custom_voucher_list') }}" name="form1"
                          id="form1" method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" class="inputs_up form-control"
                                           name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <span id="demo1" class="validate_sign" style="float: right !important">
                                            </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 srch_brdr_left">
                                <div class="row">

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Start Date
                                            </label>
                                            <input tabindex="2" type="text" name="to" id="to"
                                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                                   <?php if(isset($search_to)){?> value="{{ $search_to }}" <?php } ?>
                                                   placeholder="Start Date ......"/>
                                            <span id="demo1" class="validate_sign"
                                                  style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                End Date
                                            </label>
                                            <input tabindex="3" type="text" name="from" id="from"
                                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                                   <?php if(isset($search_from)){?> value="{{ $search_from }}" <?php } ?>
                                                   placeholder="End Date ......"/>
                                            <span id="demo1" class="validate_sign"
                                                  style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <x-class-component search="{{$search_class}}" name="class_id" id="class_id"/>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Section
                                            </label>
                                            <select tabindex="4" name="section"
                                                    class="inputs_up form-control" id="section">
                                                <option value="">Select Section</option>
                                                @foreach ($sections as $section)
                                                    <option value="{{ $section->cs_id }}"
                                                        {{ $section->cs_id == $search_section ? 'selected="selected"' : '' }}>
                                                        {{ $section->cs_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Status
                                            </label>
                                            <select tabindex="5" name="status" class="inputs_up form-control" id="status">
                                                <option value="">Select Status</option>
                                                <option value="Pending" {{ 'Pending' == $search_status ? 'selected="selected"' : '' }}>
                                                    Pending
                                                </option>
                                                <option value="Paid" {{ 'Paid' == $search_status ? 'selected="selected"' : '' }}>
                                                    Paid
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Type
                                            </label>
                                            <select tabindex="5" name="type" class="inputs_up form-control" id="type">
                                                <option value="">Select Status</option>
                                                <option value="1" {{ '1' == $search_type ? 'selected="selected"' : '' }}>
                                                    Regular
                                                </option>
                                                <option value="2" {{ '2' == $search_type ? 'selected="selected"' : '' }}>
                                                    Arrears
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <x-year-end-component search="{{$search_year}}"/>
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 mt-lg-4 text-right">
                                    @include('include.clear_search_button')

                                    <!-- Call add button component -->
                                        <x-add-button tabindex="9" href="{{ route('custom_voucher') }}"/>
                                        @include('include/print_button')

                                        <span id="demo1" class="validate_sign"
                                              style="float: right !important"> </span>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </form>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th tabindex="-1" scope="col" class="tbl_srl_4">
                                Sr#
                            </th>

                            <th scope="col" class="tbl_amnt_6">
                                Date
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                              Paid  Date
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Voucher#
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_txt_12">
                                Student Name
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_txt_5">
                                Roll No
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_txt_8">
                                Reg #
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_txt_15">
                                Class
                            </th>
                            <th scope="col" class="tbl_txt_15">
                                Detail Remarks
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Total Amount
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" class="tbl_txt_6">
                                Status
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                            $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                            $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                            $per_page_ttl_amnt = 0;
                        @endphp
                        @forelse($datas as $voucher)
                            @php $per_page_ttl_amnt = +$voucher->cv_total_amount + +$per_page_ttl_amnt; @endphp

                            <tr data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="View Journal Voucher">
                                <th scope="row">
                                    {{ $sr }}
                                </th>
                                <td>
                                    {{ date('d-M-y', strtotime(str_replace('/', '-', $voucher->cv_day_end_date))) }}
                                </td>
                                <td>
                                    {{ !empty($voucher->cv_paid_date)? date('d-M-y', strtotime(str_replace('/', '-', $voucher->cv_paid_date))):'' }}
                                </td>
                                <td class="view" data-id="{{ $voucher->cv_v_no }}" data-reg_no="{{ $voucher->cv_reg_no }}">
                                    CV-{{ $voucher->cv_v_no }}
                                </td>
                                <td>
                                    {{ $voucher->full_name }}
                                </td>
                                <td>
                                    {{ $voucher->roll_no }}
                                </td>
                                <td>
                                    {{ $voucher->registration_no }}
                                </td>
                                <td>
                                    {{ $voucher->class_name }}
                                </td>

                                <td>
                                    {!! str_replace('&oS;', '<br />', $voucher->cv_detail_remarks) !!}
                                </td>
                                <td class="align_right text-right">
                                    {{ $voucher->cv_total_amount != 0 ? number_format($voucher->cv_total_amount, 2) : '' }}
                                </td>

                                @php
                                    $ip_browser_info = '' . $voucher->cv_ip_adrs . ',' . str_replace(' ', '-', $voucher->cv_brwsr_info) . '';
                                @endphp

                                <td class="usr_prfl"
                                    data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}"
                                    title="Click To See User Detail">
                                    {{ $voucher->user_name }}
                                </td>
                                <td class="text-center">
                                    {{$voucher->cv_status}}
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
                                        <h3 style="color:#554F4F">No voucher</h3>
                                    </center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                        <tfoot>
                        <tr class="border-0">
                            <th colspan="7" align="right" class="border-0 text-right align_right pt-0">
                                Per Page Total:
                            </th>
                            <td class="text-right border-left-0" align="right"
                                style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                                {{ number_format($per_page_ttl_amnt, 2) }}
                            </td>
                        </tr>
                        <tr class="border-0">
                            <th colspan="7" align="right" class="border-0 text-right align_right pt-0">
                                Grand Total:
                            </th>
                            <td class="text-right border-left-0" align="right"
                                style="border-bottom: 2px solid #000;border-bottom: 3px double #000;border-right: 0 solid transparent;">
                                {{ number_format($ttl_amnt, 2) }}
                            </td>
                        </tr>
                        </tfoot>

                    </table>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                    </div>
                    <div class="col-md-9 text-right">
                        <span class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search, 'to' => $search_to, 'from' => $search_from, 'class_id' => $search_class,
                        'section'=> $search_section, 'status' => $search_status, 'type' => $search_type])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->

        </div><!-- col end -->

    </div><!-- row end -->

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
@endsection

@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('custom_voucher_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

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
    </script>

    <script>
        jQuery(".edit").click(function () {

            var account_id = jQuery(this).attr("data-id");

            jQuery("#account_id").val(account_id);
            jQuery("#edit").submit();
        });
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#search").val('');
            $("#to").val('');
            $("#from").val('');

            $("#class_id").select2().val(null).trigger("change");
            $("#class_id > option").removeAttr('selected');
            $("#section").select2().val(null).trigger("change");
            $("#section > option").removeAttr('selected');
            $("#type").select2().val(null).trigger("change");
            $("#type > option").removeAttr('selected');
            $("#status").select2().val(null).trigger("change");
            $("#status > option").removeAttr('selected');
        });
        jQuery("#section").select2();
    </script>
@endsection
