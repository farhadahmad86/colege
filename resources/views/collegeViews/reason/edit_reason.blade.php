
@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Update Reason</h4>
                        </div>
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" action="update_reason" onsubmit="return checkForm()" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="row">

                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Reason</label>
                                        <input type="text" name="reason" id="reason" class="inputs_up form-control"
                                               data-rule-required="true" data-msg-required="Please Enter Reason"
                                               placeholder="Reason" autofocus value="{{$request->title}}" autocomplete="off"/>
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <input value="{{$request->reason_id}}" type="hidden" name="reason_id">

                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button type="submit" name="save" id="save" class="save_button form-control"
                                    >
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div> <!-- left column ends here -->
                    </div> <!--  main row ends here -->
                </form>
            </div> <!-- white column form ends here -->
        </div><!-- col end -->
    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let reason = document.getElementById("reason"),
                validateInputIdArray = [
                    reason.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
@endsection

