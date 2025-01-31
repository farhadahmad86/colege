
@extends('extend_index')

@section('content')

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text file_name"> {{ $pge_title }}</h4>
                            </div>
                            <div class="list_btn list_mul">
                                <div class="srch_box_opn_icon">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->

                    <!-- <div class="search_form {{ ( !empty($search) || !empty($search_to) || !empty($search_from) || !empty($search_product) ) ? '' : 'search_form_hidden' }}"> -->

                    <div class="">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                                <form class="prnt_lst_frm" action="{{ route($route) }}" name="form1" id="form1" method="post">
                                    @csrf
                                    <div class="row">

                                        <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label>
                                                    All Column Search
                                                </label>
                                                <input type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                                <datalist id="browsers">

                                                </datalist>
                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                            </div>
                                        </div> <!-- left column ends here -->

                                        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                            <div class="row">
                                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label>
                                                            Select Product
                                                        </label>
                                                        <select class="inputs_up form-control" name="product_code" id="product_code">
                                                            <option value="">Select Code</option>
                                                        </select>
                                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label>
                                                            Product
                                                        </label>
                                                        <select class="inputs_up form-control" name="product_name" id="product_name">
                                                            <option value="">Select Product</option>
                                                        </select>
                                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label>
                                                            Accounts
                                                        </label>
                                                        <select class="inputs_up form-control" name="account" id="account">
                                                            <option value="">Select Account</option>
                                                            @foreach($accounts as $account)
                                                                <option value="{{$account->account_uid}}" {{ $account->account_uid == $search_account ? 'selected="selected"' : ''}}>{{$account->account_name}}</option>
                                                            @endforeach
                                                        </select>
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

                                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                    <div class="form_controls text-center text-lg-left">

                                                        <button type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                            <i class="fa fa-trash"></i> Clear
                                                        </button>
                                                        <button type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                            <i class="fa fa-search"></i> Search
                                                        </button>

                                                        <a class="save_button form-control" href="{{ route('manufacture_product') }}" role="button">
                                                            <i class="fa fa-plus"></i> Manufacture Product
                                                        </a>

                                                        @include('include/print_button')

                                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                    </div>
                                                </div>

                                                <input name="product" id="product" type="hidden" value="{{$search_product}}">

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
                                <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                                    Date
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                                    Voucher No.
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_13">
                                    Account Name
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_13">
                                    Product Name
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_6">
                                    Status
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                                    Complete At
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_18">
                                    {{$route=='reject_manufacture_product_list' ? 'Reason':'Remarks'}}
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_amnt_4">
                                    Qty
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_amnt_12">
                                    Grand Total
                                </th>
                                <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                                    Created By
                                </th>
                                @if($route=='manufacture_product_list')
                                    <th scope="col" align="center" class="align_center text-center hide_column tbl_srl_4">
                                        Action
                                    </th>
                                @endif
                            </tr>
                            </thead>

                            <tbody>
                            @php
                                $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                                $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                                $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                                $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                                $ttlPrc = 0;
                                $set_status = '';
                                if($search_by_status === 'COMPLETED'):
                                    $set_status = 'PMCV';
                                elseif($search_by_status === 'REJECTED'):
                                    $set_status = 'PMRV';
                                elseif($search_by_status === 'PROCESSING'):
                                    $set_status = 'PMPV';
                                endif;
                            @endphp
                            @forelse($datas as $manufacture_product)

                                <tr data-manufacture_id="{{$manufacture_product->pm_id}}">
                                    <td class="align_center text-center edit tbl_srl_4">
                                        {{$sr}}
                                    </td>
                                    <td class="align_center text-center edit tbl_amnt_6">
                                        {{date('d-M-y', strtotime(str_replace('/', '-', $manufacture_product->pm_datetime)))}}
                                    </td>
                                    <td align="center" class="align_center text-center tbl_amnt_6 view" data-id="{{$manufacture_product->pm_id}}">
                                        {{ $set_status }}-{{$manufacture_product->pm_id}}
                                    </td>
                                    <td class="align_left text-left edit tbl_txt_13">
                                        {{$manufacture_product->pm_account_name.' ('.$manufacture_product->pm_account_code.')'}}
                                    </td>
                                    <td class="align_left text-left edit tbl_txt_13">
                                        {{$manufacture_product->pm_pro_name.' ('.$manufacture_product->pm_pro_code.')'}}
                                    </td>
                                    <td class="align_left text-left edit tbl_txt_6">
                                        {{$manufacture_product->pm_status}}
                                    </td>
                                    <td class="align_center text-center edit tbl_amnt_6">
                                        {{date('d-M-y', strtotime(str_replace('/', '-', $manufacture_product->pm_complete_datetime)))}}
                                    </td>
                                    <td class="align_left text-left edit tbl_txt_18">
                                        {{$route=='reject_manufacture_product_list' ? $manufacture_product->pm_reject_reason:$manufacture_product->pm_remarks}}
                                    </td>
                                    <td align="center" class="align_center text-center edit tbl_amnt_4">
                                        {{$manufacture_product->pm_qty}}
                                    </td>
                                    @php
                                        $ttlPrc = +($manufacture_product->pm_grand_total) + +$ttlPrc;
                                    @endphp
                                    <td align="right" class="align_right text-right edit tbl_amnt_12">
                                        {{number_format($manufacture_product->pm_grand_total,2)}}
                                    </td>

                                    @php
                                        $ip_browser_info= ''.$manufacture_product->pm_ip_adrs.','.str_replace(' ','-',$manufacture_product->pm_brwsr_info).'';
                                    @endphp

                                    <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $manufacture_product->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                        {{ $manufacture_product->user_name }}
                                    </td>
                                    @if($route=='manufacture_product_list')
                                        <td class="align_center text-center hide_column tbl_srl_4">
                                            <a class="btn btn-success btn-sm complete rjct_acpt_btn" data-manufacture_id="{{$manufacture_product->pm_id}}" id="approve_payment">
                                                <i class="fa fa-check approve"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm reject rjct_acpt_btn" data-manufacture_id="{{$manufacture_product->pm_id}}" data-toggle="modal" data-target="#exampleModal">
                                                <i class="fa fa-ban reject"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                                @php
                                    $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="11">
                                        <center><h3 style="color:#554F4F">No Entry</h3></center>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>

                            <tfoot>
                            <tr>
                                <th colspan="9" class="align_right text-right border-0">
                                    Page Total:-
                                </th>
                                <td class="align_right text-right border-0">
                                    {{ number_format($ttlPrc,2) }}
                                </td>
                            </tr>
                            </tfoot>


                        </table>

                    </div>
                    <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'product_code'=>$search_product, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>
                </div> <!-- white column form ends here -->


            </div><!-- col end -->


        </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg mdl_wdth">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Item Detail</h4>
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

    @if($route=='manufacture_product_list')

        <form name="edit" id="edit" action="{{ route('edit_manufacture_product') }}" method="post">
            @csrf
            <input name="manufacture_id" id="manufacture_id" type="hidden">
        </form>

        <form name="complete" id="complete" action="{{ route('complete_manufacture_product') }}" method="post">
            @csrf
            <input name="complete_manufacture_id" id="complete_manufacture_id" type="hidden">
        </form>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reject Transaction</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route("reject_manufacture_product")}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label for="message-text" class="col-form-label">Reason:</label>
                                        <textarea class="inputs_up form-control" id="reason" name="reason" required></textarea>
                                        <input type="hidden" name="reject_manufacture_id" id="reject_manufacture_id">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Send message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endif

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route($route) }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");

            $('.modal-body').load('{{url("get_manufacture_product_details/view/")}}' + '/' + id, function () {
                $('#myModal').modal({show: true});
            });


        });
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#to").val('');
            $("#from").val('');

            $("#product_code").select2().val(null).trigger("change");
            $("#product_code > option").removeAttr('selected');

            $("#product_name").select2().val(null).trigger("change");
            $("#product_name > option").removeAttr('selected');

            $("#account").select2().val(null).trigger("change");
            $("#account > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    @if($route=='manufacture_product_list')

        <script>
            jQuery(".reject").click(function () {

                var manufacture_id = jQuery(this).attr("data-manufacture_id");

                jQuery("#reject_manufacture_id").val(manufacture_id);
            });

            jQuery(".complete").click(function () {

                var manufacture_id = jQuery(this).attr("data-manufacture_id");

                jQuery("#complete_manufacture_id").val(manufacture_id);
                jQuery("#complete").submit();
            });

        </script>

        <script>
            jQuery(".edit").click(function () {
                var manufacture_id = jQuery(this).parent('tr').attr("data-manufacture_id");

                jQuery("#manufacture_id").val(manufacture_id);
                jQuery("#edit").submit();
            });
        </script>

    @endif

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
            jQuery("#product_code").select2();
            jQuery("#product_name").select2();

            jQuery("#account").select2();

            jQuery("#product_code").append("{!! $pro_code !!}");
            jQuery("#product_name").append("{!! $pro_name !!}");
        });
    </script>

@endsection

