@extends('extend_index')

@section('content')

    <div class="row">
            <div class="container-fluid search-filter form-group form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Cash Transfer</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <a tabindex="-1" class="add_btn add_more_button" href="{{ route('reject_cash_transfer_list') }}" role="button" target="_blank" data-toggle="tooltip" data-placement="bottom"
                               title="Reject Cash Transfer List">
                                <i class="fa fa-ban"></i> Reject Cash
                            </a>
                            <a tabindex="-1" class="add_btn add_more_button" href="{{ route('approve_cash_transfer_list') }}" role="button" target="_blank" data-toggle="tooltip"
                               data-placement="bottom" title="Approve Cash Transfer List">
                                <i class="fa fa-check"></i> Approve Cash
                            </a>
                            <a tabindex="-1" class="add_btn add_more_button" href="{{ route('pending_cash_transfer_list') }}" role="button" target="_blank" data-toggle="tooltip"
                               data-placement="bottom" title="Pending Cash Transfer List">
                                <i class="fa fa-clock-o"></i> Pending Cash
                            </a>

                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <div class="excel_con gnrl-mrgn-pdng gnrl-blk">
                    <div class="excel_box gnrl-mrgn-pdng gnrl-blk">
                        <div class="excel_box_hdng gnrl-mrgn-pdng gnrl-blk">
                            <h2 class="gnrl-blk gnrl-mrgn-pdng gnrl-font-bold">
                                Upload Excel File
                            </h2>
                        </div>
                        <div class="excel_box_content gnrl-mrgn-pdng gnrl-blk">

                            <form action="{{ route('submit_cash_transfer_excel') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                Select Excel File
                                            </label>
                                            <input tabindex="100" type="file" name="add_cash_transfer_excel" id="add_cash_transfer_pattern_excel"
                                                   class="inputs_up form-control-file form-control height-auto"
                                                   accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        </div><!-- end input box -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                        <a href="{{ url('public/sample/cash_transfer/add_cash_transfer_pattern.xlsx') }}" tabindex="-1" type="reset" class="cancel_button btn btn-sm btn-info">
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
                </div>

                <form name="f1" class="f1 col-lg-5 mx-auto" id="f1" action="{{ route('submit_cash_transfer') }}" onsubmit="return checkForm()" method="post">
                    @csrf
                    <div class="row">
                        <div class="input_bx form-group col-lg-6 col-md-6 col-sm-12 col-xs-12"><!-- start input box -->
                            <label class="required">
                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                    data-placement="bottom" data-html="true"
                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.configurations.cash_transfer.cash_transfer_to.description')}}</p>
                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.configurations.cash_transfer.cash_transfer_to.benefits')}}</p>
                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.configurations.cash_transfer.cash_transfer_to.example')}}</p>">
                                    <i class="fa fa-info-circle"></i>
                                </a>
                                Cash Transfer To
                                <a href="{{ route('add_employee') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover"
                                    data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                    <i class="fa fa-plus"></i>
                                </a>
                                <a id="refresh_cash_transfer_to" class="add_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                    data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                    <l class="fa fa-refresh"></l>
                                </a>
                            </label>
                            <select tabindex=1 autofocus name="cash_transfer_to" class="inputs_up form-control" id="cash_transfer_to" autofocus style="width: 90%"
                                    data-rule-required="true" data-msg-required="Please Enter Cash Transfer To">
                                <option value="">Cash Transfer To</option>
                                @foreach($tellers as $teller)
                                    <option
                                        value="{{$teller->user_id}}"{{$teller->user_id == old('cash_transfer_to') ? 'selected="selected"' : ''}} >{{$teller->user_name}}</option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->

                        <div class="input_bx form-group col-lg-6 col-md-6 col-sm-12 col-xs-12"><!-- start input box -->
                            <label class="required">
                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                    data-placement="bottom" data-html="true"
                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.configurations.cash_transfer.amount.description')}}</p>
                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.configurations.cash_transfer.amount.benefits')}}</p>
                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.configurations.cash_transfer.amount.example')}}</p>">
                                    <i class="fa fa-info-circle"></i>
                                </a>
                                Amount</label>
                            <input tabindex="2" type="text" name="amount" id="amount" class="inputs_up form-control" data-rule-required="true"
                                    data-msg-required="Please Enter Amount" placeholder="Amount" value="{{old('amount')}}" autocomplete="off" onkeypress="return isNumber(event)"/>
                            <span id="demo2" class="validate_sign"> </span>
                        </div><!-- end input box -->    
                        <div class="input_bx form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><!-- start input box -->
                            <label class="">
                                <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
                                        config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
                                        config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                    <i class="fa fa-info-circle"></i>
                                </a>
                                Remarks</label>
                            <textarea tabindex="3" name="remarks" id="remarks" class="inputs_up remarks form-control" placeholder="Remarks" style="height: 100px"> {{old('remarks')}}</textarea>
                            <span id="demo3" class="validate_sign"> </span>
                        </div><!-- end input box -->
                        <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                            <button tabindex="4" type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-secondary">
                                <i class="fa fa-eraser"></i> Cancel
                            </button>
                            <button tabindex="5" type="submit" name="save" id="save" class="save_button btn btn-sm btn-success">
                                <i class="fa fa-floppy-o"></i> Save
                            </button>
                        </div>
                     </div> <!--  main row ends here -->
                </form>
            </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let cash_transfer_to = document.getElementById("cash_transfer_to"),
                amount = document.getElementById("amount"),
                validateInputIdArray = [
                    cash_transfer_to.id,
                    amount.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#cash_transfer_to").select2();
        });
    </script>

    <script>
        jQuery("#refresh_cash_transfer_to").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_cash_transfer_to",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#cash_transfer_to").html(" ");
                    jQuery("#cash_transfer_to").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>

    <script type="text/javascript">

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        function form_validation() {
            var cash_transfer_to = document.getElementById("cash_transfer_to").value;
            var amount = document.getElementById("amount").value;

            var flag_submit = true;
            var focus_once = 0;

            // if(cash_transfer_to.trim() == "")
            // {
            //     document.getElementById("demo1").innerHTML = "Required";
            //     if (focus_once == 0) { jQuery("#cash_transfer_to").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //     document.getElementById("demo1").innerHTML = "";
            // }
            //
            // if(amount.trim() == "")
            // {
            //     document.getElementById("demo2").innerHTML = "Required";
            //     if (focus_once == 0) { jQuery("#amount").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //     document.getElementById("demo2").innerHTML = "";
            // }
            return flag_submit;
        }

    </script>

    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

@endsection


