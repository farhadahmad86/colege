
@extends('extend_index')

@section('content')
    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 tabindex="-1" class="text-white get-heading-text">Create Town</h4>
                            </div>
                            <div class="list_btn">
                                <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('town_list') }}" role="button">
                                    <i class="fa fa-list"></i> view list
                                </a>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 mx-auto">
                    <div class="excel_con">
                        <div class="excel_box">
                            <div class="excel_box_hdng">
                                <h2>
                                    Upload Excel File
                                </h2>
                            </div>
                            <div class="excel_box_content">
                                <form action="{{ route('submit_town_excel') }}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">
                                                    Select Excel File
                                                </label>
                                                <input tabindex="100" type="file" name="add_town_excel" id="add_town_excel" class="inputs_up form-control-file form-control height-auto"
                                                       accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                            </div><!-- end input box -->
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                            <a href="{{ url('public/sample/town/add_town_pattern.xlsx') }}" tabindex="-1" type="reset" class="cancel_button btn btn-sm btn-info">
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

                    <form name="f1" class="f1" id="f1" action="{{ route('submit_town') }}" onsubmit="return checkForm()" method="post" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                        <div class="row">

                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        <a
                                                            data-container="body" data-toggle="popover" data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.region.name.description')}}</p><h6>Benefit</h6><p>{{
                                config('fields_info.about_form_fields.party_registration.region.name.benefits')}}</p><h6>Example</h6><p>{{
                                config('fields_info.about_form_fields.party_registration.region.name.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.region.name.validations') }}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Region Title
                                                        <a tabindex="-1" href="{{ route('add_region') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                            <l class="fa fa-plus"></l> Add
                                                        </a>
                                                        <a tabindex="-1" class="add_btn"  id="refresh_region" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                            <l class="fa fa-refresh"></l>
                                                        </a>

                                                        </label>
                                                        <select tabindex= 1 autofocus name="region_name" class="inputs_up form-control" id="region_name" autofocus data-rule-required="true" data-msg-required="Please Enter Region Title">
                                                            <option value="">Select Region</option>
                                                            @foreach($regions as $region)
                                                                <option value="{{$region->reg_id}}">{{$region->reg_title}}</option>
                                                            @endforeach

                                                        </select>
                                                        <span id="demo1" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label class="required">
                                                            <a
                                                                data-container="body" data-toggle="popover" data-trigger="hover"
                                                                data-placement="bottom" data-html="true"
                                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.area.area_title.description')}}</p><h6>Benefit</h6><p>{{
                                                        config('fields_info.about_form_fields.party_registration.area.area_title.benefits')}}</p><h6>Example</h6><p>{{
                                                        config('fields_info.about_form_fields.party_registration.area.area_title.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.area.area_title.validations') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Area Title
                                                            <a href="{{ route('add_area') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                <l class="fa fa-plus"></l> Add
                                                            </a>
                                                            <a class="add_btn"  id="refresh_area" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                <l class="fa fa-refresh"></l>
                                                            </a>
                                                        </label>
                                                        <select tabindex="2" name="area_name" class="inputs_up form-control" id="area_name" data-rule-required="true" data-msg-required="Please Enter Area Title">
                                                            <option value="">Select Area</option>
                                                        </select>
                                                        <span id="demo2" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label class="required">
                                                            <a
                                                                data-container="body" data-toggle="popover" data-trigger="hover"
                                                                data-placement="bottom" data-html="true"
                                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.description')}}</p><h6>Benefit</h6><p>{{
                                                        config('fields_info.about_form_fields.party_registration.sector.sector_title.benefits')}}</p><h6>Example</h6><p>{{
                                                        config('fields_info.about_form_fields.party_registration.sector.sector_title.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.validations') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Sector Title
                                                            <a tabindex="-1" href="{{ route('add_sector') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                <l class="fa fa-plus"></l>
                                                            </a>
                                                            <a tabindex="-1" id="refresh_sector" class="add_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                <l class="fa fa-refresh"></l>
                                                            </a>
                                                        </label>
                                                        <select tabindex="3" name="sector_name" class="inputs_up form-control" id="sector_name" data-rule-required="true" data-msg-required="Please Enter Sector Title">
                                                            <option value="">Select Sector</option>
                                                        </select>
                                                        <span id="demo3" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label class="required">
                                                            <a
                                                                data-container="body" data-toggle="popover" data-trigger="hover"
                                                                data-placement="bottom" data-html="true"
                                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.town.description')}}</p>
                                        <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.town.benefits')}}</p>
                                        <h6>Example</h6><p>{{config('fields_info.about_form_fields.town.example')}}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Town Name</label>
                                                        <input tabindex="4" type="text" name="town_name" id="town_name" class="inputs_up form-control" placeholder="Town Name" data-rule-required="true" data-msg-required="Please Enter Town Name">
                                                        <span id="demo4" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                            </div>
                                        </div>


                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

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
                                                        <textarea tabindex="5" name="remarks" id="remarks" class="inputs_up remarks form-control" style="height: 100px;" placeholder="Remarks"></textarea>
                                                        <span id="demo5" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                            <button tabindex="6" type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-secondary">
                                                <i class="fa fa-eraser"></i> Cancel
                                            </button>
                                            <button tabindex="7" type="button" name="save" id="save" class="save_button btn btn-sm btn-success" >
                                                <i class="fa fa-floppy-o"></i> Save
                                            </button>
                                        </div>
                                    </div>

                                </div> <!-- left column ends here -->

                            </div> <!--  main row ends here -->


                        </form>
                    </div></div></div> <!-- white column form ends here -->


                </div><!-- col end -->


            </div><!-- row end -->

    @endsection

    @section('scripts')
        {{--    required input validation --}}
        <script type="text/javascript">
            function checkForm() {
                let region_name = document.getElementById("region_name"),
                area_name = document.getElementById("area_name"),
                sector_name = document.getElementById("sector_name"),
                town_name = document.getElementById("town_name"),
                validateInputIdArray = [
                    region_name.id,
                    area_name.id,
                    sector_name.id,
                    town_name.id,
                ];
                var check = validateInventoryInputs(validateInputIdArray);
                if (check == true) {
                    remarks = document.getElementById("remarks").value;

                    jQuery(".pre-loader").fadeToggle("medium");

                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{route('submit_town')}}",
                        type: "POST",
                        cache: false,
                        dataType: 'json',
                        data: {
                            'region_name': region_name.value,
                            'area_name': area_name.value,
                            'sector_name': sector_name.value,
                            'town_name': town_name.value,
                            'remarks': remarks,
                        },

                        success: function (data) {
                            console.log(data);
                            console.log(data.message);
                            if(data.already_exist != null){
                                swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: 'Already Exist Town Name Try Another Name',
                                    showCancelButton: false,
                                    confirmButtonClass: 'btn btn-success',
                                    timer: 4000
                                });

                            }else{
                                $('#sector_name').val('');
                                $('#remarks').val('');

                                swal.fire({
                                    title: 'Successfully Saved'+'  '+data.name,
                                    text: false,
                                    type: 'success',
                                    showCancelButton: false,
                                    confirmButtonClass: 'btn btn-success',
                                    timer: 4000
                                });
                            }

                            jQuery(".pre-loader").fadeToggle("medium");
                        },
                        error: function () {
                            alert('error handling here');
                        }
                    });
                } else {
                    return false;
                }
            }
        </script>
        <script>
            $("#save").click(function () {
                checkForm();
            });
        </script>
        {{-- end of required input validation --}}
        <script>
            jQuery("#refresh_region").click(function() {

                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });

                jQuery.ajax({
                    url: "refresh_region",
                    data:{},
                    type: "POST",
                    cache:false,
                    dataType: 'json',
                    success:function(data){

                        jQuery("#region_name").html(" ");
                        jQuery("#region_name").append(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                        alert(errorThrown);}
                });
            });

            jQuery("#refresh_area").click(function() {

                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                var region_id = $('#region_name option:selected').val();

                jQuery.ajax({
                    url: "refresh_area",
                    data:{},
                    type: "POST",
                    cache:false,
                    dataType: 'json',
                    data: {
                        region_id: region_id,
                    },
                    success:function(data){
                        jQuery("#area_name").html(" ");
                        jQuery("#area_name").append(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(jqXHR.responseText);
                        alert(errorThrown);}
                });
            });

            jQuery("#refresh_sector").click(function () {

                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                var area_id = $('#area_name option:selected').val();
                jQuery.ajax({
                    url: "refresh_sector",
                    data: {},
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        area_id: area_id,
                    },
                    success: function (data) {

                        jQuery("#sector_name").html(" ");
                        jQuery("#sector_name").append(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(jqXHR.responseText);
                        alert(errorThrown);
                    }
                });
            });
        </script>

        <script>
            jQuery("#region_name").change(function() {

                var dropDown = document.getElementById('region_name');
                var reg_id = dropDown.options[dropDown.selectedIndex].value;

                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });

                jQuery.ajax({
                    url: "get_area",
                    data:{reg_id: reg_id},
                    type: "POST",
                    cache:false,
                    dataType: 'json',
                    success:function(data){

                        jQuery("#area_name").html(" ");
                        jQuery("#area_name").append(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // alert(jqXHR.responseText);
                        // alert(errorThrown);
                        }
                });
            });


            jQuery("#area_name").change(function () {

                var dropDown = document.getElementById('area_name');
                var area_id = dropDown.options[dropDown.selectedIndex].value;

                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });

                jQuery.ajax({
                    url: "get_sector",
                    data: {area_id: area_id},
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    success: function (data) {

                        jQuery("#sector_name").html(" ");
                        jQuery("#sector_name").append(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // alert(jqXHR.responseText);
                        // alert(errorThrown);
                    }
                });
            });

        </script>

        <script type="text/javascript">

            // function validate_form()
            // {
            //     var region_name  = document.getElementById("region_name").value;
            //     var area_name  = document.getElementById("area_name").value;
            //     var sector_name  = document.getElementById("sector_name").value;
            //     var town_name  = document.getElementById("town_name").value;
            //     var remarks  = document.getElementById("remarks").value;
            //
            //     var flag_submit = true;
            //     var focus_once = 0;
            //
            //     if(region_name.trim() == "")
            //     {
            //         document.getElementById("demo1").innerHTML = "Required";
            //         if (focus_once == 0) { jQuery("#region_name").focus(); focus_once = 1;}
            //         flag_submit = false;
            //     }else{
            //         document.getElementById("demo1").innerHTML = "";
            //     }
            //
            //     if(area_name.trim() == "")
            //     {
            //         document.getElementById("demo2").innerHTML = "Required";
            //         if (focus_once == 0) { jQuery("#area_name").focus(); focus_once = 1;}
            //         flag_submit = false;
            //     }else{
            //         document.getElementById("demo2").innerHTML = "";
            //     }
            //
            //     if(sector_name.trim() == "")
            //     {
            //         document.getElementById("demo3").innerHTML = "Required";
            //         if (focus_once == 0) { jQuery("#sector_name").focus(); focus_once = 1;}
            //         flag_submit = false;
            //     }else{
            //         document.getElementById("demo3").innerHTML = "";
            //     }
            //
            //     if(town_name.trim() == "")
            //     {
            //         document.getElementById("demo4").innerHTML = "Required";
            //         if (focus_once == 0) { jQuery("#town_name").focus(); focus_once = 1;}
            //         flag_submit = false;
            //     }else{
            //         document.getElementById("demo4").innerHTML = "";
            //     }
            //
            //     // if(remarks.trim() == "")
            //     // {
            //     //     document.getElementById("demo5").innerHTML = "Required";
            //     //     if (focus_once == 0) { jQuery("#remarks").focus(); focus_once = 1;}
            //     //     flag_submit = false;
            //     // }else{
            //     //     document.getElementById("demo5").innerHTML = "";
            //     // }
            //
            //     return flag_submit;
            // }

        </script>

        <script>
            jQuery(document).ready(function () {
                // Initialize select2
                jQuery("#region_name").select2();
                jQuery("#area_name").select2();
                jQuery("#sector_name").select2();
            });
        </script>

    @endsection


