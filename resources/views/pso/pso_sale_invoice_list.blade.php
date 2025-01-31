<!DOCTYPE html>
<html>
<head>
    @include('include/head')
</head>
<body>
@include('include/header')
@include('include.sidebar_shahzaib')

<script type="text/javascript">

    function validate_form()
    {
        var search  = document.getElementById("search").value;

        var flag_submit = true;

        if(search.trim() == "")
        {
            document.getElementById("demo1").innerHTML = "Required";
            jQuery("#search").focus();
            flag_submit = false;
        }else{
            document.getElementById("demo1").innerHTML = "";
        }

        return flag_submit;
    }
</script>

<div class="main-container">
    <div class="pd-ltr-20 customscroll-10-p height-100-p xs-pd-20-10">
        @include('inc._messages')


        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">

                <div class="page-header">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <nav aria-label="breadcrumb" role="navigation">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Sale Invoice List</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">

                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white file_name">Sale Invoice List</h4>
                            </div>
                            <div class="list_btn list_mul">
                                <a class="add_btn add_more_button hide_column" href="{{ route('sale_invoice') }}" role="button">
                                    <i class="fa fa-plus"></i> Add Sale Invoice
                                </a>
                                <a class="add_btn add_more_button hide_column" href="{{ route('sale_invoice_on_net') }}" role="button">
                                    <i class="fa fa-plus"></i> Add On-Cash Invoice
                                </a>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->


                    <div class="search_form">
                        <div class="row">

                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                                <div class="form-group">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Search
                                        </label>
                                        <select class="inputs_up form-control" id="srch_slct">
                                            <option value="all_data">All Data</option>
                                            <option value="full_search" selected>Full Search</option>
                                            <option value="custom_search">Custom Search</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">

                                <div id="full_search" class="frm_hide show_active">
                                    <form action="{{ route('sale_invoice_list') }}" name="form1" id="form1" method="post" onsubmit="return validate_form()">
                                        <div class="row">
                                            @csrf
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <div class="row">
                                                        <div class="form-group col-lg-9 col-md-9 col-sm-12">
                                                            <input type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}" autocomplete="off" required>
                                                            <datalist id="browsers">
                                                                @foreach($party as $value)
                                                                    <option value="{{$value}}">
                                                                @endforeach
                                                            </datalist>
                                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                                            <button class="save_button form-control" name="go" id="go">
                                                                <i class="fa fa-search"></i> Search
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- left column ends here -->
                                        </div>
                                    </form>
                                </div>

                                <div id="all_data" class="frm_hide">
                                    <form action="{{ route('sale_invoice_list') }}" name="form" id="form" method="post">
                                        @csrf
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <button type="submit" name="save" id="save" class="save_button form-control">
                                                    <i class="fa fa-search"></i> All Data
                                                </button>
                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                            </div>
                                        </div> <!-- right columns ends here -->
                                    </form>
                                </div>

                                <div id="custom_search" class="frm_hide">
                                    <form action="{{ route('sale_invoice_list') }}" name="form_filter" id="form_filter" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="row">
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <select class="inputs_up  form-control" name="account" id="account">
                                                                <option value="">Select Account</option>
                                                                @foreach($accounts as $account)
                                                                    <option value="{{$account->account_uid}}" {{ $account->account_uid == $search_account ? 'selected="selected"' : '' }}>{{$account->account_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <select class="inputs_up  form-control" name="product" id="product">
                                                                <option value="">Select Product</option>
                                                                @foreach($products as $product)
                                                                    <option value="{{$product->pro_code}}" {{ $product->pro_code == $search_product ? 'selected="selected"' : '' }}>{{$product->pro_title}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <input type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......" />
                                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <input type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......" />
                                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-12">
                                                <div class="form_controls">
                                                    <button type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button type="submit" name="filter_search" id="filter_search" class="save_button form-control">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>


                                <form name="edit" id="edit" action="{{ route('edit_account') }}" method="post">
                                    @csrf
                                    <input name="account_id" id="account_id" type="hidden">
                                </form>

                            </div>

                        </div>
                    </div><!-- search form end -->


                    @include('include/print_button')

                    <div class="table-responsive" id="printTable">
                        <table class="table table-bordered table-sm" id="fixTable">
                            <thead>
                                <tr>
                                    <th scope="col" >Date</th>
                                    <th scope="col" >Invoice#</th>
{{--                                    <th scope="col" >Detail Remarks</th>--}}
                                    {{--<th scope="col" style="width:80px; text-align: center !important" >Party Code</th>--}}
                                    <th scope="col" >Party Name</th>
                                    <th scope="col" >Total Price</th>
{{--                                    <th scope="col" >Expense</th>--}}
{{--                                    <th scope="col" >Trade Disc%</th>--}}
{{--                                    <th scope="col" >Trade Disc</th>--}}
{{--                                    <th scope="col" >Value of Supply</th>--}}
{{--                                    <th scope="col" >Sale tax</th>--}}
{{--                                    <th scope="col" >Special Disc%</th>--}}
{{--                                    <th scope="col" >Special Disc</th>--}}
{{--                                    <th scope="col" >Grand Total</th>--}}
                                    <th scope="col" >Cash Rec</th>
{{--                                    <th scope="col" >Remarks</th>--}}
                                    {{--<th scope="col" style="width:80px; text-align: center !important" >Date/Time</th>--}}
                                    <th scope="col"  class="align_center hide_column">Action</th>
                                </tr>
                            </thead>


                            <tbody>
                            @php
                                $sr=1;
                            @endphp
                            @forelse($invoices as $invoice)

                                <tr>
                                    <td nowrap class="align_left">{{date('d-M-y', strtotime(str_replace('/', '-', $invoice->si_day_end_date)))}}</td>
                                    <td class="align_left">{{$invoice->si_id}}</td>
{{--                                    <td class="align_center" style="white-space:pre-wrap;">{{$invoice->si_detail_remarks}}</td>--}}
                                    {{--<td class="align_center">{{$invoice->si_party_code}}</td>--}}
                                    <td class="align_left">{{$invoice->si_party_name}}</td>
                                    <td class="align_left">{{$invoice->si_total_price !=0 ? number_format($invoice->si_total_price,2):''}}</td>
{{--                                    <td class="align_right">{{$invoice->si_expense !=0 ? number_format($invoice->si_expense,2):''}}</td>--}}
{{--                                    <td class="align_right">{{$invoice->si_trade_disc_percentage !=0 ? number_format($invoice->si_trade_disc_percentage,2):''}}</td>--}}
{{--                                    <td class="align_right">{{$invoice->si_trade_disc !=0 ? number_format($invoice->si_trade_disc,2):''}}</td>--}}
{{--                                    <td class="align_right">{{$invoice->si_value_of_supply !=0 ? number_format($invoice->si_value_of_supply,2):''}}</td>--}}
{{--                                    <td class="align_right">{{$invoice->si_sales_tax !=0 ? number_format($invoice->si_sales_tax,2):''}}</td>--}}
{{--                                    <td class="align_right">{{$invoice->si_special_disc_percentage !=0 ? number_format($invoice->si_special_disc_percentage,2):''}}</td>--}}
{{--                                    <td class="align_right">{{$invoice->si_special_disc !=0 ? number_format($invoice->si_special_disc,2):''}}</td>--}}
{{--                                    <td class="align_right">{{$invoice->si_grand_total !=0 ? number_format($invoice->si_grand_total,2):''}}</td>--}}
                                    <td class="align_left">{{$invoice->si_cash_paid !=0 ? number_format($invoice->si_cash_paid,2):''}}</td>
{{--                                    <td class="align_left">{{$invoice->si_remarks}}</td>--}}
                                    {{--{{$invoice->si_remarks == '' ? 'N/A' : $invoice->si_remarks}}--}}
                                    {{--<td >{{$invoice->si_datetime}}</td>--}}
                                    <td class="align_center hide_column">
                                        <a  data-id="{{$invoice->si_id}}" class="view delete" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>

                                </tr>
                                @php
                                    $sr++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="15">
                                        <center><h3 style="color:#554F4F">No Invoice</h3></center>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <span class="hide_column">{{ $invoices ->links() }}</span>
                </div> <!-- white column form ends here -->


            </div><!-- col end -->
        </div><!-- row end -->


        @include('include/footer')
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content base_clr">
            <div class="modal-header">
                <h4 class="modal-title text-black">Sales Invoice Detail</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                <div id="table_body">

                </div>

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
                                        '<th scope="col"  class="width_2">Product Name</th>' +
                                        '<th scope="col"  class="width_5">Rate</th>' +
                                        '<th scope="col"  class="width_5 text-right">Quantity</th>' +
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
    jQuery(".edit").click(function () {

        var account_id = jQuery(this).attr("data-id");

        jQuery("#account_id").val(account_id);
        jQuery("#edit").submit();
    });

</script>

@include('include/script')

<script>
    jQuery("#cancel").click(function () {

        $("#account").select2().val(null).trigger("change");
        $("#account > option").removeAttr('selected');

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
        jQuery("#account").select2();
        jQuery("#product").select2();
    });
</script>

</body>
</html>
