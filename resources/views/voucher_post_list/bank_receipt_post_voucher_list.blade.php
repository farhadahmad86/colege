@extends('extend_index')

@section('content')
    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Post Bank Receipt Voucher List</h4>
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
                    <form class="highlight prnt_lst_frm" action="{{ route('bank_receipt_post_voucher_list') }}" name="form1" id="form1"
                          method="post">
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

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Bank Account
                                            </label>
                                            <select tabindex="4" name="bank_account"
                                                    class="inputs_up form-control" id="bank_account">
                                                <option value="">Select Bank Account</option>
                                                @foreach ($bank_accounts as $bank_account)
                                                    <option value="{{ $bank_account->account_uid }}"
                                                        {{ $bank_account->account_uid == $search_bank_account ? 'selected="selected"' : '' }}>
                                                        {{ $bank_account->account_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-lg-4 text-right">
                                        @include('include.clear_search_button')

<!-- Call add button component -->
<x-add-button tabindex="9" href="{{ route('bank_receipt_voucher') }}"/>
                                        @include('include/print_button')

                                        <span id="demo1" class="validate_sign"
                                              style="float: right !important"> </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form name="edit" id="edit" action="{{ route('edit_account') }}" method="post">
                        @csrf
                        <input name="account_id" id="account_id" type="hidden">
                    </form>
                </div><!-- search form end -->

                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">
                        <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">
                                Sr#
                            </th>

                            <th scope="col" class="tbl_amnt_10">
                                Date
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Voucher#
                            </th>
                            <th tabindex="-1" scope="col"
                                class="tbl_txt_15">
                                Remarks
                            </th>
                            <th scope="col" class="tbl_txt_41">
                                Detail Remarks
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Total Amount
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Action
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
                            @php $per_page_ttl_amnt = +$voucher->br_total_amount + +$per_page_ttl_amnt; @endphp

                            <tr data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="View Journal Voucher">
                                <th scope="row" class="edit">
                                    {{ $sr }}
                                </th>

                                <td>
                                    {{ date('d-M-y', strtotime(str_replace('/', '-', $voucher->br_day_end_date))) }}
                                </td>
                                <td class="view" data-id="{{ $voucher->br_id }}">
                                    BRV-{{ $voucher->br_id }}
                                </td>
                                <td>
                                    {{ $voucher->br_remarks }}
                                </td>
                                <td>
                                    {!! str_replace('&oS;', '<br />', $voucher->br_detail_remarks) !!}
                                </td>
                                <td class="align_right text-right">
                                    {{ $voucher->br_total_amount != 0 ? number_format($voucher->br_total_amount, 2) : '' }}
                                </td>

                                @php
                                    $ip_browser_info = '' . $voucher->br_ip_adrs . ',' . str_replace(' ', '-', $voucher->br_brwsr_info) . '';
                                @endphp

                                <td class="usr_prfl"
                                    data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}"
                                    title="Click To See User Detail">
                                    {{ $voucher->user_name }}
                                </td>
                                <td class="text-center"
                                    title="Click To See User Detail">
                                    <form method="post" action="{{ route('post_bank_receipt_voucher', $voucher->br_id) }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $voucher->br_id }}">
                                        <button type="submit" class="btn btn-sm btn-info">Post</button>

                                    </form>
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
                                        <h3 style="color:#554F4F">No Vouchar</h3>
                                    </center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                        <tfoot>
                        <tr class="border-0">
                            <th colspan="5" align="right" class="border-0 text-right align_right pt-0">
                                Per Page Total:
                            </th>
                            <td class="text-right border-left-0" align="right"
                                style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                                {{ number_format($per_page_ttl_amnt, 2) }}
                            </td>
                        </tr>
                        <tr class="border-0">
                            <th colspan="5" align="right" class="border-0 text-right align_right pt-0">
                                Grand Total:
                            </th>
                            <td class="text-right border-left-0" align="right"
                                style="border-bottom: 2px solid #000;border-bottom: 3px double #000;border-right: 0 solid transparent;">
                                {{ number_format($ttl_amnt, 2) }}
                            </td>
                        </tr>
                        </tfoot>

                    </table>
                </div><div class="row">
    <div class="col-md-3">
        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
    </div>
    <div class="col-md-9 text-right">
                <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search, 'to' => $search_to, 'from' => $search_from])->links() }}</span>
                </div></div></div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Bank Receipt Voucher Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="itm_vchr form_manage">
                        <div class="form_header">
                            <h4 class="text-white file_name">
                                <span class="db sml_txt"> Voucher #: </span>
                            </h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                <tr>
                                    <th scope="col" class="wdth_5">Account No.</th>
                                    <th scope="col" class="wdth_2">Account Name</th>
                                    <th scope="col" class="wdth_5 text-right">Amount</th>
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
        var base = '{{ route('bank_receipt_post_voucher_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function () {

            jQuery("#table_body").html("");
            // jQuery(".pre-loader").fadeToggle("medium");

            var id = jQuery(this).attr("data-id");
            $(".modal-body").load('{{ url('bank_receipt_items_view_details/view/') }}/' + id, function () {
                // jQuery(".pre-loader").fadeToggle("medium");
                $("#myModal").modal({
                    show: true
                });
            });

        // {{-- jQuery.ajaxSetup({ --}}
        // {{--    headers: { --}}
        // {{--        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') --}}
        // {{--    } --}}
        // {{-- }); --}}

        // {{-- jQuery.ajax({ --}}
        // {{--    url: "{{ route('bank_receipt_items_view_details') }}", --}}
        // {{--    data: {id: id}, --}}
        // {{--    type: "POST", --}}
        // {{--    cache: false, --}}
        // {{--    dataType: 'json', --}}
        // {{--    success: function (data) { --}}

        // {{--        var ttlAmnt = 0; --}}
        // {{--        $.each(data, function (index, value) { --}}
        // {{--            var amnt = (value['bri_amount'] !== "") ? value['bri_amount'] : 0; --}}
        // {{--            ttlAmnt = ttlAmnt + amnt; --}}


        // {{--            jQuery("#table_body").append( --}}
        // {{--            '<tr>' + --}}
        // {{--            '<td class="align_left wdth_5">' + value['bri_account_id'] + '</td>' + --}}
        // {{--            '<td class="align_left wdth_2"> <div class="max_txt"> ' + value['bri_account_name'] + '</div> </td>' + --}}
        // {{--            '<td class="align_left text-right wdth_5">' + value['bri_amount'] + '</td>' + --}}
        // {{--            '</tr>'); --}}

        // {{--        }); --}}
        // {{--        jQuery("#table_foot").html( --}}
        // {{--            '<tr>' + --}}
        // {{--            '<td colspan="1" class="align_left"></td>' + --}}
        // {{--            '<td class="align_left text-right wdth_5 border-right-0" style="border-top: 2px double #000;"> Total Amount </td>' + --}}
        // {{--            '<td class="align_left text-right wdth_5 border-left-0" style="border-top: 2px double #000;">' + ttlAmnt + '</td>' + --}}
        // {{--            '</tr>'); --}}
        // {{--    }, --}}
        // {{--    error: function (jqXHR, textStatus, errorThrown) { --}}
        // {{--        // alert(jqXHR.responseText); --}}
        // {{--        // alert(errorThrown); --}}
        // {{--    } --}}
        // {{-- }); --}}
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

            $("#bank_account").select2().val(null).trigger("change");
            $("#bank_account > option").removeAttr('selected');
        });

        jQuery("#bank_account").select2();
    </script>
@endsection
