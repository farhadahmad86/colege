@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Advance Salary</h4>
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
                    <form class="highlight prnt_lst_frm" action="{{ route('advance_salary_list') }}" name="form1"
                          id="form1" method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers"
                                           class="inputs_up form-control" name="search" id="search"
                                           placeholder="Search ..." value="{{ isset($search) ? $search : '' }}"
                                           autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach ($accounts as $value)
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
                                                Account From
                                            </label>
                                            <select tabindex="2" class="inputs_up form-control" name="account_from"
                                                    id="account_from">
                                                <option value="">Select Account</option>
                                                @foreach ($pay_accounts as $pay_account)
                                                    <option value="{{ $pay_account->account_uid }}"
                                                        {{ $pay_account->account_uid == $search_account_from ? 'selected="selected"' : '' }}>
                                                        {{ $pay_account->account_name }}</option>
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
                                                Account To
                                            </label>
                                            <select tabindex="3" class="inputs_up form-control" name="account_to"
                                                    id="account_to">
                                                <option value="">Select Account</option>
                                                @foreach ($advance_salary_accounts as $advance_salary_account)
                                                    <option value="{{ $advance_salary_account->account_uid }}"
                                                        {{ $advance_salary_account->account_uid == $search_account_to ? 'selected="selected"' : '' }}>
                                                        {{ $advance_salary_account->account_name }}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Month
                                            </label>
                                            <input tabindex="2" type="text" name="month" id="month" class="inputs_up form-control month-picker" autocomplete="off" <?php if(isset
                                            ($search_month)){?> value="{{$search_month}}" <?php } ?>
                                                   placeholder="Start Month ......">

                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Start Date
                                            </label>
                                            <input tabindex="4" type="text" name="to" id="to"
                                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                                   <?php if(isset($search_to)){?> value="{{ $search_to }}" <?php } ?>
                                                   placeholder="Start Date ......"/>
                                            <span id="demo1" class="validate_sign" style="float: right !important">
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                End Date
                                            </label>
                                            <input tabindex="5" type="text" name="from" id="from"
                                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                                   <?php if(isset($search_from)){?> value="{{ $search_from }}" <?php } ?>
                                                   placeholder="End Date ......"/>
                                            <span id="demo1" class="validate_sign" style="float: right !important">
                                            </span>
                                        </div>
                                    </div>
                                    <x-year-end-component search="{{$search_year}}"/>
                                    <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12 text-right mt-4">

                                    @include('include.clear_search_button')
                                    <!-- Call add button component -->
                                        <x-add-button tabindex="9" href="{{ route('add_new_advance_salary') }}"/>

                                        @include('include/print_button')

                                        <span id="demo1" class="validate_sign" style="float: right !important">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div><!-- search form end -->
                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" class=" tbl_srl_4">
                                Sr#
                            </th>
                            <th scope="col" class=" tbl_amnt_8">
                                Month
                            </th>
                            <th scope="col" class=" tbl_amnt_8">
                                Date
                            </th>
                            <th scope="col" class=" tbl_amnt_9">
                                Voucher No.
                            </th>
                            <th scope="col" class=" tbl_txt_15">
                                Account From
                            </th>
                            <th scope="col" class=" tbl_txt_15">
                                Remarks
                            </th>
                            <th scope="col" class=" tbl_txt_19">
                                Detail Remarks
                            </th>
                            <th scope="col" class=" tbl_amnt_13">
                                Amount
                            </th>
                            <th scope="col" class=" tbl_txt_8">
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
                            $per_page_ttl_amnt = 0;
                        @endphp
                        @forelse($datas as $salary)
                            <tr>
                                <th class=" edit tbl_srl_4">
                                    {{ $sr }}
                                </th>
                                <td class=" tbl_amnt_8">
                                    {{ $salary->as_month }}
                                </td>
                                <td class=" tbl_amnt_8">
                                    {{ date('d-M-y', strtotime(str_replace('/', '-', $salary->as_day_end_date))) }}
                                </td>
                                <td class=" tbl_amnt_9">
                                    <a class="view" data-transcation_id="{{ 'ASV-' . $salary->as_id }}"
                                       data-id="{{ $salary->as_id }}" data-toggle="modal" data-target="#myModal"
                                       style="cursor:pointer; color: #0099ff;">
                                        {{ 'ASV-' . $salary->as_id }}
                                    </a>
                                </td>
                                <td class="align_left text-left tbl_txt_15">
                                    {{ $salary->from }}
                                </td>
                                <td class="align_left text-left tbl_txt_15">
                                    {{ $salary->as_remarks }}
                                </td>
                                <td class="align_left text-left tbl_txt_19">
                                    {!! str_replace('&oS;', '<br />', $salary->as_detail_remarks) !!}
                                </td>
                                @php $per_page_ttl_amnt = +$salary->as_amount + +$per_page_ttl_amnt; @endphp

                                <td class="align_right text-right tbl_amnt_13">
                                    {{ $salary->as_amount }}
                                </td>

                                @php
                                    $ip_browser_info = '' . $salary->as_ip_adrs . ',' . str_replace(' ', '-', $salary->as_brwsr_info) . '';
                                @endphp

                                <td class="align_left text-left usr_prfl tbl_txt_8"
                                    data-usr_prfl="{{ $salary->user_id }}" data-user_info="{!! $ip_browser_info !!}"
                                    title="Click To See User Detail">
                                    {{ $salary->user_name }}
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
                                        <h3 style="color:#554F4F">No Entry</h3>
                                    </center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                        <tfoot>
                        <tr class="border-0">
                            <th colspan="7" align="right" class="border-0 text-right align_right pt-0">
                                Page Total:
                            </th>
                            <td class="text-right border-left-0" align="right"
                                style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                                {{ number_format($per_page_ttl_amnt, 2) }}
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
                        <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search, 'to' => $search_to, 'from' => $search_from])->links() }}</span>
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
                    <h4 class="modal-title text-blue table-header">Items Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive table-values">
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-6 col-md-6"></div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <button type="button" class="btn btn-default form-control cancel_button"
                                data-dismiss="modal">Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('advance_salary_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    {{--    this script add by hamza --}}
    <script>
        jQuery(".view").click(function () {

            var transcation_id = jQuery(this).attr("data-id");
            // var transcation_id = jQuery(this).attr("data-transcation_id");
            jQuery(".table-header").html("");
            jQuery(".table-values").html("");

            $(".modal-body").load('{{ url('advance_salary_items_view_details/view/') }}/' + transcation_id,
                function () {
                    $('#myModal').modal({
                        show: true
                    });
                });
            {{-- $(".modal-body").load('{{ url('/transaction_view_details_SH/') }}/'+transcation_id, function () { --}}
            {{--    $('#myModal').modal({show:true}); --}}
            {{-- }); --}}
        });
    </script>

    <script>
        $(document).on("click", ".purchase", function () {
            $('#myModal').modal('hide');

            jQuery("#table_body1").html("");

            var id = jQuery(this).attr("data-id");

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "purchase_items_view_details",
                data: {
                    id: id
                },
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    $.each(data, function (index, value) {

                        jQuery("#table_body1").append('<tr><td class="align_center">' + value[
                                'pii_product_code'] + '</td><td class="align_left">' +
                            value['pii_product_name'] + '</td><td class="align_right">' +
                            value['pii_qty'] + '</td><td class="align_right">' + value[
                                'pii_rate'] + '</td><td class="align_right">' + value[
                                'pii_discount'] + '</td><td class="align_right">' + value[
                                'pii_saletax'] + '</td><td class="align_right">' + value[
                                'pii_amount'] + '</td><td class="align_right">' + value[
                                'pii_gross_rate'] + '</td><td class="align_right">' + value[
                                'pii_expense'] + '</td><td class="align_right">' + value[
                                'pii_net_rate'] + '</td><td class="align_left">' + value[
                                'pii_remarks'] + '</td></tr>');

                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>

    <script type="text/javascript">
        // var doc = new jsPDF();
        // var specialElementHandlers = {
        //     '#editor': function (element, renderer) {
        //         return true;
        //     }
        // };
        //
        // $('#pdfTable').click(function () {
        //     doc.fromHTML($('#printTable').html(), 15, 15, {
        //         'width': 500,
        //         'elementHandlers': specialElementHandlers
        //     });
        //     doc.save('sample-file.pdf');
        // });
    </script>
    {{--    this script add by hamza --}}



    <script>
        jQuery("#cancel").click(function () {

            $("#account_from").select2().val(null).trigger("change");
            $("#account_from > option").removeAttr('selected');

            $("#account_to").select2().val(null).trigger("change");
            $("#account_to > option").removeAttr('selected');
            $("#month").val('');
            $("#search").val('');

            $("#to").val('');
            $("#from").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#account_to").select2();
            jQuery("#account_from").select2();
        });
    </script>
@endsection
