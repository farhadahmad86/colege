@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">
                                Opening Invoice & Voucher Sequence
                            </h4>
                        </div>
                    </div>
                </div><!-- form header close -->

                <form action="{{ route('system_config.update', [1]) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="table-responsive" id="printTable">
                        <table class="table table-sm" id="fixTable">

                            <thead>
                            <tr>
                                <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                                    Sr#
                                </th>
                                <th scope="col" align="center" class="text-center align_center tbl_txt_25">
                                    Label
                                </th>
                                <th scope="col" align="center" class="text-center align_center tbl_txt_65">
                                    Inputs
                                </th>

                            </tr>
                            </thead>

                            <tbody>

                                <tr>

                                        <td class="align_center text-center tbl_srl_4">

                                            1
                                        </td>
                                        <td class="align_left text-left tbl_txt_25">
                                            <label for="first_date_added" class="required">
                                                Last Bank Payment Voucher Number
                                            </label>
                                        </td>
                                        <td class="align_left text-left tbl_txt_65">
                                            <input type="text" name="sc_bank_payment_voucher_number"  class="inputs_up form-control" placeholder="Enter Last Bank Payment Voucher Number"
                                                   autocomplete="off" onkeypress="return isNumber(event)" value="{{ isset($systm_config) && !empty($systm_config->sc_bank_payment_voucher_number) ? $systm_config->sc_bank_payment_voucher_number : '1' }}">
                                            <span id="demo2" class="validate_sign"> </span>
                                        </td>

                                </tr>
                                <tr>

                                        <td class="align_center text-center tbl_srl_4">

                                            2
                                        </td>
                                        <td class="align_left text-left tbl_txt_25">
                                            <label for="first_date_added" class="required">
                                                Last Bank Receipt Voucher Number
                                            </label>
                                        </td>
                                        <td class="align_left text-left tbl_txt_65">
                                            <input type="text" name="sc_bank_receipt_voucher_number"  class="inputs_up form-control" placeholder="Enter Last Bank Receipt Voucher Number"
                                                   autocomplete="off" onkeypress="return isNumber(event)" value="{{ isset($systm_config) && !empty($systm_config->sc_bank_receipt_voucher_number) ? $systm_config->sc_bank_receipt_voucher_number : '1' }}">
                                            <span id="demo2" class="validate_sign"> </span>
                                        </td>

                                </tr>
                                <tr>

                                        <td class="align_center text-center tbl_srl_4">

                                            3
                                        </td>
                                        <td class="align_left text-left tbl_txt_25">
                                            <label for="first_date_added" class="required">
                                                Last Cash Payment Voucher Number
                                            </label>
                                        </td>
                                        <td class="align_left text-left tbl_txt_65">
                                            <input type="text" name="sc_cash_payment_voucher_number"  class="inputs_up form-control" placeholder="Enter Last Cash Payment Voucher Number"
                                                   autocomplete="off" onkeypress="return isNumber(event)" value="{{ isset($systm_config) && !empty($systm_config->sc_cash_payment_voucher_number) ? $systm_config->sc_cash_payment_voucher_number : '1' }}">
                                            <span id="demo4" class="validate_sign"> </span>
                                        </td>

                                </tr>
                                <tr>

                                        <td class="align_center text-center tbl_srl_4">

                                            4
                                        </td>
                                        <td class="align_left text-left tbl_txt_25">
                                            <label for="first_date_added" class="required">
                                                Last Cash Receipt Voucher Number
                                            </label>
                                        </td>
                                        <td class="align_left text-left tbl_txt_65">
                                            <input type="text" name="sc_cash_receipt_voucher_numer"  class="inputs_up form-control" placeholder="Enter Last Cash Receipt Voucher Number"
                                                   autocomplete="off" onkeypress="return isNumber(event)" value="{{ isset($systm_config) && !empty($systm_config->sc_cash_receipt_voucher_numer) ? $systm_config->sc_cash_receipt_voucher_numer : '1' }}">
                                            <span id="demo5" class="validate_sign"> </span>
                                        </td>

                                </tr>
                                <tr>

                                        <td class="align_center text-center tbl_srl_4">

                                            5
                                        </td>
                                        <td class="align_left text-left tbl_txt_25">
                                            <label for="first_date_added" class="required">
                                                Last Expense Payment Voucher Number
                                            </label>
                                        </td>
                                        <td class="align_left text-left tbl_txt_65">
                                            <input type="text" name="sc_expense_payment_voucher_number"  class="inputs_up form-control" placeholder="Enter Last Expense Payment Voucher Number"
                                                   autocomplete="off" onkeypress="return isNumber(event)" value="{{ isset($systm_config) && !empty($systm_config->sc_expense_payment_voucher_number) ? $systm_config->sc_expense_payment_voucher_number : '1' }}">
                                            <span id="demo6" class="validate_sign"> </span>
                                        </td>

                                </tr>
                                <tr>

                                        <td class="align_center text-center tbl_srl_4">

                                            6
                                        </td>
                                        <td class="align_left text-left tbl_txt_25">
                                            <label for="first_date_added" class="required">
                                                Last Journal Voucher Number
                                            </label>
                                        </td>
                                        <td class="align_left text-left tbl_txt_65">
                                            <input type="text" name="sc_journal_voucher_number"  class="inputs_up form-control" placeholder="Enter Last Journal Voucher Number" autocomplete="off"
                                                   onkeypress="return isNumber(event)" value="{{ isset($systm_config) && !empty($systm_config->sc_journal_voucher_number) ? $systm_config->sc_journal_voucher_number : '1' }}">
                                            <span id="demo7" class="validate_sign"> </span>
                                        </td>

                                </tr>
                                <tr>

                                        <td class="align_center text-center tbl_srl_4">

                                            7
                                        </td>
                                        <td class="align_left text-left tbl_txt_25">
                                            <label for="first_date_added" class="required">
                                                Last Purchase Invoice Number
                                            </label>
                                        </td>
                                        <td class="align_left text-left tbl_txt_65">
                                            <input type="text" name="sc_purchase_invoice_number"  class="inputs_up form-control" placeholder="Enter Last Purchase Invoice Number" autocomplete="off"
                                                   onkeypress="return isNumber(event)" value="{{ isset($systm_config) && !empty($systm_config->sc_purchase_invoice_number) ? $systm_config->sc_purchase_invoice_number : '1' }}">
                                            <span id="demo8" class="validate_sign"> </span>
                                        </td>

                                </tr>
                                <tr>

                                        <td class="align_center text-center tbl_srl_4">

                                            8
                                        </td>
                                        <td class="align_left text-left tbl_txt_25">
                                            <label for="first_date_added" class="required">
                                                Last Purchase Return Invoice Number
                                            </label>
                                        </td>
                                        <td class="align_left text-left tbl_txt_65">
                                            <input type="text" name="sc_purchase_return_invoice_number"  class="inputs_up form-control" placeholder="Enter Last Purchase Return Invoice Number"
                                                   autocomplete="off" onkeypress="return isNumber(event)" value="{{ isset($systm_config) && !empty($systm_config->sc_purchase_return_invoice_number) ? $systm_config->sc_purchase_return_invoice_number : '1' }}">
                                            <span id="demo9" class="validate_sign"> </span>
                                        </td>

                                </tr>
                                <tr>

                                        <td class="align_center text-center tbl_srl_4">

                                            9
                                        </td>
                                        <td class="align_left text-left tbl_txt_25">
                                            <label for="first_date_added" class="required">
                                                Last Purchase Sale Tax Invoice Number
                                            </label>
                                        </td>
                                        <td class="align_left text-left tbl_txt_65">
                                            <input type="text" name="sc_purchase_st_invoice_number"  class="inputs_up form-control" placeholder="Enter Last Purchase Sale Tax Invoice Number"
                                                   autocomplete="off" onkeypress="return isNumber(event)" value="{{ isset($systm_config) && !empty($systm_config->sc_purchase_st_invoice_number) ? $systm_config->sc_purchase_st_invoice_number : '1' }}">
                                            <span id="demo10" class="validate_sign"> </span>
                                        </td>

                                </tr>
                                <tr>

                                        <td class="align_center text-center tbl_srl_4">

                                            10
                                        </td>
                                        <td class="align_left text-left tbl_txt_25">
                                            <label for="first_date_added" class="required">
                                                Enter Last Purchase Return Sale Tax Invoice Number
                                            </label>
                                        </td>
                                        <td class="align_left text-left tbl_txt_65">
                                            <input type="text" name="sc_purchase_return_st_invoice_number"  class="inputs_up form-control" placeholder="Enter Last Purchase Return Sale Tax Invoice
                                            Number" onkeypress="return isNumber(event)" autocomplete="off" value="{{ isset($systm_config) && !empty($systm_config->sc_purchase_return_st_invoice_number) ? $systm_config->sc_purchase_return_st_invoice_number : '1' }}">
                                            <span id="demo11" class="validate_sign"> </span>
                                        </td>

                                </tr>
                                <tr>

                                        <td class="align_center text-center tbl_srl_4">

                                            11
                                        </td>
                                        <td class="align_left text-left tbl_txt_25">
                                            <label for="first_date_added" class="required">
                                                Last Salary Payment Voucher Number
                                            </label>
                                        </td>
                                        <td class="align_left text-left tbl_txt_65">
                                            <input type="text" name="sc_salary_payment_voucher_number"  class="inputs_up form-control" placeholder="Enter Last Salary Payment Voucher Number"
                                                   autocomplete="off" onkeypress="return isNumber(event)" value="{{ isset($systm_config) && !empty($systm_config->sc_salary_payment_voucher_number) ? $systm_config->sc_salary_payment_voucher_number : '1' }}">
                                            <span id="demo12" class="validate_sign"> </span>
                                        </td>

                                </tr>
                                <tr>

                                        <td class="align_center text-center tbl_srl_4">

                                            12
                                        </td>
                                        <td class="align_left text-left tbl_txt_25">
                                            <label for="first_date_added" class="required">
                                                Last Salary Slip Voucher Number
                                            </label>
                                        </td>
                                        <td class="align_left text-left tbl_txt_65">
                                            <input type="text" name="sc_salary_slip_voucher_number"  class="inputs_up form-control" placeholder="Enter Last Salary Slip Voucher Number"
                                                   autocomplete="off" onkeypress="return isNumber(event)" value="{{ isset($systm_config) && !empty($systm_config->sc_salary_slip_voucher_number) ? $systm_config->sc_salary_slip_voucher_number : '1' }}">
                                            <span id="demo13" class="validate_sign"> </span>
                                        </td>

                                </tr>
                                <tr>

                                        <td class="align_center text-center tbl_srl_4">

                                            13
                                        </td>
                                        <td class="align_left text-left tbl_txt_25">
                                            <label for="first_date_added" class="required">
                                                Last Advance Salary Voucher Number
                                            </label>
                                        </td>
                                        <td class="align_left text-left tbl_txt_65">
                                            <input type="text" name="sc_advance_salary_voucher_number"  class="inputs_up form-control" placeholder="Enter Last Advance Salary Voucher Number"
                                                   autocomplete="off" onkeypress="return isNumber(event)" value="{{ isset($systm_config) && !empty($systm_config->sc_advance_salary_voucher_number) ? $systm_config->sc_advance_salary_voucher_number : '1' }}">
                                            <span id="demo14" class="validate_sign"> </span>
                                        </td>

                                </tr>
                                <tr>

                                        <td class="align_center text-center tbl_srl_4">

                                            14
                                        </td>
                                        <td class="align_left text-left tbl_txt_25">
                                            <label for="first_date_added" class="required">
                                                Last Sale Invoice Number
                                            </label>
                                        </td>
                                        <td class="align_left text-left tbl_txt_65">
                                            <input type="text" name="sc_sale_invoice_number" id="service_tax_invoice_number" class="inputs_up form-control" placeholder="Enter Last Sale Invoice
                                            Number" onkeypress="return isNumber(event)" autocomplete="off" value="{{ isset($systm_config) && !empty($systm_config->sc_sale_invoice_number) ? $systm_config->sc_sale_invoice_number : '1' }}">
                                            <span id="demo15" class="validate_sign"> </span>
                                        </td>

                                </tr>
                                <tr>

                                        <td class="align_center text-center tbl_srl_4">

                                            15
                                        </td>
                                        <td class="align_left text-left tbl_txt_25">
                                            <label for="first_date_added" class="required">
                                                Last Sale Return Invoice Number
                                            </label>
                                        </td>
                                        <td class="align_left text-left tbl_txt_65">
                                            <input type="text" name="sc_sale_return_invoice_number"  class="inputs_up form-control" placeholder="Enter Last Sale Return Invoice Number"
                                                   autocomplete="off" value="{{ isset($systm_config) && !empty($systm_config->sc_sale_return_invoice_number) ? $systm_config->sc_sale_return_invoice_number : '1' }}" onkeypress="return isNumber(event)">
                                            <span id="demo16" class="validate_sign"> </span>
                                        </td>

                                </tr>
                                <tr>

                                        <td class="align_center text-center tbl_srl_4">

                                            16
                                        </td>
                                        <td class="align_left text-left tbl_txt_25">
                                            <label for="first_date_added" class="required">
                                                Last Sale Tax Invoice Number
                                            </label>
                                        </td>
                                        <td class="align_left text-left tbl_txt_65">
                                            <input type="text" name="sc_sale_tax_invoice_number"  class="inputs_up form-control" placeholder="Enter Last Sale Tax Invoice Number" autocomplete="off"
                                                   onkeypress="return isNumber(event)" value="{{ isset($systm_config) && !empty($systm_config->sc_sale_tax_invoice_number) ? $systm_config->sc_sale_tax_invoice_number : '1' }}">
                                            <span id="demo17" class="validate_sign"> </span>
                                        </td>

                                </tr>
                                <tr>

                                        <td class="align_center text-center tbl_srl_4">

                                            17
                                        </td>
                                        <td class="align_left text-left tbl_txt_25">
                                            <label for="first_date_added" class="required">
                                                Last Sale Tax Return Invoice Number
                                            </label>
                                        </td>
                                        <td class="align_left text-left tbl_txt_65">
                                            <input type="text" name="sc_sale_tax_return_invoice_number"  class="inputs_up form-control" placeholder="Enter Last Sale Tax Return Invoice Number"
                                                   autocomplete="off" onkeypress="return isNumber(event)" value="{{ isset($systm_config) && !empty($systm_config->sc_sale_tax_return_invoice_number) ? $systm_config->sc_sale_tax_return_invoice_number : '1' }}">
                                            <span id="demo18" class="validate_sign"> </span>
                                        </td>

                                </tr>
                                <tr>

                                        <td class="align_center text-center tbl_srl_4">

                                            18
                                        </td>
                                        <td class="align_left text-left tbl_txt_25">
                                            <label for="first_date_added" class="required">
                                                Last Service Invoice Number
                                            </label>
                                        </td>
                                        <td class="align_left text-left tbl_txt_65">
                                            <input type="text" name="sc_service_invoice_number"  class="inputs_up form-control" placeholder="Enter Last Service Invoice Number" autocomplete="off"
                                                   onkeypress="return isNumber(event)" value="{{ isset($systm_config) && !empty($systm_config->sc_service_invoice_number) ? $systm_config->sc_service_invoice_number : '1' }}">
                                            <span id="demo19" class="validate_sign"> </span>
                                        </td>

                                </tr>
                                <tr>

                                        <td class="align_center text-center tbl_srl_4">

                                            19
                                        </td>
                                        <td class="align_left text-left tbl_txt_25">
                                            <label for="first_date_added" class="required">
                                                Last Service Tax Invoice Number
                                            </label>
                                        </td>
                                        <td class="align_left text-left tbl_txt_65">
                                            <input type="text" name="sc_service_tax_invoice_number"  class="inputs_up form-control" placeholder="Enter Last Service Tax Invoice Number"
                                                   autocomplete="off" onkeypress="return isNumber(event)" value="{{ isset($systm_config) && !empty($systm_config->sc_service_tax_invoice_number) ? $systm_config->sc_service_tax_invoice_number : '1' }}">
                                            <span id="demo20" class="validate_sign"> </span>
                                        </td>

                                </tr>
                            </tbody>

                        </table>
                    </div>

                    <div class="form-group text-center m-0">
                        <button type="submit" name="save" class="save_button form-control m-0">
                            <i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </form>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    <script>

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
    </script>

@endsection

