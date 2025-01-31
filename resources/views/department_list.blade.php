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
                            <h4 class="text-white get-heading-text file_name">Department List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
            <!-- <div class="search_form {{ ( !empty($search) || !empty($search_region) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('search_department') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1" id="form1"
                          method="post">
                        <div class="row">
                            @csrf
                            <div class="form-group col-lg-2 col-md-9 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    {{--                                                    <label>--}}
                                    {{--                                                        All Column Search--}}
                                    {{--                                                    </label>--}}
                                    <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="All Data Search"
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach($dep_title as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->


                            <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 form_controls text-right">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                                <x-add-button tabindex="9" href="{{ route('departments.create') }}"/>

                                @include('include/print_button')

                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>


                        </div><!-- end row -->
                    </form>


                </div>

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
                            <th scope="col" class="tbl_txt_39">
                                Title
                            </th>
                            <th scope="col" class="tbl_txt_35">
                                Remarks
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" class="hide_column tbl_srl_6">
                                Enable
                            </th>
                            <th scope="col" class="hide_column tbl_srl_6">
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

                            <tr data-title="{{$data->dep_title}}" data-remarks="{{$data->dep_remarks}}" data-department_id="{{$data->dep_id}}">
                                <th scope="row" class="edit ">
                                    {{$sr}}
                                </th>
                                <td class="edit ">
                                    {{$data->dep_id}}
                                </td>
                                <td class="edit ">
                                    {{$data->dep_title}}
                                </td>
                                <td class="edit ">
                                    {{$data->dep_remarks }}
                                </td>

                                @php
                                    $ip_browser_info= ''.$data->dep_ip_adrs.','.str_replace(' ','-',$data->dep_brwsr_info).'';
                                @endphp

                                <td class="usr_prfl " data-usr_prfl="{{ $data->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{$data->user_name}}
                                </td>
                                <td class="text-center hide_column ">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($data->dep_disabled == 0) {
                                            echo 'checked="true"' . ' ' . 'value=' . $data->dep_disabled;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?>  class="enable_disable" data-id="{{$data->dep_id}}"
                                            {{ $data->dep_disabled == 0 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                <td class="text-center hide_column ">
                                    <form name="delete" id="delete" action="{{ route('departments.destroy', $data->dep_id) }}" method="post">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE"/>

                                        <button type="submit" class="delete" data-toggle="tooltip" data-placement="left" title="" data-original-title="Are you sure?">
                                            <i class="fa fa-{{$data->dep_delete_status == 1 ? 'undo':'trash'}}"></i>
                                        </button>
                                    </form>
                                </td>


                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h5 style="color:#554F4F">No Department</h5></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                    </div>
                    <div class="col-md-9 text-right">
                        <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search ])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('departments.index') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let depId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_department') }}',
                    data: {'status': status, 'dep_id': depId},
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>

    <script>
        jQuery("#cancel").click(function () {
            $("#search").val('');
        });
    </script>

    <script>

        jQuery(".edit").click(function () {
            let id = jQuery(this).parent('tr').attr("data-department_id"),

                {{--url = "{{ route('departments.edit'+ ['id'=>':id'] ) }}";--}}
                url = "departments/" + id + "/edit";
            {{--    url = url.replace(':id', id);--}}

                window.location = url;

        });


    </script>


@endsection

