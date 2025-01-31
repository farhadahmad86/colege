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
            <div class="container-fluid search-filter form-group form_manage">
                <div class="form_header">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Software Package Config</h4>
                        </div>
                    </div>
                </div>
                <form name="f1" class="f1" id="f1" action="{{ route('update_software_package') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mx-auto">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Basic</th>
                                        <th>Advance</th>
                                        <th>Premium</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th>Software Package</th>
                                        <td>
                                            <div class="custom-control custom-radio mb-10 mt-1">
                                                <input type="radio" name="check_package" class="custom-control-input check_invoice" id="check_invoice1" value="Basic"
                                                    {{ $package->pak_name == 'Basic'  ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="check_invoice1"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-radio mb-10 mt-1">
                                                <input type="radio" name="check_package" class="custom-control-input check_invoice" id="check_invoice2" value="Advance"
                                                    {{ $package->pak_name == 'Advance'  ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="check_invoice2"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-radio mb-10 mt-1">
                                                <input type="radio" name="check_package" class="custom-control-input check_invoice" id="check_invoice3" value="Premium"
                                                    {{ $package->pak_name == 'Premium'  ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="check_invoice3"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Software Users</th>
                                        <td>
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <input tabindex="2" type="text" name="check_user" id="check_user" class="inputs_up form-control" placeholder="1"
                                                    value="{{ $package->pak_total_user }}" data-rule-required="true" data-msg-required="Please Enter Total User" onkeypress="return
                                                    allow_only_number_and_decimals(this,event);">
                                                    {{--div class="form-control custom-radio mb-10 mt-1">--}}
                                                    {{--   <input type="number" name="check_user" class="custom-control-input check_user" id="check_user" value="{{ $package->pak_user }}">--}}
                                            </div>
                                        </td>
                                        <th>
                                            Financial Days
                                        </th>
                                        <td>
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <input tabindex="2" type="text" name="financial_year" id="financial_year" class="inputs_up form-control" placeholder="1"
                                                    value="{{ $package->pak_financial_year }}" data-rule-required="true" data-msg-required="Please Enter Total User" onkeypress="return
                                                    allow_only_number_and_decimals(this,event);">
                                                    {{--div class="form-control custom-radio mb-10 mt-1">--}}
                                                    {{--   <input type="number" name="check_user" class="custom-control-input check_user" id="check_user" value="{{ $package->pak_user }}">--}}
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


