
@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Courier List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <div class="search_form {{ ( !empty($search) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <form class="prnt_lst_frm" action="{{ route('courier_list') }}" name="form1" id="form1" method="post">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <input type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="All Data Search" value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($cc_title as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">

                                        <div class="row">

                                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    <a class="save_button form-control" href="{{ route('add_courier') }}" role="button">
                                                        <i class="fa fa-plus"></i> Courier
                                                    </a>

                                                    @include('include/print_button')

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <form name="edit" id="edit" action="{{ route('edit_courier') }}" method="post">
                                @csrf
                                <input name="cc_id" id="cc_id" type="hidden">
                                <input name="remarks" id="remarks" type="hidden">
                            </form>

                            <form name="delete" id="delete" action="{{ route('delete_courier') }}" method="post">
                                @csrf
                                <input name="cc_id" id="cc_id" type="hidden">
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
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_25">
                                Courier Name
                            </th>

                            <th scope="col" align="center" class="align_center text-center tbl_txt_40">
                                 Remarks
                            </th>

                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Created By
                            </th>

                            <th scope="col" align="center" class="text-center align_center tbl_txt_5">
                                Enable
                            </th>

                            <th scope="col" align="center" class="text-center align_center tbl_txt_5">
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
                            $dr_pg = $cr_pg = 0;
                        @endphp
                        @forelse($datas as $courier)

                            <tr data-remarks="{{$courier->cc_remarks}}" data-toggle="tooltip" data-placement="top" title="" data-courier_id="{{$courier->cc_id}}"  data-original-title="View courier">
                                <td class="align_center text-center edit tbl_srl_4">
                                    {{$sr}}
                                </td>

                                <td class="view align_left text-left tbl_amnt_25" data-id="{{$courier->cc_id}}">
                                    {{$courier->cc_name}}
                                </td>
                                <td class="align_left edit text-left tbl_txt_40">
                                    {{$courier->cc_remarks}}
                                </td>

                                @php
                                    $ip_browser_info= ''.$courier->cc_ip_adrs.','.str_replace(' ','-',$courier->cc_brwsr_info).'';
                                @endphp

                                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $courier->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{$courier->user_name}}
                                </td>

                                <td class="align_right text-right hide_column tbl_amnt_5">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($courier->cc_disabled == 0) {
                                            echo 'checked="true"' . ' ' . 'value=' . $courier->cc_disabled;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?>  class="enable_disable" data-id="{{$courier->cc_id}}"
                                            {{ $courier->cc_disabled == 0 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                <td class="align_right text-right hide_column tbl_srl_5">
                                    <a data-courier_id="{{$courier->cc_id}}" class="delete"  data-toggle="tooltip" data-placement="left"  title="" data-original-title="Are you sure?">
                                        <i class="fa fa-{{$courier->cc_delete_status == 1 ? 'undo':'trash'}}"></i>
                                    </a>
                                </td>
                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Courier</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>


                    </table>
                </div>
                <span class="hide_column">  {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search])->links() }}</span>
            </div> <!-- white column form ends here -->
        </div><!-- col end -->
    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">courier Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="itm_vchr form_manage">
                        <div class="form_header">
                            <h4 class="text-white file_name">
                                <span class="db sml_txt"> Courier #: </span>
                            </h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" align="center" class="wdth_5">Branch Name</th>
                                    <th scope="col" align="center" class="wdth_5">Type</th>
                                    <th scope="col" align="center" class="wdth_5 ">City</th>
                                    <th scope="col" align="center" class="wdth_5 ">Address</th>
                                    <th scope="col" align="center" class="wdth_5 text-right">Mobile-1</th>
                                    <th scope="col" align="center" class="wdth_5 text-right">Mobile-2</th>
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
        var base = '{{ route('courier_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");
            $(".modal-body").load('{{ url("courier_items_view_details/view/") }}/'+id,function () {
                $("#myModal").modal({show:true});
            });

            {{--jQuery.ajaxSetup({--}}
            {{--    headers: {--}}
            {{--        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')--}}
            {{--    }--}}
            {{--});--}}

            {{--jQuery.ajax({--}}
            {{--    url: "{{ route('journal_voucher_items_view_details') }}",--}}
            {{--    data: {id: id},--}}
            {{--    type: "POST",--}}
            {{--    cache: false,--}}
            {{--    dataType: 'json',--}}
            {{--    success: function (data) {--}}
            {{--        var ttlCr = 0,--}}
            {{--            ttlDr = 0;--}}
            {{--        $.each(data, function (index, value) {--}}
            {{--            var dr = (value['jvi_type'] === "Dr") ? value['jvi_amount'] : 0;--}}
            {{--            var cr = (value['jvi_type'] === "Cr") ? value['jvi_amount'] : 0;--}}
            {{--                ttlCr = cr + ttlCr;--}}
            {{--                ttlDr = dr + ttlDr;--}}
            {{--            jQuery("#table_body").append(--}}
            {{--            '<tr>' +--}}
            {{--            '<td class="align_left wdth_5">' + value['jvi_cc_id'] + '</td>' +--}}
            {{--            '<td class="align_left wdth_2"> <div class="max_txt"> ' + value['jvi_account_name'] + '</div> </td>' +--}}
            {{--            '<td class="align_left text-right wdth_5">' + dr + '</td>' +--}}
            {{--            '<td class="align_left text-right wdth_5">' + cr + '</td>' +--}}
            {{--            '</tr>');--}}

            {{--        });--}}
            {{--        jQuery("#table_foot").html(--}}
            {{--            '<tr>' +--}}
            {{--            '<td colspan="2" class="align_left"></td>' +--}}
            {{--            '<td class="align_left text-right wdth_5" style="border-top: 2px double #000;">' + ttlDr + '</td>' +--}}
            {{--            '<td class="align_left text-right wdth_5" style="border-top: 2px double #000;">' + ttlCr + '</td>' +--}}
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
        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let ccId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_courier') }}',
                    data: {'status': status, 'cc_id': ccId},
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>

    <script>
        jQuery(".edit").click(function () {

            var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var courier_id = jQuery(this).parent('tr').attr("data-courier_id");


            jQuery("#remarks").val(remarks);
            jQuery("#cc_id").val(courier_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var courier_id = jQuery(this).attr("data-courier_id");

            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
            }).then(function(result) {

                if (result.value) {
                    jQuery("#cc_id").val(courier_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });

    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#search").val('');

        });
    </script>

@endsection

