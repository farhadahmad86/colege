
@extends('extend_index')

@section('content')

    <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="form-group row">
                    <div class="col-md-6 col-lg-6">
                        <span id="demo1" class="validate_sign" style="float: right !important; width: 100%"> </span>
                        <div class="input-group">
                            <select name="report" class="form-control" id="report" autofocus>
                                <option value="">Select Voucher</option>
                                <option value="1">Purchase Voucher</option>
                                <option value="10">Income Tax Purchase Voucher</option>
                                <option value="11">Sale Tax Purchase Voucher</option>
{{--                                <option value="12">Service Tax Purchase Voucher</option>--}}
                                <option value="2">Purchase Return Voucher</option>
                                <option value="3">Sale Voucher</option>
                                <option value="16">Service Voucher</option>
                                <option value="13">Income Tax Sale Voucher</option>
                                <option value="14">Sale Tax Sale Voucher</option>
                                <option value="15">Service Tax Sale Voucher</option>
                                <option value="4">Sale Return Voucher</option>
                                <option value="5">Journal Voucher</option>
                                <option value="6">Cash Receipt Voucher</option>
                                <option value="7">Cash Payment Voucher</option>
                                <option value="8">Bank Receipt Voucher</option>
                                <option value="9">Bank Payment Voucher</option>
                            </select>

                        </div>
                    </div>
                </div>

            </div> <!-- left column ends here -->

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="form-group row">

                    <div class="col-md-6 col-lg-4">
                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        <div class="input-group">
                            <input type="text" name="to" id="to" class="form-control datepicker1" autocomplete="off" <?php if(isset($to)){?> value="{{$to}}" <?php } ?> placeholder="Start......"/>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        <div class="input-group">
                            <input type="text" name="from" id="from" class="form-control datepicker1" autocomplete="off" <?php if(isset($from)){?> value="{{$from}}" <?php } ?> placeholder="End......"/>
                        </div>
                    </div>
                </div>

            </div> <!-- right column ends here -->

        </div>

    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

        <div class="clearfix">
            <div class="pull-left">
                <h4 class="text-blue get-heading-text" id="head">Select Any Voucher</h4>
            </div>
        </div>


        <div class="table-responsive" id="parent">
            <table class="table table-bordered fixed_header" id="fixTable">

            </table>

        </div>

    </div> <!-- white column form ends here -->

@endsection

@section('scripts')

    <script>
        jQuery("#report").change(function () {

            var dropDown = document.getElementById('report');
            var report = dropDown.options[dropDown.selectedIndex].value;

            var to= jQuery("#to").val();
            var from=jQuery("#from").val();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_all_reports",
                data: {report: report, to: to, from: from},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#fixTable").html(" ");
                    jQuery("#fixTable").append(data[0]);

                    jQuery("#head").html(" ");
                    jQuery("#head").append(data[1]);

                    $("#fixTable").tableHeadFixer();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });

        jQuery("#to").change(function () {

            var date =jQuery("#to").val();

            var pattern = new RegExp(/([12]\d|0[1-9]|3[0-1])-(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)-(\d{4})/);
            var match = pattern.exec(date);

            if (match == null){
                return false;
            }
        });

        jQuery('#from').change(function () {

            var date=jQuery('#from').val();

            var pattern = new RegExp(/([12]\d|0[1-9]|3[0-1])-(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)]-(\d{4})/);
            var match=pattern.exec(date);

            if(match == null){
                return false;
            }
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#report").select2();

        });
    </script>

@endsection

