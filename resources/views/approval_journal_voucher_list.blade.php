@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Approval Journal Voucher {{$status}} List</h4>
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
                    @php
                        $urlss = $urls;
                        $url = 'approval_journal_voucher_list';
                        if ($status == 'Approved') $url = 'approval_journal_voucher_approved_list';
                        if ($status == 'Rejected') $url = 'approval_journal_voucher_rejected_list';
                    @endphp
                    <form class="highlight prnt_lst_frm" action="{{ route($url) }}" name="form1" id="form1" method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" class="inputs_up form-control"
                                           name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <span id="demo1" class="validate_sign"
                                          style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="form-group col-lg-10 col-md-9 col-sm-12 col-xs-12">

                                <div class="row">
                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Start Date
                                            </label>
                                            <input tabindex="2" type="text" name="to" id="to"
                                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                                   <?php if(isset($search_to)){?> value="{{$search_to}}"
                                                   <?php } ?> placeholder="Start Date ......"/>
                                            <span id="demo1" class="validate_sign"
                                                  style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                End Date
                                            </label>
                                            <input tabindex="3" type="text" name="from" id="from"
                                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                                   <?php if(isset($search_from)){?> value="{{$search_from}}"
                                                   <?php } ?> placeholder="End Date ......"/>
                                            <span id="demo1" class="validate_sign"
                                                  style="float: right !important"> </span>
                                        </div>
                                    </div>
                                    <x-year-end-component search="{{$search_year}}"/>
                                    <div class="col-lg-6 col-md-9 col-sm-12 col-xs-12 mt-4 text-right">
                                    @include('include.clear_search_button')
                                    <!-- Call add button component -->
                                        <x-add-button tabindex="9" href="{{ route('approval_journal_voucher') }}"/>
                                        @include('include/print_button')

                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form name="edit" id="edit" action="{{ route('approval_journal_voucher_edit') }}"
                          method="post">
                        @csrf
                        <input name="ajv_id" id="ajv_id" type="hidden">
                    </form>

                    <form name="approval_jv_confirm" id="approval_jv_confirm"
                          action="{{ route('approval_journal_voucher_confirm') }}" method="post">
                        @csrf
                        <input name="ajv_confirm_id" id="ajv_confirm_id" type="hidden">
                    </form>

                    <form name="approval_jv_response" id="approval_jv_response"
                          action="{{ route('approval_journal_voucher_response') }}" method="post">
                        @csrf
                        <input name="ajv_response_id" id="ajv_response_id" type="hidden">
                        <input name="ajv_response_type" id="ajv_response_type" type="hidden">
                    </form>

                </div><!-- search form end -->
                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">
                        <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">
                                Sr#
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Date
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                AJV#
                            </th>

                            <th scope="col" class="tbl_txt_30">
                                Detail Remarks
                            </th>
                            <th scope="col" class="tbl_amnt_13">
                                Total Debit
                            </th>
                            <th scope="col" class="tbl_amnt_13">
                                Total Credit
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Status
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Actions
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
                            $checkStatus = "";
                        @endphp
                        @forelse($datas as $voucher)
                            @php
                                $dr_pg = +$voucher->ajv_total_dr + +$dr_pg;
                                $cr_pg = +$voucher->ajv_total_cr + +$cr_pg;
                            @endphp
                            <tr {{ $voucher->ajv_status == 'Pending'? "data-voucher_id=$voucher->ajv_id" : "" }}> {{-- data-toggle="tooltip" data-placement="top" title="" data-original-title="View Approval Journal Voucher" --}}
                                <th class="edit">
                                    {{$sr}}
                                </th>
                                <td class="edit">
                                    {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->ajv_created_datetime)))}}
                                </td>
                                <td class="view" data-id="{{$voucher->ajv_id}}">
                                    AJV-{{$voucher->ajv_id}}
                                </td>


                                <td class="edit">

                                    {!! str_replace("&oS;",'<br />', $voucher->ajv_detail_remarks) !!}
                                </td>
                                <td class="text-right edit">
                                    {{$voucher->ajv_total_dr !=0 ? number_format($voucher->ajv_total_dr,2):''}}
                                </td>
                                <td class="text-right edit">
                                    {{$voucher->ajv_total_cr !=0 ? number_format($voucher->ajv_total_cr,2):''}}
                                </td>

                                @php
                                    $ip_browser_info= ''.$voucher->ajv_ip_adrs.','.str_replace(' ','-',$voucher->ajv_brwsr_info).'';
                                @endphp

                                <td class="usr_prfl"
                                    data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}"
                                    title="Click To See User Detail">
                                    {{$voucher->user_name}}
                                </td>
                                <td>
                                    {{$voucher->ajv_status}}
                                </td>
                                <td class="hide_column" style="min-width: 75px">
                                    @if ($voucher->ajv_status == 'Approved')
                                        <a data-voucher_id="{{$voucher->ajv_id}}"
                                           data-voucher_status="{{$voucher->ajv_status}}" class="confirm text-success"
                                           data-toggle="tooltip" data-placement="left" title=""
                                           data-original-title="Are you sure?">
                                            <i class="fa fa-check"></i>
                                        </a>
                                    @elseif($voucher->ajv_status == 'Confirmed')
                                    @elseif($voucher->ajv_status == 'Rejected')
                                    @elseif($voucher->ajv_status == 'Pending')
                                        <a data-voucher_id="{{$voucher->ajv_id}}"
                                           data-voucher_status="{{$voucher->ajv_status}}" class="approve"
                                           data-toggle="tooltip" data-placement="left" title=""
                                           data-original-title="Are you sure?">
                                            <i class="fa fa-check"></i>
                                        </a>
                                        <span class="px-1">|</span>
                                        <a data-voucher_id="{{$voucher->ajv_id}}"
                                           data-voucher_status="{{$voucher->ajv_status}}" class="delete text-danger"
                                           data-toggle="tooltip" data-placement="left" title=""
                                           data-original-title="Are you sure?">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    @endif
                                    @php
                                        $checkStatus = $voucher->ajv_status;
                                    @endphp
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
                            <th colspan="4" align="right" class="border-0 text-right align_right pt-0">
                                Page Total:
                            </th>
                            <td class="text-right border-left-0" align="right"
                                style="border-right: 0px solid transparent;">
                                {{ number_format($dr_pg,2) }}
                            </td>
                            <td class="text-right border-left-0" align="right"
                                style="border-right: 0px solid transparent;">
                                {{ number_format($cr_pg,2) }}
                            </td>
                        </tr>
                        <tr class="border-0">
                            <th colspan="4" align="right" class="border-0 text-right align_right pt-0">
                                Grand Total:
                            </th>
                            <td class="text-right border-left-0" align="right"
                                style="border-top: 1px solid #000;border-bottom: 3px double #000;border-right: 0px solid transparent;">
                                {{ number_format($ttl_dr,2) }}
                            </td>
                            <td class="text-right border-left-0" align="right"
                                style="border-top: 1px solid #000;border-bottom: 3px double #000;border-right: 0px solid transparent;">
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
                    <div class="col-md-9 text-right"><span
                            class="hide_column">  {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>
                    </div>
                </div>
            </div><!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Approval Journal Voucher Detail</h4>
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
                            <button type="button" id="cancelAJV" class="btn btn-default form-control cancel_button"
                                    data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                            <button type="button" id="approveAJV"
                                    class="btn btn-default approve form-control cancel_button" data-dismiss="modal"
                                    style="display: none">
                                <i class="fa fa-check"></i> Approve
                            </button>
                            <button type="button" id="rejectAJV"
                                    class="btn btn-default delete form-control cancel_button" data-dismiss="modal"
                                    style="display: none">
                                <i class="fa fa-times"></i> Reject
                            </button>
                            <button type="button" id="confirmAJV"
                                    class="btn btn-default confirm form-control cancel_button" data-dismiss="modal"
                                    style="display: none">
                                <i class="fa fa-check"></i> @if($checkStatus == 'Pending') Approve & @endif Confirm
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
        let $urlss = "{!! $urls !!}";
        let $url = $urlss;
        // let $url = 'approval_journal_voucher_list';
        if ("{!! $status !!}" == 'Approved') $url = 'approval_journal_voucher_approved_list';
        if ("{!! $status !!}" == 'Rejected') $url = 'approval_journal_voucher_rejected_list';
        var base = '{{ route($url) }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}
    @if (Session::get('ajv_id'))
        <script>
            jQuery("#table_body").html("");
            var id = '{{ Session::get("ajv_id") }}';
            $(".modal-body").load('{{ url("approval_journal_voucher_items_view_details/view/") }}/' + id, function () {
                $("#myModal").modal({show: true});
            });
        </script>
    @endif

    <script>
        jQuery(".view").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");
            $(".modal-body").load('{{ url("approval_journal_voucher_items_view_details/view/") }}/' + id, function () {
                $("#myModal").modal({show: true});
            });
        });
    </script>

    <script>
        @if ($status == 'Pending' || $status == '')
        jQuery(".edit").click(function () {
            var voucher_id = jQuery(this).parent().attr("data-voucher_id");
            if (typeof (voucher_id) == "undefined" && voucher_id == null) return 0;

            jQuery("#ajv_id").val(voucher_id);
            jQuery("#edit").submit();
        });
        @endif

        $('a.confirm').on('click', function (event) {
            var voucher_id = jQuery(this).attr("data-voucher_id");
            var voucher_status = jQuery(this).attr("data-voucher_status");
            $('#confirmAJV').attr('data-voucher_id', voucher_id);
            $('.view[data-id=' + voucher_id + ']').trigger('click');

            if (voucher_status === 'Approved') {
                $('#confirmAJV').show();
                $('#approveAJV').hide();
                $('#rejectAJV').hide();
            }
        });
        $('button.confirm').on('click', function (event) {
            var voucher_id = jQuery(this).attr("data-voucher_id");
            jQuery("#ajv_confirm_id").val(voucher_id);
            jQuery("#approval_jv_confirm").submit();
        });


        $('a.approve').on('click', function (event) {
            var voucher_id = jQuery(this).attr("data-voucher_id");
            var voucher_status = jQuery(this).attr("data-voucher_status");
            $('#approveAJV').attr('data-voucher_id', voucher_id);
            $('#rejectAJV').attr('data-voucher_id', voucher_id);
            $('#confirmAJV').attr('data-voucher_id', voucher_id);
            $('.view[data-id=' + voucher_id + ']').trigger('click');

            if (voucher_status === 'Pending') {
                $('#confirmAJV').show();
                $('#approveAJV').show();
                $('#rejectAJV').hide();
            }
        });
        $('button.approve').on('click', function (event) {
            var voucher_id = jQuery(this).attr("data-voucher_id");
            jQuery("#ajv_response_id").val(voucher_id);
            jQuery("#ajv_response_type").val('approved');
            jQuery("#approval_jv_response").submit();
        });


        $('a.delete').on('click', function (event) {
            var voucher_id = jQuery(this).attr("data-voucher_id");
            var voucher_status = jQuery(this).attr("data-voucher_status");
            $('#approveAJV').attr('data-voucher_id', voucher_id);
            $('#rejectAJV').attr('data-voucher_id', voucher_id);
            $('.view[data-id=' + voucher_id + ']').trigger('click');

            if (voucher_status === 'Pending') {
                $('#confirmAJV').hide();
                $('#approveAJV').hide();
                $('#rejectAJV').show();
            }
        });
        $('button.delete').on('click', function (event) {
            var voucher_id = jQuery(this).attr("data-voucher_id");
            jQuery("#ajv_response_id").val(voucher_id);
            jQuery("#ajv_response_type").val('rejected');
            jQuery("#approval_jv_response").submit();
        });
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#search").val('');
            $("#to").val('');
            $("#from").val('');
        });
    </script>
    {{--    <script>// english to urdu api--}}

    {{--        const settings = {--}}
    {{--            "async": true,--}}
    {{--            "crossDomain": true,--}}
    {{--            "url": "https://google-translate1.p.rapidapi.com/language/translate/v2",--}}
    {{--            "method": "POST",--}}
    {{--            "headers": {--}}
    {{--                "content-type": "application/x-www-form-urlencoded",--}}
    {{--                "accept-encoding": "application/gzip",--}}
    {{--                "x-rapidapi-key": "7c31ea181bmshd378fe70d604c14p1466b4jsn879bd5909726",--}}
    {{--                "x-rapidapi-host": "google-translate1.p.rapidapi.com"--}}
    {{--            },--}}
    {{--            "data": {--}}
    {{--                "q": "{!! $voucher->proj_project_name !!}",--}}
    {{--                "target": "ur",--}}
    {{--                "source": "en",--}}

    {{--            }--}}
    {{--        };--}}

    {{--        $.ajax(settings).done(function (response) {--}}
    {{--            "<td class='edit tbl_txt_10'> " + response + " </td>"--}}
    {{--            console.log(response);--}}
    {{--        });--}}

    {{--    </script>--}}
@endsection

