@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text">Create Department</h4>
                    </div>
                    <div class="list_btn">
                        <a class="btn list_link add_more_button" href="{{route('departments.index')}}" role="button">
                            <i class="fa fa-list"></i>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->

            <form name="f1" class="f1 mx-auto col-lg-6 col-md-6 col-sm-12 col-xs-12" id="f1" action="{{route('departments.store')}}" method="post" onsubmit="return checkForm()">
                @csrf
                <div class="row">
                <div class="input_bx form-group col-lg-12 col-md-12 col-sm-12"><!-- start input box -->
                    <label class="required">
                        <a
                            data-container="body" data-toggle="popover" data-trigger="hover"
                            data-placement="bottom" data-html="true"
                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.region.name.description')}}</p>
                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.region.name.benefits')}}</p>
                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.region.name.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.region.name.validations') }}</p>">
                            <i class="fa fa-info-circle"></i>
                        </a>
                        Department Title

                    </label>
                    <input type="text" name="department_name" id="department_name" class="inputs_up form-control" placeholder="Department Title" autofocus data-rule-required="true"
                            data-msg-required="Please Enter Department Title" autocomplete="off" value="{{ old('department_name') }}"/>
                    <span id="demo1" class="validate_sign"> </span>
                </div><!-- end input box -->
                <div class="input_bx form-group col-lg-12 col-md-12 col-sm-12"><!-- start input box -->
                    <label class="">
                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                            data-placement="bottom" data-html="true"
                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
                            config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
                            config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                            <i class="fa fa-info-circle"></i>
                        </a>
                        Department Remarks</label>
                    <textarea name="department_remarks" id="department_remarks" class="inputs_up remarks form-control"
                                placeholder="Department Remarks">{{ old('department_remarks') }}</textarea>
                    <span id="demo2" class="validate_sign"> </span>
                </div><!-- end input box -->  
                <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                    <button type="reset" name="cancel" id="cancel" class="cancel_button btn btn-secondary btn-sm">
                        <i class="fa fa-eraser"></i> Cancel
                    </button>
                    <button type="submit" name="save" id="save" class="save_button btn btn-success btn-sm">
                        <i class="fa fa-floppy-o"></i> Save
                    </button>
                </div>
            </form>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let department_name = document.getElementById("department_name"),
                validateInputIdArray = [
                    department_name.id,
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
        $(document).ready(function () {
            $('#parent_head').select2();
        });

        jQuery("#refresh_parent_head").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_parent_head",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#parent_head").html(" ");
                    jQuery("#parent_head").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>

@endsection


