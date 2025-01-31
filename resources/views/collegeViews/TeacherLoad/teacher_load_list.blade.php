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
                        <h4 class="text-white get-heading-text file_name">Teacher Load List</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            {{--                    <!-- <div class="search_form {{ ( !empty($search) || !empty($search_region) ) ? '' : 'search_form_hidden' }}"> --> --}}
            {{--                    --}}
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm"
                    action="{{ route('teacher_load_list') . (isset($restore_list) && $restore_list == 1 ? '?restore_list=1' : '') }}"
                    name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <label>
                                    All Data Search
                                </label>
                                <!-- start input box -->
                                {{-- <label> --}}
                                {{--    All Column Search --}}
                                {{-- </label> --}}
                                <input tabindex="1" autofocus type="search" list="browsers"
                                    class="inputs_up form-control" name="search" id="search"
                                    placeholder="All Data Search" value="{{ isset($search) ? $search : '' }}"
                                    autocomplete="off">
                                <datalist id="browsers">
                                    @foreach ($subject_title as $value)
                                        <option value="{{ $value }}">
                                    @endforeach
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div> <!-- left column ends here -->
                        <x-year-end-component search="{{$search_year}}"/>
                        <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 text-right form_controls">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('add_teacher_load') }}" />

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="edit" id="edit" action="{{ route('edit_teacher_load') }}" method="post">
                    @csrf
                    <input name="title" id="title" type="hidden">
                    {{-- <input name="remarks" id="remarks" type="hidden"> --}}
                    <input name="acctual_load" id="acctual_load" type="hidden">
                    <input name="appointment_load" id="appointment_load" type="hidden">
                    <input name="attendance_load" id="attendance_load" type="hidden">
                    <input name="tl_extra_load_amount" id="tl_extra_load_amount" type="hidden">
                    <input name="rc_id" id="rc_id" type="hidden">
                    <input name="tl_id" id="tl_id" type="hidden">
                </form>
                <form name="delete" id="delete" action="{{ route('delete_subject') }}" method="post">
                    @csrf
                    <input name="subject_id" id="subject_id" type="hidden">
                </form>
            </div>

            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                        <tr>
                            {{--                                    <th scope="col"class="tbl_srl_4"> --}}
                            {{--                                        Sr# --}}
                            {{--                                    </th> --}}
                            <th scope="col" class="tbl_srl_4">
                                ID
                            </th>
                            <th scope="col" class="tbl_txt_32">
                                Teacher
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Appointment Letter Load
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Acctual Load
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Attendance Load
                            </th>
                            <th scope="col" class="tbl_txt_12">
                                Extra Lecture Amount
                            </th>
                            <th scope="col" class="tbl_txt_20">
                                Branch
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Created By
                            </th>
                            <th scope="col" class="hide_column tbl_srl_6">
                                Enable
                            </th>
                            {{-- <th scope="col" class="hide_column tbl_srl_6">
                                Action
                            </th> --}}
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                            $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                            $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                            use App\User;
                        @endphp
                        @forelse($datas as $data)
                            <tr data-title="{{ $data->tl_teacher_id }}" data-acctual_load="{{ $data->tl_acctual_load }}"
                                data-appointment_load="{{ $data->tl_appointment_load }}"
                                data-attendance_load="{{ $data->tl_attendance_load }}"
                                data-tl_extra_load_amount="{{ $data->tl_extra_load_amount }}"
                                data-tl_id="{{ $data->tl_id }}" data-rc_id="{{ $data->rc_id }}">
                                <th scope="row">
                                    {{ $sr }}
                                </th>
                                {{-- <th scope="row" class="edit ">
                                    {{ $data->subject_id }}
                                </th> --}}
                                <td class="edit ">
                                    {{ $data->user_name }}
                                </td>

                                @php
                                    $ip_browser_info = '' . $data->subject_ip_adrs . ',' . str_replace(' ', '-', $data->subject_brwsr_info) . '';
                                @endphp
                                <td class="edit ">
                                    {{ $data->tl_appointment_load }}
                                </td>
                                <td class="edit ">
                                    {{ $data->tl_acctual_load }}
                                </td>
                                <td class="edit ">
                                    {{ $data->tl_attendance_load }}
                                </td>
                                <td class="edit ">
                                    @if ($data->tl_extra_load_amount == null)
                                        {{ $data->rc_extra_lecture_amount }}
                                    @else
                                        {{ $data->tl_extra_load_amount }}
                                    @endif
                                </td>
                                <td>
                                    {{ $data->branch_name }}
                                </td>
                                <td class="usr_prfl " data-usr_prfl="{{ $data->users->user_id }}"
                                    data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $data->users->user_name }}
                                </td>
                                {{--                                        <td class="hide_column"> --}}
                                {{--                                            <a class="edit" style="cursor:pointer;"> --}}
                                {{--                                                <i class="fa fa-edit"></i> --}}
                                {{--                                            </a> --}}
                                {{--                                        </td> --}}

                                <td class="text-center hide_column ">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($data->subject_disable_enable == 1) {
                                            echo 'checked="true"' . ' ' . 'value=' . $data->subject_disable_enable;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?> class="enable_disable"
                                            data-id="{{ $data->subject_id }}"
                                            {{ $data->subject_disable_enable == 1 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                {{-- <td class="text-center hide_column ">
                                    <a data-subject_id="{{ $data->subject_id }}" class="delete" data-toggle="tooltip"
                                        data-placement="left" title="" data-original-title="Are you sure?">
                                        <i class="fa fa-{{ $data->subject_delete_status == 1 ? 'undo' : 'trash' }}"></i>
                                    </a>
                                </td> --}}


                                {{--                                        <td><input type="checkbox" data-id="{{ $data->subject_id }}" name="status" class="js-switch" {{ $data->subject_disabled == 0 ? 'checked' : '' }}></td> --}}
                            </tr>
                            @php
                                $sr++;
                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center>
                                        <h3 style="color:#554F4F">No Teacher Load</h3>
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
        var base = '{{ route('subject_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function() {
            $('.enable_disable').change(function() {
                let status = $(this).prop('checked') === true ? 1 : 0;
                let subject_id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_subject') }}',
                    data: {
                        'status': status,
                        'subject_id': subject_id
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
            // var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var tl_extra_load_amount = jQuery(this).parent('tr').attr("data-tl_extra_load_amount");
            var rc_id = jQuery(this).parent('tr').attr("data-rc_id");
            var acctual_load = jQuery(this).parent('tr').attr("data-acctual_load");
            var appointment_load = jQuery(this).parent('tr').attr("data-appointment_load");
            var attendance_load = jQuery(this).parent('tr').attr("data-attendance_load");
            var tl_id = jQuery(this).parent('tr').attr("data-tl_id");

            jQuery("#title").val(title);
            // jQuery("#remarks").val(remarks);
            jQuery("#tl_extra_load_amount").val(tl_extra_load_amount);
            jQuery("#rc_id").val(rc_id);
            jQuery("#acctual_load").val(acctual_load);
            jQuery("#appointment_load").val(appointment_load);
            jQuery("#attendance_load").val(attendance_load);
            jQuery("#tl_id").val(tl_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function(event) {

            var subject_id = jQuery(this).attr("data-subject_id");

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
                    jQuery("#regId").val(subject_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>


@endsection
