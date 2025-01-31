@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex=-1 class="text-white get-heading-text">Fee Voucher</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex=-1 class="btn list_link add_more_button" href="{{ 'fee_voucher_list' }}" role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->


            <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher">
                <!-- invoice container start -->
                <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate">
                    <!-- invoice box start -->

                    <form id="f1" action="{{ route('submit_fee_voucher') }}" method="post"
                          onsubmit="return checkForm()" autocomplete="off">
                        @csrf
                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                            <!-- invoice scroll box start -->
                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                <!-- invoice content start -->

                                <div class="invoice_row">
                                    <!-- invoice row start -->

                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label class="required">
                                                Class
                                                <a href="{{ route('add_class') }}" role="button"
                                                   class="add_btn" TARGET="_blank" data-container="body"
                                                   data-toggle="popover" data-trigger="hover"
                                                   data-placement="bottom" data-html="true"
                                                   data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <a class="add_btn" id="refresh_class" data-container="body"
                                                   data-toggle="popover" data-trigger="hover"
                                                   data-placement="bottom" data-html="true"
                                                   data-content="{{ config('fields_info.about_form_fields.refresh.description') }}">
                                                    <i class="fa fa-refresh"></i>
                                                </a>
                                            </label>
                                            <select tabindex="1" name="class" class="inputs_up form-control"
                                                    id="class" data-rule-required="true"
                                                    data-msg-required="Please Enter Class">
                                                <option value="0">Select Class</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->class_id }}">{{ $class->class_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign"> </span>
                                        </div>
                                        <!-- end input box -->
                                    </div>
                                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label class="required">
                                                Section
                                            </label>
                                            <select tabindex="2"  name="section" class="form-control required" id="section"
                                                     data-rule-required="true" data-msg-required="Please Enter Section">
                                            </select>
                                            <span id="demo1" class="validate_sign"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label class="required">
                                                Month</label>
                                            <select class="inputs_up form-control" name="month" id="month" data-rule-required="true" data-msg-required="Please Enter Month">
                                                <option value="">Select Month</option>
                                            @foreach($months as $month)
                                                <option value="{{$month}}">{{$month}}</option>
                                            @endforeach
                                            </select>
                                        </div><!-- end input box -->
                                    </div>
                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Issue Date
                                            </label>
                                            <input tabindex="5" type="text" name="issue_date" id="issue_date"
                                                   class="inputs_up form-control datepicker1" data-rule-required="true" data-msg-required="Please Issue Date" autocomplete="off"
                                                   value=""
                                                   placeholder="Issue Date ......"/>
                                            <span id="demo1" class="validate_sign" style="float: right !important">
                                        </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Due Date
                                            </label>
                                            <input tabindex="5" type="text" name="due_date" id="due_date"
                                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                                   value="" data-rule-required="true" data-msg-required="Please Enter Due Date"
                                                   placeholder="Due Date ......"/>
                                            <span id="demo1" class="validate_sign" style="float: right !important">
                                        </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Total Students
                                            </label>
                                            <input tabindex="2" type="hidden" name="total_students"
                                                   id="total_students" class="inputs_up form-control" autocomplete="off"
                                                   value="" data-rule-required="true"
                                                   data-msg-required="Section students must be Greater than 0"
                                                   placeholder="">
                                            <span id="total_std" class="total_std"
                                                  style="margin-left: 50px; color: red; font-size: 40px">
                                            </span>
                                        </div>
                                    </div>

                                </div><!-- invoice row end -->

                                <div class="invoice_row">
                                    <!-- invoice row start -->
                                    <div class="invoice_col col-lg-12">
                                        <!-- invoice column start -->
                                        <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns">
                                            <!-- invoice column box start -->
                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                <button tabindex="8" type="submit" name="save" id="save"
                                                        class="invoice_frm_btn btn btn-sm btn-success">
                                                    <i class="fa fa-floppy-o"></i> Save
                                                </button>
                                                <span id="demo28" class="validate_sign"></span>
                                            </div>
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->
                                </div><!-- invoice row end -->
                            </div><!-- invoice content end -->
                        </div><!-- invoice scroll box end -->
                    </form>
                </div><!-- invoice box end -->
            </div><!-- invoice container end -->
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let class_id = document.getElementById("class"),
                section = document.getElementById("section"),
                month = document.getElementById("month"),
                issue_date = document.getElementById("issue_date"),
                due_date = document.getElementById("due_date"),
                total_students = document.getElementById("total_students"),
                validateInputIdArray = [
                    class_id.id,
                    section.id,
                    month.id,
                    issue_date.id,
                    due_date.id,
                    total_students.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);
            if(check == true){
                jQuery(".pre-loader").fadeToggle("medium");
            }
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    {{--    @if (Session::get('bp_id')) --}}
    {{--        <script> --}}
    {{--            jQuery("#table_body").html(""); --}}
    {{--            var id = '{{ Session::get('bp_id') }}'; --}}
    {{--            $(".modal-body").load('{{ url('bank_payment_items_view_details/view/') }}/' + id, function() { --}}
    {{--                $("#myModal").modal({ --}}
    {{--                    show: true --}}
    {{--                }); --}}
    {{--            }); --}}
    {{--        </script> --}}
    {{--    @endif --}}


    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#class").select2();
            jQuery("#section").select2();
            jQuery("#month").select2();
        });
        jQuery("#month").change(function () {
            let month = $(this).val();
            let section_id = $('#section').val();
            let class_id = $('#class').val();
            if (class_id != '' && section_id != '' && month != '') {
                get_student(class_id, section_id, month)
            }
        });
        jQuery("#section").change(function () {
            let class_id = $('#class').val();
            let section_id = $(this).val();
            let month = $('#month').val();
            if (class_id != '' && section_id != '' && month != '') {
                get_student(class_id, section_id, month)
            }
        });

        function get_student(class_id, section_id, month) {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_students_for_fee",
                data: {
                    class_id: class_id,
                    section_id: section_id,
                    month: month
                },
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    jQuery("#total_students_alert").html(" ");
                    jQuery("#total_std").html(" ");
                    jQuery("#total_students").val("");
                    jQuery("#total_std").append(data.students);
                    if (data.students > 0) {
                        jQuery("#total_students").val(data.students);
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        };
    </script>
    <script>
        $('#class').change(function() {
            var class_id = $(this).val();
            $.ajax({
                url: '/get_groups',
                type: 'get',
                datatype: 'text',
                data: {
                    'class_id': class_id
                },
                success: function(data) {
                    console.log(data);
                    var groups = '<option selected disabled hidden>Choose Groups</option>';
                    var sections = '<option selected disabled hidden>Choose Section</option>';

                    $.each(data.section, function(index, items) {

                        sections +=
                            `<option value="${items.cs_id}"> ${items.cs_name} </option>`;


                    });
                    $('#section').html(sections);
                }
            })
        });
    </script>
@endsection
