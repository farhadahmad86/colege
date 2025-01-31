@extends('extend_index')

@section('content')
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet"> --}}
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Subject Weightage</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('student_attendance_list') }}"
                            role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div> <!-- invoice box start -->
            <form name="f1" class="f1" id="f1" action="{{ route('store_weightage') }}"
                method="post" onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Teacher
                            </label>
                            <select tabindex="4" autofocus name="teacher_id" class="inputs_up form-control" id="teacher_id"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Teacher">
                                <option value="">Select Teacher</option>

                                @foreach ($allteachers as $allteacher)
                                    <option value="{{ $allteacher->user_id }}">
                                        {{ $allteacher->user_name }}
                                    </option>
                                @endforeach

                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="table-responsive" id="printTable">
                        <table class="table table-bordered table-sm" id="category_dynamic_table">
                            <!-- product table box start -->
                            <thead>
                                <tr>
                                    <th class="text-center tbl_txt_5">Sr#</th>
                                    <th class="text-center tbl_txt_5">Subjects</th>
                                    <th class="text-center tbl_txt_40">Weightage</th>
                                </tr>
                            </thead>
                            <tbody id="table_body">

                            </tbody>
                        </table>
                    </div><!-- product table box end -->


                </div>
                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                        <button tabindex="1" type="submit" name="save" id="save"
                            class="save_button btn btn-sm btn-success">
                            <i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </div>
            </form>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection

@section('scripts')
    <script type="text/javascript">
        var base = '{{ route('add_weightage') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    required input validation --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('input[type="checkbox"]').change(function() {
                if ($(this).is(':checked')) {
                    $('input[type="checkbox"]').not(this).prop('checked', false);
                }
            });
        });

        function checkForm() {
            let attendance_date = document.getElementById("attendance_date"),
                validateInputIdArray = [
                    attendance_date.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    <script>
        $('#teacher_id').change(function() {
            var teacher_id = $(this).val();
            $.ajax({
                url: '/get_allsubjects',
                type: 'get',
                datatype: 'text',
                data: {
                    'teacher_id': teacher_id
                },
                success: function(data) {
                    console.log(data);
                    $('#table_body').html("");
                    var std_sr = 1;
                    var subject = '';
                    data.forEach(element => {
                        subject +=
                            `<tr>
                                <td class="tbl_srl_5" >${std_sr++}</td>
                                <td class="tbl_srl_5"  value="${element.subject_id}">${element.subject_name} <input type="hidden" name="subject_id[]" id="subject_id" value="${element.subject_id}"> </td>
                                <td class="tbl_srl_40"><input type="text" name="weightage[]" id="weightage" style="width:100%"></td>
                            </tr>`;
                    });
                    $('#table_body').html(subject);
                }
            })
        });
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">
        jQuery("#teacher_id").select2();
    </script>
@endsection
