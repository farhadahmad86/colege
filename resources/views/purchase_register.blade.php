@extends('extend_index')

@section('content')
    <style>
        @font-face {
            font-family: Jameel;
            src: url({{asset('public/urdu_font/Jameel.ttf')}});
        }

        .fonti {
            font-family: Jameel;
        }

    </style>
    @php
        use App\Models\AccountRegisterationModel;
    use App\Models\ReportConfigModel;
       use Illuminate\Support\Facades\DB;
       use App\Models\PurchaseInvoiceItemsModel;
       use App\Models\PurchaseInvoiceModel;
    @endphp
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Purchase Register</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

            <!-- <div class="search_form {{ ( !empty($search) || !empty($search_account) || !empty($search_product) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}"> -->
                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('purchase_register') }}" name="form1" id="form1" method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach($party as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->


                            <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Account
                                            </label>
                                            <select tabindex="2" class="inputs_up form-control" name="account" id="account">
                                                <option value="">Select Account</option>
                                                @foreach($accounts as $account)
                                                    <option
                                                        value="{{$account->account_uid}}" {{ $account->account_uid == $search_account ? 'selected="selected"' : '' }}>{{$account->account_name}}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <input name="product" id="product" type="hidden" value="{{$search_product}}">

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Select Product
                                            </label>
                                            <select tabindex="3" class="inputs_up form-control" name="product_code" id="product_code">
                                                <option value="">Select Code</option>
                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Product
                                            </label>
                                            <select tabindex="4" class="inputs_up form-control" name="product_name" id="product_name">
                                                <option value="">Select Product</option>
                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Posting Refferrence
                                            </label>
                                            <select tabindex="4" class="inputs_up form-control" name="posting" id="posting">
                                                <option value="">Posting Refference</option>
                                                @foreach($posting_references as $posting_reference)
                                                    <option value="{{$posting_reference->pr_id}}">{{$posting_reference->pr_name}}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>


                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Start Date
                                            </label>
                                            <input tabindex="5" type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
                                                   <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......"/>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                End Date
                                            </label>
                                            <input tabindex="6" type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off"
                                                   <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......"/>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-lg-4 text-right">
                                    @include('include.clear_search_button')

                                    <!-- Call add button component -->
                                        <x-add-button tabindex="9" href="{{ route('purchase_invoice') }}"/>

                                        @include('include/print_button')

                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
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
                            <th tabindex="-1" scope="col" class="text-center tbl_srl_4">
                                Sr#
                            </th>
                            <th tabindex="-1" scope="col" class="text-center tbl_srl_4">
                                Product Name
                            </th>
                            <th tabindex="-1" scope="col" class="text-center tbl_amnt_9">
                                QTY
                            </th>
                            <th tabindex="-1" scope="col" class="text-center tbl_amnt_6">
                                Rate
                            </th>
                            <th tabindex="-1" scope="col" class="text-center tbl_txt_21">
                                Exclusive Discount
                            </th>
                            <th tabindex="-1" scope="col" class="text-center tbl_txt_21">
                                Dis. %
                            </th>
                            <th tabindex="-1" scope="col" class="text-center tbl_txt_15">
                                Discount Amount
                            </th>
                            <th tabindex="-1" scope="col" class="text-center tbl_txt_25">
                                Total Amount
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
                             $extra_discount= $extra_tax = $extra_qty = $extra_sale_tax = $total_invoice= $extra_gross_amount = $extra_grand_total =0;
                        @endphp
                        @forelse($datas as $invoice)
                            @php
                                $urdu_eng = ReportConfigModel::where('rc_id', '=', 1)->select('rc_invoice', 'rc_invoice_party')->first();

            if ($urdu_eng->rc_invoice_party == 0) {
                $pim = PurchaseInvoiceModel::where('pi_id', $invoice->pi_id)->first();
            } else {
                $pim = DB::table('financials_purchase_invoice')
                    ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_purchase_invoice.pi_party_code')
                    ->where('pi_id', $invoice->pi_id)
                    ->select('financials_accounts.account_urdu_name as pi_party_name', 'pi_id', 'pi_party_code', 'pi_customer_name', 'pi_remarks', 'pi_total_items', 'pi_total_price', 'pi_product_disc', 'pi_round_off_disc',
                        'pi_cash_disc_per', 'pi_cash_disc_amount', 'pi_total_discount', 'pi_inclusive_sales_tax', 'pi_exclusive_sales_tax', 'pi_total_sales_tax', 'pi_grand_total', 'pi_cash_paid', 'pi_day_end_id', 'pi_day_end_date', 'pi_createdby')->first();
            }


            $accnts = AccountRegisterationModel::where('account_uid', $pim->pi_party_code)->first();
            if ($urdu_eng->rc_invoice == 0) {
                $piims = PurchaseInvoiceItemsModel::where('pii_purchase_invoice_id', $invoice->pi_id)
    //            ->select('pii_product_name as name', 'pii_remarks as remarks', 'pii_qty as qty', 'pii_rate as rate', 'pii_discount as discount', 'pii_saletax as sale_tax', 'pii_amount as amount')
                    ->select('pii_product_name as name', 'pii_remarks as remarks', 'pii_qty as qty', 'pii_rate as rate', 'pii_discount_per as discount', 'pii_discount_amount as discount_amount', 'pii_after_dis_rate as after_discount', 'pii_saletax_per as sale_tax', 'pii_saletax_amount as sale_tax_amount', 'pii_saletax_inclusive as inclu_exclu', 'pii_amount as amount', 'pii_scale_size as scale_size')
                    ->orderby('pii_product_name', 'ASC')
                    ->get();

            } else {
                $piims = DB::table('financials_purchase_invoice_items')
                    ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_purchase_invoice_items.pii_product_code')
                    ->where('pii_purchase_invoice_id', $invoice->pi_id)

    //                PurchaseInvoiceItemsModel::where('pii_purchase_invoice_id', $id)

                    ->select('financials_products.pro_urdu_title as name', 'pii_remarks as remarks', 'pii_qty as qty', 'pii_rate as rate', 'pii_discount_per as discount', 'pii_discount_amount as discount_amount', 'pii_after_dis_rate as after_discount', 'pii_saletax_per as sale_tax', 'pii_saletax_amount as sale_tax_amount', 'pii_saletax_inclusive as inclu_exclu', 'pii_amount as amount', 'pii_scale_size as scale_size')
                    ->orderby('financials_products.pro_urdu_title', 'ASC')
                    ->get();

            }

            //$nbrOfWrds = $this->myCnvrtNbr($pim->pi_grand_total);
            $invoice_nbr = $pim->pi_id;
            $invoice_date = $pim->pi_day_end_date;
            $i=0;
                            @endphp
                            <tr>
                                <td class="align_center text-center edit tbl_srl_4" colspan="2" style="border-left:1px solid black; border-right:none; border-bottom:none;border-top:none;">
                                    <b>Invoice#:</b> {{$invoice->pi_id}}
                                </td>
                                <td nowrap class="align_center text-center tbl_amnt_9 border-0" colspan="3">
                                    <b>Purchase Date: </b>{{date('d-M-y', strtotime(str_replace('/', '-', $invoice->pi_day_end_date)))}}
                                </td>

                                <td class="atext-center text-center tbl_txt_21" colspan="3" style="border-left:none; border-right:1px solid black; border-bottom:none;border-top:none;">
                                    <b>Party: </b>{{$invoice->pi_party_name}}
                                </td>

                            </tr>

                            @php $i = 1; $excluDis = $ttlExcluDis = $ttlIncluDis = $ttlSaleTax = $ttlAmnt = 0;
            $trade_offerTtl=0;
            $discountAmountTtl=0; $total_invoice+=1;
                            @endphp
                            @foreach( $piims as $piim )
                                @php

                                    $db_qty=$piim->qty;
                                    $extra_qty = $extra_qty + $db_qty;
                                    $db_rate=$piim->rate;
                                     $gross_amount=$db_rate * $db_qty;


                                      $excluDis = $piim->qty * $piim->rate;
                                      $ttlExcluDis = +$excluDis + +$ttlExcluDis;
                                      $ttlIncluDis = +$piim->after_discount + +$ttlIncluDis;
                                      $ttlSaleTax = +$ttlSaleTax + +$piim->sale_tax_amount;
                                      $ttlAmnt = +$ttlAmnt + +$piim->amount;

                                 $trade_offer = $gross_amount - $piim->amount - $piim->discount_amount;
                                    $trade_offerTtl = +$trade_offerTtl + +$trade_offer;
                                    $discountAmountTtl = +$discountAmountTtl + +$piim->discount_amount ;


                                @endphp

                                <tr class="even pointer">

                                    <td class="tbl_srl_4 align_center text-center">
                                        {{ $i }}
                                    </td>
                                    <td class="align_left text-left tbl_txt_25 fonti">
                                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $piim->name) !!}
                                        @if(!empty($piim->remarks) && isset($piim->remarks))
                                            <blockquote class="fonti">
                                                {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $piim->remarks) !!}
                                            </blockquote>
                                        @endif
                                    </td>
                                    <td class="tbl_amnt_6 align_center text-center">
                                        {!! $piim->qty !!}
                                    </td>
                                    <td class="tbl_amnt_8 align_center text-center">
                                        {{ number_format($piim->rate,2) }}
                                    </td>

                                    <td class="tbl_amnt_10 align_right text-right">
                                        {{ number_format($excluDis,2) }}
                                    </td>

                                    <td class="tbl_amnt_8 align_center text-center">
                                        {!! $piim->discount !!}
                                    </td>
                                    <td class="tbl_amnt_8 align_center text-center">
                                        {!! $piim->discount_amount !!}
                                    </td>
                                    <td class="tbl_amnt_15 align_right text-right">
                                        {!! number_format($piim->amount,2) !!}
                                    </td>

                                </tr>
                                @php $i++; @endphp
                            @endforeach
                            <tr>
                                @php
                                    $extra_discount= $extra_discount + $invoice->pi_total_discount;
                                    $extra_tax= $extra_tax + $invoice->pi_total_sales_tax;
                                    $extra_gross_amount= $extra_gross_amount + $invoice->pi_total_price;
                                    $extra_grand_total= $extra_grand_total + $invoice->pi_grand_total;
                                @endphp
                                <td class="text-center" colspan="2" style="border-left:1px solid black; border-right:none; border-bottom:none;"><b>Sale Tax:</b> {{$invoice->pi_total_sales_tax}}</td>
                                <td class="border-0 text-center" colspan="2"><b>Discount: </b> {{$invoice->pi_total_discount}}</td>
                                <td class="border-0 text-center" colspan="2"><b>Grand Total:</b> {{$invoice->pi_grand_total}}</td>
                                <td class="text-center" colspan="3" style="border-left:none; border-right:1px solid black; border-bottom:none;border-top:none;"><b>Cash Paid:</b>
                                    {{$invoice->pi_cash_paid == '' ? 0 : $invoice->pi_cash_paid}}</td>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="9" style="border-bottom:3px solid black;border-top:none;">
                                </td>
                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="15">
                                    <center><h3 style="color:#554F4F">No List Found</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                        <tfoot>
                        <tr>
                            <td class="align_center text-center border-0" colspan="2">
                                <b>No of Inv: </b>{{ $total_invoice }}
                            </td>
                            <td class="align_center text-center border-0" colspan="2">
                                <b>Quantity: </b>{{ $extra_qty }}
                            </td>
                            <td class="align_center text-center border-0">
                                <b>Value: </b>{{ $extra_gross_amount }}
                            </td>
                            <td class="align_left text-left border-0">
                                <b>Sale Tax: </b>{{ $extra_tax }}
                            </td>
                            <td class="align_center text-center border-0">
                                <b>Discount: </b>{{ $extra_discount }}
                            </td>
                            <td class="align_center text-center border-0" colspan="2">
                                <b>Net Value: </b>{{ number_format($extra_grand_total,2) }}
                            </td>
                        </tr>

                        </tfoot>

                    </table>

                </div>
                <span
                    class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'account'=>$search_account, 'product_code'=>$search_product, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('purchase_register') }}',
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

        });
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#account").select2().val(null).trigger("change");
            $("#account > option").removeAttr('selected');

            // $("#product").select2().val(null).trigger("change");
            // $("#product > option").removeAttr('selected');

            $("#product_code").select2().val(null).trigger("change");
            $("#product_code > option").removeAttr('selected');

            $("#product_name").select2().val(null).trigger("change");
            $("#product_name > option").removeAttr('selected');


            $("#search").val('');

            $("#to").val('');
            $("#from").val('');
        });
    </script>

    <script>
        jQuery("#product_code").change(function () {

            var pcode = jQuery('option:selected', this).val();

            jQuery("#product_name").select2("destroy");

            jQuery('#product_name option[value="' + pcode + '"]').prop('selected', true);

            jQuery("#product_name").select2();

            assign_product_parent_value();
        });

        jQuery("#product_name").change(function () {

            var pcode = jQuery('option:selected', this).val();

            jQuery("#product_code").select2("destroy");

            jQuery('#product_code option[value="' + pcode + '"]').prop('selected', true);

            jQuery("#product_code").select2();

            assign_product_parent_value(); //this function define in script.php file
        });


    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#account").select2();
            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            jQuery("#posting").select2();

            jQuery("#product_code").append("{!! $pro_code !!}");
            jQuery("#product_name").append("{!! $pro_name !!}");
        });
    </script>

@endsection

