
@extends('extend_index')

@section('content')

    <div class="row">

        @php
            $company_info = Session::get('company_info');
            if(isset($company_info) || !empty($company_info)){
                $win = $company_info->info_bx;
            }else{
                $win = '';
            }

        @endphp
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" id="main_col" data-win="{{ ($win === 'full') ? 'min' : 'full' }} " data-win-time="0">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                <div class="close_info_bx"><!-- info bx start -->
                    <i class="fa fa-expand"></i>
                </div><!-- info bx end -->

                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Assign Board Material List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
            <!-- <div class="search_form  {{ ( !empty($search) || !empty($search_product) || !empty($search_board_type) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="">
                    <div class="row">


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            {{--                            . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '')}}--}}
                            {{-- . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') --}}
                            <form class="prnt_lst_frm" action="{{ route('assign_board_material_list')}}" name="form1" id="form1" method="post">
                                <div class="row">
                                    @csrf

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($assign_board_material_title as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">
                                                        Select Product
                                                    </label>
                                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="product" id="product" style="width: 90%">
                                                        <option value="">Select Product</option>
                                                        @foreach($products as $product)
                                                            <option value="{{$product->pro_p_code}}" {{ $product->pro_p_code == $search_product ? 'selected="selected"' : ''
                                                            }}>{{$product->pro_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">
                                                        Select Board Type
                                                    </label>
                                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="board_type" id="board_type" style="width: 90%">
                                                        <option value="">Select Product</option>
                                                        @foreach($board_types as $board_type)
                                                            <option value="{{$board_type->bt_id}}" {{ $board_type->bt_id == $search_board_type ? 'selected="selected"' : ''
                                                            }}>{{$board_type->bt_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>


                                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button tabindex="3" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button tabindex="4" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    <a tabindex="5" class="save_button form-control" href="{{ route('assign_board_material') }}" role="button">
                                                        <l class="fa fa-plus"></l> Assign Board Material
                                                    </a>

                                                    @include('include/print_button')

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                </div><!-- end row -->
                            </form>

                            {{--                            <form name="edit" id="edit" action="{{ route('edit_area') }}" method="post">--}}
                            {{--                                @csrf--}}
                            {{--                                <input tabindex="-1" name="region_title" id="region_title" type="hidden">--}}
                            {{--                                <input name="area_title" id="area_title" type="hidden">--}}
                            {{--                                <input name="remarks" id="remarks" type="hidden">--}}
                            {{--                                <input name="abm_id" id="abm_id" type="hidden">--}}
                            {{--                                <input name="region_id" id="region_id" type="hidden">--}}

                            {{--                            </form>--}}

                            <form name="delete" id="delete" action="{{ route('assign_board_material.destroy') }}" method="post">
                                @csrf
                                @method('delete')
                                <input name="abm_id" id="del_abm_id" type="hidden">
                            </form>


                        </div>
                    </div>
                </div>

                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" align="center" class="text-center align_center tbl_srl_4">Sr#</th>
                            {{--                           <th scope="col" align="center" class="text-center align_center tbl_srl_4">ID</th>--}}
                            <th scope="col" align="center" class="text-center align_center tbl_txt_23">Company Title</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_23">Product Title</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_23">Board Title</th>
{{--                            <th scope="col" align="center" class="text-center align_center tbl_txt_25">Remarks</th>--}}
                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">Created By</th>
                            {{--<th scope="col" style="width:80px; text-align: center !important" align="center">Date/Time</th>--}}
{{--                            <th scope="col" class="text-center align_center hide_column tbl_srl_6">Status</th>--}}
                            <th scope="col" class="text-center align_center hide_column tbl_srl_6">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                        @endphp
                        @forelse($datas as $assign_material)

                            <tr >
{{--                                data-region_title="{{$assign_material->account_name}}" data-area_title="{{$assign_material->name}}" data-remarks="{{$assign_material->remarks}}"
data-abm_id="{{$assign_material->id}}"
data-region_id="{{$assign_material->account_uid}}">--}}

                                <td class="align_center text-center edit tbl_srl_4">{{$sr}}</td>
                                {{--                                 <td class="align_center text-center edit tbl_srl_4">{{$assign_material->account_id}}</td>--}}
                                <td class="view align_center text-center tbl_amnt_6" data-id="{{$assign_material->abm_id}}">
                                    {{$assign_material->abm_id}}
                                </td>

                                <td class="align_left text-left edit tbl_txt_23">{{$assign_material->pro_title}}</td>

                                <td class="align_left text-left edit tbl_txt_23">{{$assign_material->bt_title}}</td>


                                {{--                                @php--}}
                                {{--                                    $ip_browser_info= ''.$assign_material->area_ip_adrs.','.str_replace(' ','-',$assign_material->area_brwsr_info).'';--}}
                                {{--                                @endphp--}}
                                {{--                                data-user_info="{!! $ip_browser_info !!}"--}}
                                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $assign_material->user_id }}"  title="Click To See User Detail">
                                    {{ $assign_material->user_name }}
                                </td>

                                {{--                                <td class="align_right text-right hide_column tbl_amnt_6">--}}

                                {{--                                </td>--}}

                                <td class="align_center  text-right hide_column tbl_srl_6">

                                    <a href="{{ route('edit_assign_board_material', $assign_material->abm_id) }}" class="float-left" data-toggle="tooltip" data-placement="left" title=""
                                       data-original-title="Are
                                    you sure want to edit?"><i class="fa fa-edit"></i></a>

                                    <a data-abm_id="{{$assign_material->abm_id}}" class="delete" data-toggle="tooltip" data-placement="left" title="" data-original-title="Are you sure want to
                                    delete?">
                                        {{--                                        <i class="fa fa-{{$assign_material->area_delete_status == 1 ? 'undo':'trash'}}"></i>--}}
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Assign Board Material</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>

                <span class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'product'=>$search_product, 'board_type'=>$search_board_type ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Assign Board Material Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div id="table_body">

                    </div>
                    <div id="hello"></div>

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
        var base = '{{ route('assign_board_material_list') }}',
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
            $(".modal-body").load('{{ url('assign_board_material_items_view_details/view/') }}/'+id, function () {
                // jQuery(".pre-loader").fadeToggle("medium");
                $("#myModal").modal({show:true});
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

        // jQuery(".edit").click(function () {
        //
        //     var region_title = jQuery(this).parent('tr').attr("data-region_title");
        //     var area_title = jQuery(this).parent('tr').attr("data-area_title");
        //     var remarks = jQuery(this).parent('tr').attr("data-remarks");
        //     var abm_id = jQuery(this).parent('tr').attr("data-abm_id");
        //     var region_id = jQuery(this).parent('tr').attr("data-region_id");
        //
        //     jQuery("#region_title").val(region_title);
        //     jQuery("#area_title").val(area_title);
        //     jQuery("#remarks").val(remarks);
        //     jQuery("#abm_id").val(abm_id);
        //     jQuery("#region_id").val(region_id);
        //     jQuery("#edit").submit();
        // });

        $('.delete').on('click', function (event) {

            var abm_id = jQuery(this).attr("data-abm_id");

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
                    jQuery("#del_abm_id").val(abm_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });




        {{--$(function() {--}}
        {{--var availableTutorials  =  JSON.parse('{!! json_encode($area_title) !!}');--}}
        {{--$( "#search" ).autocomplete({--}}
        {{--source: availableTutorials,--}}
        {{--});--}}
        {{--});--}}

    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#product").select2().val(null).trigger("change");
            $("#product > option").removeAttr('selected');

            $("#board_type").select2().val(null).trigger("change");
            $("#board_type > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#product").select2();
            jQuery("#board_type").select2();
        });
    </script>

    <style>
        input::-webkit-calendar-picker-indicator {
            display: none;
        }
    </style>

@endsection
