@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex=-1 class="text-white get-heading-text">Fee Paid Voucher</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex=-1 class="btn list_link add_more_button" href="{{ 'fee_paid_voucher_list' }}" role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->

            <div class="excel_con gnrl-mrgn-pdng gnrl-blk">
                <div class="excel_box gnrl-mrgn-pdng gnrl-blk">
                    <div class="excel_box_hdng gnrl-mrgn-pdng gnrl-blk">
                        <h2 class="gnrl-blk gnrl-mrgn-pdng gnrl-font-bold">
                            Upload Fee Voucher Excel File
                        </h2>
                    </div>
                    <div class="excel_box_content gnrl-mrgn-pdng gnrl-blk">

                        <form id="f1" action="{{ route('submit_fee_paid_voucher_excel') }}" method="post" enctype="multipart/form-data" onsubmit="return checkForm()">
                            @csrf
                            <div class="invoice_col form-group col-lg-12 col-md-12 col-sm-12">
                                <x-account-name-component tabindex="1" name="account" class="bank_voucher"
                                                          id="account" title="Bank" href="bank_account_registration" body="1"/>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Select Excel File
                                        </label>
                                        <input tabindex="100" type="file" name="add_fee_excel" id="add_fee_excel" class="inputs_up form-control-file form-control height-auto"
                                               accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                    </div><!-- end input box -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <a href="{{ url('public/sample/student_fee/add_student_fee_pattern.xlsx') }}" tabindex="-1" type="reset" class="cancel_button btn btn-sm btn-info">
                                        Download Sample Pattern
                                    </a>
                                    <button tabindex="101" type="submit" name="save" id="save2" class="save_button btn btn-sm btn-success">
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <span id="show_error" class="text-danger" style="font-weight: 800;font-size: 15px;"></span><br/>
                <span id="show_reg_error" class="text-danger" style="font-weight: 800;font-size: 15px;"></span>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let account = document.getElementById("account"),
                add_fee_excel = document.getElementById("add_fee_excel"),
                validateInputIdArray = [
                    account.id,
                    add_fee_excel.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    @if (Session::get('voucher_no') || Session::get('students'))
        <script>
            var id = '{{ Session::get('voucher_no') }}';
            var students = '{{ Session::get('students') }}';

            if (id != '' || students != '') {
                // Swal.fire('This vouchers number not found '+id);
                $('#show_error').html('This vouchers number not found ' + id);
                $('#show_reg_error').html('This Registration number not found ' + students);
            }

        </script>
    @endif

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#account").select2();
        });
    </script>
@endsection
