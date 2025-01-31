<!DOCTYPE html>
<html>
<head>
    @include('include/head')
</head>
<body>
@include('include/header')
@include('include/teller_sidebar')

<div class="main-container">
    <div class="pd-ltr-20 customscroll-10-p height-100-p xs-pd-20-10">
        @include('inc._messages')


        <div class="row">



            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">



                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text file_name">Sale Invoice List</h4>
                            </div>
                            <div class="list_btn list_mul">
                                <div class="srch_box_opn_icon">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->


                    <div class="search_form {{ ( !empty($search) || !empty($search_account) || !empty($search_product) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <form class="prnt_lst_frm" action="{{ route('teller/sale_invoice_list') }}" name="form1" id="form1" method="post">
                                    @csrf
                                    <div class="row">

                                        <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label>
                                                    All Column Search
                                                </label>
                                                <input type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                                <datalist id="browsers">
{{--                                                    @foreach($party as $value)--}}
{{--                                                        <option value="{{$value}}">--}}
{{--                                                    @endforeach--}}
                                                </datalist>
                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                <input type="checkbox" name="check_desktop" id="check_desktop" value="1" {{$check_desktop==1 ? 'checked':'' }}>
                                                <label class="d-inline" for="check_desktop">Desktop Invoice</label>
                                            </div>
                                        </div> <!-- left column ends here -->


                                        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                            <div class="row">

                                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12" hidden>
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label>
                                                            Account
                                                        </label>
                                                        <select class="inputs_up  form-control" name="account" id="account">
                                                            <option value="">Select Account</option>
{{--                                                            @foreach($accounts as $account)--}}
{{--                                                                <option value="{{$account->account_uid}}" {{ $account->account_uid == $search_account ? 'selected="selected"' : '' }}>{{$account->account_name}}</option>--}}
{{--                                                            @endforeach--}}
                                                        </select>
                                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label>
                                                            Select Code
                                                        </label>
                                                        <select class="inputs_up form-control" name="product" id="product">
                                                            <option value="">Select Code</option>
                                                            @foreach($products as $product)
                                                                <option value="{{$product->pro_code}}" {{ $product->pro_code == $search_product ? 'selected="selected"' : '' }}>{{$product->pro_code}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label>
                                                            Select Product
                                                        </label>
                                                        <select class="inputs_up  form-control" name="product_name" id="product_name">
                                                            <option value="">Select Product</option>
                                                            @foreach($products as $product)
                                                                <option value="{{$product->pro_code}}" {{ $product->pro_code == $search_product ? 'selected="selected"' : ''
                                                                }}>{{$product->pro_title}}</option>
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
                                                        <input type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......" />
                                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label>
                                                            End Date
                                                        </label>
                                                        <input type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......" />
                                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                    </div>
                                                </div>

                                                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                    <div class="form_controls text-center text-lg-left">

                                                        <button type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                            <i class="fa fa-trash"></i> Clear
                                                        </button>
                                                        <button type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                            <i class="fa fa-search"></i> Search
                                                        </button>

                                                        <a class="save_button form-control" href="{{ route('teller/sale_invoice') }}" role="button">
                                                            <i class="fa fa-plus"></i> Sale Invoice
                                                        </a>

                                                        @include('include/print_button')

                                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </form>


                                <form name="edit" id="edit" action="{{ route('edit_account') }}" method="post">
                                    @csrf
                                    <input name="account_id" id="account_id" type="hidden">
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
                                        Date
                                    </th>
                                    <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                                        Invoice No.
                                    </th>
                                    <th scope="col" align="center" class="align_center text-center tbl_txt_21">
                                        Party Name
                                    </th>
                                    <th scope="col" align="center" class="align_center text-center tbl_txt_34">
                                        Detail Remarks
                                    </th>
                                    <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                                        Total Price
                                    </th>

                                    <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                                        Cash Rec
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
                                        {{date('d-M-y', strtotime(str_replace('/', '-', $invoice->si_day_end_date)))}}
                                    </td>
                                    <td class="align_center text-center view tbl_amnt_6" data-id="{{$invoice->si_id}}">
                                        SI-{{$invoice->si_id}}
                                    </td>
{{--                                    <td class="align_center" style="white-space:pre-wrap;">{{$invoice->si_detail_remarks}}</td>--}}
                                    {{--<td class="align_center">{{$invoice->si_party_code}}</td>--}}
                                    <td class="align_left text-left tbl_txt_21">
                                        {{$invoice->si_party_name}}
                                    </td>
                                    <td class="align_left text-left tbl_txt_34">
                                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $invoice->si_detail_remarks) !!}
                                    </td>
                                    @php
                                        $ttlPrc = +($invoice->si_total_price) + +$ttlPrc;
                                    @endphp
                                    <td class="align_right text-right tbl_amnt_10">
                                        {{$invoice->si_total_price !=0 ? number_format($invoice->si_total_price,2):''}}
                                    </td>
{{--                                    <td class="align_right">{{$invoice->si_expense !=0 ? number_format($invoice->si_expense,2):''}}</td>--}}
{{--                                    <td class="align_right">{{$invoice->si_trade_disc_percentage !=0 ? number_format($invoice->si_trade_disc_percentage,2):''}}</td>--}}
{{--                                    <td class="align_right">{{$invoice->si_trade_disc !=0 ? number_format($invoice->si_trade_disc,2):''}}</td>--}}
{{--                                    <td class="align_right">{{$invoice->si_value_of_supply !=0 ? number_format($invoice->si_value_of_supply,2):''}}</td>--}}
{{--                                    <td class="align_right">{{$invoice->si_sales_tax !=0 ? number_format($invoice->si_sales_tax,2):''}}</td>--}}
{{--                                    <td class="align_right">{{$invoice->si_special_disc_percentage !=0 ? number_format($invoice->si_special_disc_percentage,2):''}}</td>--}}
{{--                                    <td class="align_right">{{$invoice->si_special_disc !=0 ? number_format($invoice->si_special_disc,2):''}}</td>--}}
{{--                                    <td class="align_right">{{$invoice->si_grand_total !=0 ? number_format($invoice->si_grand_total,2):''}}</td>--}}
                                    @php
                                        $cashPaid = +($invoice->si_cash_paid) + +$cashPaid;
                                    @endphp
                                    <td class="align_right text-right tbl_amnt_10">
                                        {{$invoice->si_cash_paid !=0 ? number_format($invoice->si_cash_paid,2):''}}
                                    </td>

                                    @php
                                        $ip_browser_info= ''.$invoice->si_ip_adrs.','.str_replace(' ','-',$invoice->si_brwsr_info).'';
                                    @endphp

                                    <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $invoice->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                        {{$invoice->user_name}}
                                    </td>

                                    {{--                                    <td class="align_left">{{$invoice->si_remarks}}</td>--}}
                                    {{--{{$invoice->si_remarks == '' ? 'N/A' : $invoice->si_remarks}}--}}
                                    {{--<td align="center">{{$invoice->si_datetime}}</td>--}}

                                </tr>
                                @php
                                    $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="15">
                                        <center><h3 style="color:#554F4F">No Invoice</h3></center>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>

                            <tfoot>
                            <tr>
                                <th colspan="5" class="align_right text-right border-0">
                                    Per Page Total:-
                                </th>
                                <td class="align_right text-right border-0">
                                    {{ number_format($ttlPrc,2) }}
                                </td>
                                <td class="align_right text-right border-0">
                                    {{ number_format($cashPaid,2) }}
                                </td>
                            </tr>
                            </tfoot>


                        </table>
                    </div>
                    <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'account'=>$search_account, 'product_code'=>$search_product, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>
                </div> <!-- white column form ends here -->


            </div><!-- col end -->


        </div><!-- row end -->


        @include('include/footer')
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg mdl_wdth">
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


{{--    add code by shahzaib start --}}
<script type="text/javascript">
    var base = '{{ route('teller/sale_invoice_list') }}',
        url;

    @include('include.print_script_sh')
</script>
{{--    add code by shahzaib end --}}



<script>
    // jQuery("#invoice_no").blur(function () {
    jQuery(".view").click(function () {

        jQuery("#table_body").html("");

        var id = jQuery(this).attr("data-id");

        $('.modal-body').load('{{url("teller/sale_items_view_details/view/") }}'+'/'+id, function(){
            $('#myModal').modal({show:true});
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

        $("#product_name").select2().val(null).trigger("change");
        $("#product_name > option").removeAttr('selected');

        $("#search").val('');

        $("#to").val('');
        $("#from").val('');
    });
</script>

<script>
    jQuery("#product_name").change(function () {
        var pcode = jQuery('option:selected', this).val();

        jQuery("#product").select2("destroy");

        // jQuery("#product > option").each(function () {
        //     jQuery('#product option[value="' + pcode + '"]').prop('selected', true);
        // });

        jQuery('#product option[value="' + pcode + '"]').prop('selected', true);
        jQuery("#product").select2();

    });


    jQuery("#product").change(function () {
        var pcode = jQuery('option:selected', this).val();

        jQuery("#product_name").select2("destroy");

        // jQuery("#product_name > option").each(function () {
            jQuery('#product_name option[value="' + pcode + '"]').prop('selected', true);
        // });

        jQuery("#product_name").select2();

    });


</script>


<script>
    jQuery(document).ready(function () {
        // Initialize select2
        jQuery("#account").select2();
        jQuery("#product").select2();
        jQuery("#product_name").select2();
    });
</script>

</body>
</html>