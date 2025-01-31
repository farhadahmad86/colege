@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Reason</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{route('reason_list')}}" role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->

            <form name="f1" class="f1" id="f1" action="{{route('submit_reason')}}" method="post"
                  onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ewsq  offset-md-3">
                        <div class="row">

                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">Reason</label>
                                    <input tabindex="1" type="text" name="reason" id="reason" class="inputs_up form-control" placeholder="Reason" autofocus   data-rule-required="true"
                                           data-msg-required="Please Enter Reason" autocomplete="off" value="{{ old('reason') }}"/>
                                    <span id="demo1" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                                <button tabindex="1" type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-secondary">
                                    <i class="fa fa-eraser"></i> Cancel
                                </button>
                                <button tabindex="1" type="submit" name="save" id="save" class="save_button btn btn-sm btn-success">
                                    <i class="fa fa-floppy-o"></i> Save
                                </button>
                            </div>
                        </div>
                    </div> <!-- left column ends here -->
                </div> <!--  main row ends here -->
            </form>
        </div> <!-- white column form ends here -->
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
    {{-- end of required input validation --}}
    <script type="text/javascript">

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

    </script>

@endsection


