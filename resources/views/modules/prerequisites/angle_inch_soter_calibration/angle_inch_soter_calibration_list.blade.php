
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
                            <h4 class="text-white get-heading-text file_name">Angle Inch Soter Calibration List</h4>
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

                            <form class="prnt_lst_frm" action="{{ route('angle_calibration_list')}}" name="form1" id="form1" method="post">
                                <div class="row">
                                    @csrf

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($aisc_title as $value)
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
                                                    <label class="required">
                                                        Select Board Type
                                                    </label>
                                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="board_type" id="board_type" style="width: 90%">
                                                        <option value="">Select Board Type</option>
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

                                                    <a tabindex="5" class="save_button form-control" href="add_angle_calibration" role="button">
                                                        <l class="fa fa-plus"></l> Angle Inch Soter Calibration
                                                    </a>

                                                    @include('include/print_button')

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                </div><!-- end row -->
                            </form>


                            <form name="edit" id="edit" action="{{ route('edit_angle_calibration') }}" method="post">
                                @csrf
                                <input name="board_type_title" id="board_type_title" type="hidden">
                                <input name="width_to" id="width_to" type="hidden">
                                <input name="width_from" id="width_from" type="hidden">
                                <input name="angle_support" id="angle_support" type="hidden">
                                <input name="angle_calibration_id" id="angle_calibration_id" type="hidden">
                                <input name="board_type_id" id="board_type_id" type="hidden">

                            </form>

                            <form name="delete" id="delete" action="{{ route('delete_angle_calibration') }}" method="post">
                                @csrf
                                <input name="aisc_id" id="aisc_id" type="hidden">
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
                            <th scope="col" align="center" class="text-center align_center tbl_srl_30">
                                Board Type
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_15">
                                Width From
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_15">
                                Width To
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_15">
                                Angle Support
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Created By
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

                            <tr data-width_from="{{$data->aisc_width_from}}" data-width_to="{{$data->aisc_width_to}}" data-angle_support="{{$data->aisc_angle_support}}"
                                data-angle_calibration_id="{{$data->aisc_id}}" data-board_type_title="{{$data->bt_title}}" data-board_type_id="{{$data->aisc_board_type_id}}">
                                <td class="align_center text-center edit tbl_srl_4">
                                    {{$sr}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_30">
                                    {{$data->bt_title }}
                                </td>
                                <td class="align_left text-left edit tbl_txt_15">
                                    {{$data->aisc_width_from }}
                                </td>
                                <td class="align_left text-left edit tbl_txt_15">
                                    {{$data->aisc_width_to}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_15">
                                    {{$data->aisc_angle_support}}
                                </td>

                                @php
                                    $ip_browser_info= ''.$data->aisc_ip_adrs.','.str_replace(' ','-',$data->aisc_brwsr_info).'';
                                @endphp

                                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $data->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{$data->user_name}}
                                </td>
                                {{--                                        <td class="align_center hide_column">--}}
                                {{--                                            <a class="edit" style="cursor:pointer;">--}}
                                {{--                                                <i class="fa fa-edit"></i>--}}
                                {{--                                            </a>--}}
                                {{--                                        </td>--}}


                                <td class="align_right text-right hide_column tbl_srl_6">
                                    <a data-angle_calibration_id="{{$data->aisc_id}}" class="delete"  data-toggle="tooltip" data-placement="left"  title="" data-original-title="Are you sure?">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>



                                {{--                                        <td><input type="checkbox" data-id="{{ $data->aisc_id }}" name="status" class="js-switch" {{ $data->reg_disabled == 0 ?
                                'checked' : '' }}></td>--}}
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
                <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'board_type'=>$search_board_type ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        $('#board_type').select2();
        var base = '{{ route('angle_calibration_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery("#cancel").click(function () {

            $("#board_type").select2().val(null).trigger("change");
            $("#board_type > option").removeAttr('selected');

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

            var width_from = jQuery(this).parent('tr').attr("data-width_from");
            var width_to = jQuery(this).parent('tr').attr("data-width_to");
            var angle_support = jQuery(this).parent('tr').attr("data-angle_support");
            var angle_calibration_id = jQuery(this).parent('tr').attr("data-angle_calibration_id");
            var board_type_title = jQuery(this).parent('tr').attr("data-board_type_title");
            var board_type_id = jQuery(this).parent('tr').attr("data-board_type_id");


            jQuery("#width_from").val(width_from);
            jQuery("#width_to").val(width_to);
            jQuery("#angle_support").val(angle_support);
            jQuery("#angle_calibration_id").val(angle_calibration_id);
            jQuery("#board_type_id").val(board_type_id);
            jQuery("#board_type_title").val(board_type_title);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var angle_calibration_id = jQuery(this).attr("data-angle_calibration_id");

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
                    jQuery("#aisc_id").val(angle_calibration_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });

    </script>


@endsection

