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
                        <h4 class="text-white get-heading-text file_name">Student Dashboard</h4>
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
                      action="{{ route('student_dashboard') }}"
                      name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <label>Search</label>
                                <input tabindex="1" autofocus type="search" list="browsers"
                                       class="inputs_up form-control" name="search" id="search"
                                       placeholder="All Data Search" value="{{ isset($search) ? $search : '' }}"
                                       autocomplete="off">
                                <datalist id="browsers">
                                    @foreach ($student_title as $value)
                                        <option value="{{ $value }}">
                                    @endforeach
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div> <!-- left column ends here -->
                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <x-class-component tabindex="9" search="{{ $search_class }}" id="class" name="class"/>
                        </div> <!-- left column ends here -->
                        <div class="form-group col-lg-1 col-md-1 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <label>Section</label>
                                <select class="inputs_up form-control" name="section" id="section">
                                    <option value="">Select Section</option>
                                    @foreach($sections as $section)
                                        <option value="{{$section->cs_id}}" {{$search_section == $section->cs_id ? 'selected':''}}>{{$section->cs_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> <!-- left column ends here -->

                        <div class="form-group col-lg-1 col-md-1 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <label>Status</label>
                                <select class="inputs_up form-control" name="status" id="student_status">
                                    <option value="">Select Status</option>
                                    <option value="1" {{$search_status == 1 ? 'selected':''}}>Active</option>
                                    <option value="2" {{$search_status == 2 ? 'selected':''}}>Graduate</option>
                                    <option value="3" {{$search_status == 3 ? 'selected':''}}>Stuck Off</option>
                                    <option value="4" {{$search_status == 4 ? 'selected':''}}>Warning</option>
                                </select>
                            </div>
                        </div> <!-- left column ends here -->
                        <div class="form-group col-lg-1 col-md-1 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <label>Roll No</label>
                                <input type="text" class="inputs_up form-control" name="roll_no" id="roll_no" value="{{$search_roll_no}}" placeholder="Roll No">
                            </div>
                        </div> <!-- left column ends here -->
                        <x-year-end-component search="{{$search_year}}"/>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-right form_controls mt-3">
                        @include('include.clear_search_button')
                        <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('add_student') }}"/>

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="edit" id="edit" action="{{ route('edit_student') }}" method="post">
                    @csrf
                    <input name="title" id="title" type="hidden">
                    <input name="student_id" id="student_id" type="hidden">
                </form>
                <form name="transfer" id="transfer" action="{{ route('student_transfer') }}" method="post">
                    @csrf
                    <input name="student_id" id="transfer_student_id" type="hidden">
                </form>
                <form name="package" id="package" action="{{ route('create_installments') }}" method="post">
                    @csrf
                    <input name="title" id="name" type="hidden">
                    <input name="student_id" id="std_id" type="hidden">
                </form>
                <form name="delete" id="delete" action="{{ route('delete_student') }}" method="post">
                    @csrf
                    <input name="id" id="id" type="hidden">
                </form>
            </div>

            <div class="row student-dashboard-row">
                <style>
                    .student-card p {
                        margin-bottom: 1px;
                    }

                    .student-card .badge {
                        padding: 0.25em 0.4em;
                        font-size: 75%;
                        color: #fff;
                    }

                    .pointer {
                        cursor: pointer;
                    }
                </style>
                @foreach ($datas as $student)
                    <div class="col-lg-3 col-md-4 col-sm-12 mb-2">
                        <div class="card student-card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-4" data-student_id="{{ $student->id }}" data-title="{{ $student->full_name }}">
                                        <div class="package" data-toggle="tooltip"
                                             data-placement="left" title="" data-original-title="Are you sure want to make package?"><img class="card-thumb" src="{{$student->profile_pic}}" alt="">
                                        </div>
                                        {{--                                        {{$student->full_name[0]}}--}}
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-8">
                                        <h5 data-toggle="tooltip" title="Edit Parent" class="card-text">
                                            <a style="color: black;" href="#">{{$student->full_name}}</a>
                                        </h5>
                                        <p><b>Reg #:</b> {{$student->registration_no}}</p>
                                        <p>{{$student->father_name}}</p>
                                        <p>{{$student->class_name}}</p>
                                        <p><b>Roll No:</b> {{$student->roll_no}} &nbsp; <b>Section:</b> {{$student->cs_name}} </p>
                                        <p><b>Group:</b> {{$student->ng_name}}</p>
                                        <p><i class="fa fa-phone" aria-hidden="true"></i><a href="tel:+921234567">{{$student->contact}}</a>, <a href="tel:+921234567">{{$student->parent_contact}}</a>
                                        </p>
                                        <p><b>Status:</b> {{$student->student_disable_enable == 1 ? 'Active': 'De-Active'}}</p>
                                        <p><b>Status:</b> <span class="badge rounded-pill bg-{{$student->status == 1 ? 'info': ($student->status == 3 ? 'danger': ($student->status ==
                                        2 ? 'success':'warning'))}} text-white">

                                            {{$student->status == 1 ? 'Active': ($student->status == 3 ? 'Stuck Off': ($student->status == 2 ? 'Graduate':'Warning'))}}</span></p>
                                        <p><b>Branch:</b> {{$student->branch_name}}</p>
                                        <p><b>Transport:</b> {{$student->transport}}</p>

                                        <p data-title="{{ $student->full_name }}" data-student_id="{{ $student->id }}">
                                            @if($student->status != 3)
                                                <span class="badge rounded-pill bg-primary edit pointer">Edit</span>
                                                <span class="badge rounded-pill bg-success pointer view" data-id="{{ $student->id }}">Status</span>
                                                <span class="badge rounded-pill bg-danger transfer pointer">Transfer</span>
                                            @else
                                                <span class="badge rounded-pill bg-success pointer">{{ $student->status ==3 ? 'Stuck Off':''}}</span>
                                            @endif

                                            @if(!empty($student->form_pdf))
                                                   <a href="{{$student->form_pdf}}"> <span class="badge rounded-pill bg-info transfer pointer">PDF</span></a>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-md-3">
                    <span>Showing {{ $datas->firstItem() }} - {{ $datas->lastItem() }} of {{ $datas->total() }}</span>
                </div>
                <div class="col-md-9 text-right">
                    <span
                        class="hide_column">{{ $datas->appends(['search' => $search, 'class'=>$search_class, 'section'=>$search_section, 'student_status'=>$search_status, 'roll_no'=>$search_roll_no ,'year'=>$search_year])
                        ->links() }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Change Status</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form name="f1" class="f1" id="f1" action="{{ route('change_student_status') }}"
                      onsubmit="return checkForm()" style="width: 100%" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="student_id" id="current_student_id">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <label class="required">Status</label>
                                    <select name="status" id="status" class="inputs_up form-control" data-msg-required="Select Status" data-rule-required="true">
                                        <option value="" selected>Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="2">Graduate</option>
                                        <option value="3">Stuck Off</option>
                                        <option value="4">Warning</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="required">Date</label>
                                    <input tabindex="3" type="text" name="date" id="date" class="inputs_up form-control datepicker1" autocomplete="off" value="" placeholder="Date ......"
                                           data-msg-required="Select Date" data-rule-required="true">
                                </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <label class="required">Reason</label>
                                    <select name="reason" id="reason" class="inputs_up form-control" data-msg-required="Select Reason" data-rule-required="true">
                                        <option value="">Select Reason</option>
                                        @foreach($reasons as $reason)
                                            <option value="{{$reason->cssr_id}}">{{$reason->cssr_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <x-upload-image title="File Upload"/>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <label class="required">Detail</label>
                                    <textarea name="remarks" id="remarks" class="inputs_up form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="row">
                                <div class="col-lg-10 col-md-10 col-sm-10">
                                    <div class="form_controls">
                                        <button class="btn btn-default btn-sm form-control cancel_button"
                                                data-dismiss="modal">
                                            <i class="fa fa-times"></i> Cancel
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                    <div class="form_controls">
                                        <button type="submit" name="save" id="save" class="invoice_frm_btn btn btn-sm btn-success">
                                            <i class="fa fa-floppy-o"></i> Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('student_dashboard') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}
    <script>
        function checkForm() {
            let status = document.getElementById("status"),
                date = document.getElementById("date"),
                reason = document.getElementById("reason"),
                validateInputIdArray = [
                    status.id,
                    date.id,
                    reason.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {

                jQuery(".pre-loader").fadeToggle("medium");
            }
            $('#save').prop('disabled', false);
            return validateInventoryInputs(validateInputIdArray);
        }

        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function () {

            jQuery("#status").val("");
            jQuery("#date").val("");
            jQuery("#reason").val("");
            jQuery("#remarks").val("");

            var id = jQuery(this).attr("data-id");
            jQuery("#current_student_id").val(id);
            $('#myModal').modal({
                show: true
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#student_status').select2();
            $('#status').select2();
            $('#section').select2();
            $('#reason').select2();
            $('.enable_disable').change(function () {

                let status = $(this).prop('checked') === true ? 1 : 0;
                let stdId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_student') }}',
                    data: {
                        'status': status,
                        'id': stdId
                    },
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
            $("#roll_no").val('');
            $("#class").select2().val(null).trigger("change");
            $("#class > option").removeAttr('selected');
            $("#section").select2().val(null).trigger("change");
            $("#section > option").removeAttr('selected');
            $("#student_status").select2().val(null).trigger("change");
            $("#student_status > option").removeAttr('selected');
        });
    </script>

    <script>
        jQuery(".edit").click(function () {

            var title = jQuery(this).parent('p').attr("data-title");
            var student_id = jQuery(this).parent('p').attr("data-student_id");
            console.log(title, student_id);
            jQuery("#title").val(title);
            jQuery("#student_id").val(student_id);
            jQuery("#edit").submit();
        });
        jQuery(".transfer").click(function () {
            var student_id = jQuery(this).parent('p').attr("data-student_id");
            jQuery("#transfer_student_id").val(student_id);
            jQuery("#transfer").submit();
        });

        jQuery(".package").click(function () {

            var title = jQuery(this).parent('div').attr("data-title");
            var student_id = jQuery(this).parent('div').attr("data-student_id");
            console.log(title, student_id);
            jQuery("#name").val(title);
            jQuery("#std_id").val(student_id);
            jQuery("#package").submit();
        });

        $('.delete').on('click', function (event) {

            var student_id = jQuery(this).attr("data-student_id");

            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
            }).then(function (result) {

                if (result.value) {
                    jQuery("#id").val(student_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>


@endsection
