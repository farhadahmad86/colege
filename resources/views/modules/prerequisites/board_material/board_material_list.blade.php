
@extends('extend_index')
@section('styles_get')
    <style>
        .action_td .dropdown .dropdown-toggle::after {
            content: unset !important;
        }
    </style>
@stop
@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">



                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Board Type List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
                {{--                    <!-- <div class="search_form {{ ( !empty($search) || !empty($search_region) ) ? '' : 'search_form_hidden' }}"> -->--}}
                {{--                    --}}
                <div class="search_form">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <form class="prnt_lst_frm" action="{{ route('board_material_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1" id="form1" method="post">
                                <div class="row">
                                    @csrf
                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            {{--                                                    <label>--}}
                                            {{--                                                        All Column Search--}}
                                            {{--                                                    </label>--}}
                                            <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="All Data Search" value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($bm_title as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->


                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form_controls text-left">

                                            <button tabindex="2" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                <i class="fa fa-trash"></i> Clear
                                            </button>
                                            <button tabindex="3" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                <i class="fa fa-search"></i> Search
                                            </button>

                                            <a tabindex="4" class="save_button form-control" href="{{ route('add_board_material') }}" role="button">
                                                <l class="fa fa-plus"></l> Board Type
                                            </a>

                                            @include('include/print_button')

                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                        </div>
                                    </div>


                                </div><!-- end row -->
                            </form>


                            <form name="edit" id="edit" action="{{ route('edit_board_material') }}" method="post">
                                @csrf
                                <input name="title" id="title" type="hidden">
                                <input name="remarks" id="remarks" type="hidden">
                                <input name="board_material_id" id="board_material_id" type="hidden">

                            </form>

                            <form name="delete" id="delete" action="{{ route('delete_board_material') }}" method="post">
                                @csrf
                                <input name="bm_id" id="bm_id" type="hidden">
                            </form>

                        </div>

                    </div>
                </div>

                <div class="table-responsive" id="printTable">
                    <table class="table table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                                Sr#
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                                ID
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_37">
                                Title
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_35">
                                Remarks
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" align="center" class="text-center align_center hide_column tbl_srl_6">
                                Enable
                            </th>
                            <th scope="col" align="center" class="text-center align_center hide_column tbl_srl_6">
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
                        @endphp
                        @forelse($datas as $data)

                            <tr data-title="{{$data->bm_title}}" data-remarks="{{$data->bm_remarks}}" data-board_material_id="{{$data->bm_id}}">
                                <td class="align_center text-center edit tbl_srl_4">
                                    {{$sr}}
                                </td>
                                <td class="align_center text-center edit tbl_srl_4">
                                    {{$data->bm_id}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_37">
                                    {{$data->bm_title}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_35">
                                    {{$data->bm_remarks }}
                                </td>

                                @php
                                    $ip_browser_info= ''.$data->bm_ip_adrs.','.str_replace(' ','-',$data->bm_brwsr_info).'';
                                @endphp

                                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $data->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{$data->user_name}}
                                </td>
                                {{--                                        <td class="align_center hide_column">--}}
                                {{--                                            <a class="edit" style="cursor:pointer;">--}}
                                {{--                                                <i class="fa fa-edit"></i>--}}
                                {{--                                            </a>--}}
                                {{--                                        </td>--}}

                                <td class="align_right text-right hide_column tbl_amnt_6">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($data->bm_disabled == 0) {
                                            echo 'checked="true"' . ' ' . 'value=' . $data->bm_disabled;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?>  class="enable_disable" data-id="{{$data->bm_id}}"
                                            {{ $data->bm_disabled == 0 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                <td class="align_right text-right hide_column tbl_srl_6">
                                    <a data-board_material_id="{{$data->bm_id}}" class="delete"  data-toggle="tooltip" data-placement="left"  title="" data-original-title="Are you sure?">
                                        <i class="fa fa-{{$data->bm_delete_status == 1 ? 'undo':'trash'}}"></i>
                                    </a>
                                </td>



                                {{--                                        <td><input type="checkbox" data-id="{{ $data->bm_id }}" name="status" class="js-switch" {{ $data->reg_disabled == 0 ? 'checked' : '' }}></td>--}}
                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Region</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>
                <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('board_material_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let regId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_region') }}',
                    data: {'status': status, 'bm_id': regId},
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>

    <script>
        jQuery("#cancel").click(function () {

            // $("#region").select2().val(null).trigger("change");
            // $("#region > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>

        // $('#print').click(function () {
        //     var printContents = document.getElementById('printTable').innerHTML;
        //     $('[name="content"]').val(printContents);
        //
        //     $(this).submit();
        // });

        jQuery(".edit").click(function () {

            var title = jQuery(this).parent('tr').attr("data-title");
            var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var board_material_id = jQuery(this).parent('tr').attr("data-board_material_id");

            jQuery("#title").val(title);
            jQuery("#remarks").val(remarks);
            jQuery("#board_material_id").val(board_material_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var board_material_id = jQuery(this).attr("data-board_material_id");

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
                    jQuery("#bm_id").val(board_material_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });

    </script>


@endsection

