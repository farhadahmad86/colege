@extends('extend_index')

@section('content')
    <style>
        .custom-checkbox {
            float: unset;
        }

        table {
            width: 100%
        }

        table tbody tr td {
            padding-left: 5px;
            width: 15%;
        }

        table tbody tr td:first-child {
            width: 70%;
        }

        table tbody tr td:last-child {
            width: 15%;
        }

        /*table tbody tr.important { border-left: 2px solid red; border-right: 1px solid red; }*/
        /*table tbody tr:nth-child(6) { border-top: 1px solid red; }*/
        /*table tbody tr.important:last-child { border-bottom: 1px solid red; }*/


    </style>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                <div class="form_header">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Day End Config</h4>
                        </div>
                    </div>
                </div>

                <form name="f1" class="f1" id="f1" action="{{ route('submit_day_end_config') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mx-auto">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Day End</th>
                                        <th>Month End</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Check Cash Negative Balance</td>
                                        <td>
                                            <div class="custom-control custom-radio mb-10 mt-1">
                                                <input type="radio" name="check_cash" class="custom-control-input check_cash" id="check_cash1" value="1"
                                                    {{ $day_end_config->dec_cash_check == 1  ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="check_cash1"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-radio mb-10 mt-1">
                                                <input type="radio" name="check_cash" class="custom-control-input check_cash" id="check_cash2" value="2"
                                                    {{ $day_end_config->dec_cash_check == 2  ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="check_cash2"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Check Bank Negative Balance</td>
                                        <td>
                                            <div class="custom-control custom-radio mb-10 mt-1">
                                                <input type="radio" name="check_bank" class="custom-control-input check_bank" id="check_bank1" value="1"
                                                    {{ $day_end_config->dec_bank_check == 1  ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="check_bank1"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-radio mb-10 mt-1">
                                                <input type="radio" name="check_bank" class="custom-control-input check_bank" id="check_bank2" value="2"
                                                    {{ $day_end_config->dec_bank_check == 2  ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="check_bank2"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Check Product Negative Balance</td>
                                        <td>
                                            <div class="custom-control custom-radio mb-10 mt-1">
                                                <input type="radio" name="check_product" class="custom-control-input check_product" id="check_product1" value="1"
                                                    {{ $day_end_config->dec_product_check == 1  ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="check_product1"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-radio mb-10 mt-1">
                                                <input type="radio" name="check_product" class="custom-control-input check_product" id="check_product2" value="2"
                                                    {{ $day_end_config->dec_product_check == 2  ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="check_product2"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Check Warehouse Negative Balance</td>
                                        <td>
                                            <div class="custom-control custom-radio mb-10 mt-1">
                                                <input type="radio" name="check_warehouse" class="custom-control-input check_warehouse" id="check_warehouse1" value="1"
                                                    {{ $day_end_config->dec_warehouse_check == 1  ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="check_warehouse1"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-radio mb-10 mt-1">
                                                <input type="radio" name="check_warehouse" class="custom-control-input check_warehouse" id="check_warehouse2" value="2"
                                                    {{ $day_end_config->dec_warehouse_check == 2  ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="check_warehouse2"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    @if( $systemConfig->sc_all_done === 0)
                                        <tr>
                                            <td style="padding: 20px 0;"></td>
                                        </tr>
                                        <tr class="important" hidden>
                                            <td>Create Trial Balance</td>

                                            <td>
                                                <div class="custom-control custom-radio mb-10 mt-1">
                                                    <input type="radio" name="create_trail" class="custom-control-input create_trail disabled" id="create_trail2" value="2"
                                                        {{ $day_end_config->dec_create_trial == 2  ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="create_trail2"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="important" hidden>
                                            <td>Create Closing Stock</td>

                                            <td>
                                                <div class="custom-control custom-radio mb-10 mt-1">
                                                    <input type="radio" name="create_closing" class="custom-control-input create_closing disabled" id="create_closing2" value="2"
                                                        {{ $day_end_config->dec_create_closing_stock == 2  ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="create_closing2"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="important" hidden>
                                            <td>Create Cash/Bank Balance</td>

                                            <td>
                                                <div class="custom-control custom-radio mb-10 mt-1">
                                                    <input type="radio" name="create_cb_balance" class="custom-control-input create_cb_balance disabled" id="create_cb_balance2" value="2"
                                                        {{ $day_end_config->dec_create_cash_bank_closing == 2  ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="create_cb_balance2"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="important" hidden>
                                            <td>Create Profit & Loss Statement</td>

                                            <td>
                                                <div class="custom-control custom-radio mb-10 mt-1">
                                                    <input type="radio" name="create_pnl" class="custom-control-input create_pnl" id="create_pnl2" value="2"
                                                        {{ $day_end_config->dec_create_pnl == 2  ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="create_pnl2"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="important" hidden>
                                            <td>Create Balance Sheet</td>

                                            <td>
                                                <div class="custom-control custom-radio mb-10 mt-1">
                                                    <input type="radio" name="create_balance_sheet" class="custom-control-input create_balance_sheet" id="create_balance_sheet2" value="2"
                                                        {{ $day_end_config->dec_create_balance_sheet == 2  ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="create_balance_sheet2"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="important" hidden>
                                            <td>Create Profit Distribution</td>

                                            <td>
                                                <div class="custom-control custom-radio mb-10 mt-1">
                                                    <input type="radio" name="create_profit_distribution" class="custom-control-input create_profit_distribution" id="create_profit_distribution2" value="2"
                                                        {{ $day_end_config->dec_create_pnl_distribution == 2  ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="create_profit_distribution2"></label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls text-center">
                                    <button type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-secondary">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button type="submit" name="save" id="save" class="save_button btn btn-sm btn-success">
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
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
    <script type="text/javascript">
        jQuery(document).ready(function () {

            var table = $('table').DataTable();
            table.destroy();

        });

        $(document).ready(function () {
            $(document).on("change", ".create_trail, .create_closing, .create_cb_balance, .create_pnl, .create_balance_sheet, .create_profit_distribution", function () {

                var value = $(this).val();

                // if (value == 1) {
                //     $('input#create_trail' + value).prop('checked', true);
                //     $('input#create_closing' + value).prop('checked', true);
                //     $('input#create_cb_balance' + value).prop('checked', true);
                // }

                $('.create_trail').prop('checked', false);
                $('.create_closing').prop('checked', false);
                $('.create_cb_balance').prop('checked', false);
                $('.create_pnl').prop('checked', false);
                $('.create_balance_sheet').prop('checked', false);
                $('.create_profit_distribution').prop('checked', false);

                $('input#create_trail' + value).prop('checked', true);
                $('input#create_closing' + value).prop('checked', true);
                $('input#create_cb_balance' + value).prop('checked', true);
                $('input#create_pnl' + value).prop('checked', true);
                $('input#create_balance_sheet' + value).prop('checked', true);
                $('input#create_profit_distribution' + value).prop('checked', true);
            });
        });

    </script>
@endsection


