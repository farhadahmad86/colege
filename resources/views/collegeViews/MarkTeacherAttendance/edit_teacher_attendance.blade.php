@extends('extend_index')

@section('content')
    <div class="row">

        <form action="{{ route('update_lecturer_attendance') }}" method="post">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">


                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                    @csrf
                    <div class="form_header">
                        <!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 tabindex="-1" class="text-white get-heading-text">Edit Attendance</h4>
                            </div>
                            <div class="list_btn">
                                <a tabindex="-1" class="btn list_link add_more_button"
                                    href="{{ route('bank_receipt_voucher_list') }}" role="button">
                                    <i class="fa fa-list"></i> view list
                                </a>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->
                    <div class="invoice_row">
                        <!-- invoice column start -->
                        <div class="pro_tbl_con for_voucher_tbl col-lg12">
                            <!-- product table container start -->
                            <div class="table-responsive pro_tbl_bx">
                                <!-- product table box start -->
                                <table tabindex="-1" class="table table-bordered table-sm"id="category_dynamic_table">
                                    <thead style="background-color: #33A6D4;color: #fff;">
                                        <tr>
                                            <th class="text-center tbl_srl_10">
                                                Sr#
                                            </th>
                                            <th class="text-center tbl_srl_20">
                                                Department
                                            </th>
                                            <th class="text-center tbl_srl_20">
                                                Section
                                            </th>
                                            <th class="text-center tbl_srl_20">
                                                Teacher Name
                                            </th>
                                            <th class="text-center tbl_srl_10">
                                                Subject
                                            </th>
                                            <th class="text-center tbl_srl_20">
                                                Attendance
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody id="table_body">
                                        <tr>

                                        </tr>
                                    </tbody>
                                </table>
                            </div><!-- product table box end -->
                        </div><!-- product table container end -->
                    </div><!-- invoice row end -->
                    <div class="invoice_row">
                        <!-- invoice row start -->
                        <div class="invoice_col basis_col_100">
                            <!-- invoice column start -->
                            <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns">
                                <!-- invoice column box start -->
                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                    <button tabindex="1" type="submit" name="save1" id="save1"
                                        class="save_button btn btn-sm btn-success"> Save
                                    </button>
                                    <span id="demo28" class="validate_sign"></span>
                                </div>
                            </div><!-- invoice column box end -->
                        </div><!-- invoice column end -->
                    </div><!-- invoice row end -->
                </div><!-- invoice content end -->
            </div><!-- invoice scroll box end -->
        </form>
    </div><!-- row end -->
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let account = document.getElementById("account"),
                total_amount = document.getElementById("total_amount"),
                validateInputIdArray = [
                    account.id,
                    total_amount.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script>
        jQuery(document).ready(function() {
            let array = JSON.parse('{!! json_encode($attendance_items) !!}');
            var counter = 1;
            $.each(array, function(index, value) {
                console.log(value);
                jQuery("#table_body").append(
                    `<tr id="${counter}" class="edit_update">
                        <td class="text-center tbl_srl_10">${counter}</td>
                        <td class="text-center tbl_srl_20"><input type="hidden" name="lai_id[${counter}]" value="${value.lai_id}" id="a_${counter}" readonly>
                            <input type="hidden" name="lai_la_id[${counter}]" value="${value.lai_la_id}" id="a_${counter}" readonly>
                            <input type="hidden" name="dep_id[${counter}]" value="${value.lai_department_id}" id="a_${counter}" readonly>
                            ${value.dep_title}
                        </td>
                        <td class="text-center tbl_srl_20">
                            <input type="hidden" name="section_id[${counter}]" value="${value.lai_section_id}" id="a_${counter}" readonly>
                            ${value.cs_name}
                        </td>
                        <td class="text-center tbl_srl_20">
                            <input type="hidden" name="emp_id[${counter}]" value="${value.lai_emp_id}" id="a_${counter}" readonly>
                            ${value.employee}
                        </td>
                        <td class="text-center tbl_srl_10">
                            <input type="hidden" name="subject_id[${counter}]" value="${value.lai_subject_id}" id="a_${counter}" readonly>
                            ${value.subject_name}
                        </td>
                        <td class="text-center tbl_srl_20">
                            <input type="radio" name="lec_attendance[${counter}]" class="lec_attendance" id="P_${counter}" value="P" ${value.lai_attendance === 'P' ? 'checked' : ''}>
                            P
                            <input type="radio" name="lec_attendance[${counter}]" class="lec_attendance" id="A_${counter}" value="A" ${value.lai_attendance === 'A' ? 'checked' : ''}>
                            A
                            <input type="radio" name="lec_attendance[${counter}]" class="lec_attendance" id="L_${counter}" value="L" ${value.lai_attendance === 'L' ? 'checked' : ''}>
                            L
                            <input type="radio" name="lec_attendance[${counter}]" class="lec_attendance" id="S.L_${counter}" value="S.L" ${value.lai_attendance === 'S.L' ? 'checked' : ''}>
                            S.L
                        </td>
                    </tr>
                `);
                counter++;
            });
        });
    </script>

    <script>
        jQuery(document).ready(function() {
            // Initialize select2
            jQuery("#account_code").select2();
            jQuery("#account_name").select2();
            jQuery("#account").select2();
            jQuery("#posting_reference").select2();
        });
    </script>
@endsection
