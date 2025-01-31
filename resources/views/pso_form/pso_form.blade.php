<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>PSO FORM</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('public/pso_form/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/pso_form/css/style.css') }}" type="text/css" rel="stylesheet">

</head>
<body>

<header class="header"><!-- header start -->
    <div class="container">
        <div class="mp_0 db form_pso">
            <div class="mp_0 db frm_hdr">

                <div class="mp_0 db frm_logo"><!-- logo start -->
                    <img src="{{ asset('public/pso_form/images/logo.png') }}" alt="" width="120"/>
                </div><!-- logo end -->
                <div class="mp_0 db frm_hdng text-center"><!-- logo start -->
                    <h1 class="mp_0 db frm_hdng_ttl upper bold">
                        Pakistan State Oil Company Limited
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


<section class="mp_0 db sctn sctn_one"><!-- section one start -->
    <div class="container">
        <div class="mp_0 db form_pso sctn_bx"><!-- form pso start -->

            <form action="{{route('submit_tank_receiving')}}" method="post">
                <div class="table-responsive">
                    <table class="table table-bordered brdr_clr mp_0">

                        <tr><!-- row start -->
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="customer_code" class="db mp_0 lbl">
                                    Customer Code
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control wdth_2" id="customer_code" name="customer_code" placeholder="Customer Code">
                            </td>
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="date" class="db mp_0 lbl">
                                    Date
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control wdth_2" id="date" name="date" placeholder="Date">
                            </td>
                        </tr><!-- row end -->

                        <tr><!-- row start -->
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="name" class="db mp_0 lbl">
                                    Name
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control  wdth_2" id="name" name="name" placeholder="Name">
                            </td>
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="invoice_no" class="db mp_0 lbl">
                                    Invoice No
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control wdth_2" id="invoice_no" name="invoice_no" placeholder="Invoice No.">
                            </td>
                        </tr><!-- row end -->

                        <tr><!-- row start -->
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="address" class="db mp_0 lbl">
                                    Address
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <textarea class="txt_area wdth_2" id="address" name="address" placeholder="Address"></textarea>
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
                                            <input type="text" class="inputs_up form-control wdth_2" name="delivery_no" id="delivery_no" placeholder="Delivery No.">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="sctn_one_tbl_th brdr_clr brdr_0_lft">
                                            <label for="vehicle_code" class="db mp_0 lbl">
                                                Vehicle Code.
                                            </label>
                                        </th>
                                        <td class="mp_0_imp brdr_clr">
                                            <input type="text" class="inputs_up form-control wdth_2" id="vehicle_code" name="vehicle_code" placeholder="Vehicle Code.">
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
                                <input type="text" class="inputs_up form-control wdth_2" id="stax_reg_no" placeholder="S.Tax Reg No.">
                            </td>
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="fleet_group" class="db mp_0 lbl">
                                    Fleet Group
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control wdth_2" id="fleet_group" placeholder="Fleet Group">
                            </td>
                        </tr><!-- row end -->

                        <tr><!-- row start -->
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="ctract_no" class="db mp_0 lbl">
                                    Cotract No.
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control wdth_2" id="ctract_no" placeholder="Cotract No.">
                            </td>
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="tl_reg_no" class="db mp_0 lbl">
                                    T/L Reg No.
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control wdth_2" id="tl_reg_no" placeholder="T/L Reg No.">
                            </td>
                        </tr><!-- row end -->

                        <tr><!-- row start -->
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="indent_no" class="db mp_0 lbl">
                                    Indent No.
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control wdth_2" id="indent_no" placeholder="Indent No.">
                            </td>
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="ll_ack_no" class="db mp_0 lbl">
                                    L.L. Ack No.
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control wdth_2" id="ll_ack_no" placeholder="L.L. Ack No.">
                            </td>
                        </tr><!-- row end -->

                        <tr><!-- row start -->
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="shipping_point" class="db mp_0 lbl">
                                    Shipping Point
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control wdth_2" id="shipping_point" placeholder="Shipping Point">
                            </td>
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="calibration_no" class="db mp_0 lbl">
                                    Calibration No.
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control wdth_2" id="calibration_no" placeholder="Calibration No.">
                            </td>
                        </tr><!-- row end -->

                        <tr><!-- row start -->
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="dest_code" class="db mp_0 lbl">
                                    Dest. Code
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control wdth_2" id="dest_code" placeholder="Dest. Code">
                            </td>
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="calibration_exp" class="db mp_0 lbl">
                                    Calibration EXP
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control wdth_2" id="calibration_exp" placeholder="Calibration EXP">
                            </td>
                        </tr><!-- row end -->

                        <tr><!-- row start -->
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="shipment_type" class="db mp_0 lbl">
                                    Shipment Type
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control wdth_2" id="shipment_type" placeholder="Shipment Type">
                            </td>
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="token_no" class="db mp_0 lbl">
                                    Token No
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control wdth_2" id="token_no" placeholder="Token No.">
                            </td>
                        </tr><!-- row end -->

                        <tr><!-- row start -->
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="cc_no" class="db mp_0 lbl">
                                    C/C No.
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control wdth_2" id="cc_no" placeholder="C/C No.">
                            </td>
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="freight_po_no" class="db mp_0 lbl">
                                    Freight PO No.
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control wdth_2" id="freight_po_no" placeholder="Freight PO No.">
                            </td>
                        </tr><!-- row end -->

                        <tr><!-- row start -->
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="cc_name" class="db mp_0 lbl">
                                    C/C Name
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control wdth_2" id="cc_name" placeholder="C/C Name">
                            </td>
                            <th class="sctn_one_tbl_th brdr_clr">
                                <label for="lc_no" class="db mp_0 lbl">
                                    LC No.
                                </label>
                            </th>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control wdth_2" id="lc_no" placeholder="LC No.">
                            </td>
                        </tr><!-- row end -->

                    </table>
                </div><!-- table end -->

                <div class="table-responsive">
                    <table class="table table-bordered brdr_clr brdr_0_tp">
                        <thead>
                        <tr>
                            <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th brdr_0_tp wdth_1">
                                Prod. Code
                            </th>
                            <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th brdr_0_tp wdth_2">
                                Description
                            </th>
                            <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th brdr_0_tp wdth_4">
                                Temp/Den
                            </th>
                            <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th brdr_0_tp wdth_4">
                                S.Loc
                            </th>
                            <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th brdr_0_tp wdth_4">
                                Batch/Unit
                            </th>
                            <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th brdr_0_tp wdth_5">
                                Qty
                            </th>
                            <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th brdr_0_tp wdth_5">
                                Rate
                            </th>
                            <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th brdr_0_tp wdth_5">
                                Price
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="prod[]" placeholder="Prod. CODE">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="des[]" placeholder="Description">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="temp_den[]" placeholder="TEMP/DEN">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="sloc[]" placeholder="S.LOC">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="batch_unit[]" placeholder="BATCH/UNIT">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="qty[]" placeholder="QTY">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="rate[]" placeholder="Rate">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="price[]" placeholder="Price">
                            </td>
                        </tr>


                        <tr>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="prod[]" placeholder="Prod. CODE">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="des[]" placeholder="Description">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="temp_den[]" placeholder="TEMP/DEN">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="sloc[]" placeholder="S.LOC">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="batch_unit[]" placeholder="BATCH/UNIT">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="qty[]" placeholder="QTY">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="rate[]" placeholder="Rate">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="price[]" placeholder="Price">
                            </td>
                        </tr>


                        <tr>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="prod[]" placeholder="Prod. CODE">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="des[]" placeholder="Description">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="temp_den[]" placeholder="TEMP/DEN">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="sloc[]" placeholder="S.LOC">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="batch_unit[]" placeholder="BATCH/UNIT">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="qty[]" placeholder="QTY">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="rate[]" placeholder="Rate">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="price[]" placeholder="Price">
                            </td>
                        </tr>


                        <tr>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="prod[]" placeholder="Prod. CODE">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="des[]" placeholder="Description">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="temp_den[]" placeholder="TEMP/DEN">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="sloc[]" placeholder="S.LOC">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="batch_unit[]" placeholder="BATCH/UNIT">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="qty[]" placeholder="QTY">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="rate[]" placeholder="Rate">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="price[]" placeholder="Price">
                            </td>
                        </tr>


                        <tr>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="prod[]" placeholder="Prod. CODE">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="des[]" placeholder="Description">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="temp_den[]" placeholder="TEMP/DEN">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="sloc[]" placeholder="S.LOC">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="batch_unit[]" placeholder="BATCH/UNIT">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="qty[]" placeholder="QTY">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="rate[]" placeholder="Rate">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="price[]" placeholder="Price">
                            </td>
                        </tr>


                        <tr>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="prod[]" placeholder="Prod. CODE">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="des[]" placeholder="Description">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="temp_den[]" placeholder="TEMP/DEN">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="sloc[]" placeholder="S.LOC">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="batch_unit[]" placeholder="BATCH/UNIT">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="qty[]" placeholder="QTY">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="rate[]" placeholder="Rate">
                            </td>
                            <td class="mp_0_imp brdr_clr">
                                <input type="text" class="inputs_up form-control input_up_scnd" id="price[]" placeholder="Price">
                            </td>
                        </tr>


                        </tbody>
                    </table>
                </div><!-- table end -->


        </div><!-- form pso end -->
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
                                            مصنوعات پیٹرولیم اور قدرتی وسائل کی طرف سے جاری کردہ تفصیلات سے متعلق ہے. آخری نمبر PL-NRL (4) -99 (سپیکی) کا درجہ 13.4.1 988 ہے
                                        </div>
                                        Product meets specification issued by Ministry of Petroleum and Natural Resources. Latter No. PL-NRL(4)-99(SPEG) Dated 13.4.1988
                                    </td>
                                    <td class="mp_0_imp">
                                        <table class="table mp_0_imp">
                                            <tr>
                                                <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 ln_ht brdr_0_rt brdr_0_tp"> Ref Dip</th>
                                            </tr>
                                            <tr>
                                                <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 ln_ht brdr_0_rt"> Pred Dip</th>
                                            </tr>
                                            <tr>
                                                <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 ln_ht brdr_0_rt"> Seal No.</th>
                                            </tr>
                                            <tr>
                                                <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 ln_ht brdr_0_rt"> Short Dip</th>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td colspan="6" class="mp_0_imp">
                            <table class="table mp_0_imp">

                                <tr>
                                    <td class="mp_0_imp brdr_clr brdr_0_lft">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_one[]" placeholder="CHMB 1">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_two[]" placeholder="CHMB 2">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_three[]" placeholder="CHMB 3">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_four[]" placeholder="CHMB 4">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_five[]" placeholder="CHMB 5">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_six[]" placeholder="CHMB 6">
                                    </td>
                                </tr>


                                <tr>
                                    <td class="mp_0_imp brdr_clr brdr_0_lft">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_one[]" placeholder="CHMB 1">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_two[]" placeholder="CHMB 2">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_three[]" placeholder="CHMB 3">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_four[]" placeholder="CHMB 4">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_five[]" placeholder="CHMB 5">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_six[]" placeholder="CHMB 6">
                                    </td>
                                </tr>


                                <tr>
                                    <td class="mp_0_imp brdr_clr brdr_0_lft">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_one[]" placeholder="CHMB 1">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_two[]" placeholder="CHMB 2">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_three[]" placeholder="CHMB 3">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_four[]" placeholder="CHMB 4">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_five[]" placeholder="CHMB 5">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_six[]" placeholder="CHMB 6">
                                    </td>
                                </tr>


                                <tr>
                                    <td class="mp_0_imp brdr_clr brdr_0_lft">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_one[]" placeholder="CHMB 1">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_two[]" placeholder="CHMB 2">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_three[]" placeholder="CHMB 3">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_four[]" placeholder="CHMB 4">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_five[]" placeholder="CHMB 5">
                                    </td>
                                    <td class="mp_0_imp brdr_clr">
                                        <input type="text" class="inputs_up form-control input_up_scnd" id="chamb_six[]" placeholder="CHMB 6">
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
                                    <input type="text" class="inputs_up form-control input_up_scnd" id="bank[]" placeholder="Bank">
                                </td>
                                <td class="mp_0_imp brdr_clr">
                                    <input type="text" class="inputs_up form-control input_up_scnd" id="inst_type[]" placeholder="INST TYPE">
                                </td>
                                <td class="mp_0_imp brdr_clr">
                                    <input type="text" class="inputs_up form-control input_up_scnd" id="inst_no[]" placeholder="INST No.">
                                </td>
                                <td class="mp_0_imp brdr_clr">
                                    <input type="text" class="inputs_up form-control input_up_scnd" id="amount[]" placeholder="Amount">
                                </td>
                            </tr>
                            <tr>
                                <td class="mp_0_imp brdr_clr">
                                    <input type="text" class="inputs_up form-control input_up_scnd" id="bank[]" placeholder="Bank">
                                </td>
                                <td class="mp_0_imp brdr_clr">
                                    <input type="text" class="inputs_up form-control input_up_scnd" id="inst_type[]" placeholder="INST TYPE">
                                </td>
                                <td class="mp_0_imp brdr_clr">
                                    <input type="text" class="inputs_up form-control input_up_scnd" id="inst_no[]" placeholder="INST No.">
                                </td>
                                <td class="mp_0_imp brdr_clr">
                                    <input type="text" class="inputs_up form-control input_up_scnd" id="amount[]" placeholder="Amount">
                                </td>
                            </tr>
                            <tr>
                                <td class="mp_0_imp brdr_clr">
                                    <input type="text" class="inputs_up form-control input_up_scnd" id="bank[]" placeholder="Bank">
                                </td>
                                <td class="mp_0_imp brdr_clr">
                                    <input type="text" class="inputs_up form-control input_up_scnd" id="inst_type[]" placeholder="INST TYPE">
                                </td>
                                <td class="mp_0_imp brdr_clr">
                                    <input type="text" class="inputs_up form-control input_up_scnd" id="inst_no[]" placeholder="INST No.">
                                </td>
                                <td class="mp_0_imp brdr_clr">
                                    <input type="text" class="inputs_up form-control input_up_scnd" id="amount[]" placeholder="Amount">
                                </td>
                            </tr>
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
                                    <input type="text" class="inputs_up form-control input_up_scnd" id="rr_date[]" placeholder="R R Date">
                                </td>
                                <td class="mp_0_imp brdr_clr">
                                    <input type="text" class="inputs_up form-control input_up_scnd" id="rr_nbr[]" placeholder="R R Number">
                                </td>
                                <td class="mp_0_imp brdr_clr">
                                    <input type="text" class="inputs_up form-control input_up_scnd" id="rr_inv_no[]" placeholder="R R INV No">
                                </td>
                                <td class="mp_0_imp brdr_clr">
                                    <input type="text" class="inputs_up form-control input_up_scnd" id="weight[]" placeholder="Weight">
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
                                    <input type="text" class="inputs_up form-control input_up_scnd" id="miscellaneous[]" placeholder="Miscellaneous Information">
                                </td>
                            </tr>
                            <tr>
                                <td class="mp_0_imp brdr_clr">
                                    <input type="text" class="inputs_up form-control input_up_scnd" id="miscellaneous[]" placeholder="Miscellaneous Information">
                                </td>
                            </tr>
                            <tr>
                                <td class="mp_0_imp brdr_clr">
                                    <input type="text" class="inputs_up form-control input_up_scnd" id="miscellaneous[]" placeholder="Miscellaneous Information">
                                </td>
                            </tr>
                            </tbody>

                        </table>
                    </div><!-- table end -->

                    <div class="table-responsive"><!-- table start -->
                        <table class="table table-bordered brdr_clr">

                            <thead>
                            <tr>
                                <td class="sctn_one_tbl_th brdr_clr text-left lbl_th">
                                    I confirm that the quality of product received against the invoice is in accordance with my requirments and is free from any adulteration
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
                                    <input type="text" class="inputs_up form-control text-left input_up_thrd" id="pre_by" placeholder="Prepared By">
                                </td>
                            </tr>
                            <tr>
                                <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 brdr_0_rt">
                                    Approved By:
                                </th>
                                <td class="mp_0_imp brdr_clr wdth_7 brdr_0_lft brdr_0_rt">
                                    <input type="text" class="inputs_up form-control text-left input_up_thrd" id="approved_by" placeholder="Approved By">
                                </td>
                            </tr>
                            <tr>
                                <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 brdr_0_rt">
                                    Released By:
                                </th>
                                <td class="mp_0_imp brdr_clr wdth_7 brdr_0_lft brdr_0_rt">
                                    <input type="text" class="inputs_up form-control text-left input_up_thrd" id="released_by" placeholder="Released By">
                                </td>
                            </tr>
                            <tr>
                                <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 brdr_0_rt">
                                    Driver's Signature:
                                </th>
                                <td class="mp_0_imp brdr_clr wdth_7 brdr_0_lft">
                                    <input type="text" class="inputs_up form-control text-left input_up_thrd" id="driv_signature[]" placeholder="Driver Signature">
                                </td>
                            </tr>
                            <tr>
                                <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 brdr_0_rt">
                                    NIC No:
                                </th>
                                <td class="mp_0_imp brdr_clr wdth_7 brdr_0_lft">
                                    <input type="text" class="inputs_up form-control text-left input_up_thrd" id="nic_no[]" placeholder="NIC No.">
                                </td>
                            </tr>
                            <tr>
                                <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 brdr_0_rt">
                                    Buyer Signature:
                                </th>
                                <td class="mp_0_imp brdr_clr wdth_7 brdr_0_lft">
                                    <input type="text" class="inputs_up form-control text-left input_up_thrd" id="buyer_signature[]" placeholder="Buyer Signature">
                                </td>
                            </tr>
                            <tr>
                                <th class="sctn_one_tbl_th brdr_clr mp_01 text-center lbl_th wdth_5 brdr_0_rt">
                                    Date:
                                </th>
                                <td class="mp_0_imp brdr_clr wdth_7 brdr_0_lft">
                                    <input type="text" class="inputs_up form-control text-left input_up_thrd" id="date_bot" placeholder="Date">
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
                                    <textarea class="txt_area wdth_2" id="con_sig_stamp" placeholder="Consignee Signature Stamp & Date"></textarea>
                                    <label for="con_sig_stamp" class="db mp_0 lbl text-center">
                                        Consignee Signature Stamp & Date
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th class="sctn_one_tbl_th brdr_clr mp_01 text-center wdth_5 brdr_0_lft">
                                    Exclusive GST:
                                </th>
                                <td class="mp_0_imp brdr_clr wdth_7 brdr_0_lft brdr_0_rt">
                                    <input type="text" class="inputs_up form-control text-left input_up_thrd" id="val_exclu_gst[]" placeholder="Value Exclusive GST">
                                </td>
                            </tr>
                            <tr>
                                <th class="sctn_one_tbl_th brdr_clr mp_01 text-center wdth_5 brdr_0_lft">
                                    GST:
                                </th>
                                <td class="mp_0_imp brdr_clr wdth_7 brdr_0_lft brdr_0_rt">
                                    <input type="text" class="inputs_up form-control text-left input_up_thrd" id="gst[]" placeholder="GST">
                                </td>
                            </tr>
                            <tr>
                                <th class="sctn_one_tbl_th brdr_clr mp_01 text-center wdth_5 brdr_0_lft">
                                    Inclusive GST
                                </th>
                                <td class="mp_0_imp brdr_clr wdth_7 brdr_0_lft brdr_0_rt">
                                    <input type="text" class="inputs_up form-control text-left input_up_thrd" id="val_inclu_gst[]" placeholder="Value Inclusive GST">
                                </td>
                            </tr>
                            </tbody>

                        </table>
                    </div><!-- table end -->

                    <div class="form_controls">
                        <button type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                            Clear
                        </button>
                        <button type="submit" name="filter_search" id="filter_search" class="save_button form-control">
                            Submit
                        </button>
                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                    </div>

                </div><!-- col end -->

                </form>
            </div><!-- row end -->
        </div>
</section><!-- section one end -->


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{ asset('public/pso_form/js/jquery-1.12.4.min.js') }}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ asset('public/pso_form/js/bootstrap.min.js') }}" type="text/javascript"></script>

</body>
</html>