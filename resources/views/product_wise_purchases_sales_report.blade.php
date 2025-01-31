
@extends('extend_index')

@section('content')

    <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <!-- <div class="title">
                        <h4>Account Registration</h4>
                    </div> -->
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Product Wise {{$title}} Report</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

        <div class="clearfix">
            <div class="pull-left">
                <h4 class="text-blue get-heading-text">Product Wise {{$title}} Report</h4>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col" style="width:50px; text-align: center !important" align="center">Date</th>
                    <th scope="col" style="width:50px; text-align: center !important" align="center">Invoice #</th>
                    <th scope="col" style="width:50px; text-align: center !important" align="center">Detail Remarks</th>
                    <th scope="col" style="width:50px; text-align: center !important" align="center">Party Name</th>
                    <th scope="col" style="width:80px; text-align: center !important" align="center">Total Price</th>
                    <th scope="col" style="width:80px; text-align: center !important" align="center">Expense</th>
                    <th scope="col" style="width:50px; text-align: center !important" align="center">Trade Disc%</th>
                    <th scope="col" style="width:80px; text-align: center !important" align="center">Trade Disc</th>
                    <th scope="col" style="width:80px; text-align: center !important" align="center">Sale tax</th>
                    <th scope="col" style="width:50px; text-align: center !important" align="center">Special Disc%</th>
                    <th scope="col" style="width:80px; text-align: center !important" align="center">Special Disc</th>
                    <th scope="col" style="width:80px; text-align: center !important" align="center">Grand Total</th>
                    <th scope="col" style="width:80px; text-align: center !important" align="center">Cash Paid</th>
                    <th scope="col" style="width:80px; text-align: center !important" align="center">Remarks</th>
                    <th scope="col" nowrap style="width:50px; text-align: center !important" align="center">View</th>
                </tr>
                </thead>


                <tbody>
                @php
                    $sr=0;
                @endphp
                @foreach($purchase_invoices as $purchase_invoice)

                    <tr>
                        <td nowrap class="align_center">{{date('d-M-y', strtotime(str_replace('/', '-', $purchase_invoice->pi_day_end_date)))}}</td>
                        <td class="align_center">{{'PV-'.$purchase_invoice->pi_id}}</td>
                        <td  class="align_center" style="white-space:pre-wrap;">{{$purchase_invoice->pi_detail_remarks}}</td>
                        <td class="align_left">{{$purchase_invoice->pi_party_name}}</td>
                        <td class="align_right">{{$purchase_invoice->pi_total_price !=0 ? number_format($purchase_invoice->pi_total_price,2):''}}</td>
                        <td class="align_right">{{$purchase_invoice->pi_expense !=0 ? number_format($purchase_invoice->pi_expense,2):''}}</td>
                        <td class="align_right">{{$purchase_invoice->pi_trade_disc_percentage !=0 ? number_format($purchase_invoice->pi_trade_disc_percentage,2):''}}</td>
                        <td class="align_right">{{$purchase_invoice->pi_trade_disc !=0 ? number_format($purchase_invoice->pi_trade_disc,2):''}}</td>
                        <td class="align_right">{{$purchase_invoice->pi_sales_tax !=0 ? number_format($purchase_invoice->pi_sales_tax,2):''}}</td>
                        <td class="align_right">{{$purchase_invoice->pi_special_disc_percentage !=0 ? number_format($purchase_invoice->pi_special_disc_percentage,2):''}}</td>
                        <td class="align_right">{{$purchase_invoice->pi_special_disc !=0 ? number_format($purchase_invoice->pi_special_disc,2):''}}</td>
                        <td class="align_right">{{$purchase_invoice->pi_grand_total !=0 ? number_format($purchase_invoice->pi_grand_total,2):''}}</td>
                        <td class="align_right">{{$purchase_invoice->pi_cash_paid !=0 ? number_format($purchase_invoice->pi_cash_paid,2):''}}</td>
                        <td class="align_left">{{$purchase_invoice->pi_remarks}}</td>
                        <td class="align_center"><a  data-id="{{$purchase_invoice->pi_id}}" data-type="purchase" class="view" data-toggle="modal" data-target="#myModal" style="cursor:pointer;"><i class="fa fa-eye"></i></a></td>

                    </tr>
                    @php
                        $sr=1;
                    @endphp
                @endforeach

                @foreach($sale_invoices as $sale_invoice)
                    <tr>
                        <td nowrap class="align_center">{{date('d-M-y', strtotime(str_replace('/', '-', $sale_invoice->si_day_end_date)))}}</td>
                        <td class="align_center">{{'SV-'.$sale_invoice->si_id}}</td>
                        <td  class="align_center" style="white-space:pre-wrap;">{{$sale_invoice->si_detail_remarks}}</td>
                        <td class="align_left">{{$sale_invoice->si_party_name}}</td>
                        <td class="align_right">{{$sale_invoice->si_total_price !=0 ? number_format($sale_invoice->si_total_price,2):''}}</td>
                        <td class="align_right">{{$sale_invoice->si_expense !=0 ? number_format($sale_invoice->si_expense,2):''}}</td>
                        <td class="align_right">{{$sale_invoice->si_trade_disc_percentage !=0 ? number_format($sale_invoice->si_trade_disc_percentage,2):''}}</td>
                        <td class="align_right">{{$sale_invoice->si_trade_disc !=0 ? number_format($sale_invoice->si_trade_disc,2):''}}</td>
                        <td class="align_right">{{$sale_invoice->si_sales_tax !=0 ? number_format($sale_invoice->si_sales_tax,2):''}}</td>
                        <td class="align_right">{{$sale_invoice->si_special_disc_percentage !=0 ? number_format($sale_invoice->si_special_disc_percentage,2):''}}</td>
                        <td class="align_right">{{$sale_invoice->si_special_disc !=0 ? number_format($sale_invoice->si_special_disc,2):''}}</td>
                        <td class="align_right">{{$sale_invoice->si_grand_total !=0 ? number_format($sale_invoice->si_grand_total,2):''}}</td>
                        <td class="align_right">{{$sale_invoice->si_cash_paid !=0 ? number_format($sale_invoice->si_cash_paid,2):''}}</td>
                        <td class="align_left">{{$sale_invoice->si_remarks}}</td>
                        <td class="align_center"><a  data-id="{{$sale_invoice->si_id}}" data-type="sale" class="view" data-toggle="modal" data-target="#myModal" style="cursor:pointer;"><i class="fa fa-eye"></i></a></td>

                    </tr>
                    @php
                        $sr=1;
                    @endphp
                @endforeach
                @if($sr!=1)
                <tr>
                    <td colspan="15">
                        <center><h3 style="color:#554F4F">No Invoice</h3></center>
                    </td>
                </tr>
                @endif
                </tbody>
            </table>

        </div>
    </div> <!-- white column form ends here -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg" >
            <div class="modal-content"  style="width: 1250px; margin-left: -220px;">
                <div class="modal-header">
                    <h4 class="modal-title text-blue">Items Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr class="change_head">
                                <th scope="col" style="width:50px; text-align: center !important" align="center">Pro #</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Pro-Name</th>
                                <th scope="col" style="width:50px; text-align: center !important" align="center">Qty</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Rate</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Discount</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Sale Tax</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Amount</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">G.Rate</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Expense per Pro.</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Net Rate</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Remarks</th>
                            </tr>
                            </thead>
                            <tbody id="table_body">

                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-6 col-md-6"></div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");

            var type = jQuery(this).attr("data-type");

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });


            if(type=='purchase') {

                jQuery.ajax({
                    url: "purchase_items_view_details",
                    data: {id: id},
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    success: function (data) {

                        jQuery(".change_head").html("");
                        jQuery(".change_head").append('<th scope="col" style="width:50px; text-align: center !important" align="center">Pro #</th>\n' +
                            '                            <th scope="col" style="width:80px; text-align: center !important" align="center">Pro-Name</th>\n' +
                            '                            <th scope="col" style="width:50px; text-align: center !important" align="center">Qty</th>\n' +
                            '                            <th scope="col" style="width:80px; text-align: center !important" align="center">Rate</th>\n' +
                            '                            <th scope="col" style="width:80px; text-align: center !important" align="center">Discount</th>\n' +
                            '                            <th scope="col" style="width:80px; text-align: center !important" align="center">Sale Tax</th>\n' +
                            '                            <th scope="col" style="width:80px; text-align: center !important" align="center">Amount</th>\n' +
                            '                            <th scope="col" style="width:80px; text-align: center !important" align="center">G.Rate</th>\n' +
                            '                            <th scope="col" style="width:80px; text-align: center !important" align="center">Expense per Pro.</th>\n' +
                            '                            <th scope="col" style="width:80px; text-align: center !important" align="center">Net Rate</th>\n' +
                            '                            <th scope="col" style="width:80px; text-align: center !important" align="center">Remarks</th>');

                        $.each(data, function (index, value) {

                            var qty;
                            var rate;
                            var discount;
                            var saletax;
                            var amount;
                            var gross_rate;
                            var expense;
                            var net_rate;

                            if (value['pii_qty'] == 0) {
                                qty = '';
                            } else {
                                qty = value['pii_qty'];
                            }
                            if (value['pii_rate'] == 0) {
                                rate = '';
                            } else {
                                rate = value['pii_rate'];
                            }
                            if (value['pii_discount'] == 0) {
                                discount = '';
                            } else {
                                discount = value['pii_discount'];
                            }
                            if (value['pii_saletax'] == 0) {
                                saletax = '';
                            } else {
                                saletax = value['pii_saletax'];
                            }
                            if (value['pii_amount'] == 0) {
                                amount = '';
                            } else {
                                amount = value['pii_amount'];
                            }
                            if (value['pii_gross_rate'] == 0) {
                                gross_rate = '';
                            } else {
                                gross_rate = value['pii_gross_rate'];
                            }
                            if (value['pii_expense'] == 0) {
                                expense = '';
                            } else {
                                expense = value['pii_expense'];
                            }
                            if (value['pii_net_rate'] == 0) {
                                net_rate = '';
                            } else {
                                net_rate = value['pii_net_rate'];
                            }

                            jQuery("#table_body").append('<tr><td class="align_center">' + value['pii_product_code'] + '</td><td class="align_left">' + value['pii_product_name'] + '</td><td class="align_right">' + qty + '</td><td class="align_right">' + rate + '</td><td class="align_right">' + discount + '</td><td class="align_right">' + saletax + '</td><td class="align_right">' + amount + '</td><td class="align_right">' + gross_rate + '</td><td class="align_right">' + expense + '</td><td class="align_right">' + net_rate + '</td><td class="align_left">' + value['pii_remarks'] + '</td></tr>');

                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // alert(jqXHR.responseText);
                        // alert(errorThrown);
                    }
                });

            }else{

                jQuery.ajax({
                    url: "sale_items_view_details",
                    data: {id: id},
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    success: function (data) {
                        jQuery(".change_head").html("");
                        jQuery(".change_head").append('<th scope="col" style="width:50px; text-align: center !important" align="center">Pro #</th>\n' +
                            '                            <th scope="col" style="width:80px; text-align: center !important" align="center">Pro-Name</th>\n' +
                            '                            <th scope="col" style="width:50px; text-align: center !important" align="center">Qty</th>\n' +
                            '                            <th scope="col" style="width:80px; text-align: center !important" align="center">Rate</th>\n' +
                            '                            <th scope="col" style="width:80px; text-align: center !important" align="center">Discount</th>\n' +
                            '                            <th scope="col" style="width:80px; text-align: center !important" align="center">Sale Tax</th>\n' +
                            '                            <th scope="col" style="width:80px; text-align: center !important" align="center">Amount</th>\n' +
                            '                            <th scope="col" style="width:80px; text-align: center !important" align="center">Remarks</th>');

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

                            jQuery("#table_body").append('<tr><td class="align_center">' + value['sii_product_code'] + '</td><td class="align_left">' + value['sii_product_name'] + '</td><td class="align_right">' + qty + '</td><td class="align_right">' + rate + '</td><td class="align_right">' +  discount + '</td><td class="align_right">' + saletax + '</td><td class="align_right">' + amount + '</td><td class="align_left">' + value['sii_remarks'] + '</td></tr>');

                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // alert(jqXHR.responseText);
                        // alert(errorThrown);
                    }
                });
            }
        });
    </script>

    <script>
        jQuery(".edit").click(function () {

            var account_id = jQuery(this).attr("data-id");

            jQuery("#account_id").val(account_id);
            jQuery("#edit").submit();
        });

    </script>

@endsection

