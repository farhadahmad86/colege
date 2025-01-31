@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">


            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Surveyor Working Area List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

            <!-- <div class="search_form {{ ( !empty($search) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <form class="prnt_lst_frm" action="{{ route('survey_work_area_list') }}" name="form1" id="form1" method="post">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input tabindex="1" autofocus type="search" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."
                                                   value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->


                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">


                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Order List
                                                    </label>
                                                    <select tabindex="3" class="inputs_up form-control cstm_clm_srch" name="order_list" id="order_list">
                                                        <option value="">Select Order List</option>
                                                        @foreach($order_lists as $order_list)
                                                            <option value="{{$order_list->ol_id}}" {{ $order_list->ol_id == $search_order_list ? 'selected="selected"' : ''
                                                            }}>{{$order_list->ol_order_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

{{--                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">--}}
{{--                                                <div class="input_bx"><!-- start input box -->--}}
{{--                                                    <label>--}}
{{--                                                        Select Project--}}
{{--                                                    </label>--}}
{{--                                                    <select tabindex="3" class="inputs_up form-control cstm_clm_srch" name="project" id="project">--}}
{{--                                                        <option value="">Select Project</option>--}}
{{--                                                        @foreach($projects as $project)--}}
{{--                                                            <option value="{{$project->proj_id}}" {{ $project->proj_id == $search_project ? 'selected="selected"' : ''--}}
{{--                                                            }}>{{$project->proj_project_name}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}
{{--                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Start Date
                                                    </label>
                                                    <input tabindex="2" type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
                                                           <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......"/>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        End Date
                                                    </label>
                                                    <input tabindex="3" type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off"
                                                           <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......"/>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>


                                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button tabindex="5" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button tabindex="6" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    <a tabindex="7" class="save_button form-control" href="{{ route('survey_work_area') }}" role="button">
                                                        <i class="fa fa-plus"></i> Add Survey Working Area
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
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                                Date
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                                Surveyor Detail
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_25">
                                Order List
                            </th>
{{--                            <th scope="col" align="center" class="align_center text-center tbl_txt_15">--}}
{{--                                Project--}}
{{--                            </th>--}}
                            <th scope="col" align="center" class="text-center align_center tbl_amnt_37">
                                Remarks
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Action
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            $per_page_ttl_amnt = 0;
                        @endphp
                        @forelse($datas as $voucher)

                            <tr>
                                <td class="align_center text-center tbl_srl_4">
                                    {{$sr}}
                                </td>
                                <td class="align_center text-center tbl_amnt_10">
                                    {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->swa_day_end_date)))}}
                                </td>
                                <td class="view align_center text-center tbl_amnt_6" data-id="{{$voucher->swa_id}}">
                                    SWA-{{$voucher->swa_id}}
                                </td>
                                <td class="align_left text-left tbl_txt_25">
                                    {{$voucher->ol_order_title}}
                                </td>
{{--                                <td class="align_left text-left tbl_txt_15">--}}
{{--                                    {{$voucher->proj_project_name}}--}}
{{--                                </td>--}}
                                <td class="align_right text-right tbl_amnt_37">
                                    {{$voucher->swa_remarks}}
                                </td>

                                @php
                                    $ip_browser_info= ''.$voucher->swa_ip_adrs.','.str_replace(' ','-',$voucher->swa_brwsr_info).'';
                                @endphp

                                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{$voucher->user_name}}
                                </td>
                                <td class="align_left text-left usr_prfl tbl_txt_8">
                                    <a href="{{ route('edit_survey_work_area','id='.$voucher->swa_id) }}" class="btn btn-sm btn-warning d-inline"><i class="fa fa-edit"></i></a>

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

                        {{--                        <tfoot>--}}
                        {{--                        <tr class="border-0">--}}
                        {{--                            <th colspan="5" align="right" class="border-0 text-right align_right pt-0">--}}
                        {{--                                Per Page Total:--}}
                        {{--                            </th>--}}
                        {{--                            <td class="text-right border-left-0" align="right" style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">--}}
                        {{--                                {{ number_format($per_page_ttl_amnt,2) }}--}}
                        {{--                            </td>--}}
                        {{--                        </tr>--}}
                        {{--                        <tr class="border-0">--}}
                        {{--                            <th colspan="5" align="right" class="border-0 text-right align_right pt-0">--}}
                        {{--                                Grand Total:--}}
                        {{--                            </th>--}}
                        {{--                            <td class="text-right border-left-0" align="right" style="border-bottom: 2px solid #000;border-bottom: 3px double #000;border-right: 0 solid transparent;">--}}
                        {{--                                {{ number_format($ttl_amnt,2) }}--}}
                        {{--                            </td>--}}
                        {{--                        </tr>--}}
                        {{--                        </tfoot>--}}

                    </table>
                </div>
                <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'to'=>$search_to, 'from'=>$search_from, 'order_list'=>$search_order_list ])->links()
                }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg mdl_wdth">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Surveyor Working Area Detail</h4>
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
        var base = '{{ route('survey_work_area_list') }}',
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
            $(".modal-body").load('{{ url('work_area_items_view_details/view/') }}/' + id, function () {
                // jQuery(".pre-loader").fadeToggle("medium");
                $("#myModal").modal({show: true});
            });

            {{--jQuery.ajaxSetup({--}}
            {{--    headers: {--}}
            {{--        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')--}}
            {{--    }--}}
            {{--});--}}

            {{--jQuery.ajax({--}}
            {{--    url: "{{ route('cash_receipt_items_view_details') }}",--}}
            {{--    data: {id: id},--}}
            {{--    type: "POST",--}}
            {{--    cache: false,--}}
            {{--    dataType: 'json',--}}
            {{--    success: function (data) {--}}

            {{--        var ttlAmnt = 0;--}}
            {{--        $.each(data, function (index, value) {--}}
            {{--            var amnt = (value['cri_amount'] !== "") ? value['cri_amount'] : 0;--}}
            {{--            ttlAmnt = ttlAmnt + amnt;--}}

            {{--            jQuery("#table_body").append(--}}
            {{--            '<tr>' +--}}
            {{--            '<td class="align_left wdth_5">' + value['cri_account_id'] + '</td>' +--}}
            {{--            '<td class="align_left wdth_2"> <div class="max_txt"> ' + value['cri_account_name'] + '</div> </td>' +--}}
            {{--            '<td class="align_left text-right wdth_5">' + value['cri_amount'] + '</td>' +--}}
            {{--            '</tr>');--}}

            {{--        });--}}
            {{--        jQuery("#table_foot").html(--}}
            {{--            '<tr>' +--}}
            {{--            '<td colspan="1" class="align_left"></td>' +--}}
            {{--            '<td class="align_left text-right wdth_5 border-right-0" style="border-top: 2px double #000;"> Total Amount </td>' +--}}
            {{--            '<td class="align_left text-right wdth_5 border-left-0" style="border-top: 2px double #000;">' + ttlAmnt + '</td>' +--}}
            {{--            '</tr>');--}}
            {{--    },--}}
            {{--    error: function (jqXHR, textStatus, errorThrown) {--}}
            {{--        // alert(jqXHR.responseText);--}}
            {{--        // alert(errorThrown);--}}
            {{--    }--}}
            {{--});--}}
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

            $("#order_list").select2().val(null).trigger("change");
            $("#order_list > option").removeAttr('selected');
            $("#project").select2().val(null).trigger("change");
            $("#project > option").removeAttr('selected');
        });

        jQuery("#cash_account").select2();
    </script>

    <script>
        $(document).ready(function () {
            $('#order_list').select2();
            $('#project').select2();
        });
    </script>
@endsection

