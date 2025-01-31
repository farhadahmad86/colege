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
                        <h4 class="text-white get-heading-text file_name">Subject Outline List</h4>
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
                    action="{{ route('course_outline_list') . (isset($restore_list) && $restore_list == 1 ? '?restore_list=1' : '') }}"
                    name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label>
                                Select Subject
                            </label>
                            <select tabindex="1" autofocus name="search" class="inputs_up form-control required"
                                id="search" autofocus data-rule-required="true" data-msg-required="Please Enter Class">
                                <option value="">Select Subject</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->subject_id }}"
                                        {{ $subject->subject_id == $search ? 'selected' : '' }}>
                                        {{ $subject->subject_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label>
                                Select Group
                            </label>
                            <select tabindex="1" autofocus name="subject_group" class="inputs_up form-control required"
                                id="subject_group" autofocus data-rule-required="true" data-msg-required="Please Enter Class">
                                <option readonly disabled selected>Select Group</option>
                                <option value="1" {{$subject_group == 1 ? 'selected' : ''}}>First Year</option>
                                <option value="2" {{$subject_group == 2 ? 'selected' : ''}}>Second Year</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 text-right form_controls mt-3">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('create_outline') }}" />

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="edit" id="edit" action="{{ route('edit_outlines') }}" method="post">
                    @csrf
                    <input name="co_id" id="co_id" type="hidden">
                    <input name="subject_id" id="subject_id" type="hidden">
                    <input name="group_id" id="group_id" type="hidden">
                    <input name="outlines" id="outlines" type="hidden">
                    <input name="ch_name" id="ch_name" type="hidden">
                    <input name="chp_no" id="chp_no" type="hidden">
                </form>
            </div>

            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">
                                Sr#
                            </th>
                            <th scope="col" class="tbl_srl_8">
                                Subject Name
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Chapter No#
                            </th>
                            <th scope="col" class="tbl_txt_20">
                                Chapter Name</th>
                            <th scope="col" class="tbl_txt_50">
                                Outlines
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By</th>
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
                            <tr data-id='{{ $data->co_id }}'data-ch_name='{{ $data->co_chp_name }}'
                            data-chp_no='{{ $data->co_chp_no }}'data-outlines='{{ $data->co_outlines }}'
                            data-group_id='{{ $data->co_group_id }}' data-subject_id='{{ $data->co_subject_id }}'>
                                <th scope="row">
                                    {{ $sr }}
                                </th>
                                <td  class="edit text-center">
                                    {{ $data->subject_name }}
                                </td>
                                <td  class="edit text-center">
                                    {{ $data->co_chp_no }}
                                </td>
                                <td  class="edit text-center" >
                                    {{ $data->co_chp_name }}
                                </td>
                                @php
                                    $outlines = json_decode($data->co_outlines);
                                @endphp
                                <td class="edit text-center">
                                    @if ($outlines)
                                        @foreach ($outlines as $key => $value)
                                            {{ $value->outline }}
                                            <br />
                                        @endforeach
                                    @endif
                                </td>
                                <td  class="edit text-center">
                                    {{ $data->user_name }}
                                </td>
                            </tr>
                            @php
                                $sr++;
                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center>
                                        <h3 style="color:#554F4F">No Outlines</h3>
                                    </center>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- <div class="row">
                <div class="col-md-3">
                    <span>Showing {{ $datas->firstItem() }} - {{ $datas->lastItem() }} of {{ $datas->total() }}</span>
                </div>
                <div class="col-md-9 text-right">
                    <span
                        class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search])->links() }}</span>
                </div>
            </div> --}}
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Student Attedance List</h4>
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
        var base = '{{ route('course_outline_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function() {
            $('.enable_disable').change(function() {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let regId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_region') }}',
                    data: {
                        'status': status,
                        'regId': regId
                    },
                    success: function(data) {
                        console.log(data.message);
                    }
                });
            });
        });
        jQuery("#search").select2();
        jQuery("#subject_group").select2();
    </script>
    <script>
        jQuery("#cancel").click(function() {
            $("#search").val('');
            $("#subject_group").val('');

        });
    </script>

    <script>
        jQuery(".edit").click(function() {

            var co_id = jQuery(this).parent('tr').attr("data-id");
            var subject_id = jQuery(this).parent('tr').attr("data-subject_id");
            var group_id = jQuery(this).parent('tr').attr("data-group_id");
            var outlines = jQuery(this).parent('tr').attr("data-outlines");
            var ch_name = jQuery(this).parent('tr').attr("data-ch_name");
            var chp_no = jQuery(this).parent('tr').attr("data-chp_no");
            jQuery("#co_id").val(co_id);
            jQuery("#subject_id").val(subject_id);
            jQuery("#group_id").val(group_id);
            jQuery("#outlines").val(outlines);
            jQuery("#ch_name").val(ch_name);
            jQuery("#chp_no").val(chp_no);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function(event) {

            var class_id = jQuery(this).attr("data-class_id");

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
                    jQuery("#class_id").val(class_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>
    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function() {

            // jQuery(".pre-loader").fadeToggle("medium");
            jQuery("#table_body").html("");

            var class_id = jQuery(this).attr("data-class_id");
            var cs_id = jQuery(this).attr("data-cs_id");
            var date = jQuery(this).attr("data-std_att_created_at")
            $(".modal-body").load('{{ url('class_attendance_view_detail/view/') }}/' + class_id + '/' +
                cs_id + '/' + date,
                function() {
                    // jQuery(".pre-loader").fadeToggle("medium");
                    $("#myModal").modal({
                        show: true
                    });
                });
        });
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>


@endsection
