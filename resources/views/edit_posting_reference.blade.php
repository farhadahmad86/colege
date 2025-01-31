@extends('extend_index')

@section('content')
    <div class="row">
        <div
            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Create Posting Reference</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{route('posting_reference_list')}}" role="button">
                                <l class="fa fa-list"></l>
                                view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" action="{{route('update_posting_reference')}}" method="post"
                      onsubmit="return checkForm()">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ewsq  offset-md-3">
                            <div class="row">

                                <div hidden class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">

                                            Posting Reference ID

                                        </label>
                                        <input tabindex="1" type="text" name="posting_reference_id" id="posting_reference_id" class="inputs_up form-control" placeholder="Posting Reference Title" autofocus
                                               data-rule-required="true"
                                               data-msg-required="Please Enter Posting Reference" autocomplete="off" value="{{ $posting_reference->pr_id }}"/>
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">

                                            Posting Reference Title

                                        </label>
                                        <input tabindex="1" type="text" name="posting_reference" id="posting_reference" class="inputs_up form-control" placeholder="Posting Reference Title" autofocus
                                               data-rule-required="true"
                                               data-msg-required="Please Enter Posting Reference" autocomplete="off" value="{{ $posting_reference->pr_name }}"/>
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                            </div>

                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a
                                                data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Remarks</label>
                                        <textarea tabindex="1" name="remarks" id="remarks" class="inputs_up remarks form-control"
                                                  placeholder="Remarks">{{ $posting_reference->pr_remarks }}</textarea>
                                        <span id="demo2" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button tabindex="1" type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button tabindex="1" type="submit" name="save" id="save" class="save_button form-control"
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
            let posting_reference = document.getElementById("posting_reference"),
                validateInputIdArray = [
                    posting_reference.id,
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


