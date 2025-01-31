
@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">



                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Unit Testing List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i tabindex="-1" class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <!-- <div class="search_form {{ ( !empty($search) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}"> -->
                 
                <div class="search_form">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <form class="prnt_lst_frm" action="{{ route('unit_testing_list') }}" name="form1" id="form1" method="post">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input tabindex="1" autofocus type="search" class="inputs_up form-control" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->


                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">

                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Start Date
                                                    </label>
                                                    <input tabindex="2" type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......" />
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        End Date
                                                    </label>
                                                    <input tabindex="3" type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......" />
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Product
                                                    </label>
                                                    <select tabindex="4" name="product" class="inputs_up form-control" id="product">
                                                        <option value="">Select Product</option>
                                                        @foreach($products as $product)
                                                            <option
                                                                value="{{$product->pro_code}}" {{ $product->pro_code == $search_product ? 'selected="selected"' : '' }}>{{$product->pro_title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button tabindex="5" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button tabindex="6" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    <a tabindex="7" class="save_button form-control" href="{{ route('unit_testing') }}" role="button">
                                                        <i class="fa fa-plus"></i> Unit Testing
                                                    </a>

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
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">
                                Sr#
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_amnt_10">
                                Date
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_amnt_6">
                                Description
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_60">
                                Detail Remarks
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_amnt_10">
                                Action
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_8">
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
                            $per_page_ttl_amnt = 0;
                        @endphp
                        @forelse($datas as $invoice)
                            <tr>
                                <td class="align_center text-center edit tbl_srl_4">
                                    {{$sr}}
                                </td>
                                <td class="align_center text-center tbl_amnt_10">
                                    {{date('d-M-y', strtotime(str_replace('/', '-', $invoice->si_day_end_date)))}}
                                </td>
                                <td class="view align_center text-center tbl_amnt_6">
                                    {{$invoice->si_party_name}}
                                </td>
                                <td class="align_left text-left tbl_txt_62">
                                    {{$invoice->si_detail_remarks}}
                                </td>
                                <td class="align_right text-right tbl_amnt_10 hide_column">
                                    <a data-id="{{$invoice->si_id}}" class="view delete" data-toggle="modal"
                                       data-target="#myModal">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>

                                @php
                                    $ip_browser_info= ''.$invoice->si_ip_adrs.','.str_replace(' ','-',$invoice->si_brwsr_info).'';
                                @endphp

                                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $invoice->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{$invoice->user_name}}
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Invoice</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>


                    </table>
                </div>
                <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Unit Testing Detail</h4>
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
        var base = '{{ route('unit_testing_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

{{--    <script>--}}
{{--        // jQuery("#invoice_no").blur(function () {--}}
{{--        jQuery(".view").click(function () {--}}

{{--            // jQuery(".pre-loader").fadeToggle("medium");--}}
{{--            jQuery("#table_body").html("");--}}

{{--            var id = jQuery(this).attr("data-id");--}}
{{--            $(".modal-body").load('{{ url('cash_payment_items_view_details/view/') }}/'+id, function () {--}}
{{--                // jQuery(".pre-loader").fadeToggle("medium");--}}
{{--                $("#myModal").modal({show:true});--}}
{{--            });--}}

{{--        });--}}
{{--    </script>--}}


    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "{{ route('sale_items_view_details') }}",
                data: {id: id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    $.each(data, function (index, value) {

                        var qty;
                        var rate;
                        var discount;
                        var saletax;
                        var amount;

                        if(value['sii_qty']==0){
                            qty='';
                        }else{
                            qty=value['sii_qty'];
                        }
                        if(value['sii_rate']==0){
                            rate='';
                        }else{
                            rate=value['sii_rate'];
                        }
                        if(value['sii_discount']==0){
                            discount='';
                        }else{
                            discount=value['sii_discount'];
                        }
                        if(value['sii_saletax']==0){
                            saletax='';
                        }else{
                            saletax=value['sii_saletax'];
                        }
                        if(value['sii_amount']==0){
                            amount='';
                        }else{
                            amount=value['sii_amount'];
                        }

                        jQuery("#table_body").append(
                            '<div class="itm_vchr form_manage">' +
                                '<div class="form_header">' +
                                    '<h4 class="text-white file_name">' +
                                        '<span class="db sml_txt"> Product #: </span>' +
                                        '' + value['sii_product_code'] + '' +
                                    '</h4>' +
                                '</div>' +
                            '<div class="table-responsive">' +
                                '<table class="table table-bordered">' +
                                    '<thead>' +
                                        '<tr>' +
                                            '<th scope="col" align="center" class="width_2">Product Name</th>' +
                                            '<th scope="col" align="center" class="width_5">Rate</th>' +
                                            '<th scope="col" align="center" class="width_5 text-right">Quantity</th>' +
                                        '</tr>' +
                                    '</thead>' +
                                    '<tbody>' +
                                        '<tr>' +
                                            '<td class="align_left"> <div class="max_txt"> ' + value['sii_product_name'] + '</div> </td>' +
                                            '<td class="align_left">' + rate + '</td>' +
                                            '<td class="align_left text-right">' + qty + '</td>' +'</td>' +
                                        '</tr>' +
                                    '</tbody>' +
                                    '<tfoot class="side-section">'+
                                        '<tr class="border-0">'+
                                            '<td colspan="7" align="right" class="border-0">'+
                                                '<table class="m-0 p-0">'+
                                                    '<tfoot>'+
                                                        '<tr>'+
                                                            '<td>'+
                                                                '<label class="total-items-label text-right">Discounts</label>'+
                                                            '</td>'+
                                                            '<td class="p-0 text-right">'+
                                                                ((discount != null && discount != "") ? discount : '0.00') +
                                                            '</td>'+
                                                        '</tr>'+
                                                        '<tr>'+
                                                            '<td colspan="" align="right">'+
                                                                '<label class="total-items-label text-right">Sale Tax</label>'+
                                                            '</td>'+
                                                            '<td class="p-0 text-right" align="right">'+
                                                                ((saletax != null && saletax != "") ? saletax : '0.00') +
                                                            '</td>'+
                                                        '</tr>'+
                                                        '<tr>'+
                                                            '<td colspan="" align="right">'+
                                                                '<label class="total-items-label text-right">Total Amount</label>'+
                                                            '</td>'+
                                                            '<td class="p-0 text-right" align="right">'+
                                                                ((amount != null && amount != "") ? amount : '0.00') +
                                                            '</td>'+
                                                        '</tr>'+
                                                    '</tfoot>'+
                                                '</table>'+
                                            '</td>'+
                                        '</tr>'+
                                    '</tfoot>'+
                                '</table>' +
                            '</div>' +
                            '<div class="itm_vchr_rmrks '+((value['sii_remarks'] != null && value['sii_remarks'] != "") ? '' : 'hidden') +'">' +
                                '<h5 class="title_cus bold"> Remarks: </h5>' +
                                '<p class="m-0 p-0">' + value['sii_remarks'] + '</p>' +
                            '</div>' +
                            '<div class="input_bx_ftr"></div>' +
                        '</div>');

                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });
    </script>


    <script>
        jQuery("#cancel").click(function () {

            $("#product").select2().val(null).trigger("change");
            $("#product > option").removeAttr('selected');

            $("#search").val('');

            $("#to").val('');
            $("#from").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#product").select2();
        });
    </script>

@endsection

