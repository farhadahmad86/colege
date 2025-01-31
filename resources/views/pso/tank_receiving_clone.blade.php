@extends('extend_index')

@section('styles_get')

    <link rel="stylesheet" href="{{ asset('public/pso_form/css/style.css') }}" type="text/css" rel="stylesheet">

    <style>
        td .select2 {
            border: 0;
        }
        .border{
            border:1px solid red !important;
        }
    </style>

@stop
@section('content')

    <div class="main-container" style="height: unset">
        <div class="pd-ltr-20 customscroll-10-p height-100-p xs-pd-20-10">


            <header class=""><!-- header start -->
                <div class="container">
                    <div class="mp_0 db form_pso">
                        <div class="mp_0 db frm_hdr">

                            <div class="mp_0 db frm_logo"><!-- logo start -->
                                <img src="{{ asset('public/pso_form/images/logo.png') }}" alt="" width="120"/>
                            </div><!-- logo end -->
                            <div class="mp_0 db frm_hdng text-center"><!-- logo start -->
                                <h1 class="mp_0 db frm_hdng_ttl upper bold">
                                    CLONE Pakistan State Oil Company Limited
                                </h1>
                                <p class="mp_0 db frm_hdng_para upper bold">
                                    Sales Tax invoice (STR # 02-06-3208-015-46)
                                    <span class="db mp_0">
                                    P.O. Box # 3973, 8501, Karachi
                                </span>
                                </p>
                                <div class="mp_0 db frm_srl upper">
                                    SLS-01
                                </div>
                            </div><!-- logo end -->

                        </div>
                    </div>
                </div>
            </header><!-- header end -->

            <form action="{{route('submit_tank_receiving')}}" id="f1" class="f1" onsubmit="return validate_form()"
                  method="post" autocomplete="off">
                @csrf
                <section class="mp_0 db sctn sctn_one"><!-- section one start -->
                    <div class="container">
                        <div class="mp_0 db form_pso sctn_bx"><!-- form pso start -->


                            <div class="table-responsive">
                                <table class="table table-bordered brdr_clr mp_0">

                                    <tr><!-- row start -->
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="customer_code" class="db mp_0 lbl">
                                                Customer Code
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2" id="customer_code"
                                                   name="customer_code" placeholder="Customer Code">
                                        </td>
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="date" class="db mp_0 lbl">
                                                Date
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2" id="date"
                                                   name="date" placeholder="Date">
                                        </td>
                                    </tr><!-- row end -->

                                    <tr><!-- row start -->
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="name" class="db mp_0 lbl">
                                                Name
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control  wdth_2" id="name"
                                                   name="name" placeholder="Name">
                                        </td>
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="invoice_no" class="db mp_0 lbl">
                                                Invoice No
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2" id="invoice_no"
                                                   placeholder="Invoice No.">
                                        </td>
                                    </tr><!-- row end -->

                                    <tr><!-- row start -->
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="address" class="db mp_0 lbl">
                                                Address
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <textarea class="txt_area wdth_2" id="address" name="address"
                                                      placeholder="Address"></textarea>
                                        </td>
                                        <td colspan="2" class="mp_0_imp">
                                            <table class="table table-bordered brdr_clr mp_0_imp brdr_0_lft brdr_0_tp">
                                                <tr>
                                                    <th class="sctn_one_tbl_th brdr_clr brdr_0_lft brdr_0_tp">
                                                        <label for="delivery_no" class="db mp_0 lbl">
                                                            Delivery No
                                                        </label>
                                                    </th>
                                                    <td class="mp_0_imp brdr_clr brdr_0_tp">
                                                        <input type="text" class="inputs_up form-control wdth_2"
                                                               id="delivery_no" name="delivery_no"
                                                               placeholder="Delivery No.">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="sctn_one_tbl_th brdr_clr brdr_0_lft">
                                                        <label for="vehicle_code" class="db mp_0 lbl">
                                                            Vehicle Code.
                                                        </label>
                                                    </th>
                                                    <td class="mp_0_imp brdr_clr">
                                                        <input type="text" class="inputs_up form-control wdth_2"
                                                               id="vehicle_code" name="vehicle_code"
                                                               placeholder="Vehicle Code.">
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr><!-- row end -->

                                    <tr><!-- row start -->
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="stax_reg_no" class="db mp_0 lbl">
                                                S.Tax Reg No.
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2" id="stax_reg_no"
                                                   name="stax_reg_no" placeholder="S.Tax Reg No.">
                                        </td>
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="fleet_group" class="db mp_0 lbl">
                                                Fleet Group
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2" id="fleet_group"
                                                   name="fleet_group" placeholder="Fleet Group">
                                        </td>
                                    </tr><!-- row end -->

                                    <tr><!-- row start -->
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="ctract_no" class="db mp_0 lbl">
                                                Contract No.
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2" id="contract_no"
                                                   name="contract_no" placeholder="Contract No.">
                                        </td>
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="tl_reg_no" class="db mp_0 lbl">
                                                T/L Reg No.
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2" id="tl_reg_no"
                                                   name="tl_reg_no" placeholder="T/L Reg No.">
                                        </td>
                                    </tr><!-- row end -->

                                    <tr><!-- row start -->
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="indent_no" class="db mp_0 lbl">
                                                Indent No.
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2" id="indent_no"
                                                   name="indent_no" placeholder="Indent No.">
                                        </td>
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="ll_ack_no" class="db mp_0 lbl">
                                                L.L. Ack No.
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2" id="ll_ack_no"
                                                   name="ll_ack_no" placeholder="L.L. Ack No.">
                                        </td>
                                    </tr><!-- row end -->

                                    <tr><!-- row start -->
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="shipping_point" class="db mp_0 lbl">
                                                Shipping Point
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2" id="shipping_point"
                                                   name="shipping_point" placeholder="Shipping Point">
                                        </td>
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="calibration_no" class="db mp_0 lbl">
                                                Calibration No.
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2" id="calibration_no"
                                                   name="calibration_no" placeholder="Calibration No.">
                                        </td>
                                    </tr><!-- row end -->

                                    <tr><!-- row start -->
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="dest_code" class="db mp_0 lbl">
                                                Dest. Code
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2" id="dest_code"
                                                   name="dest_code" placeholder="Dest. Code">
                                        </td>
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="calibration_exp" class="db mp_0 lbl">
                                                Calibration EXP
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2"
                                                   id="calibration_exp" name="calibration_exp"
                                                   placeholder="Calibration EXP">
                                        </td>
                                    </tr><!-- row end -->

                                    <tr><!-- row start -->
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="shipment_type" class="db mp_0 lbl">
                                                Shipment Type
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2" id="shipment_type"
                                                   name="shipment_type" placeholder="Shipment Type">
                                        </td>
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="token_no" class="db mp_0 lbl">
                                                Token No
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2" id="token_no"
                                                   name="token_no" placeholder="Token No.">
                                        </td>
                                    </tr><!-- row end -->

                                    <tr><!-- row start -->
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="cc_no" class="db mp_0 lbl">
                                                C/C No.
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2" id="cc_no"
                                                   name="cc_no" placeholder="C/C No.">
                                        </td>
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="freight_po_no" class="db mp_0 lbl">
                                                Freight PO No.
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2" id="freight_po_no"
                                                   name="freight_po_no" placeholder="Freight PO No.">
                                        </td>
                                    </tr><!-- row end -->

                                    <tr><!-- row start -->
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="cc_name" class="db mp_0 lbl">
                                                C/C Name
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2" id="cc_name"
                                                   name="cc_name" placeholder="C/C Name">
                                        </td>
                                        <th class="sctn_one_tbl_th brdr_clr">
                                            <label for="lc_no" class="db mp_0 lbl">
                                                LC No.
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2" id="lc_no"
                                                   name="lc_no" placeholder="LC No.">
                                        </td>
                                    </tr><!-- row end -->

                                </table>
                            </div><!-- table end -->

                            <!------------------------------------------------------------- New Code (Add Multiple Products)----------------------------------------------->

                            <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher border">
                                <!-- invoice container start -->
                                <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate">
                                    <!-- invoice box start -->

                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                        <!-- invoice scroll box start -->
                                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                            <!-- invoice content start -->
                                            <div class="invoice_row"><!-- invoice row start -->

                                                <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                                    <div class="invoice_col_bx border"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            Bar Code
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <select name="product_code" class="inputs_up form-control"
                                                                    id="product_code">
                                                                <option value="0">Code</option>

                                                            </select>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_14"><!-- invoice column start -->
                                                    <div class="invoice_col_bx border"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            Product Name
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <select name="product_name" class="inputs_up form-control"
                                                                    id="product_name">
                                                                <option value="0">Product</option>

                                                            </select>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_14"><!-- invoice column start -->
                                                    <div class="invoice_col_bx border"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            Tank
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <select name="tank" class="inputs_up form-control"
                                                                    id="tank">
                                                                <option value="0">Tank</option>
                                                                @foreach($tanks as $tank)
                                                                    <option
                                                                        value="{{$tank->t_id}}">{{$tank->t_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_20"><!-- invoice column start -->
                                                    <div class="invoice_col_bx border"><!-- invoice column box start -->
                                                        <div class=" invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            DESCRIPTION
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <input type="text" name="des" class="inputs_up form-control"
                                                                   id="des" placeholder="Description">
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_10"><!-- invoice column start -->
                                                    <div class="invoice_col_bx border"><!-- invoice column box start -->
                                                        <div class=" invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            Temp/Den
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <input type="text" name="temp_den"
                                                                   class="inputs_up form-control"
                                                                   id="temp_den" placeholder="S.LOC">
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_10"><!-- invoice column start -->
                                                    <div class="invoice_col_bx border"><!-- invoice column box start -->
                                                        <div class=" invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            S.Loc
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <input type="text" name="sloc"
                                                                   class="inputs_up form-control"
                                                                   id="sloc" placeholder="S.LOC">
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_10"><!-- invoice column start -->
                                                    <div class="invoice_col_bx border"><!-- invoice column box start -->
                                                        <div class=" invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            Batch/Unit
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <input type="text" name="batch_unit"
                                                                   class="inputs_up form-control"
                                                                   id="batch_unit" placeholder="BATCH/UNIT">
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_7"><!-- invoice column start -->
                                                    <div class="invoice_col_bx border"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            Qty
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <input type="text" name="qty"
                                                                   class="inputs_up text-center form-control"
                                                                   id="qty" placeholder="Qty"
                                                                   onfocus="this.select();"
                                                                   onkeypress="return allow_only_number_and_decimals(this,event);">
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column title end -->
                                                </div><!-- invoice column box end -->

                                                <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                                    <div class="invoice_col_bx border"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            Rate
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <input type="text" name="rate"
                                                                   class="inputs_up text-right form-control"
                                                                   id="rate" placeholder="Rate"
                                                                   onfocus="this.select();"
                                                                   onkeypress="return allow_only_number_and_decimals(this,event);">
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                                    <div class="invoice_col_bx border"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            Price
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <input type="text" name="price"
                                                                   class="inputs_up text-right form-control"
                                                                   id="price" placeholder="Price">
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_21"><!-- invoice column start -->
                                                    <div class="invoice_col_txt for_voucher_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="invoice_col_txt with_cntr_jstfy">
                                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk border">
                                                                <button id="first_add_more" class="invoice_frm_btn"
                                                                        onclick="add_product()"
                                                                        type="button">
                                                                    <i class="fa fa-plus"></i> Add
                                                                </button>
                                                            </div>
                                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk border">
                                                                <button style="display: none;" id="cancel_button"
                                                                        class="invoice_frm_btn"
                                                                        onclick="cancel_all()" type="button">
                                                                    <i class="fa fa-times"></i> Cancel
                                                                </button>
                                                            </div>
                                                            <span id="demo201" class="validate_sign"> </span>
                                                        </div>
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                            </div><!-- invoice row end -->



                                            <div class="invoice_row"><!-- invoice row start -->

                                                <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                    <div class="invoice_row"><!-- invoice row start -->

                                                        <div class="invoice_col basis_col_100 gnrl-mrgn-pdng"><!-- invoice column start -->
                                                            <div class="pro_tbl_con for_voucher_tbl"><!-- product table container start -->
                                                                <div class="pro_tbl_bx"><!-- product table box start -->
                                                                    <table class="table gnrl-mrgn-pdng" id="category_dynamic_table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th class="border text-center tbl_srl_10">
                                                                                Code
                                                                            </th>
                                                                            <th class="border text-center tbl_txt_10">
                                                                                Product Name
                                                                            </th>
                                                                            <th class="border text-center tbl_srl_10">
                                                                                Tank
                                                                            </th>
                                                                            <th class="border text-center tbl_srl_20">
                                                                                Description
                                                                            </th>
                                                                            <th class="border text-center tbl_txt_10">
                                                                                TEMP/DEN
                                                                            </th>
                                                                            <th class="border text-center tbl_srl_10">
                                                                                S.LOC
                                                                            </th>
                                                                            <th class="border text-center tbl_srl_10">
                                                                                BATCH/UNIT
                                                                            </th>
                                                                            <th class="border text-center tbl_srl_6">
                                                                                QTY
                                                                            </th>
                                                                            <th class="border text-center tbl_srl_8">
                                                                                RATE
                                                                            </th>
                                                                            <th class="border text-center tbl_srl_10">
                                                                                PRICE
                                                                            </th>
                                                                        </tr>
                                                                        </thead>

                                                                        <tbody id="table_body">
                                                                        <tr>
                                                                            <td colspan="15" align="center">
                                                                                No Product Added
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>

                                                                        <tfoot>
                                                                        <tr>
                                                                            <th colspan="4" class="text-right border">
                                                                                Total Items
                                                                            </th>
                                                                            <td class="text-center tbl_srl_12 border">
                                                                                <div class="invoice_col_txt">
                                                                                    <!-- invoice column box start -->
                                                                                    <div class="invoice_col_input ">
                                                                                        <!-- invoice column input start -->
                                                                                        <input type="text" name="total_items"
                                                                                               class="inputs_up text-right form-control total-items-field"
                                                                                               id="total_items" placeholder="0.00" readonly
                                                                                               data-rule-required="true"
                                                                                               data-msg-required="Please Add"/>
                                                                                    </div><!-- invoice column input end -->
                                                                                </div><!-- invoice column box end -->
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th colspan="4" class="text-right border">
                                                                                Total Price
                                                                            </th>
                                                                            <td class="text-center tbl_srl_12 border">
                                                                                <div class="invoice_col_txt">
                                                                                    <!-- invoice column box start -->
                                                                                    <div class="invoice_col_input">
                                                                                        <!-- invoice column input start -->
                                                                                        <input type="text" name="total_price"
                                                                                               class="inputs_up text-right form-control grand-total-field"
                                                                                               id="total_price" placeholder="0.00"
                                                                                               readonly/>
                                                                                    </div><!-- invoice column input end -->
                                                                                </div><!-- invoice column box end -->
                                                                            </td>
                                                                        </tr>
                                                                        </tfoot>

                                                                    </table>
                                                                </div><!-- product table box end -->
                                                            </div><!-- product table container end -->
                                                        </div><!-- invoice column end -->


                                                    </div><!-- invoice row end -->
                                                </div><!-- invoice column end -->
                                            </div><!-- invoice row end -->

                                        </div>

                                    </div>
                                </div>
                            </div>

                        <input type="hidden" name="products_array" id="products_array">
                        <!------------------------------------------------------------- New Code (Add Multiple Products)----------------------------------------------->

                        {{--                            <div class="table-responsive">--}}
                        {{--                                <table class="table table-bordered brdr_clr brdr_0_tp">--}}
                        {{--                                    <thead>--}}
                        {{--                                    <tr>--}}
                        {{--                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th brdr_0_tp wdth_1">--}}
                        {{--                                            PROD. CODE--}}
                        {{--                                        </th>--}}
                        {{--                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th brdr_0_tp wdth_2">--}}
                        {{--                                            Description--}}
                        {{--                                        </th>--}}
                        {{--                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th brdr_0_tp wdth_4">--}}
                        {{--                                            Temp/Den--}}
                        {{--                                        </th>--}}
                        {{--                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th brdr_0_tp wdth_4">--}}
                        {{--                                            S.Loc--}}
                        {{--                                        </th>--}}
                        {{--                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th brdr_0_tp wdth_4">--}}
                        {{--                                            Batch/Unit--}}
                        {{--                                        </th>--}}
                        {{--                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th brdr_0_tp wdth_5">--}}
                        {{--                                            Qty--}}
                        {{--                                        </th>--}}
                        {{--                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th brdr_0_tp wdth_5">--}}
                        {{--                                            Rate--}}
                        {{--                                        </th>--}}
                        {{--                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th brdr_0_tp wdth_5">--}}
                        {{--                                            Price--}}
                        {{--                                        </th>--}}
                        {{--                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th brdr_0_tp wdth_5">--}}
                        {{--                                            Tank--}}
                        {{--                                        </th>--}}
                        {{--                                    </tr>--}}
                        {{--                                    </thead>--}}
                        {{--                                    <tbody>--}}

                        {{--                                    <tr>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <select class="inputs_up form-control input_up_scnd prod_select" id="prod1" name="prod[]">--}}
                        {{--                                                <option value="">Select</option>--}}
                        {{--                                                @foreach($products as $product)--}}
                        {{--                                                    <option value="{{$product->pro_code}}">{{$product->pro_code}}</option>--}}
                        {{--                                                @endforeach--}}
                        {{--                                            </select>--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="des1" name="des[]" placeholder="Description">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="temp_den1" name="temp_den[]" placeholder="TEMP/DEN">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="sloc1" name="sloc[]" placeholder="S.LOC">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="batch_unit1" name="batch_unit[]" placeholder="BATCH/UNIT">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="qty1" name="qty[]" onkeypress="return numeric_decimal_only(event);" onkeyup="calculation();"--}}
                        {{--                                                   placeholder="QTY">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="rate1" name="rate[]" onkeypress="return numeric_decimal_only(event);" onkeyup="calculation();" placeholder="Rate">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="price1" name="price[]" onkeypress="return numeric_decimal_only(event);" onkeyup="calculation();" placeholder="Price">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <select class="inputs_up form-control input_up_scnd tank_select" id="tank1" name="tank[]">--}}
                        {{--                                                <option value="">Select</option>--}}
                        {{--                                                @foreach($tanks as $tank)--}}
                        {{--                                                    <option value="{{$tank->t_id}}">{{$tank->t_name}}</option>--}}
                        {{--                                                @endforeach--}}
                        {{--                                            </select>--}}
                        {{--                                        </td>--}}
                        {{--                                    </tr>--}}


                        {{--                                    <tr>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <select class="inputs_up form-control input_up_scnd prod_select" id="prod2" name="prod[]">--}}
                        {{--                                                <option value="">Select</option>--}}
                        {{--                                                @foreach($products as $product)--}}
                        {{--                                                    <option value="{{$product->pro_code}}">{{$product->pro_code}}</option>--}}
                        {{--                                                @endforeach--}}
                        {{--                                            </select>--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="des2" name="des[]" placeholder="Description">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="temp_den2" name="temp_den[]" placeholder="TEMP/DEN">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="sloc2" name="sloc[]" placeholder="S.LOC">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="batch_unit2" name="batch_unit[]" placeholder="BATCH/UNIT">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="qty2" name="qty[]" onkeypress="return numeric_decimal_only(event);" onkeyup="calculation();" placeholder="QTY">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="rate2" name="rate[]" onkeypress="return numeric_decimal_only(event);" onkeyup="calculation();" placeholder="Rate">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="price2" name="price[]" onkeypress="return numeric_decimal_only(event);" onkeyup="calculation();" placeholder="Price">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <select class="inputs_up form-control input_up_scnd tank_select" id="tank2" name="tank[]">--}}
                        {{--                                                <option value="">Select</option>--}}
                        {{--                                                @foreach($tanks as $tank)--}}
                        {{--                                                    <option value="{{$tank->t_id}}">{{$tank->t_name}}</option>--}}
                        {{--                                                @endforeach--}}
                        {{--                                            </select>--}}
                        {{--                                        </td>--}}
                        {{--                                    </tr>--}}


                        {{--                                    <tr>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <select class="inputs_up form-control input_up_scnd prod_select" id="prod3" name="prod[]">--}}
                        {{--                                                <option value="">Select</option>--}}
                        {{--                                                @foreach($products as $product)--}}
                        {{--                                                    <option value="{{$product->pro_code}}">{{$product->pro_code}}</option>--}}
                        {{--                                                @endforeach--}}
                        {{--                                            </select>--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="des3" name="des[]" placeholder="Description">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="temp_den3" name="temp_den[]" placeholder="TEMP/DEN">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="sloc3" name="sloc[]" placeholder="S.LOC">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="batch_unit3" name="batch_unit[]" placeholder="BATCH/UNIT">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="qty3" name="qty[]" onkeypress="return numeric_decimal_only(event);" onkeyup="calculation();" placeholder="QTY">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="rate3" name="rate[]" onkeypress="return numeric_decimal_only(event);" onkeyup="calculation();" placeholder="Rate">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="price3" name="price[]" onkeypress="return numeric_decimal_only(event);" onkeyup="calculation();" placeholder="Price">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <select class="inputs_up form-control input_up_scnd tank_select" id="tank3" name="tank[]">--}}
                        {{--                                                <option value="">Select</option>--}}
                        {{--                                                @foreach($tanks as $tank)--}}
                        {{--                                                    <option value="{{$tank->t_id}}">{{$tank->t_name}}</option>--}}
                        {{--                                                @endforeach--}}
                        {{--                                            </select>--}}
                        {{--                                        </td>--}}
                        {{--                                    </tr>--}}


                        {{--                                    <tr>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <select class="inputs_up form-control input_up_scnd prod_select" id="prod4" name="prod[]">--}}
                        {{--                                                <option value="">Select</option>--}}
                        {{--                                                @foreach($products as $product)--}}
                        {{--                                                    <option value="{{$product->pro_code}}">{{$product->pro_code}}</option>--}}
                        {{--                                                @endforeach--}}
                        {{--                                            </select>--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="des4" name="des[]" placeholder="Description">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="temp_den4" name="temp_den[]" placeholder="TEMP/DEN">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="sloc4" name="sloc[]" placeholder="S.LOC">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="batch_unit4" name="batch_unit[]" placeholder="BATCH/UNIT">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="qty4" name="qty[]" onkeypress="return numeric_decimal_only(event);" onkeyup="calculation();" placeholder="QTY">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="rate4" name="rate[]" onkeypress="return numeric_decimal_only(event);" onkeyup="calculation();" placeholder="Rate">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="price4" name="price[]" onkeypress="return numeric_decimal_only(event);" onkeyup="calculation();" placeholder="Price">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <select class="inputs_up form-control input_up_scnd tank_select" id="tank4" name="tank[]">--}}
                        {{--                                                <option value="">Select</option>--}}
                        {{--                                                @foreach($tanks as $tank)--}}
                        {{--                                                    <option value="{{$tank->t_id}}">{{$tank->t_name}}</option>--}}
                        {{--                                                @endforeach--}}
                        {{--                                            </select>--}}
                        {{--                                        </td>--}}
                        {{--                                    </tr>--}}


                        {{--                                    <tr>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <select class="inputs_up form-control input_up_scnd prod_select" id="prod5" name="prod[]">--}}
                        {{--                                                <option value="">Select</option>--}}
                        {{--                                                @foreach($products as $product)--}}
                        {{--                                                    <option value="{{$product->pro_code}}">{{$product->pro_code}}</option>--}}
                        {{--                                                @endforeach--}}
                        {{--                                            </select>--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="des5" name="des[]" placeholder="Description">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="temp_den5" name="temp_den[]" placeholder="TEMP/DEN">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="sloc5" name="sloc[]" placeholder="S.LOC">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="batch_unit5" name="batch_unit[]" placeholder="BATCH/UNIT">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="qty5" name="qty[]" onkeypress="return numeric_decimal_only(event);" onkeyup="calculation();" placeholder="QTY">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="rate5" name="rate[]" onkeypress="return numeric_decimal_only(event);" onkeyup="calculation();" placeholder="Rate">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="price5" name="price[]" onkeypress="return numeric_decimal_only(event);" onkeyup="calculation();" placeholder="Price">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <select class="inputs_up form-control input_up_scnd tank_select" id="tank5" name="tank[]">--}}
                        {{--                                                <option value="">Select</option>--}}
                        {{--                                                @foreach($tanks as $tank)--}}
                        {{--                                                    <option value="{{$tank->t_id}}">{{$tank->t_name}}</option>--}}
                        {{--                                                @endforeach--}}
                        {{--                                            </select>--}}
                        {{--                                        </td>--}}
                        {{--                                    </tr>--}}


                        {{--                                    <tr>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <select class="inputs_up form-control input_up_scnd prod_select" id="prod6" name="prod[]">--}}
                        {{--                                                <option value="">Select</option>--}}
                        {{--                                                @foreach($products as $product)--}}
                        {{--                                                    <option value="{{$product->pro_code}}">{{$product->pro_code}}</option>--}}
                        {{--                                                @endforeach--}}
                        {{--                                            </select>--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="des6" name="des[]" placeholder="Description">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="temp_den6" name="temp_den[]" placeholder="TEMP/DEN">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="sloc6" name="sloc[]" placeholder="S.LOC">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="batch_unit6" name="batch_unit[]" placeholder="BATCH/UNIT">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="qty6" name="qty[]" onkeypress="return numeric_decimal_only(event);" onkeyup="calculation();" placeholder="QTY">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="rate6" name="rate[]" onkeypress="return numeric_decimal_only(event);" onkeyup="calculation();" placeholder="Rate">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <input type="text" class="inputs_up form-control input_up_scnd" id="price6" name="price[]" onkeypress="return numeric_decimal_only(event);" onkeyup="calculation();" placeholder="Price">--}}
                        {{--                                        </td>--}}
                        {{--                                        <td class="mp_0_imp brdr_clr">--}}
                        {{--                                            <select class="inputs_up form-control input_up_scnd tank_select" id="tank6" name="tank[]">--}}
                        {{--                                                <option value="">Select</option>--}}
                        {{--                                                @foreach($tanks as $tank)--}}
                        {{--                                                    <option value="{{$tank->t_id}}">{{$tank->t_name}}</option>--}}
                        {{--                                                @endforeach--}}
                        {{--                                            </select>--}}
                        {{--                                        </td>--}}
                        {{--                                    </tr>--}}


                        {{--                                    </tbody>--}}
                        {{--                                </table>--}}
                        {{--                            </div><!-- table end -->--}}

{{--                        <div class="form-row col-md-12" style="margin-top: 10px;">--}}
{{--                            <div class="form-group row col-md-12">--}}
{{--                                <div class="pt-3 row  col-md-12">--}}
{{--                                    <label class=" col-form-label text-md-center col-md-3">Total Invoice Amount</label>--}}
{{--                                    <div class="">--}}
{{--                                        <input type="text" class="form-control text-md-right"--}}
{{--                                               style="border: 1px solid red;" id="total_invoice_amount"--}}
{{--                                               name="total_invoice_amount" onkeyup="calculation();"--}}
{{--                                               placeholder="000,000">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        {{--                        <div class="form-row" style="margin-top: 10px;">--}}
                        {{--                            <div class="form-group row">--}}
                        {{--                                <div class="col-md-offset-6 pt-3">--}}
                        {{--                                    <label class="col-md-4 col-form-label text-md-right">Total Invoice Amount</label>--}}
                        {{--                                    <div class="col-md-8">--}}
                        {{--                                        <input type="text" class="form-control" style="border: 1px solid red;" id="total_invoice_amount" name="total_invoice_amount" onkeyup="calculation();"  placeholder="Total Invoice Amount">--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
{{--                    </div><!-- form pso end -->--}}
        </div>
                    </div>
        </section><!-- section one end -->


        <section class="mp_0 db sctn sctn_one"><!-- header start -->
            <div class="container">
                <div class="mp_0 db form_pso sctn_bx"><!-- form pso start -->

                    <div class="table-responsive">
                        <table class="table table-bordered brdr_clr">

                            <thead>
                            <tr>
                                <th class="sctn_one_tbl_th brdr_clr text-left lbl_th wdth_6">
                                    F.O Liters:-
                                </th>
                                <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 brdr_0_btm">
                                    CHMB 1
                                </th>
                                <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 brdr_0_btm">
                                    CHMB 2
                                </th>
                                <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 brdr_0_btm">
                                    CHMB 3
                                </th>
                                <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 brdr_0_btm">
                                    CHMB 4
                                </th>
                                <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 brdr_0_btm">
                                    CHMB 5
                                </th>
                                <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 brdr_0_btm">
                                    CHMB 6
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td class="mp_0 brdr_clr mp_0_imp">
                                    <table class="table mp_0_imp">
                                        <tr>
                                            <td class="txt_fnt bold">
                                                <div class="db txt_fnt bold text-right urdu_div">
                                                    کمپنی کی ذمہ داری اس وقت ختم ہو جاتی ہے جب سامان عوامی کیریئر کے
                                                    حوالے کر دیا گیا ہو اور اس وقت سے واضح دسید حاصل کر لی گی ہو
                                                </div>
                                                Product meets specification issued by Ministry of Petroleum and Natural
                                                Resources. Letter No. PL-NRL(4)-86(SPEC) Dated 13.4.1988
                                            </td>
                                            <td class="mp_0_imp">
                                                <table class="table mp_0_imp">
                                                    <tr>
                                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 ln_ht brdr_0_rt brdr_0_tp">
                                                            Ref Dip
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 ln_ht brdr_0_rt">
                                                            Prod Dip
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 ln_ht brdr_0_rt">
                                                            Seal No.
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 ln_ht brdr_0_rt">
                                                            Short Dip
                                                        </th>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td colspan="6" class="mp_0_imp p-0">
                                    <table class="table mp_0_imp">

                                        <tr>
                                            <td class="mp_0_imp brdr_clr brdr_0_lft">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_one[]" name="chamb_one[]" placeholder="CHMB 1">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_two[]" name="chamb_two[]" placeholder="CHMB 2">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_three[]" name="chamb_three[]" placeholder="CHMB 3">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_four[]" name="chamb_four[]" placeholder="CHMB 4">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_five[]" name="chamb_five[]" placeholder="CHMB 5">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_six[]" name="chamb_six[]" placeholder="CHMB 6">
                                            </td>
                                        </tr>


                                        <tr>
                                            <td class="mp_0_imp brdr_clr brdr_0_lft">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_one[]" name="chamb_one[]" placeholder="CHMB 1">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_two[]" name="chamb_two[]" placeholder="CHMB 2">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_three[]" name="chamb_three[]" placeholder="CHMB 3">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_four[]" name="chamb_four[]" placeholder="CHMB 4">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_five[]" name="chamb_five[]" placeholder="CHMB 5">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_six[]" name="chamb_six[]" placeholder="CHMB 6">
                                            </td>
                                        </tr>


                                        <tr>
                                            <td class="mp_0_imp brdr_clr brdr_0_lft">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_one[]" name="chamb_one[]" placeholder="CHMB 1">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_two[]" name="chamb_two[]" placeholder="CHMB 2">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_three[]" name="chamb_three[]" placeholder="CHMB 3">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_four[]" name="chamb_four[]" placeholder="CHMB 4">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_five[]" name="chamb_five[]" placeholder="CHMB 5">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_six[]" name="chamb_six[]" placeholder="CHMB 6">
                                            </td>
                                        </tr>


                                        <tr>
                                            <td class="mp_0_imp brdr_clr brdr_0_lft">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_one[]" name="chamb_one[]" placeholder="CHMB 1">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_two[]" name="chamb_two[]" placeholder="CHMB 2">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_three[]" name="chamb_three[]" placeholder="CHMB 3">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_four[]" name="chamb_four[]" placeholder="CHMB 4">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_five[]" name="chamb_five[]" placeholder="CHMB 5">
                                            </td>
                                            <td class="mp_0_imp brdr_clr">
                                                <input type="text" class="inputs_up form-control input_up_scnd"
                                                       id="chamb_six[]" name="chamb_six[]" placeholder="CHMB 6">
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>

                            </tbody>

                        </table>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-7"><!-- col start -->

                            <div class="table-responsive"><!-- table start -->
                                <table class="table table-bordered brdr_clr">

                                    <thead>
                                    <tr>
                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th">
                                            Bank
                                        </th>
                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th">
                                            Inst. Type
                                        </th>
                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th">
                                            Inst. No.
                                        </th>
                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th">
                                            Amount
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control input_up_scnd" id="bank"
                                                   name="bank" placeholder="Bank">
                                        </td>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control input_up_scnd"
                                                   id="inst_type" name="inst_type" placeholder="INST TYPE">
                                        </td>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control input_up_scnd" id="inst_no"
                                                   name="inst_no" placeholder="INST No.">
                                        </td>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control input_up_scnd" id="amount"
                                                   name="amount" placeholder="Amount">
                                        </td>
                                    </tr>
                                    {{--                            <tr>--}}
                                    {{--                                <td class="mp_0_imp brdr_clr">--}}
                                    {{--                                    <input type="text" class="inputs_up form-control input_up_scnd" id="bank[]" name="bank" placeholder="Bank">--}}
                                    {{--                                </td>--}}
                                    {{--                                <td class="mp_0_imp brdr_clr">--}}
                                    {{--                                    <input type="text" class="inputs_up form-control input_up_scnd" id="inst_type[]" name="inst_type" placeholder="INST TYPE">--}}
                                    {{--                                </td>--}}
                                    {{--                                <td class="mp_0_imp brdr_clr">--}}
                                    {{--                                    <input type="text" class="inputs_up form-control input_up_scnd" id="inst_no[]" name="inst_no" placeholder="INST No.">--}}
                                    {{--                                </td>--}}
                                    {{--                                <td class="mp_0_imp brdr_clr">--}}
                                    {{--                                    <input type="text" class="inputs_up form-control input_up_scnd" id="amount[]" name="amount" placeholder="Amount">--}}
                                    {{--                                </td>--}}
                                    {{--                            </tr>--}}
                                    {{--                            <tr>--}}
                                    {{--                                <td class="mp_0_imp brdr_clr">--}}
                                    {{--                                    <input type="text" class="inputs_up form-control input_up_scnd" id="bank[]" placeholder="Bank">--}}
                                    {{--                                </td>--}}
                                    {{--                                <td class="mp_0_imp brdr_clr">--}}
                                    {{--                                    <input type="text" class="inputs_up form-control input_up_scnd" id="inst_type[]" placeholder="INST TYPE">--}}
                                    {{--                                </td>--}}
                                    {{--                                <td class="mp_0_imp brdr_clr">--}}
                                    {{--                                    <input type="text" class="inputs_up form-control input_up_scnd" id="inst_no[]" placeholder="INST No.">--}}
                                    {{--                                </td>--}}
                                    {{--                                <td class="mp_0_imp brdr_clr">--}}
                                    {{--                                    <input type="text" class="inputs_up form-control input_up_scnd" id="amount[]" placeholder="Amount">--}}
                                    {{--                                </td>--}}
                                    {{--                            </tr>--}}
                                    </tbody>

                                </table>
                            </div><!-- table end -->

                            <div class="table-responsive"><!-- table start -->
                                <table class="table table-bordered brdr_clr">

                                    <thead>
                                    <tr>
                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_4">
                                            R R Date
                                        </th>
                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_1">
                                            R R Number
                                        </th>
                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_1">
                                            R R INV No
                                        </th>
                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_4">
                                            Weight
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control input_up_scnd" id="rr_date"
                                                   name="rr_date" placeholder="R R Date">
                                        </td>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control input_up_scnd" id="rr_nbr"
                                                   name="rr_nbr" placeholder="R R Number">
                                        </td>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control input_up_scnd"
                                                   id="rr_inv_no" name="rr_inv_no" placeholder="R R INV No">
                                        </td>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control input_up_scnd" id="weight"
                                                   name="weight" placeholder="Weight">
                                        </td>
                                    </tr>
                                    </tbody>

                                </table>
                            </div><!-- table end -->

                        </div><!-- col end -->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-5"><!-- col start -->

                            <div class="table-responsive"><!-- table start -->
                                <table class="table table-bordered brdr_clr">

                                    <thead>
                                    <tr>
                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5">
                                            Miscellaneous Information
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control input_up_scnd"
                                                   id="miscellaneous" placeholder="Miscellaneous Information">
                                        </td>
                                    </tr>
                                    {{--                            <tr>--}}
                                    {{--                                <td class="mp_0_imp brdr_clr">--}}
                                    {{--                                    <input type="text" class="inputs_up form-control input_up_scnd" id="miscellaneous[]" placeholder="Miscellaneous Information">--}}
                                    {{--                                </td>--}}
                                    {{--                            </tr>--}}
                                    {{--                            <tr>--}}
                                    {{--                                <td class="mp_0_imp brdr_clr">--}}
                                    {{--                                    <input type="text" class="inputs_up form-control input_up_scnd" id="miscellaneous[]" placeholder="Miscellaneous Information">--}}
                                    {{--                                </td>--}}
                                    {{--                            </tr>--}}
                                    </tbody>

                                </table>
                            </div><!-- table end -->

                            <div class="table-responsive"><!-- table start -->
                                <table class="table table-bordered brdr_clr">

                                    <thead>
                                    <tr>
                                        <td class="sctn_one_tbl_th brdr_clr text-left lbl_th">
                                            I confirm that the quality of product received against the invoice is in
                                            accordance with my requirments and is free from any adulteration
                                        </td>
                                    </tr>
                                    </thead>

                                </table>
                            </div><!-- col end -->
                        </div>

                    </div><!-- form pso end -->

                    <div class="row mp_0_imp">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-7 mp_0"><!-- col start -->

                            <div class="table-responsive mp_0"><!-- table start -->
                                <table class="table table-bordered brdr_clr mp_0">

                                    <tbody>
                                    <tr>
                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 brdr_0_rt">
                                            Prepared By:
                                        </th>
                                        <td class="mp_0_imp brdr_clr wdth_7 brdr_0_lft brdr_0_rt">
                                            <input type="text" class="inputs_up form-control text-left input_up_thrd"
                                                   id="pre_by" name="pre_by" placeholder="Prepared By">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 brdr_0_rt">
                                            Approved By:
                                        </th>
                                        <td class="mp_0_imp brdr_clr wdth_7 brdr_0_lft brdr_0_rt">
                                            <input type="text" class="inputs_up form-control text-left input_up_thrd"
                                                   id="approved_by" name="approved_by" placeholder="Approved By">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 brdr_0_rt">
                                            Released By:
                                        </th>
                                        <td class="mp_0_imp brdr_clr wdth_7 brdr_0_lft brdr_0_rt">
                                            <input type="text" class="inputs_up form-control text-left input_up_thrd"
                                                   id="released_by" name="released_by" placeholder="Released By">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 brdr_0_rt">
                                            Driver's Signature:
                                        </th>
                                        <td class="mp_0_imp brdr_clr wdth_7 brdr_0_lft">
                                            <input type="text" class="inputs_up form-control text-left input_up_thrd"
                                                   id="driv_signature[]" name="driv_signature"
                                                   placeholder="Driver Signature">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 brdr_0_rt">
                                            NIC No:
                                        </th>
                                        <td class="mp_0_imp brdr_clr wdth_7 brdr_0_lft">
                                            <input type="text" class="inputs_up form-control text-left input_up_thrd"
                                                   id="nic_no[]" name="nic_no" placeholder="NIC No.">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 brdr_0_rt">
                                            Buyer's Signature:
                                        </th>
                                        <td class="mp_0_imp brdr_clr wdth_7 brdr_0_lft">
                                            <input type="text" class="inputs_up form-control text-left input_up_thrd"
                                                   id="buyer_signature[]" name="buyer_signature"
                                                   placeholder="Buyer Signature">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 brdr_0_rt">
                                            Dated:
                                        </th>
                                        <td class="mp_0_imp brdr_clr wdth_7 brdr_0_lft">
                                            <input type="text" class="inputs_up form-control text-left input_up_thrd"
                                                   id="date_bot" name="date_bot" placeholder="Dated">
                                        </td>
                                    </tr>
                                    </tbody>

                                </table>
                            </div><!-- table end -->


                        </div><!-- col end -->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-5 mp_0"><!-- col start -->

                            <div class="table-responsive"><!-- table start -->
                                <table class="table table-bordered brdr_clr brdr_0_lft">

                                    <tbody>
                                    <tr>
                                        <td colspan="2" class="mp_0_imp brdr_clr wdth_7 brdr_0_lft">
                                            <textarea class="txt_area wdth_2" id="con_sig_stamp"
                                                      placeholder="Consignee Signature Stamp & Date"></textarea>
                                            <label for="con_sig_stamp" class="db mp_0 lbl text-center">
                                                Consignee Signature Stamp & Date
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center wdth_5 brdr_0_lft">
                                            Exclusive GST
                                        </th>
                                        <td class="mp_0_imp brdr_clr wdth_7 brdr_0_lft brdr_0_rt">
                                            <input type="text" class="inputs_up form-control text-left input_up_thrd"
                                                   id="val_exclu_gst[]" name="val_exclu_gst"
                                                   placeholder="Value Exclusive GST">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center wdth_5 brdr_0_lft">
                                            GST
                                        </th>
                                        <td class="mp_0_imp brdr_clr wdth_7 brdr_0_lft brdr_0_rt">
                                            <input type="text" class="inputs_up form-control text-left input_up_thrd"
                                                   id="gst[]" name="gst" placeholder="GST">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="sctn_one_tbl_th brdr_clr mp_01 text-center wdth_5 brdr_0_lft">
                                            Inclusive GST
                                        </th>
                                        <td class="mp_0_imp brdr_clr wdth_7 brdr_0_lft brdr_0_rt">
                                            <input type="text" class="inputs_up form-control text-left input_up_thrd"
                                                   id="val_inclu_gst[]" name="val_inclu_gst"
                                                   placeholder="Value Inclusive GST">
                                        </td>
                                    </tr>
                                    </tbody>

                                </table>
                            </div><!-- table end -->

                            <div class="form_controls">

                                <button type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                    <i class="fa fa-eraser"></i> Clear
                                </button>
                                <button type="submit" name="filter_search" id="filter_search"
                                        class="save_button form-control">
                                    <i class="fa fa-floppy-o"></i> Save
                                </button>
                                <span id="demo1" class="validate_sign"
                                      style="float: right !important; color: red"> </span>
                            </div>
                        </div><!-- col end -->

                    </div><!-- row end -->
                </div>
            </div>
        </section><!-- section one end -->
        </form>
    </div>
    </div>

@endsection

@section('scripts')

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery(".prod_select").select2();
            jQuery(".tank_select").select2();
        });
    </script>

{{--    <script>--}}
{{--        function validate_form() {--}}
{{--            var product = $('#prod1').val();--}}
{{--            var des = $('#des1').val();--}}
{{--            var temp = $('#temp_den1').val();--}}
{{--            var sloc = $('#sloc1').val();--}}
{{--            var batch = $('#batch_unit1').val();--}}
{{--            var qty = $('#qty1').val();--}}
{{--            var rate = $('#rate1').val();--}}
{{--            var price = $('#price1').val();--}}
{{--            var tank = $('#tank1').val();--}}

{{--            var flag_submit = true;--}}
{{--            var focus_once = 0;--}}

{{--            if (product.trim() == "") {--}}
{{--                //   document.getElementById("demo1").innerHTML = "Required";--}}
{{--                if (focus_once == 0) {--}}
{{--                    jQuery("#product1").focus();--}}
{{--                    focus_once = 1;--}}
{{--                }--}}
{{--                flag_submit = false;--}}
{{--            } else {--}}
{{--                //  document.getElementById("demo1").innerHTML = "";--}}
{{--            }--}}

{{--            if (qty.trim() == "") {--}}
{{--                //   document.getElementById("demo1").innerHTML = "Required";--}}
{{--                if (focus_once == 0) {--}}
{{--                    jQuery("#qty1").focus();--}}
{{--                    focus_once = 1;--}}
{{--                }--}}
{{--                flag_submit = false;--}}
{{--            } else {--}}
{{--                //   document.getElementById("demo1").innerHTML = "";--}}
{{--            }--}}

{{--            if (rate.trim() == "") {--}}
{{--                // document.getElementById("demo1").innerHTML = "Required";--}}
{{--                if (focus_once == 0) {--}}
{{--                    jQuery("#rate1").focus();--}}
{{--                    focus_once = 1;--}}
{{--                }--}}
{{--                flag_submit = false;--}}
{{--            } else {--}}
{{--                // document.getElementById("demo1").innerHTML = "";--}}
{{--            }--}}

{{--            if (price.trim() == "") {--}}
{{--                //  document.getElementById("demo1").innerHTML = "Required";--}}
{{--                if (focus_once == 0) {--}}
{{--                    jQuery("#price1").focus();--}}
{{--                    focus_once = 1;--}}
{{--                }--}}
{{--                flag_submit = false;--}}
{{--            } else {--}}
{{--                //    document.getElementById("demo1").innerHTML = "";--}}
{{--            }--}}

{{--            if (tank.trim() == "") {--}}
{{--                //  document.getElementById("demo1").innerHTML = "Required";--}}
{{--                if (focus_once == 0) {--}}
{{--                    jQuery("#tank1").focus();--}}
{{--                    focus_once = 1;--}}
{{--                }--}}
{{--                flag_submit = false;--}}
{{--            } else {--}}
{{--                //    document.getElementById("demo1").innerHTML = "";--}}
{{--            }--}}

{{--            if (!flag_submit) {--}}
{{--                document.getElementById("demo1").innerHTML = "Enter At Least First Row Of Product List";--}}
{{--            } else {--}}
{{--                document.getElementById("demo1").innerHTML = "";--}}
{{--            }--}}

{{--            return flag_submit;--}}
{{--        }--}}


{{--        function numeric_decimal_only(e) {--}}

{{--            return e.charCode === 0 || ((e.charCode >= 48 && e.charCode <= 57) || (e.charCode == 46 && document.getElementById(e.target.id).value.indexOf('.') < 0));--}}
{{--        }--}}
{{--    </script>--}}

{{--    <script>--}}
{{--        function calculation() {--}}
{{--            var qty1 = $('#qty1').val();--}}
{{--            var qty2 = $('#qty2').val();--}}
{{--            var qty3 = $('#qty3').val();--}}
{{--            var qty4 = $('#qty4').val();--}}
{{--            var qty5 = $('#qty5').val();--}}
{{--            var qty6 = $('#qty6').val();--}}

{{--            var rate1 = $('#rate1').val();--}}
{{--            var rate2 = $('#rate2').val();--}}
{{--            var rate3 = $('#rate3').val();--}}
{{--            var rate4 = $('#rate4').val();--}}
{{--            var rate5 = $('#rate5').val();--}}
{{--            var rate6 = $('#rate6').val();--}}

{{--            var price1 = qty1 * rate1;--}}
{{--            var price2 = qty2 * rate2;--}}
{{--            var price3 = qty3 * rate3;--}}
{{--            var price4 = qty4 * rate4;--}}
{{--            var price5 = qty5 * rate5;--}}
{{--            var price6 = qty6 * rate6;--}}


{{--            $('#price1').val(price1);--}}
{{--            $('#price2').val(price2);--}}
{{--            $('#price3').val(price3);--}}
{{--            $('#price4').val(price4);--}}
{{--            $('#price5').val(price5);--}}
{{--            $('#price6').val(price6);--}}

{{--            var total_amount = +price1 + +price2 + +price3 + +price4 + +price5 + +price6;--}}

{{--            $('#total_invoice_amount').val(total_amount);--}}
{{--        }--}}

{{--    </script>--}}

    <script>
        function product_calculation() {
            var quantity = jQuery("#qty").val();
            var rate = jQuery("#rate").val();
            var price;

            price = (rate * quantity);

            jQuery("#price").val(price);
        }

        function grand_total_calculation() {
            var price = 0;

            jQuery.each(products, function (index, value) {
                price = +price + +value['product_price'];
            });

            jQuery("#total_price").val(price);
        }
    </script>

    <script>
        jQuery("#product_code").change(function () {

            var purchase_price = jQuery('option:selected', this).attr('data-purchase_price');

            var pname = jQuery('option:selected', this).val();
            jQuery("#product_name").select2("destroy");

            jQuery('#product_name option[value="' + pname + '"]').prop('selected', true);

            jQuery("#product_name").select2();

            jQuery("#rate").val(purchase_price);

            product_calculation();
        });

    </script>

    <script>
        jQuery("#product_name").change(function () {

            var purchase_price = jQuery('option:selected', this).attr('data-purchase_price');
            var pcode = jQuery('option:selected', this).val();

            jQuery("#product_code").select2("destroy");
            jQuery('#product_code option[value="' + pcode + '"]').prop('selected', true);

            jQuery("#product_code").select2();

            jQuery("#rate").val(purchase_price);

            product_calculation();
        });
    </script>

    <script>

        jQuery("#qty").keyup(function () {

            product_calculation();
        });

        jQuery("#rate").keyup(function () {
            product_calculation();
        });
    </script>

    <script>

        // adding packs into table
        var numberofproducts = 0;
        var counter = 0;
        var products = {};
        var global_id_to_edit = 0;
        var edit_product_value = '';

        function popvalidation() {
            isDirty = true;

            var product_code = document.getElementById("product_code").value;
            var product_name = document.getElementById("product_name").value;
            var des = document.getElementById("des").value;
            var qty = document.getElementById("qty").value;
            var rate = document.getElementById("rate").value;
            var price = document.getElementById("price").value;
            var remarks = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;

            if (remarks.trim() == "") {
                var isDirty = false;
                if (focus_once == 0) {
                    jQuery("#remarks").focus();
                    focus_once = 1;
                }
                flag_submit = false;

            }


            if (numberofproducts == 0) {
                var isDirty = false;
                if (product_code == "0") {
                    if (focus_once == 0) {
                        jQuery("#product_code").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }


                if (product_name == "0") {

                    if (focus_once == 0) {
                        jQuery("#product_name").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }


                if (qty == "" || qty <= 0) {

                    if (focus_once == 0) {
                        jQuery("#qty").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }


                // if (rate == "" || rate == 0) {
                //
                //     if (focus_once == 0) {
                //         jQuery("#rate").focus();
                //         focus_once = 1;
                //     }
                //     flag_submit = false;
                // }
                //
                //
                // if (price == "") {
                //
                //
                //     if (focus_once == 0) {
                //         jQuery("#price").focus();
                //         focus_once = 1;
                //     }
                //     flag_submit = false;
                // }

                document.getElementById("demo28").innerHTML = "Add Items";
                flag_submit = false;
            } else {
                document.getElementById("demo28").innerHTML = "";
            }
            return flag_submit;
        }


        function add_product() {

            var product_code = document.getElementById("product_code").value;
            var product_name = document.getElementById("product_name").value;
            var des = document.getElementById("des").value;
            var temp_den = document.getElementById("temp_den").value;
            var sloc = document.getElementById("sloc").value;
            var batch_unit = document.getElementById("batch_unit").value;
            var qty = document.getElementById("qty").value;
            var rate = document.getElementById("rate").value;
            var price = document.getElementById("price").value;


            var flag_submit1 = true;
            var focus_once1 = 0;

            if (product_code == "0") {

                if (focus_once1 == 0) {
                    jQuery("#product_code").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (product_name == "0") {

                if (focus_once1 == 0) {
                    jQuery("#product_name").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (qty == "" || qty <= 0) {

                if (focus_once1 == 0) {
                    jQuery("#qty").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            // if (rate == "" || rate == 0) {
            //
            //     if (focus_once1 == 0) {
            //         jQuery("#rate").focus();
            //         focus_once1 = 1;
            //     }
            //     flag_submit1 = false;
            // }
            //
            //
            // if (price == "") {
            //
            //     if (focus_once1 == 0) {
            //         jQuery("#price").focus();
            //         focus_once1 = 1;
            //     }
            //     flag_submit1 = false;
            // }


            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete products[global_id_to_edit];
                }

                counter++;

                jQuery("#product_code").select2("destroy");
                jQuery("#product_name").select2("destroy");
                jQuery("#tank").select2("destroy");

                var tank = jQuery("#tank").val();
                var tank_name = jQuery("#tank option:selected").text();
                var selected_code_value = jQuery("#product_code option:selected").attr('data-parent');
                var product_name = jQuery("#product_name option:selected").text();
                var qty = jQuery("#qty").val();
                var selected_rate = jQuery("#rate").val();
                // var selected_rate = 0;//jQuery("#rate").val();
                var selected_price = jQuery("#price").val();
                // var selected_price = 0;//= jQuery("#price").val();
                var selected_des = jQuery("#des").val();
                var selected_temp_den = jQuery("#temp_den").val();
                var selected_sloc = jQuery("#sloc").val();
                var selected_batch_unit = jQuery("#batch_unit").val();

                numberofproducts = Object.keys(products).length;

                if (numberofproducts == 0) {
                    jQuery("#table_body").html("");
                }

                products[counter] = {
                    'tank': tank,
                    'tank_name': tank_name,
                    'product_code': selected_code_value,
                    'product_name': product_name,
                    'product_qty': qty,
                    'product_rate': selected_rate,
                    'product_price': selected_price,
                    'product_des': selected_des,
                    'product_temp_den': selected_temp_den,
                    'product_sloc': selected_sloc,
                    'product_batch_unit': selected_batch_unit
                };

                jQuery("#product_code option[value=" + selected_code_value + "]").attr("disabled", "true");
                jQuery("#product_name option[value=" + selected_code_value + "]").attr("disabled", "true");
                numberofproducts = Object.keys(products).length;

                jQuery("#table_body").append(
                    '<tr id=' + counter + ' class="edit_update"><td class="border text-center tbl_srl_10">' + selected_code_value + '</td><td class="border text-left tbl_txt_10">' + product_name + '</td><td class="border text-left tbl_srl_10">' + tank_name + '</td><td class="border text-left tbl_txt_20">' + selected_des + '</td><td class="border text-left tbl_txt_10">' + selected_temp_den + '</td><td class="border text-left tbl_txt_10">' + selected_sloc + '</td><td class="border text-left tbl_txt_10">' + selected_batch_unit + '</td><td class="border text-right tbl_txt_6">' + qty + '</td><td class="border text-right tbl_txt_8">' + selected_rate + '</td><td class="border text-right tbl_srl_10">' + selected_price + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_product(' + counter + ')><i class="fa fa-edit"></i></a> <a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_product(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');

                jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#tank option[value="' + 1 + '"]').prop('selected', true);

                jQuery("#qty").val("");
                jQuery("#des").val("");
                jQuery("#temp_den").val("");
                jQuery("#sloc").val("");
                jQuery("#batch_unit").val("");
                jQuery("#rate").val("");
                jQuery("#price").val("");

                jQuery("#products_array").val(JSON.stringify(products));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i>  Add');

                jQuery("#total_items").val(numberofproducts);

                jQuery("#product_code").select2();
                jQuery("#product_name").select2();
                jQuery("#tank").select2();

                grand_total_calculation();

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();
            }
        }


        function delete_product(current_item) {

            jQuery("#" + current_item).remove();
            var temp_products = products[current_item];
            jQuery("#product_code option[value=" + temp_products['product_code'] + "]").attr("disabled", false);
            jQuery("#product_name option[value=" + temp_products['product_code'] + "]").attr("disabled", false);

            delete products[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#products_array").val(JSON.stringify(products));


            if (isEmpty(products)) {
                numberofproducts = 0;
            }
            jQuery("#total_items").val(numberofproducts);

            grand_total_calculation();
        }


        function edit_product(current_item) {

            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();


            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;

            var temp_products = products[current_item];

            edit_product_value = temp_products['product_code'];

            jQuery("#product_code").select2("destroy");
            jQuery("#product_name").select2("destroy");
            jQuery("#tank").select2("destroy");

            jQuery("#product_code option[value=" + temp_products['product_code'] + "]").attr("disabled", false);
            jQuery("#product_name option[value=" + temp_products['product_code'] + "]").attr("disabled", false);

            jQuery('#product_code option[value="' + temp_products['product_code'] + '"]').prop('selected', true);
            jQuery('#tank option[value="' + temp_products['tank'] + '"]').prop('selected', true);


            jQuery("#product_name").val(temp_products['product_code']);
            jQuery("#qty").val(temp_products['product_qty']);
            jQuery("#rate").val(temp_products['product_rate']);
            jQuery("#price").val(temp_products['product_price']);
            jQuery("#des").val(temp_products['product_des']);
            jQuery("#temp_den").val(temp_products['product_temp_den']);
            jQuery("#sloc").val(temp_products['product_sloc']);
            jQuery("#batch_unit").val(temp_products['product_batch_unit']);

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            jQuery("#tank").select2();

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            // var newvaltohide = jQuery("#product_code").val();

            var newvaltohide = edit_product_value;

            jQuery("#product_code option[value=" + newvaltohide + "]").attr("disabled", "true");

            jQuery("#product_name option[value=" + newvaltohide + "]").attr("disabled", "true");
            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#tank option[value="' + 1 + '"]').prop('selected', true);

            jQuery("#product_code").select2("destroy");
            jQuery("#product_name").select2("destroy");
            jQuery("#tank").select2("destroy");

            jQuery("#des").val("");
            jQuery("#temp_den").val("");
            jQuery("#sloc").val("");
            jQuery("#batch_unit").val("");
            jQuery("#qty").val("");
            jQuery("#rate").val("");
            jQuery("#price").val("");

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            jQuery("#tank").select2();

            jQuery("#cancel_button").hide();
            jQuery(".table-responsive").show();
            jQuery("#save").show();
            jQuery("#first_add_more").html('Add');

            global_id_to_edit = 0;


            jQuery(".edit_link").show();
            jQuery(".delete_link").show();

            edit_product_value = '';
        }
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2

            jQuery("#product_code").append("{!! $pro_code !!}");
            jQuery("#product_name").append("{!! $pro_name !!}");

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            jQuery("#tank").select2();
        });
    </script>

@endsection
