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
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text file_name">Group List</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm"
                      action="{{ route('new_group_list') }}"
                      name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <label>
                                    All Data Search
                                </label>
                                <input tabindex="1" autofocus type="search" list="browsers"
                                       class="inputs_up form-control" name="search" id="search"
                                       placeholder="All Data Search" value="{{ isset($search) ? $search : '' }}"
                                       autocomplete="off">
                                <datalist id="browsers">
                                    @foreach ($groups_title as $value)
                                        <option value="{{ $value }}">
                                    @endforeach
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div> <!-- left column ends here -->
                            <x-year-end-component search="{{$search_year}}"/>
                        <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 text-right form_controls mt-2">
                        @include('include.clear_search_button')
                        <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('create_group') }}" />

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="edit" id="edit" action="{{ route('edit_new_group') }}" method="post">
                    @csrf
                    <input name="title" id="title" type="hidden">
                    {{-- <input name="remarks" id="remarks" type="hidden"> --}}
                    <input name="group_id" id="group_id" type="hidden">
                </form>
                <form name="delete" id="delete" action="{{ route('delete_new_group') }}" method="post">
                    @csrf
                    <input name="group_id" id="group_id" type="hidden">
                </form>
            </div>

            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                    <tr>
                        <th scope="col" class="tbl_srl_4">
                            Sr#
                        </th>
                        <th scope="col" class="tbl_txt_40">
                            Title
                        </th>
                        <th scope="col" class="tbl_txt_40">
                            Branch
                        </th>
                        <th scope="col" class="tbl_txt_11">
                            Created By
                        </th>
{{--                        <th scope="col" class="hide_column tbl_srl_6">--}}
{{--                            Enable--}}
{{--                        </th>--}}
                    </tr>
                    </thead>

                    <tbody>
                    @php
                        $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                        $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                        $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                        $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                    @endphp
                    @forelse($datas as $data)
                        <tr data-title="{{ $data->ng_name }}" data-group_id="{{ $data->ng_id }}">
                            <th scope="row">
                                {{ $sr }}
                            </th>
                            <td class="edit">
                                {{ $data->ng_name }}
                            </td>
                            <td class="edit">
                                {{ $data->branch_name }}
                            </td>

                            @php
                                $ip_browser_info = '' . $data->ngp_ip_adrs . ',' . str_replace(' ', '-', $data->ng_brwsr_info) . '';
                            @endphp

                            <td class="usr_prfl " data-usr_prfl="{{ $data->user_id }}"
                                data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{ $data->user_name }}
                            </td>
{{--                            <td class="text-center hide_column ">--}}
{{--                                <label class="switch">--}}
{{--                                    <input type="checkbox" <?php if ($data->ng_disable_enable == 1) {--}}
{{--                                        echo 'checked="true"' . ' ' . 'value=' . $data->ng_disable_enable;--}}
{{--                                    } else {--}}
{{--                                        echo 'value=DISABLE';--}}
{{--                                    } ?> class="enable_disable"--}}
{{--                                           data-id="{{ $data->ng_id }}"--}}
{{--                                        {{ $data->ng_disable_enable == 1 ? 'checked' : '' }}>--}}
{{--                                    <span class="slider round"></span>--}}
{{--                                </label>--}}
{{--                            </td>--}}

                            {{-- <td class="text-center hide_column ">
                                <a data-group_id="{{ $data->group_id }}" class="delete" data-toggle="tooltip"
                                    data-placement="left" title="" data-original-title="Are you sure?">
                                    <i class="fa fa-{{ $data->group_delete_status == 1 ? 'undo' : 'trash' }}"></i>
                                </a>
                            </td> --}}
                        </tr>
                        @php
                            $sr++;
                            !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center>
                                    <h3 style="color:#554F4F">No Group</h3>
                                </center>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <span>Showing {{ $datas->firstItem() }} - {{ $datas->lastItem() }} of {{ $datas->total() }}</span>
                </div>
                <div class="col-md-9 text-right">
                    <span
                        class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search])->links() }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('new_group_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function() {
            $('.enable_disable').change(function() {
                let status = $(this).prop('checked') === true ? 1 : 0;
                let group_id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_groups') }}',
                    data: {
                        'status': status,
                        'group_id': group_id
                    },
                    success: function(data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>

    <script>
        jQuery("#cancel").click(function() {
            $("#search").val('');
        });
    </script>

    <script>
        jQuery(".edit").click(function() {

            var title = jQuery(this).parent('tr').attr("data-title");
            var group_id = jQuery(this).parent('tr').attr("data-group_id");
            jQuery("#title").val(title);
            jQuery("#group_id").val(group_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function(event) {

            var group_id = jQuery(this).attr("data-group_id");

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
                    jQuery("#group_id").val(group_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>


@endsection
