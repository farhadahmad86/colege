@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Update Extra Lecture Amount</h4>
                    </div>
                </div>
            </div><!-- form header close -->


            <form name="f1" class="f1" id="f1" action="{{ route('update_extra_amount') }}" method="post"
                onsubmit="return checkForm()">
                @csrf
                <div class="row">

                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Amount
                            </label>
                            <input tabindex="1" type="text" name="extra_amount" id="extra_amount"
                                class="inputs_up form-control" placeholder="Enter Amount" autofocus data-rule-required="true"
                                data-msg-required="Please Enter Amount" autocomplete="off"
                                value="{{ $request->title }}" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <input value="{{ $request->rc_id }}" type="hidden" name="rc_id">
                </div>
                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                        <button tabindex="1" type="submit" name="save" id="save"
                            class="save_button btn btn-sm btn-success">
                            <i class="fa fa-floppy-o"></i> Update
                        </button>
                    </div>
                </div>

        </div> <!-- left column ends here -->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            {{-- <div class="show_info_div"> --}}
            {{-- </div> --}}
        </div>
        <!-- right columns ends here -->
    </div>
    <!--  main row ends here -->


    </form>
    </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let extra_amount = document.getElementById("extra_amount"),
                validateInputIdArray = [
                    extra_amount.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);
            if(check == true){
                jQuery(".pre-loader").fadeToggle("medium");
            }
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">
        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    </script>
@endsection
