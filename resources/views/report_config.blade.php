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
</style>

<div class="row">


    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

            <div class="form_header">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text">Report Config</h4>
                    </div>
                </div>
            </div>

            <form name="f1" class="f1" id="f1" action="{{ route('submit_report_config') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mx-auto">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>English</th>
                                    <th>Urdu</th>
                                    <th>Always Asked</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Invoice Report</td>
                                    <td>
                                        <div class="custom-control custom-radio mb-10 mt-1">
                                            <input type="radio" name="check_invoice" class="custom-control-input check_invoice" id="check_invoice1" value="0"
                                                    {{ $report_config->rc_invoice == 0  ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="check_invoice1"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-radio mb-10 mt-1">
                                            <input type="radio" name="check_invoice" class="custom-control-input check_invoice" id="check_invoice2" value="1"
                                                    {{ $report_config->rc_invoice == 1  ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="check_invoice2"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Invoice Party Name</td>
                                    <td>
                                        <div class="custom-control custom-radio mb-10 mt-1">
                                            <input type="radio" name="check_invoice_party" class="custom-control-input check_invoice_party" id="check_invoice_party1" value="0"
                                                {{ $report_config->rc_invoice_party == 0  ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="check_invoice_party1"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-radio mb-10 mt-1">
                                            <input type="radio" name="check_invoice_party" class="custom-control-input check_invoice_party" id="check_invoice_party2" value="1"
                                                {{ $report_config->rc_invoice_party == 1  ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="check_invoice_party2"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Invoice Detail Remarks</td>
                                    <td>
                                        <div class="custom-control custom-radio mb-10 mt-1">
                                            <input type="radio" name="check_detail_remarks" class="custom-control-input check_detail_remarks" id="check_detail_remarks1" value="0"
                                                {{ $report_config->rc_detail_remarks == 0  ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="check_detail_remarks1"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-radio mb-10 mt-1">
                                            <input type="radio" name="check_detail_remarks" class="custom-control-input check_detail_remarks" id="check_detail_remarks2" value="1"
                                                {{ $report_config->rc_detail_remarks == 1  ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="check_detail_remarks2"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-radio mb-10 mt-1">
                                            <input type="radio" name="check_detail_remarks" class="custom-control-input check_detail_remarks" id="check_detail_remarks3" value="2"
                                                {{ $report_config->rc_detail_remarks == 2  ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="check_detail_remarks3"></label>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group row">
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


