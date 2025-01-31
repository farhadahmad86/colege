@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Transport Pending Voucher List</h4>
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
                    <form class="highlight prnt_lst_frm" action="{{ route('transport_voucher_pending_list') }}" name="form1"
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
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        Month Search
                                    </label>

                                    <input tabindex="1" autofocus type="search" list="browsers"
                                           class="inputs_up form-control" name="month" id="month"
                                           placeholder="Month Search" value="{{ isset($search_month) ? $search_month : '' }}"
                                           autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach ($month_year as $value)
                                            <option value="{{ $value }}">
                                        @endforeach
                                    </datalist>

                                </div>
                            </div> <!-- left column ends here -->

                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 srch_brdr_left">
                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
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

                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
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

                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-lg-4 text-right">
                                        @include('include.clear_search_button')

                                        <!-- Call add button component -->
                                        <x-add-button tabindex="9" href="{{ route('transport_voucher') }}"/>
                                        @include('include/print_button')

                                        <span id="demo1" class="validate_sign"
                                              style="float: right !important"> </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form name="delete" id="delete" action="{{ route('reverse_transport_voucher') }}" method="post">
                        @csrf
                        <input name="tv_id" id="del_tv_id" type="hidden">
                        <input name="tv_v_no" id="del_tv_v_no" type="hidden">
                    </form>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th tabindex="-1" scope="col" class="tbl_srl_4">
                                Sr#
                            </th>

                            <th scope="col" class="tbl_amnt_7">
                                Date
                            </th>
                            <th scope="col" class="tbl_amnt_7">
                                Paid Date
                            </th>
                            <th scope="col" class="tbl_amnt_5">
                                Voucher#
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_txt_10">
                                Registration
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_txt_15">
                                Student Name
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_txt_8">
                                Issue Date
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_txt_8">
                                Due Date
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Total Amount
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Branch
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Status
                            </th><th scope="col" class="tbl_txt_8">
                                Delete
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
                            @php $per_page_ttl_amnt = +$voucher->tv_total_amount + +$per_page_ttl_amnt; @endphp

                            <tr>
                                <th scope="row">
                                    {{ $sr }}
                                </th>
                                <td>
                                    {{ date('d-M-y', strtotime(str_replace('/', '-', $voucher->tv_day_end_date))) }}
                                </td>
                                <td>
                                    {{ !empty($voucher->tv_paid_date) ?  date('d-M-y', strtotime(str_replace('/', '-', $voucher->tv_paid_date))) : '' }}
                                </td>
                                <td class="view" data-id="{{ $voucher->tv_v_no }}" data-reg_no="{{ $voucher->tv_reg_no }}" data-status="{{$voucher->tv_status}}">
                                    TV-{{ $voucher->tv_v_no }}
                                </td>
                                <td>
                                    {{ $voucher->registration_no }}
                                </td>
                                <td>
                                    {{ $voucher->full_name }}
                                </td>
                                <td>
                                    {{ $voucher->tv_issue_date }}
                                </td>
                                <td>
                                    {{ $voucher->tv_due_date }}
                                </td>
                                <td class="align_right text-right">
                                    {{ $voucher->tv_total_amount != 0 ? number_format($voucher->tv_total_amount, 2) : '' }}
                                </td>

                                @php
                                    $ip_browser_info = '' . $voucher->tv_ip_adrs . ',' . str_replace(' ', '-', $voucher->tv_brwsr_info) . '';
                                @endphp
                                <td>
                                    {{ $voucher->branch_name }}
                                </td>
                                <td class="usr_prfl"
                                    data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}"
                                    title="Click To See User Detail">
                                    {{ $voucher->user_name }}
                                </td>
                                <td class="text-center">
                                    {{$voucher->tv_status == 0 ? 'Pending': 'Paid'}}
                                </td>
                                <td class="text-center hide_column ">
                                    <a data-tv_id="{{$voucher->tv_id}}" data-tv_v_no="{{$voucher->tv_v_no}}" class="delete" data-toggle="tooltip" data-placement="left" title="" data-original-title="Are you sure you want to delete this voucher?">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @php
                                $sr++;
                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="12">
                                    <center>
                                        <h3 style="color:#554F4F">No voucher</h3>
                                    </center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                        <tfoot>
                        <tr class="border-0">
                            <th colspan="8" align="right" class="border-0 text-right align_right pt-0">
                                Per Page Total:
                            </th>
                            <td class="text-right border-left-0" align="right"
                                style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                                {{ number_format($per_page_ttl_amnt, 2) }}
                            </td>
                        </tr>
                        <tr class="border-0">
                            <th colspan="8" align="right" class="border-0 text-right align_right pt-0">
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
                        <span class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search, 'to' => $search_to, 'from' => $search_from,
                        'section'=>$search_month])->links()
                        }}</span>
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
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('transport_voucher_pending_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function () {

            jQuery("#table_body").html("");

            let status = jQuery(this).attr("data-status");
            if (status == 1) {
                Swal.fire({
                    title: "Good job!",
                    text: "یہ واؤچربھراجاچکاہے ",
                    icon: "success",
                    timer: 3000
                });
            } else {
                var id = jQuery(this).attr("data-id");
                var reg_no = jQuery(this).attr("data-reg_no");
                $(".modal-body").load('{{ url('transport_items_view_details/view/') }}/' + id + '/' + reg_no, function () {
                    $("#myModal").modal({
                        show: true
                    });
                });
            }
        });
    </script>

    <script>
        $('.delete').on('click', function (event) {

            var tv_id = jQuery(this).attr("data-tv_id");
            var tv_v_no = jQuery(this).attr("data-tv_v_no");

            event.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to delete this voucher?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
            }).then(function (result) {
                if (result.value) {
                    jQuery(".pre-loader").fadeToggle("medium");
                    jQuery("#del_tv_id").val(tv_id);
                    jQuery("#del_tv_v_no").val(tv_v_no);
                    jQuery("#delete").submit();
                }
            });
        });
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#search").val('');
            $("#month").val('');
            $("#to").val('');
            $("#from").val('');

        });

        jQuery("#status").select2();
    </script>
@endsection
