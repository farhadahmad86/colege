@extends('extend_index')
@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create City</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('city_list') }}" role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <form name="f1" class="f1 mx-auto col-lg-6 col-md-6 col-sm-12 col-xs-12" id="f1" onsubmit="return checkForm()" action="{{ route('submit_city') }}" method="post">
                @csrf
                <div class="input_bx form-group col-lg-12 col-md-12 col-sm-12"><!-- start input box -->
                    <label class="required"> Province Title </label>
                    <select tabindex="1" autofocus name="province" class="inputs_up form-control required" id="province" autofocus data-rule-required="true" data-msg-required="Please Enter Province Title">
                        <option value="">Select Province</option>
                        <option value="Azad Kashmir">Azad Kashmir</option>
                        <option value="Balochistan">Balochistan</option>
                        <option value="Federally Administered Tribal Areas">Federally Administered Tribal Areas</option>
                        <option value="Gilgit Baltistan">Gilgit Baltistan</option>
                        <option value="Khyber Pakhtunkhwa">Khyber Pakhtunkhwa</option>
                        <option value="Punjab">Punjab</option>
                        <option value="Sindh">Sindh</option>
                    </select>
                    <span id="demo1" class="validate_sign"> </span>
                </div><!-- end input box -->
                <div class="input_bx form-group col-lg-12 col-md-12 col-sm-12"><!-- start input box -->
                    <label class="required"> City Name</label>
                    <input tabindex="2" type="text" name="city_name" id="city_name" class="inputs_up form-control" placeholder="City Name" autocomplete="off"
                            value="{{ old('city_name') }}" data-rule-required="true" data-msg-required="Please Enter City Name">
                    <span id="demo2" class="validate_sign"> </span>
                </div><!-- end input box -->
                <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                    <button tabindex="4" type="reset" name="cancel" id="cancel" class="cancel_button btn btn-secondary btn-sm">
                        <i class="fa fa-eraser"></i> Cancel
                    </button>
                    <button tabindex="5" type="submit" name="save" id="save" class="save_button  btn btn-success btn-sm">
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
            let province = document.getElementById("province"),
                city_name = document.getElementById("city_name");
            validateInputIdArray = [
                province.id,
                city_name.id,
            ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}

    <script>
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $(function () {
            $('[data-toggle="popover"]').popover()
        });
    </script>

    <script>
        $('#province').select2();
        jQuery("#refresh_region").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_region",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#province").html(" ");
                    jQuery("#province").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>

    <script>



@endsection

@section('shortcut_script')

@endsection

