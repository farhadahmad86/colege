@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Bus Route</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('route_list') }}"
                           role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <form name="f1" class="f1" id="f1" action="{{ route('submit_route') }}" method="post"
                  onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Route Title
                            </label>
                            <input tabindex="1" type="text" name="route_title" id="route_title"
                                   class="form-control"
                                   placeholder="Route Title" autofocus data-rule-required="true"
                                   data-msg-required="Please Enter Route Title" autocomplete="off"
                                   value="{{ old('route_title') }}"/>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Route Name
                            </label>
                            <input tabindex="2" type="text" name="route_name" id="route_name"
                                   class="form-control"
                                   placeholder="Route Name" autofocus data-rule-required="true"
                                   data-msg-required="Please Enter Route Name" autocomplete="off"
                                   value="{{ old('route_name') }}"/>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Single Route Amount
                            </label>
                            <input tabindex="3" type="number" name="single_route_amount" id="single_route_amount"
                                   class="form-control"
                                   placeholder="Single Route Amount" autofocus data-rule-required="true"
                                   data-msg-required="Please Enter Single Route Amount" autocomplete="off"
                                   value="{{ old('single_route_amount') }}"/>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Double Route Amount
                            </label>
                            <input tabindex="4" type="number" name="double_route_amount" id="double_route_amount"
                                   class="form-control"
                                   placeholder="Double Route Amount" autofocus data-rule-required="true"
                                   data-msg-required="Please Enter Double Route Amount" autocomplete="off"
                                   value="{{ old('double_route_amount') }}"/>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Vendor Charges
                            </label>
                            <input tabindex="1" type="number" name="vendor_charge" id="vendor_charge"
                                   class="form-control"
                                   placeholder="Vendor Charges" autofocus data-rule-required="true"
                                   data-msg-required="Please Enter Vendor Charges" autocomplete="off"
                                   value="{{ old('vendor_charge') }}"/>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Remarks
                            </label>
                            <textarea tabindex="1" type="text" name="remarks" id="remarks"
                                      class="form-control"
                                      placeholder="Remarks" autofocus data-rule-required="true"
                                      data-msg-required="Please Enter Remarks" autocomplete="off"
                                      value=""></textarea>
{{--                            <span id="demo1" class="validate_sign"> </span>--}}
                        </div><!-- end input box -->
                    </div>
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
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let route_title = document.getElementById("route_title"),
                route_name = document.getElementById("route_name"),
                single_route_amount = document.getElementById("single_route_amount"),
                double_route_amount = document.getElementById("double_route_amount"),
                vendor_charge = document.getElementById("vendor_charge"),
                // remarks = document.getElementById("remarks"),
                validateInputIdArray = [
                    route_title.id,
                    route_name.id,
                    double_route_amount.id,
                    single_route_amount.id,
                    vendor_charge.id,
                    // remarks.id,
                    // class_incharge_id.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        $(document).ready(function () {
            $('#transport_type').select2();
            $('#class_id').select2();
        });
    </script>
@endsection
