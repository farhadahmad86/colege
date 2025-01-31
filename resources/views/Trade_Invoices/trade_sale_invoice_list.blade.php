@extends('extend_index')

@section('content')
    <div class="row">
            <div class="container-fluid search-filter form-group form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Trade Sale Invoice List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

            <!-- <div class="search_form {{ ( !empty($search) || !empty($search_account) || !empty($search_product) ||!empty($search_sale_persons) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form m-0 p-0">
                            <form class="highlight prnt_lst_frm" action="{{ route('trade_sale_invoice_list') }}" name="form1" id="form1" method="post">
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
                                            <input type="checkbox" name="check_desktop" id="check_desktop" value="1" {{$check_desktop==1 ? 'checked':'' }}>
                                            <label class="d-inline" for="check_desktop">Desktop Invoice</label>
                                        </div>
                                    </div> <!-- left column ends here -->


                                    <div class="form-group col-lg-10 col-md-9 col-sm-12 col-xs-12">
                                        <div class="row">

                                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Account
                                                    </label>
                                                    <select tabindex="2" class="inputs_up  form-control" name="account" id="account">
                                                        <option value="">Select Account</option>
                                                        @foreach($accounts as $account)
                                                            <option
                                                                value="{{$account->account_uid}}" {{ $account->account_uid == $search_account ? 'selected="selected"' : '' }}>{{$account->account_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Code
                                                    </label>
                                                    <select tabindex="3" class="inputs_up form-control" name="product" id="product">
                                                        <option value="">Select Code</option>
                                                        @foreach($products as $product)
                                                            <option
                                                                value="{{$product->pro_p_code}}" {{ $product->pro_p_code == $search_product ? 'selected="selected"' : '' }}>{{$product->pro_p_code}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Product
                                                    </label>
                                                    <select tabindex="4" class="inputs_up  form-control" name="product_name" id="product_name">
                                                        <option value="">Select Product</option>
                                                        @foreach($products as $product)
                                                            <option value="{{$product->pro_p_code}}" {{ $product->pro_p_code == $search_product ? 'selected="selected"' : ''
                                                                }}>{{$product->pro_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        Select Sale Person
                                                    </label>
                                                    <select tabindex="5" class="inputs_up form-control cstm_clm_srch" name="sale_person" id="sale_person" style="width: 90%">
                                                        <option value="">Select Sale Person</option>
                                                        @foreach($sale_persons as $sale_person)
                                                            <option
                                                                value="{{$sale_person->user_id}}" {{ $sale_person->user_id == $search_sale_persons ? 'selected="selected"' : '' }}>{{$sale_person->user_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Posting Reference
                                                    </label>
                                                    <select tabindex="4" class="inputs_up form-control" name="posting" id="posting">
                                                        <option value="">Posting Reference</option>
                                                        @foreach($posting_references as $posting_reference)
                                                            <option value="{{$posting_reference->pr_id}}" {{ $posting_reference->pr_id == $search_posting_reference ? 'selected="selected"' : '' }}>{{$posting_reference->pr_name}}</option>
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
                                            <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12 mt-lg-4 text-right">
                                                @include('include.clear_search_button')
<!-- Call add button component -->
<x-add-button tabindex="9" href="{{ route('trade_sale_invoice') }}"/>
                                                    @include('include/print_button')
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                </div><!-- search form end -->
                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th tabindex="-1" scope="col" class="tbl_srl_4">
                                Sr#
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_srl_4">
                                DO ID
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_srl_4">
                                DC ID
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_amnt_9">
                                Date
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_amnt_6">
                                Invoice No.
                            </th>

                            <th scope="col" class="tbl_txt_21">
                                Party Name
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_txt_21">
                                Posting Reference
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_txt_11">
                                Remarks
                            </th>
                            <th scope="col" class="tbl_txt_29">
                                Detail Remarks
                            </th>
                            <th scope="col" class="tbl_amnt_5">
                                Total Price
                            </th>
                            <th scope="col" class="tbl_amnt_5">
                                Cash Rec
                            </th>
                            <th scope="col" class="tbl_txt_8">
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
                            <th scope="row" class="edit tbl_srl_4">
                                    {{$sr}}
                                </th>
                                <td class="edit tbl_srl_4">
                                    {{$invoice->si_whatsapp}}
                                </td>
                                <td class="edit tbl_srl_4">
                                    {{$invoice->sde_dc_id}}
                                </td>
                                <td nowrap class="tbl_amnt_9">
                                    {{date('d-M-y', strtotime(str_replace('/', '-', $invoice->si_day_end_date)))}}
                                </td>
                                <td class="view tbl_amnt_6" data-id="{{$invoice->si_id}}">
                                    TSI-{{$invoice->si_id}}
                                </td>
                                @php
                                    $party_name = $invoice->si_party_name;
                                        if($urdu_eng->rc_invoice_party == 1){
                                    $party_name = $invoice->account_urdu_name;
                                }
                                @endphp
                                <td class="align_left text-left tbl_txt_21 ">
                                    {{$party_name}}
                                </td>
                                <td class="align_left text-left tbl_txt_21">
                                    {{$invoice->pr_name}}
                                </td>
                                <td class="align_left text-left tbl_txt_11  ">
                                    {{$invoice->si_remarks}}
                                </td>
                                <td class="align_left text-left tbl_txt_29 ">
                                    {!! str_replace("&oS;",'<br />', $invoice->si_detail_remarks) !!}
                                </td>
                                @php
                                    $ttlPrc = +($invoice->si_grand_total) + +$ttlPrc;
                                @endphp
                                <td class="align_right text-right tbl_amnt_5">
                                    {{$invoice->si_grand_total !=0 ? number_format($invoice->si_grand_total,2):''}}
                                </td>
                                @php
                                    $cashPaid = +($invoice->si_cash_received) + +$cashPaid;
                                @endphp
                                <td class="align_right text-right tbl_amnt_5">
                                    {{$invoice->si_cash_received !=0 ? number_format($invoice->si_cash_received,2):''}}
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
                                <td colspan="15">
                                    <center><h3 style="color:#554F4F">No Invoice</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                        <tfoot>
                        <tr>
                            <th colspan="9" class="align_right text-right border-0">
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
                <div class="row">
    <div class="col-md-3">
        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
    </div>
    <div class="col-md-9 text-right">
                <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'account'=>$search_account, 'product_code'=>$search_product, 'sale_person'=>$search_sale_persons, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>
                </div></div></div> <!-- white column form ends here -->
   </div><!-- row end -->

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

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('trade_sale_invoice_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");

            $('.modal-body').load('{{url("trade_sale_items_view_details/view/") }}' + '/' + id, function () {
                $('#myModal').modal({show: true});
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

    <script>
        jQuery("#cancel").click(function () {

            $("#account").select2().val(null).trigger("change");
            $("#account > option").removeAttr('selected');

            $("#product").select2().val(null).trigger("change");
            $("#product > option").removeAttr('selected');

            $("#product_name").select2().val(null).trigger("change");
            $("#product_name > option").removeAttr('selected');

            $("#sale_person").select2().val(null).trigger("change");
            $("#sale_person > option").removeAttr('selected');

            $("#posting").select2().val(null).trigger("change");
            $("#posting > option").removeAttr('selected');

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
            jQuery("#sale_person").select2();
            jQuery("#posting").select2();
        });
    </script>

@endsection

