<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('include.head')

</head>

<body>

@include('include/header')
@include('include/teller_sidebar')

<div class="main-container">
    <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10 return_status">
        @include('inc._messages')
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <!-- <div class="title">
                        <h4>Account Registration</h4>
                    </div> -->
                    <!--   <nav aria-label="breadcrumb" role="navigation">
                          <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="index">Home</a></li>
                              <li class="breadcrumb-item active" aria-current="page">sale Invoice</li>
                          </ol>
                      </nav> -->
                </div>
            </div>
        </div>
        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

            <div class="clearfix">
                <div class="pull-left">
                    <h4 class="text-blue">Sale Return Full Invoice</h4>
                </div>
                <a class="btn btn-primary add_more_button" href="sale_return_invoice_list" role="button"><li class="fa fa-list"></li></a>
            </div>

            <form name="f1" class="f1" id="f1" action="submit_sale_return_full_invoice" onsubmit="return validate_form()"
                  method="post" autocomplete="off">
            @csrf
            <!-- main row ends here --> <!-- first row ends here -->

                <!-- lower row starts here -->
                <div class="row">

                    <div class="pi_left col-lg-10 col-md-10 p-0"> <!-- left column starts here  -->
                        <!-- *********************************************** upper row added here ****************************************-->
                        <div class="upper-section border_dashed m-0">
                            <div class="row" style="">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            {{--<label class="">Session</label>--}}
                                            <span id="demo1" class="validate_sign"> </span>
                                            <select name="session" class="form-control" id="session" tabindex="1" hidden>
                                                <option value="">Select Session</option>
                                            </select>

                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            {{--<label class="">Business Unit</label>--}}
                                            <span id="demo2" class="validate_sign"> </span>
                                            <select name="business_name" class="form-control" id="business_name"
                                                    tabindex="2" hidden>
                                                <option value="">Select Business</option>
                                            </select>

                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            {{--<label class="required">Date</label>--}}
                                            <span id="demo3" class="validate_sign"> </span>
                                            <input class="form-control" placeholder="Select Date" type="hidden" tabindex="3"
                                                   value="{{$date}}" readonly>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row" style="">
                                <div class="col-lg-2 col-md-6">
                                    <label class="required">Code</label>
                                    <span id="demo4" class="validate_sign"> </span>
                                    {{--<select name="customer_code" class="form-control" id="customer_code" tabindex="4">--}}
                                    {{--<option value="0">Code</option>--}}
                                    {{--@foreach($accounts as $account)--}}
                                    {{--<option value="{{$account->account_uid}}" data-party_head="{{$account->account_parent_code}}">{{$account->account_uid}}</option>--}}
                                    {{--@endforeach--}}
                                    {{--</select>--}}
                                    <input type="text" name="customer_code" class="form-control" id="customer_code" tabindex="4" value="{{$account->account_uid}}" readonly>

                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <label class="required">Party Name</label>
                                    <span id="demo5" class="validate_sign"></span>
                                    {{--<select name="party_name" class="form-control" id="party_name" tabindex="5">--}}
                                    {{--<option value="0">Party Name</option>--}}
                                    {{--@foreach($accounts as $account)--}}
                                    {{--<option value="{{$account->account_uid}}" data-party_head="{{$account->account_parent_code}}">{{$account->account_name}}</option>--}}
                                    {{--@endforeach--}}
                                    {{--</select>--}}

                                    <input type="text" name="party_name" class="form-control" id="party_name" tabindex="5" value="{{$account->account_name}}" readonly>

                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label>Customer Name</label>
                                    <span id="demo6" class="validate_sign"></span>
                                    <input type="text" name="customer_name" class="form-control" id="customer_name"
                                           placeholder="Customer Name" tabindex="6">

                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="">Remarks</label>
                                    <span id="demo7" class="validate_sign"></span>
                                    <input type="text" name="remarks" class="form-control" id="remarks"
                                           placeholder="Remarks" tabindex="7">

                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <label class="required">Invoice Number</label>
                                    <span id="demo70" class="validate_sign"></span>
                                    <input type="text" name="invoice_no" class="form-control" id="invoice_no"
                                           placeholder="Invoice number" tabindex="8">

                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <!-- added later -->
                                    <label class=""></label>
                                    <div class="input-method m-2">

                                        <button id="check" class="btn btn-primary" type="button">Check</button>

                                    </div>
                                    <!-- ended-->
                                </div>



                            </div>
                        </div>
                        <!-- ********************************** upper row ended here  **************************************************** -->
                        <div class="row middle-section" style="">  <!--  new row starts here -->
                            <div class="col-lg-2 col-md-6">
                                <label class="required">Code</label>
                                <span id="demo8" class="validate_sign"> </span>
                                <select name="product_code" class="form-control" id="product_code" tabindex="9" style="width: 100%;">
                                    <option value="0">Code</option>
                                    {{--@foreach($products as $product)--}}
                                        {{--<option value="{{$product->pro_id}}"--}}
                                                {{--data-sale_price="{{$product->pro_sale_price}}">{{$product->pro_id}}</option>--}}
                                    {{--@endforeach--}}

                                </select>

                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label class="required">Product Name</label>
                                <span id="demo9" class="validate_sign">(Stock)</span>

                                <select name="product_name" class="form-control" id="product_name" tabindex="10" style="width: 100%;">
                                    <option value="0">Product</option>
                                    {{--@foreach($products as $product)--}}
                                        {{--<option value="{{$product->pro_id}}"--}}
                                                {{--data-sale_price="{{$product->pro_sale_price}}">{{$product->pro_title}}</option>--}}
                                    {{--@endforeach--}}

                                </select>

                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label class="">Remarks</label>
                                <span id="demo10" class="validate_sign"></span>
                                <input type="text" name="product_remarks" class="form-control" id="product_remarks"
                                       placeholder="Remarks" tabindex="11">

                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label class="required">Quantity</label>
                                <span id="demo11" class="validate_sign"></span>
                                <input type="number" name="quantity" class="form-control" id="quantity"
                                       placeholder="Qty" min="1" tabindex="12">

                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label class="required">Rate</label>
                                <span id="demo12" class="validate_sign"></span>
                                <input type="number" name="rate" class="form-control" id="rate" placeholder="" min="1"
                                       tabindex="13">

                            </div>

                            <div class="col-lg-2 col-md-6">
                                <label class="">Discount</label>
                                <span id="demo13" class="validate_sign"></span>
                                <input type="number" name="product_discount" class="form-control" id="product_discount"
                                       placeholder="" min="1" tabindex="14">

                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label class="">Sales Tax</label>
                                <span id="demo14" class="validate_sign"></span>
                                <input type="number" name="product_sales_tax" class="form-control"
                                       id="product_sales_tax" placeholder="" min="1" tabindex="15">

                            </div>

                            <!--  <div class="col-lg-1 col-md-1 col-sm-1">
                                 <label class="">Tax Amount</label>
                                 <span id="demo141" class="validate_sign"></span>
                                 <input type="number" name="product_sales_tax_amount" class="form-control" id="product_sales_tax_amount" placeholder="" min="1" >

                             </div> -->

                            <div class="col-lg-3 col-md-6">
                                <label class="required">Amount</label>
                                <span id="demo15" class="validate_sign"></span>
                                <input type="number" name="amount" class="form-control" id="amount" placeholder=""
                                       min="1" readonly>

                            </div>

                            <div class="col-lg-3 col-md-6">
                                <!-- added later -->
                                <label class=""></label>
                                <div class="input-method">

                                    <button id="first_add_more" class="btn green_small_button" onclick="add_sale()" style="display: none !important;"
                                            type="button">Add

                                    </button>

                                    <button style="display: none; background-color: red !important" id="cancel_button"
                                            class="btn green_small_button" onclick="cancel_all()" type="button">Cancel

                                    </button>

                                    <span id="demo201" class="validate_sign"> </span>

                                </div>
                                <!-- ended-->
                            </div>

                        </div> <!-- new row ends here -->
                        <div class="row m-0" style="">
                            <!-- table code starts here -->
                            <div class="table_div table-responsive table-max-height-500px">
                                <table class="table table-striped shadowed table-bordered m-0" id="category_dynamic_table">
                                    <thead class="lower-section-thead">
                                    <tr>
                                        <th scope="col">Code</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Remarks</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Rate</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Sale Tax</th>
                                        <th scope="col">Amount</th>

                                    </tr>
                                    </thead>
                                    <tbody id="table_body">

                                    <tr>
                                        <td colspan="10" align="center"> No Product Added</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!-- table code ends here -->
                            </div> <!-- responsive table div ends here -->

                        </div>
                    </div> <!-- left column ends here -->
                    <div class="pi_right col-lg-2 col-md-2">
                        <!-- ***************************************************************************************************************************-->

                        <div class="row form-group lower_dashed side-section"> <!-- lower -->
                            <div class="col-lg-12 col-md-12 col-sm-12 px-1">
                                <label class="total-items-label">Total Items</label>
                                <span id="demo16" class="validate_sign"></span>
                                <input type="number" name="total_items" class="form-control total-items-field" id="total_items"
                                       placeholder="0.00" readonly>

                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 px-1">
                                <label class="grand-total-label">Grand Total</label>
                                <span id="demo26" class="validate_sign"></span>
                                <input type="number" name="grand_total" class="form-control grand-total-field" id="grand_total"
                                       placeholder="0.00" readonly>

                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 px-1">
                                <label class="cash-received-label">Cash Paid</label>
                                <input type="number" name="cash_paid" class="form-control cash-received-field" id="cash_paid"
                                       placeholder="0.00" tabindex="22" step="any">
                                <span id="demo27" class="validate_sign"></span>

                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 px-1">
                                <label class="cash-return-label">Cash Return</label>
                                <input type="text" name="cash_return" class="form-control cash-return-field" id="cash_return"
                                       placeholder="0.00" tabindex="22" step="any" readonly>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 px-1 w-100 margin-top-10px">
                                <p class="">
                                    <button class="btn btn-primary modal-button" type="button" data-toggle="collapse"
                                            data-target="#collapseExample" aria-expanded="false"
                                            aria-controls="collapseExample">View Detail</button>
                                </p>
                                <div class="collapse w-100" id="collapseExample">
                                    <div class="card card-body p-0 modal-button__card side-section__card">
                                        <div class="col-lg-12 col-md-12 col-sm-12 px-1">
                                            <label>Total Price</label>
                                            <span id="demo17" class="validate_sign"></span>
                                            <input type="number" name="total_price" class="form-control" id="total_price"
                                                   placeholder="" readonly>

                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 px-1">
                                            <label>Expense</label>
                                            <span id="demo18" class="validate_sign"></span>
                                            <input type="number" name="expense" class="form-control" id="expense" placeholder=""
                                                   tabindex="16" step="any">

                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 px-1">
                                            <label>Value Of Supply</label>
                                            <span id="demo19" class="validate_sign"></span>
                                            <input type="number" name="value_of_supply" class="form-control" id="value_of_supply"
                                                   placeholder="" tabindex="17" step="any">

                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 px-1">
                                            <div style="clear: both;"><label>Scheme Disc. %</label></div>
                                            <div style="width: 30%; float: left;">

                                                <span id="demo20" class="validate_sign"></span>
                                                <input type="number" name="disc_percentage" class="form-control"
                                                       id="disc_percentage" placeholder="" tabindex="18" step="any" style="padding: 1px;">
                                            </div>
                                            <div style="width: 70%; float: left;">
                                                <input type="number" name="disc_amount" class="form-control" id="disc_amount"
                                                       placeholder="" tabindex="19" step="any">

                                            </div>

                                        </div>
                                        <!--   <div class="col-lg-12 col-md-12 col-sm-12">
                                                      <label >Scheme Disc.</label>
                                                      <span id="demo21" class="validate_sign"></span>
                                                      <input type="number" name="disc_amount" class="form-control" id="disc_amount" placeholder="" >

                                          </div> -->

                                        <div class="col-lg-12 col-md-12 col-sm-12 px-1">
                                            <div style="clear: both;"><label style="">Special Disc.%</label></div>

                                            <div style="width: 30%; float: left;">
                                                <span id="demo24" class="validate_sign"></span>
                                                <input type="number" name="special_disc_percentage" class="form-control"
                                                       id="special_disc_percentage" placeholder="" tabindex="20" step="any" style="padding: 1px;">
                                            </div>
                                            <div style="width: 70%; float: left;">
                                                <input type="number" name="special_disc_amount" class="form-control"
                                                       id="special_disc_amount" placeholder="" tabindex="21" step="any">

                                            </div>

                                        </div>
                                        <!--    <div class="col-lg-12 col-md-12 col-sm-12">
                                                       <label >Special Disc.</label>
                                                       <span id="demo25" class="validate_sign"></span>
                                                       <input type="number" name="special_disc_amount" class="form-control" id="special_disc_amount" placeholder="" >

                                           </div> -->

                                        <div class="col-lg-12 col-md-12 col-sm-12 px-1">
                                            <label>Total Sales Tax</label>
                                            <span id="demo23" class="validate_sign"></span>
                                            <input type="number" name="sales_tax_amount" class="form-control" id="sales_tax_amount"
                                                   placeholder="" readonly>

                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 px-1">
                                            <label>Total Discount</label>
                                            <span id="demo230" class="validate_sign"></span>
                                            <input type="number" name="total_discount" class="form-control" id="total_discount"
                                                   placeholder="" readonly>

                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                        <span id="demo28" class="validate_sign"></span>
                                        <button type="submit" name="save" id="save" class="save_button form-control"
                                                onclick="return popvalidation()">Save
                                        </button>
                                    </div>
                                </div>
                            </div>



                        </div>
                        <!-- *****************************************************************************************************************************-->

                    </div>
                </div>


                <input type="hidden" name="salesval" id="salesval">
                <input type="hidden" name="customer_party_name" id="customer_party_name" value="{{$account->account_name}}">
                <input type="hidden" name="party_head" id="party_head" value="{{$account->account_parent_code}}">
            </form>
        </div> <!-- white column form ends here -->

        @include('include/footer')
    </div>
</div>

@include('include/script')



<script>

    jQuery(function () {
        jQuery(document).on('keypress', function (e) {
            var that = document.activeElement;
            if (e.which == 13) {
                e.preventDefault();
                jQuery('[tabIndex=' + (+that.tabIndex + 1) + ']')[0].focus();
            }
        });
    });


    jQuery("#product_sales_tax_amount").keyup(function () {

        var rate = jQuery("#rate").val();
        var quantity = jQuery("#quantity").val();
        var product_discount = jQuery("#product_discount").val();
        var product_sales_tax_amount = jQuery("#product_sales_tax_amount").val();

        var amount = (rate * quantity) - product_discount;
        var sale_tax = (product_sales_tax_amount / amount) * 100;
        amount = +amount + +product_sales_tax_amount;

        jQuery("#amount").val(amount);
        jQuery("#product_sales_tax").val(sale_tax);
    });

</script>

<script>
    jQuery("#product_code").change(function () {

        var sale_price = jQuery('option:selected', this).attr('data-sale_price');

        var pname = jQuery('option:selected', this).val();
        jQuery("#product_name").select2("destroy");
        jQuery("#product_name").children("option[value^=" + pname + "]");

        jQuery("#product_name > option").each(function () {
            jQuery('#product_name option[value="' + pname + '"]').prop('selected', true);
        });

        jQuery("#rate").val(sale_price);
        jQuery("#product_name").select2();

        var quantity = jQuery("#quantity").val();
        var rate = jQuery("#rate").val();
        var product_discount = jQuery("#product_discount").val();
        var product_sales_tax = jQuery("#product_sales_tax").val();
        var amount;

        amount = (rate * quantity) - product_discount;
        var sale_tax = (amount / 100) * product_sales_tax;
        amount = +amount + +sale_tax;

        jQuery("#amount").val(amount);
    });

</script>

<script>
    jQuery("#product_name").change(function () {

        var sale_price = jQuery('option:selected', this).attr('data-sale_price');
        var pcode = jQuery('option:selected', this).val();
        jQuery("#product_code").select2("destroy");
        jQuery("#product_code").children("option[value^=" + pcode + "]");

        jQuery("#product_code > option").each(function () {
            jQuery('#product_code option[value="' + pcode + '"]').prop('selected', true);
        });
        jQuery("#rate").val(sale_price);
        jQuery("#product_code").select2();

        var quantity = jQuery("#quantity").val();
        var rate = jQuery("#rate").val();
        var product_discount = jQuery("#product_discount").val();
        var product_sales_tax = jQuery("#product_sales_tax").val();
        var amount;

        amount = (rate * quantity) - product_discount;
        var sale_tax = (amount / 100) * product_sales_tax;
        amount = +amount + +sale_tax;

        jQuery("#amount").val(amount);
    });


</script>


<script>

    jQuery("#quantity").keyup(function () {

        var rate = jQuery("#rate").val();
        var quantity = jQuery("#quantity").val();
        var product_discount = jQuery("#product_discount").val();
        var product_sales_tax = jQuery("#product_sales_tax").val();
        var amount;

        amount = (rate * quantity) - product_discount;
        var sale_tax = (amount / 100) * product_sales_tax;
        amount = +amount + +sale_tax;

        jQuery("#amount").val(amount);
    });

</script>


<script>

    jQuery("#product_discount").keyup(function () {

        var rate = jQuery("#rate").val();
        var quantity = jQuery("#quantity").val();
        var product_discount = jQuery("#product_discount").val();
        var product_sales_tax = jQuery("#product_sales_tax").val();

        var amount = (rate * quantity) - product_discount;
        var sale_tax = (amount / 100) * product_sales_tax;
        amount = +amount + +sale_tax;

        jQuery("#amount").val(amount);
    });

</script>


<script>

    jQuery("#product_sales_tax").keyup(function () {

        var rate = jQuery("#rate").val();
        var quantity = jQuery("#quantity").val();
        var product_discount = jQuery("#product_discount").val();
        var product_sales_tax = jQuery("#product_sales_tax").val();

        var amount = (rate * quantity) - product_discount;
        var sale_tax = (amount / 100) * product_sales_tax;
        amount = +amount + +sale_tax;

        jQuery("#amount").val(amount);
    });

</script>


<script>

    jQuery("#rate").keyup(function () {

        var rate = jQuery("#rate").val();
        var quantity = jQuery("#quantity").val();
        var product_discount = jQuery("#product_discount").val();
        var product_sales_tax = jQuery("#product_sales_tax").val();

        var amount = (rate * quantity) - product_discount;
        var sale_tax = (amount / 100) * product_sales_tax;
        amount = +amount + +sale_tax;

        jQuery("#amount").val(amount);
    });

</script>

<script>

    jQuery("#expense").keyup(function () {

        var expense = jQuery("#expense").val();
        var disc_amount = jQuery("#disc_amount").val();
        var special_disc_amount = jQuery("#special_disc_amount").val();
        var total_price = jQuery("#total_price").val();
        var grand_total_amount = 0;

        grand_total_amount = +total_price + +expense - disc_amount - special_disc_amount;

        jQuery("#grand_total").val(grand_total_amount);
    });

</script>


<script>

    jQuery("#disc_percentage").keyup(function () {

        var expense = jQuery("#expense").val();
        var special_disc_amount = jQuery("#special_disc_amount").val();
        var total_price = jQuery("#total_price").val();
        var grand_total_amount = 0;
        var disc_percentage = jQuery("#disc_percentage").val();
        var total_discount_amount=0;

        var disc_amount = (total_price / 100) * disc_percentage;

        total_discount_amount = +total_discount + +disc_amount + +special_disc_amount;

        jQuery("#total_discount").val(total_discount_amount);

        jQuery("#disc_amount").val(disc_amount);

        grand_total_amount = +total_price + +expense - disc_amount - special_disc_amount;

        jQuery("#grand_total").val(grand_total_amount);
    });

</script>


<script>

    jQuery("#disc_amount").keyup(function () {

        var expense = jQuery("#expense").val();
        var disc_amount = jQuery("#disc_amount").val();
        var special_disc_amount = jQuery("#special_disc_amount").val();
        var total_price = jQuery("#total_price").val();
        var grand_total_amount = 0;
        var total_discount_amount=0;

        var disc_percentage = (disc_amount / total_price) * 100;

        total_discount_amount = +total_discount + +disc_amount + +special_disc_amount;

        jQuery("#total_discount").val(total_discount_amount);

        jQuery("#disc_percentage").val(disc_percentage);

        grand_total_amount = +total_price + +expense - disc_amount - special_disc_amount;

        jQuery("#grand_total").val(grand_total_amount);
    });

</script>


<script>

    jQuery("#special_disc_percentage").keyup(function () {

        var expense = jQuery("#expense").val();
        var disc_amount = jQuery("#disc_amount").val();
        var total_price = jQuery("#total_price").val();
        var special_disc_percentage = jQuery("#special_disc_percentage").val();
        var grand_total_amount = 0;
        var total_discount_amount=0;

        var special_disc_amount = (total_price / 100) * special_disc_percentage;

        total_discount_amount = +total_discount + +disc_amount + +special_disc_amount;

        jQuery("#total_discount").val(total_discount_amount);

        jQuery("#special_disc_amount").val(special_disc_amount);

        grand_total_amount = +total_price + +expense - disc_amount - special_disc_amount;

        jQuery("#grand_total").val(grand_total_amount);
    });

</script>


<script>

    jQuery("#special_disc_amount").keyup(function () {

        var expense = jQuery("#expense").val();
        var disc_amount = jQuery("#disc_amount").val();
        var special_disc_amount = jQuery("#special_disc_amount").val();
        var total_price = jQuery("#total_price").val();
        var grand_total_amount = 0;
        var total_discount_amount=0;

        var special_disc_percentage = (special_disc_amount / total_price) * 100;

        total_discount_amount = +total_discount + +disc_amount + +special_disc_amount;

        jQuery("#total_discount").val(total_discount_amount);

        jQuery("#special_disc_percentage").val(special_disc_percentage);

        grand_total_amount = +total_price + +expense - disc_amount - special_disc_amount;

        jQuery("#grand_total").val(grand_total_amount);
    });

</script>

<script>

    jQuery("#cash_paid").keyup(function () {

        var cash_paid = jQuery("#cash_paid").val();
        var grand_total = jQuery("#grand_total").val();

        var cash_return = grand_total - cash_paid;

        jQuery("#cash_return").val(cash_return);
    });

</script>

<script>
    // adding packs into table
    var numberofsales = 0;
    var counter = 0;
    var sales = {};
    var global_id_to_edit = 0;
    var total_discount=0;

    function popvalidation() {
        isDirty = true;

        var product_code = document.getElementById("product_code").value;
        var product_name = document.getElementById("product_name").value;
        var product_remarks = document.getElementById("product_remarks").value;
        var quantity = document.getElementById("quantity").value;
        var rate = document.getElementById("rate").value;
        var amount = document.getElementById("amount").value;
        var customer_code = document.getElementById("customer_code").value;
        var party_name = document.getElementById("party_name").value;
        var invoice_no = document.getElementById("invoice_no").value;
        var disc_percentage = document.getElementById("disc_percentage").value;
        var special_disc_percentage = document.getElementById("special_disc_percentage").value;
        var remarks  = document.getElementById("remarks").value;
        var grand_total  = document.getElementById("grand_total").value;
        var cash_paid  = document.getElementById("cash_paid").value;

        var flag_submit = true;
        var focus_once = 0;

        if (customer_code.trim() == "0") {
            var isDirty = false;
            document.getElementById("demo4").innerHTML = "";
            if (focus_once == 0) {
                jQuery("#customer_code").focus();
                focus_once = 1;
            }
            flag_submit = false;
        } else {
            document.getElementById("demo4").innerHTML = "";
        }


        if (party_name.trim() == "0") {
            var isDirty = false;
            document.getElementById("demo5").innerHTML = "";
            if (focus_once == 0) {
                jQuery("#party_name").focus();
                focus_once = 1;
            }
            flag_submit = false;

        } else {
            document.getElementById("demo5").innerHTML = "";
        }

        if (invoice_no.trim() == "0" || invoice_no.trim() == "") {
            var isDirty = false;
            document.getElementById("demo70").innerHTML = "";
            if (focus_once == 0) {
                jQuery("#invoice_no").focus();
                focus_once = 1;
            }
            flag_submit = false;

        } else {
            document.getElementById("demo70").innerHTML = "";
        }

        // if(remarks.trim() == "")
        // {
        //     document.getElementById("demo7").innerHTML = "";
        //     if (focus_once == 0) { jQuery("#remarks").focus(); focus_once = 1;}
        //     flag_submit = false;
        // }else{
        //     document.getElementById("demo7").innerHTML = "";
        // }

        if(special_disc_percentage !='' && disc_percentage!='' ){

            var percentage = +special_disc_percentage + +disc_percentage;

            if(parseInt(percentage) > 100){
                jQuery("#demo26").html('Special Disc & Scheme Disc not greater than 100%');
                if (focus_once == 0) {
                    jQuery("#special_disc_percentage").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            }else{
                jQuery("#demo26").html('');
            }

        }

        if (numberofsales == 0) {
            var isDirty = false;
            if (product_code == "0") {
                document.getElementById("demo8").innerHTML = "";
                if (focus_once == 0) {
                    jQuery("#product_code").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo8").innerHTML = "";
            }


            if (product_name == "0") {
                //  document.getElementById("demo9").innerHTML = "";
                if (focus_once == 0) {
                    jQuery("#product_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                //  document.getElementById("demo9").innerHTML = "";
            }


            // if (product_remarks == "") {
            //     document.getElementById("demo10").innerHTML = "";
            //     if (focus_once == 0) {
            //         jQuery("#product_remarks").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // } else {
            //     document.getElementById("demo10").innerHTML = "";
            // }


            if (quantity == "" || quantity == 0) {
                // document.getElementById("demo11").innerHTML = "";
                if (focus_once == 0) {
                    jQuery("#quantity").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                if (!validatequantity(quantity)) {
                    //  document.getElementById("demo11").innerHTML = "";
                    if (focus_once == 0) {
                        jQuery("#quantity").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
                else {
                    //  document.getElementById("demo11").innerHTML = "";
                }
            }


            if (rate == "" || rate == 0) {
                document.getElementById("demo12").innerHTML = "";
                if (focus_once == 0) {
                    jQuery("#rate").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {

                if (!validatequantity(rate)) {
                    document.getElementById("demo12").innerHTML = "";
                    if (focus_once == 0) {
                        jQuery("#rate").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
                else {
                    document.getElementById("demo12").innerHTML = "";
                }
            }


            if (amount == "") {
                document.getElementById("demo15").innerHTML = "";

                if (focus_once == 0) {
                    jQuery("#amount").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {

                document.getElementById("demo15").innerHTML = "";
            }

            document.getElementById("demo28").innerHTML = "Press Add Button to Add Sale";
            flag_submit = false;
        } else {
            document.getElementById("demo28").innerHTML = "";
        }

        if(customer_code.trim()== '{{config('global_variables.cash_in_hand')}}'){

            if(cash_paid != grand_total){
                document.getElementById("demo27").innerHTML = "Grand Total Not Equal to Cash Paid.";
                flag_submit = false;
            }else{
                document.getElementById("demo27").innerHTML = "";
            }
        }else{
            document.getElementById("demo27").innerHTML = "";
        }
        return flag_submit;
    }


    function add_sale() {

        var product_code = document.getElementById("product_code").value;
        var product_name = document.getElementById("product_name").value;
        var product_remarks = document.getElementById("product_remarks").value;
        var quantity = document.getElementById("quantity").value;
        var rate = document.getElementById("rate").value;
        var amount = document.getElementById("amount").value;


        var flag_submit1 = true;
        var focus_once1 = 0;

        if (product_code == "0") {
            document.getElementById("demo8").innerHTML = "";
            if (focus_once1 == 0) {
                jQuery("#product_code").focus();
                focus_once1 = 1;
            }
            flag_submit1 = false;
        } else {
            document.getElementById("demo8").innerHTML = "";
        }


        if (product_name == "0") {
            // document.getElementById("demo9").innerHTML = "";
            if (focus_once1 == 0) {
                jQuery("#product_name").focus();
                focus_once1 = 1;
            }
            flag_submit1 = false;
        } else {
            // document.getElementById("demo9").innerHTML = "";
        }


        if (product_remarks == "") {
            document.getElementById("demo10").innerHTML = "";
            if (focus_once1 == 0) {
                jQuery("#product_remarks").focus();
                focus_once1 = 1;
            }
            flag_submit1 = false;
        } else {
            document.getElementById("demo10").innerHTML = "";
        }


        if (quantity == "" || quantity == 0) {
            // document.getElementById("demo11").innerHTML = "";
            if (focus_once1 == 0) {
                jQuery("#quantity").focus();
                focus_once1 = 1;
            }
            flag_submit1 = false;
        } else {
            if (!validatequantity(quantity)) {
                //   document.getElementById("demo11").innerHTML = "";
                if (focus_once1 == 0) {
                    jQuery("#quantity").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            else {

                //  document.getElementById("demo11").innerHTML = "";
            }
        }


        if (rate == "" || rate == 0) {
            document.getElementById("demo12").innerHTML = "";
            if (focus_once1 == 0) {
                jQuery("#rate").focus();
                focus_once1 = 1;
            }
            flag_submit1 = false;
        } else {

            if (!validatequantity(rate)) {
                document.getElementById("demo12").innerHTML = "";
                if (focus_once1 == 0) {
                    jQuery("#rate").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            else {
                document.getElementById("demo12").innerHTML = "";
            }

        }


        if (amount == "") {
            document.getElementById("demo15").innerHTML = "";

            if (focus_once1 == 0) {
                jQuery("#amount").focus();
                focus_once1 = 1;
            }
            flag_submit1 = false;
        } else {

            document.getElementById("demo15").innerHTML = "";
        }


        if (flag_submit1) {

            if (global_id_to_edit != 0) {
                jQuery("#" + global_id_to_edit).remove();

                delete sales[global_id_to_edit];
            }
            document.getElementById("demo11").innerHTML = "";
            document.getElementById("demo9").innerHTML = "";
            counter++;

            jQuery("#product_code").select2("destroy");
            jQuery("#product_name").select2("destroy");

            var checkedValue = [];

            var product_name = jQuery("#product_name option:selected").text();
            var selected_code_value = jQuery("#product_code option:selected").val();
            var qty = jQuery("#quantity").val();
            var selected_product_name = jQuery("#product_name").val();
            var selected_remarks = jQuery("#product_remarks").val();
            var selected_rate = jQuery("#rate").val();
            var selected_amount = jQuery("#amount").val();
            var product_sales_tax = document.getElementById("product_sales_tax").value;
            var product_discount = document.getElementById("product_discount").value;

            if (product_sales_tax == '') {
                product_sales_tax = 0;
            }
            if (product_discount == '') {
                product_discount = 0;
            }
            // if (selected_remarks == '') {
            //     selected_remarks = 'N/A';
            // }
            numberofsales = Object.keys(sales).length;

            if (numberofsales == 0) {
                jQuery("#table_body").html("");
            }
            var sale_tax = 0;
            //  rate=value[4]- value[6];
            // sale_tax=+sale_tax + +value[7];

            sale_tax = ((((selected_rate * qty) - product_discount) / 100) * product_sales_tax);

            sales[counter] = [selected_code_value, product_name, selected_remarks, qty, selected_rate, selected_amount, product_discount, product_sales_tax, sale_tax];

            jQuery("#product_code option[value=" + selected_code_value + "]").attr("disabled", "true");
            jQuery("#product_name option[value=" + selected_code_value + "]").attr("disabled", "true");
            numberofsales = Object.keys(sales).length;

            jQuery("#table_body").append('<tr id=' + counter + '><td >' + selected_code_value + '</td><td >' + product_name + '</td><td>' + selected_remarks + '</td><td >' + qty + '</td><td >' + selected_rate + '</td><td>' + product_discount + '</td><td>' + product_sales_tax + '</td><td>' + selected_amount + '</td></tr>');

            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);

            jQuery("#quantity").val("");
            jQuery("#product_remarks").val("");
            jQuery("#rate").val("");
            jQuery("#amount").val("");
            jQuery("#product_discount").val("");
            jQuery("#product_sales_tax").val("");

            jQuery("#salesval").val(JSON.stringify(sales));
            jQuery("#cancel_button").hide();
            jQuery(".table-responsive").show();
            jQuery("#save").show();
            jQuery("#first_add_more").html('Add');

            jQuery("#total_items").val(numberofsales);

            var expense = jQuery("#expense").val();
            var disc_amount = jQuery("#disc_amount").val();
            var special_disc_amount = jQuery("#special_disc_amount").val();

            var rate = 0;
            var amount = 0;
            var sale_tax_amount = 0;
            total_discount = 0;

            jQuery.each(sales, function (index, value) {
                amount = +amount + +value[5];
                rate = (value[4] * value[3]) - value[6];
                sale_tax_amount = +sale_tax_amount + +((rate / 100) * value[7]);
                total_discount = +total_discount + +value[6];
            });

            var total_discount_amount =+total_discount + +disc_amount + +special_disc_amount;
            jQuery("#total_discount").val(total_discount_amount);

            var grand_total = +amount + +expense - disc_amount - special_disc_amount;

            jQuery("#total_price").val(amount);
            jQuery("#sales_tax_amount").val(sale_tax_amount);
            jQuery("#grand_total").val(grand_total);
            // jQuery("#first_add_more").attr("style", "display:none");
            jQuery("#product_code").select2();
            jQuery("#product_name").select2();


            //////////////////////////////////////////////////////////////////////////////


            var expense = jQuery("#expense").val();
            var special_disc_amount = jQuery("#special_disc_amount").val();
            var total_price = jQuery("#total_price").val();
            var grand_total_amount = 0;
            var disc_percentage = jQuery("#disc_percentage").val();
            var total_discount_amount=0;

            var disc_amount = (total_price / 100) * disc_percentage;

            total_discount_amount = +total_discount + +disc_amount + +special_disc_amount;

            jQuery("#total_discount").val(total_discount_amount);

            jQuery("#disc_amount").val(disc_amount);

            grand_total_amount = +total_price + +expense - disc_amount - special_disc_amount;

            jQuery("#grand_total").val(grand_total_amount);

            //////////////////////////////////////////////////////////////////////////////////////////////////////

            var expense = jQuery("#expense").val();
            var disc_amount = jQuery("#disc_amount").val();
            var total_price = jQuery("#total_price").val();
            var special_disc_percentage = jQuery("#special_disc_percentage").val();
            var grand_total_amount = 0;
            var total_discount_amount=0;

            var special_disc_amount = (total_price / 100) * special_disc_percentage;

            total_discount_amount = +total_discount + +disc_amount + +special_disc_amount;

            jQuery("#total_discount").val(total_discount_amount);

            jQuery("#special_disc_amount").val(special_disc_amount);

            grand_total_amount = +total_price + +expense - disc_amount - special_disc_amount;

            jQuery("#grand_total").val(grand_total_amount);

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

        }
    }


    function delete_sale(current_item) {

        jQuery("#" + current_item).remove();
        var temp_sales = sales[current_item];
        jQuery("#product_code option[value=" + temp_sales[0] + "]").attr("disabled", false);
        jQuery("#product_name option[value=" + temp_sales[0] + "]").attr("disabled", false);

        delete sales[current_item];

        function isEmpty(obj) {

            for (var key in obj) {

                if (obj.hasOwnProperty(key))
                    return false;
            }
            return true;
        }

        jQuery("#salesval").val(JSON.stringify(sales));

        if (isEmpty(sales)) {
            numberofsales = 0;

            jQuery("#check").removeAttr("disabled");
            jQuery("#first_add_more").show();
        }

        var number_of_sales = Object.keys(sales).length;
        jQuery("#total_items").val(number_of_sales);


        var expense = jQuery("#expense").val();
        var disc_amount = jQuery("#disc_amount").val();
        var special_disc_amount = jQuery("#special_disc_amount").val();

        var amount = 0;
        var sale_tax_amount = 0;
        var rate = 0;
        total_discount = 0;

        jQuery.each(sales, function (index, value) {
            amount = +amount + +value[5];
            rate = (value[4] * value[3]) - value[6];
            sale_tax_amount = +sale_tax_amount + +((rate / 100) * value[7]);
            total_discount = +total_discount + +value[6];
        });

        var total_discount_amount =+total_discount + +disc_amount + +special_disc_amount;
        jQuery("#total_discount").val(total_discount_amount);

        var grand_total = +amount + +expense - disc_amount - special_disc_amount;

        jQuery("#total_price").val(amount);
        jQuery("#sales_tax_amount").val(sale_tax_amount);
        jQuery("#grand_total").val(grand_total);


        //////////////////////////////////////////////////////////////////////////////


        var expense = jQuery("#expense").val();
        var special_disc_amount = jQuery("#special_disc_amount").val();
        var total_price = jQuery("#total_price").val();
        var grand_total_amount = 0;
        var disc_percentage = jQuery("#disc_percentage").val();
        var total_discount_amount=0;

        var disc_amount = (total_price / 100) * disc_percentage;

        total_discount_amount = +total_discount + +disc_amount + +special_disc_amount;

        jQuery("#total_discount").val(total_discount_amount);

        jQuery("#disc_amount").val(disc_amount);

        grand_total_amount = +total_price + +expense - disc_amount - special_disc_amount;

        jQuery("#grand_total").val(grand_total_amount);

        //////////////////////////////////////////////////////////////////////////////////////////////////////

        var expense = jQuery("#expense").val();
        var disc_amount = jQuery("#disc_amount").val();
        var total_price = jQuery("#total_price").val();
        var special_disc_percentage = jQuery("#special_disc_percentage").val();
        var grand_total_amount = 0;
        var total_discount_amount=0;

        var special_disc_amount = (total_price / 100) * special_disc_percentage;

        total_discount_amount = +total_discount + +disc_amount + +special_disc_amount;

        jQuery("#total_discount").val(total_discount_amount);

        jQuery("#special_disc_amount").val(special_disc_amount);

        grand_total_amount = +total_price + +expense - disc_amount - special_disc_amount;

        jQuery("#grand_total").val(grand_total_amount);

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////

    }


    function edit_sale(current_item) {

        jQuery(".table-responsive").attr("style", "display:none");
        jQuery("#save").attr("style", "display:none");
        jQuery("#first_add_more").html('update');
        jQuery("#first_add_more").show();
        jQuery("#cancel_button").show();

        global_id_to_edit = current_item;

        var temp_sales = sales[current_item];

        jQuery("#product_code").select2("destroy");
        jQuery("#product_name").select2("destroy");

        jQuery("#product_code").children("option[value^=" + temp_sales[0] + "]").show(); //showing hid unit
        jQuery("#product_code option[value=" + temp_sales[0] + "]").attr("disabled", false);
        jQuery("#product_name option[value=" + temp_sales[0] + "]").attr("disabled", false);
        jQuery("#product_code > option").each(function () {
            jQuery('#product_code option[value="' + temp_sales[0] + '"]').prop('selected', true);
        });

        jQuery("#product_name").val(temp_sales[0]);
        jQuery("#product_remarks").val(temp_sales[2]);
        jQuery("#quantity").val(temp_sales[3]);
        jQuery("#rate").val(temp_sales[4]);
        jQuery("#amount").val(temp_sales[5]);
        jQuery("#product_discount").val(temp_sales[6]);
        jQuery("#product_sales_tax").val(temp_sales[7]);

        var pro_id = temp_sales[0];

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: "get_inventory",
            data: {pro_id: pro_id},
            type: "POST",
            cache: false,
            dataType: 'json',
            success: function (data) {

                jQuery("#demo9").html("");
                jQuery("#demo9").append('(' + data + ')');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                alert(errorThrown);
            }
        });

        jQuery("#product_code").select2();
        jQuery("#product_name").select2();

        jQuery("#cancel_button").attr("style", "display:inline");
        jQuery("#cancel_button").attr("style", "background-color:red !important");
    }

    function cancel_all() {

        var newvaltohide = jQuery("#product_code").val();

        jQuery("#quantity").val("");

        jQuery("#product_code option[value=" + newvaltohide + "]").attr("disabled", "true");
        jQuery("#product_name option[value=" + newvaltohide + "]").attr("disabled", "true");
        jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
        jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);

        jQuery("#product_code").select2("destroy");
        jQuery("#product_name").select2("destroy");

        jQuery("#product_remarks").val("");
        jQuery("#rate").val("");
        jQuery("#amount").val("");
        jQuery("#product_discount").val("");
        jQuery("#product_sales_tax").val("");
        jQuery("#demo11").html("");
        jQuery("#demo9").html("");

        jQuery("#product_code").select2();
        jQuery("#product_name").select2();

        jQuery("#cancel_button").hide();

        jQuery(".table-responsive").show();

        jQuery("#save").show();

        jQuery("#first_add_more").html('Add');
        global_id_to_edit = 0;
    }

    function validatequantity(pas) {
        var pass = /^[0-9]*$/;

        if (pass.test(pas)) {
            return true;
        }
        else {
            return false;
        }
    }
</script>


<script>
    jQuery("#product_code").change(function () {

        var dropDown = document.getElementById('product_code');
        var pro_id = dropDown.options[dropDown.selectedIndex].value;

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: "get_inventory",
            data: {pro_id: pro_id},
            type: "POST",
            cache: false,
            dataType: 'json',
            success: function (data) {

                jQuery("#demo9").html("");
                jQuery("#demo9").append('(' + data + ')');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                alert(errorThrown);
            }
        });
    });
</script>

<script>
    jQuery("#product_name").change(function () {

        var dropDown = document.getElementById('product_name');
        var pro_id = dropDown.options[dropDown.selectedIndex].value;

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: "get_inventory",
            data: {pro_id: pro_id},
            type: "POST",
            cache: false,
            dataType: 'json',
            success: function (data) {

                jQuery("#demo9").html("");
                jQuery("#demo9").append('(' + data + ')');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                alert(errorThrown);
            }
        });
    });
</script>

<script>
    // jQuery("#invoice_no").blur(function () {
    jQuery("#check").click(function () {

        jQuery("#table_body").html("");
        jQuery("#product_code").html("");
        jQuery("#product_name").html("");

        numberofsales == 0;
        sales = {};
        var invoice_no = jQuery('#invoice_no').val();

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: "get_sale_items_for_return",
            data: {invoice_no: invoice_no},
            type: "POST",
            cache: false,
            dataType: 'json',
            success: function (data) {



                jQuery(".alert-info").hide();
                if(data[7]=='full'){

                    jQuery(".return_status").prepend('<div class="alert alert-info">' +
                        'Already Return!' +
                        '</div>');
                    data[0]='';
                    data[1]='';
                    data[3]='';
                    data[4]='';

                }else if(data[7]=='partial'){
                    jQuery(".return_status").prepend('<div class="alert alert-info">' +
                        'Partial Return!' +
                        '</div>');
                    data[0]='';
                    data[1]='';
                    data[3]='';
                    data[4]='';
                }

                jQuery('#cash_paid').val(data[0]['si_cash_paid']);
                jQuery('#grand_total').val(data[0]['si_grand_total']);
                jQuery('#special_disc_amount').val(data[0]['si_special_disc']);
                jQuery('#special_disc_percentage').val(data[0]['si_special_disc_percentage']);
                jQuery('#sales_tax_amount').val(data[0]['si_sales_tax']);
                jQuery('#disc_amount').val(data[0]['si_trade_disc']);
                jQuery('#disc_percentage').val(data[0]['si_trade_disc_percentage']);
                jQuery('#value_of_supply').val(data[0]['si_value_of_supply']);
                jQuery('#expense').val(data[0]['si_expense']);
                jQuery('#total_price').val(data[0]['si_total_price']);
                jQuery('#total_items').val(data[0]['si_cash_paid']);
                jQuery('#total_discount').val(data[0]['si_total_discount']);

                jQuery("#remarks").val(data[0]['si_remarks']);
                // jQuery("#customer_party_name").val(data[0]['si_party_name']);
                // jQuery("#customer_code").val(data[0]['si_party_code']);
                // jQuery("#party_name").val(data[0]['si_party_name']);
                // jQuery("#party_head").val(data[0]['si_party_code'].substring(0, 5));


                jQuery("#product_code").append(data[4]);
                jQuery("#product_name").append(data[3]);
                $.each(data[1], function (index, value) {

                    var product_name = value['sii_product_name'];
                    var selected_code_value = value['sii_product_code'];
                    var qty = value['sii_qty'];
                    var selected_product_name = value['sii_product_code'];
                    var selected_remarks = value['sii_remarks'];
                    var selected_rate = value['sii_rate'];
                    var selected_amount = value['sii_amount'];
                    var product_sales_tax = value['sii_saletax'];
                    var product_discount = value['sii_discount'];


                    if (global_id_to_edit != 0) {
                        jQuery("#" + global_id_to_edit).remove();
                        delete sales[global_id_to_edit];
                    }

                    counter++;

                    var checkedValue = [];

                    if (product_sales_tax == '') {
                        product_sales_tax = 0;
                    }
                    if (product_discount == '') {
                        product_discount = 0;
                    }
                    // if (selected_remarks == '') {
                    //     selected_remarks = product_name;
                    // }
                    numberofsales = Object.keys(sales).length;


                    if (numberofsales == 0) {
                        jQuery("#table_body").html("");
                    }
                    // $("#invoice_no").attr("disabled", "true");

                    var sale_tax = 0;
                    //  rate=value[4]- value[6];
                    // sale_tax=+sale_tax + +value[7];

                    sale_tax = ((((selected_rate * qty) - product_discount) / 100) * product_sales_tax);

                    sales[counter] = [selected_code_value, product_name, selected_remarks, qty, selected_rate, selected_amount, product_discount, product_sales_tax, sale_tax];

                    jQuery("#product_code option[value=" + selected_code_value + "]").attr("disabled", "true");
                    jQuery("#product_name option[value=" + selected_code_value + "]").attr("disabled", "true");
                    numberofsales = Object.keys(sales).length;

                    jQuery("#table_body").append('<tr id=' + counter + '><td >' + selected_code_value + '</td><td >' + product_name + '</td><td>' + selected_remarks + '</td><td >' + qty + '</td><td >' + selected_rate + '</td><td>' + product_discount + '</td><td>' + product_sales_tax + '</td><td>' + selected_amount + '</td></tr>');

                    // if (numberofsales > 0) {
                    //     jQuery("#check").attr("disabled", "true");
                    // }

                    jQuery("#salesval").val(JSON.stringify(sales));
                    jQuery("#cancel_button").hide();
                    jQuery(".table-responsive").show();
                    jQuery("#save").show();
                    jQuery("#first_add_more").html('Add');
                    jQuery("#first_add_more").hide();

                    jQuery("#total_items").val(numberofsales);
                });


                //////////////////////////////////////////////////////////////////////////////


                var expense = jQuery("#expense").val();
                var special_disc_amount = jQuery("#special_disc_amount").val();
                var total_price = jQuery("#total_price").val();
                var grand_total_amount = 0;
                var disc_percentage = jQuery("#disc_percentage").val();
                var total_discount_amount=0;

                var disc_amount = (total_price / 100) * disc_percentage;

                total_discount_amount = +total_discount + +disc_amount + +special_disc_amount;

                jQuery("#total_discount").val(total_discount_amount);

                jQuery("#disc_amount").val(disc_amount);

                grand_total_amount = +total_price + +expense - disc_amount - special_disc_amount;

                jQuery("#grand_total").val(grand_total_amount);

                //////////////////////////////////////////////////////////////////////////////////////////////////////

                var expense = jQuery("#expense").val();
                var disc_amount = jQuery("#disc_amount").val();
                var total_price = jQuery("#total_price").val();
                var special_disc_percentage = jQuery("#special_disc_percentage").val();
                var grand_total_amount = 0;
                var total_discount_amount=0;

                var special_disc_amount = (total_price / 100) * special_disc_percentage;

                total_discount_amount = +total_discount + +disc_amount + +special_disc_amount;

                jQuery("#total_discount").val(total_discount_amount);

                jQuery("#special_disc_amount").val(special_disc_amount);

                grand_total_amount = +total_price + +expense - disc_amount - special_disc_amount;

                jQuery("#grand_total").val(grand_total_amount);

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////

            },
            error: function (jqXHR, textStatus, errorThrown) {
                // alert(jqXHR.responseText);
                // alert(errorThrown);
            }
        });
    });
</script>

<style type="text/css">

    /* Hide HTML5 Up and Down arrows. */
    input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none !important;
        margin: 0 !important;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

    .border_dashed {
        border-bottom: 2px dashed grey;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }

    .lower_dashed {
        border-left: 2px dashed grey;
        /*padding-top: 20px;
        margin-top: 20px;   */
    }

    .shadowed {
        margin-top: 20px;
        margin-bottom: 20px;
        min-height: 300px !important;
        max-height: 320px !important;
        overflow-y: scroll;
        box-shadow: 3px 3px 3px 3px grey;
    }
</style>
<script>
    jQuery(document).ready(function () {
        // Initialize select2
        // jQuery("#customer_code").select2();
        // jQuery("#party_name").select2();
        jQuery("#product_code").select2();
        jQuery("#product_name").select2();
    });
</script>
</body>
</html>
