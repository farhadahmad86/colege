@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Credit Card Machine Settlement List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <div class="search_form {{ ( !empty($search) || !empty($search_bank) || !empty($search_machine) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <form class="prnt_lst_frm" action="{{ route('credit_card_machine_settlement_list') }}" name="form1" id="form1" method="post">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."
                                                   value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($party as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Bank
                                                    </label>
                                                    <select class="inputs_up form-control" name="account" id="account">
                                                        <option value="">Select Bank</option>
                                                        @foreach($accounts as $account)
                                                            <option
                                                                value="{{$account->account_uid}}" {{ $account->account_uid == $search_bank ? 'selected="selected"' : '' }}>{{$account->account_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Machine
                                                    </label>
                                                    <select class="inputs_up form-control" name="machine" id="machine">
                                                        <option value="">Select Machine</option>
                                                        @foreach($machines as $machine)
                                                            <option value="{{$machine->ccm_id}}" {{ $machine->ccm_id == $search_machine ? 'selected="selected"' : '' }}>{{$machine->ccm_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Start Date
                                                    </label>
                                                    <input type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
                                                           <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......"/>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        End Date
                                                    </label>
                                                    <input type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off"
                                                           <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......"/>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                @include('include.clear_search_button')
                                                <!-- Call add button component -->
                                                    <x-add-button tabindex="9" href="{{ route('credit_card_machine_settlement') }}"/>

                                                    @include('include/print_button')

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                            </form>

                        </div>

                    </div>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                                Sr#
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_9">
                                Settlement Date
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                                Time
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_13">
                                Bank Name
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_15">
                                Machine Name
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                                Batch
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                                Amount
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_25">
                                Remarks
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Created By
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            $ttlPrc = $cashPaid = 0;
                        @endphp
                        @forelse($datas as $invoice)

                            <tr>
                                <td class="align_center text-center edit tbl_srl_4">
                                    {{$sr}}
                                </td>
                                <td nowrap class="align_center text-center tbl_amnt_9">
                                    {{date('d-M-y', strtotime(str_replace('/', '-', $invoice->ccms_date)))}}
                                </td>
                                <td class="align_center text-center tbl_amnt_6">
                                    {{ date("g:i a", strtotime($invoice->ccms_time))}}
                                </td>
                                <td class="align_left text-left tbl_txt_13">
                                    {{$invoice->account_name}}
                                </td>
                                <td class="align_left text-left tbl_txt_15">
                                    {{$invoice->ccm_title}}
                                </td>
                                <td class="align_center text-center tbl_amnt_10">
                                    {{$invoice->ccms_batch_number }}
                                </td>
                                <td class="align_right text-right tbl_amnt_10">
                                    {{$invoice->ccms_amount !=0 ? number_format($invoice->ccms_amount,2):''}}
                                </td>
                                <td class="align_right text-right tbl_amnt_25">
                                    {{$invoice->ccms_remarks}}
                                </td>

                                @php
                                    $ip_browser_info= ''.$invoice->ccms_ip_adrs.','.str_replace(' ','-',$invoice->ccms_brwsr_info).'';
                                @endphp

                                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $invoice->user_id }}" data-user_info="{!! $ip_browser_info !!}"
                                    title="Click To See User Detail">
                                    {{$invoice->user_name}}
                                </td>
                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="15">
                                    <center><h3 style="color:#554F4F">No Credit Card Machine Settlement</h3></center>
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
                        <span
                            class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'bank'=>$search_bank, 'machine'=>$search_machine, 'to'=>$search_to, 'from'=>$search_from])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg mdl_wdth">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Credit Card Machine Settlement</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div id="table_body">

                    </div>
                    <div id="hello"></div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">
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
        var base = '{{ route('credit_card_machine_settlement_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function () {
            // jQuery(".pre-loader").fadeToggle("medium");
            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");
            $('.modal-body').load('{{url("purchase_items_view_details/view/")}}' + '/' + id, function () {
                // jQuery(".pre-loader").fadeToggle("medium");
                $('#myModal').modal({show: true});
            });

            {{--jQuery.ajaxSetup({--}}
            {{--    headers: {--}}
            {{--        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')--}}
            {{--    }--}}
            {{--});--}}

            {{--jQuery.ajax({--}}
            {{--    url: "{{ route('purchase_items_view_details') }}",--}}
            {{--    data: {id: id},--}}
            {{--    type: "POST",--}}
            {{--    cache: false,--}}
            {{--    dataType: 'json',--}}
            {{--    success: function (data) {--}}

            {{--        jQuery("#hello").html(--}}
            {{--           'this is Account Name'+data+'yuppp...'--}}
            {{--    );--}}


            {{--        $.each(data, function (index, value) {--}}

            {{--            var qty;--}}
            {{--            var rate;--}}
            {{--            var discount;--}}
            {{--            var saletax;--}}
            {{--            var amount;--}}
            {{--            var gross_rate;--}}
            {{--            var expense;--}}
            {{--            var net_rate;--}}

            {{--            if(value['pii_qty']==0){--}}
            {{--                 qty='';--}}
            {{--            }else{--}}
            {{--                qty=value['pii_qty'];--}}
            {{--            }--}}
            {{--            if(value['pii_rate']==0){--}}
            {{--                rate='';--}}
            {{--            }else{--}}
            {{--                rate=value['pii_rate'];--}}
            {{--            }--}}
            {{--            if(value['pii_discount']==0){--}}
            {{--                discount='';--}}
            {{--            }else{--}}
            {{--                discount=value['pii_discount'];--}}
            {{--            }--}}
            {{--            if(value['pii_saletax']==0){--}}
            {{--                saletax='';--}}
            {{--            }else{--}}
            {{--                saletax=value['pii_saletax'];--}}
            {{--            }--}}
            {{--            if(value['pii_amount']==0){--}}
            {{--                amount='';--}}
            {{--            }else{--}}
            {{--                amount=value['pii_amount'];--}}
            {{--            }--}}
            {{--            if(value['pii_gross_rate']==0){--}}
            {{--                gross_rate='';--}}
            {{--            }else{--}}
            {{--                gross_rate=value['pii_gross_rate'];--}}
            {{--            }--}}
            {{--            if(value['pii_expense']==0){--}}
            {{--                expense='';--}}
            {{--            }else{--}}
            {{--                expense=value['pii_expense'];--}}
            {{--            }--}}
            {{--            if(value['pii_net_rate']==0){--}}
            {{--                net_rate='';--}}
            {{--            }else{--}}
            {{--                net_rate=value['pii_net_rate'];--}}
            {{--            }--}}

            {{--            jQuery("#table_body").append(--}}
            {{--                '<div class="itm_vchr form_manage">' +--}}
            {{--                    '<div class="form_header">' +--}}
            {{--                        '<h4 class="text-white file_name">' +--}}
            {{--                            '<span class="db sml_txt"> Product #: </span>' +--}}
            {{--                            '' + value['pii_product_code'] + '' +--}}
            {{--                        '</h4>' +--}}
            {{--                    '</div>' +--}}
            {{--                    '<div class="table-responsive">' +--}}
            {{--                        '<table class="table table-bordered">' +--}}
            {{--                            '<thead>' +--}}
            {{--                                '<tr>' +--}}
            {{--                                    '<th scope="col" align="center" class="width_2">Product Name</th>' +--}}
            {{--                                    '<th scope="col" align="center" class="width_5">Rate</th>' +--}}
            {{--                                    '<th scope="col" align="center" class="width_5">Quantity</th>' +--}}
            {{--                                    '<th scope="col" align="center" class="width_5 text-right">Expense Per Pro.</th>' +--}}
            {{--                                '</tr>' +--}}
            {{--                            '</thead>' +--}}
            {{--                            '<tbody>' +--}}
            {{--                                '<tr>' +--}}
            {{--                                    '<td class="align_left"> <div class="max_txt"> ' + value['pii_product_name'] + '</div> </td>' +--}}
            {{--                                    '<td class="align_left">' + rate + '</td>' +--}}
            {{--                                    '<td class="align_left">' + qty + '</td>' +--}}
            {{--                                    '<td class="align_left text-right">' + ((expense != null && expense != "") ? expense : '0.00') + '</td>' +--}}
            {{--                                '</tr>' +--}}
            {{--                            '</tbody>' +--}}
            {{--                            '<tfoot class="side-section">'+--}}
            {{--                                '<tr class="border-0">'+--}}
            {{--                                    '<td colspan="7" align="right" class="p-0 border-0">'+--}}
            {{--                                        '<table class="m-0 p-0 chk_dmnd">'+--}}
            {{--                                            '<tfoot>'+--}}
            {{--                                                '<tr>'+--}}
            {{--                                                    '<td>'+--}}
            {{--                                                        '<label class="total-items-label">Gross Rate</label>'+--}}
            {{--                                                        gross_rate +--}}
            {{--                                                    '</td>'+--}}
            {{--                                                    '<td>'+--}}
            {{--                                                        '<label class="total-items-label">Net Rate</label>'+--}}
            {{--                                                        net_rate +--}}
            {{--                                                    '</td>'+--}}
            {{--                                                    '<td class="border-top-0 border-right-0">'+--}}
            {{--                                                        '<label class="total-items-label text-right">Discounts</label>'+--}}
            {{--                                                    '</td>'+--}}
            {{--                                                    '<td class="text-right border-top-0 border-left-0">'+--}}
            {{--                                                        ((discount != null && discount != "") ? discount : '0.00') +--}}
            {{--                                                    '</td>'+--}}
            {{--                                                '</tr>'+--}}
            {{--                                                '<tr>'+--}}
            {{--                                                    '<td colspan="3" align="right" class="border-right-0">'+--}}
            {{--                                                        '<label class="total-items-label text-right">Sale Tax</label>'+--}}
            {{--                                                    '</td>'+--}}
            {{--                                                    '<td class="text-right border-left-0" align="right">'+--}}
            {{--                                                        ((saletax != null && saletax != "") ? saletax : '0.00') +--}}
            {{--                                                    '</td>'+--}}
            {{--                                                '</tr>'+--}}
            {{--                                                '<tr>'+--}}
            {{--                                                    '<td colspan="3" align="right" class="border-right-0">'+--}}
            {{--                                                        '<label class="total-items-label text-right">Total Amount</label>'+--}}
            {{--                                                    '</td>'+--}}
            {{--                                                    '<td class="text-right border-left-0" align="right">'+--}}
            {{--                                                        ((amount != null && amount != "") ? amount : '0.00') +--}}
            {{--                                                    '</td>'+--}}
            {{--                                                '</tr>'+--}}
            {{--                                            '</tfoot>'+--}}
            {{--                                        '</table>'+--}}
            {{--                                    '</td>'+--}}
            {{--                                '</tr>'+--}}
            {{--                            '</tfoot>'+--}}
            {{--                        '</table>' +--}}
            {{--                    '</div>' +--}}
            {{--                    '<div class="itm_vchr_rmrks '+((value['pii_remarks'] != null && value['pii_remarks'] != "") ? '' : 'search_form_hidden') +'">' +--}}
            {{--                        '<h5 class="title_cus bold"> Remarks: </h5>' +--}}
            {{--                        '<p class="m-0 p-0">' + value['pii_remarks'] + '</p>' +--}}
            {{--                    '</div>' +--}}
            {{--                    '<div class="input_bx_ftr"></div>' +--}}
            {{--                '</div>');--}}

            {{--        });--}}
            {{--    },--}}
            {{--    error: function (jqXHR, textStatus, errorThrown) {--}}
            {{--        // alert(jqXHR.responseText);--}}
            {{--        // alert(errorThrown);--}}
            {{--    }--}}
            {{--});--}}





        });
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#account").select2().val(null).trigger("change");
            $("#account > option").removeAttr('selected');

            $("#machine").select2().val(null).trigger("change");
            $("#machine > option").removeAttr('selected');

            $("#search").val('');

            $("#to").val('');
            $("#from").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#account").select2();
            jQuery("#machine").select2();

        });
    </script>

@endsection

