@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Journal Voucher Reference List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


            <!-- <div class="search_form {{ ( !empty($search) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('journal_voucher_reference_list') }}" name="form1" id="form1" method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-9 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12">

                                <div class="row">
                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Start Date
                                            </label>
                                            <input tabindex="2" type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
                                                   <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......"/>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                End Date
                                            </label>
                                            <input tabindex="3" type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off"
                                                   <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......"/>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12 mt-4 text-right">
                                        @include('include.clear_search_button')
                                        <!-- Call add button component -->
                                        <x-add-button tabindex="9" href="{{ route('journal_voucher_reference') }}"/>
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
                            <th scope="col" class="tbl_srl_4">
                                Sr#
                            </th>
                            <th scope="col" class="tbl_srl_4">
                                ID
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Date
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                JV#
                            </th>

                            <th scope="col" class="tbl_txt_41">
                                Detail Remarks
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Total Debit
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Total Credit
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
                            $dr_pg = $cr_pg = 0;
                        @endphp
                        @forelse($datas as $voucher)
                            @php
                                $dr_pg = +$voucher->jvr_total_dr + +$dr_pg;
                                $cr_pg = +$voucher->jvr_total_cr + +$cr_pg;
                            @endphp

                            <tr data-toggle="tooltip" data-placement="top" title="" data-original-title="View Journal Voucher">
                                <th scope="row" class="edit">
                                    {{$sr}}
                                </th>
                                <td class="edit">
                                    {{$voucher->jvr_id}}
                                </td>
                                <td>
                                    {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->jvr_day_end_date)))}}
                                </td>
                                <td class="view" data-id="{{$voucher->jvr_id}}">
                                JVR-{{$voucher->jvr_id}}
                                </td>

                                <td>

                                    {!! str_replace("&oS;",'<br />', $voucher->jvr_detail_remarks) !!}
                                </td>
                                <td>
                                    {{$voucher->jvr_total_dr !=0 ? number_format($voucher->jvr_total_dr,2):''}}
                                </td>
                                <td>
                                    {{$voucher->jvr_total_cr !=0 ? number_format($voucher->jvr_total_cr,2):''}}
                                </td>

                                @php
                                    $ip_browser_info= ''.$voucher->jvr_ip_adrs.','.str_replace(' ','-',$voucher->jvr_brwsr_info).'';
                                @endphp

                                <td class="usr_prfl" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{$voucher->user_name}}
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

                        <tfoot>
                        <tr class="border-0">
                            <th colspan="5" align="right" class="border-0 text-right align_right pt-0">
                                Page Total:
                            </th>
                            <td class="text-right border-left-0" align="right" style="border-right: 0px solid transparent;">
                                {{ number_format($dr_pg,2) }}
                            </td>
                            <td class="text-right border-left-0" align="right" style="border-right: 0px solid transparent;">
                                {{ number_format($cr_pg,2) }}
                            </td>
                        </tr>
                        <tr class="border-0">
                            <th colspan="5" align="right" class="border-0 text-right align_right pt-0">
                                Grand Total:
                            </th>
                            <td class="text-right border-left-0" align="right" style="border-top: 1px solid #000;border-bottom: 3px double #000;border-right: 0px solid transparent;">
                                {{ number_format($ttl_dr,2) }}
                            </td>
                            <td class="text-right border-left-0" align="right" style="border-top: 1px solid #000;border-bottom: 3px double #000;border-right: 0px solid transparent;">
                                {{ number_format($ttl_cr,2) }}
                            </td>
                        </tr>
                        </tfoot>

                    </table>
                </div>
                <div class="row">
    <div class="col-md-3">
        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
    </div>
    <div class="col-md-9 text-right"><span class="hide_column">  {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>
    </div></div> </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Journal Voucher Reference Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="itm_vchr form_manage">
                        <div class="form_header">
                            <h4 class="text-white file_name">
                                <span class="db sml_txt"> Product #: </span>
                            </h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" class="wdth_5">Account No.</th>
                                    <th scope="col" class="wdth_2">Account Name</th>
                                    <th scope="col" class="wdth_5 text-right">Dr.</th>
                                    <th scope="col" class="wdth_5 text-right">Cr.</th>
                                </tr>
                                </thead>
                                <tbody id="table_body">
                                </tbody>
                                <tfoot id="table_foot">
                                </tfoot>
                            </table>
                        </div>
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
        var base = '{{ route('journal_voucher_reference_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");

            $(".modal-body").load('{{ url("journal_voucher_reference_items_view_details/view/") }}/' + id, function () {
                $("#myModal").modal({show: true});
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

            $("#search").val('');
            $("#to").val('');
            $("#from").val('');
        });
    </script>

@endsection

