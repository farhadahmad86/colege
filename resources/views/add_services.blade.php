@extends('extend_index')
@section('content')
<div class="row">
    <div class="container-fluid search-filter form-group form_manage">
        <div class="form_header"><!-- form header start -->
            <div class="clearfix">
                <div class="pull-left">
                    <h4 tabindex="-1" class="text-white get-heading-text">Create Service</h4>
                </div>
                <div class="list_btn">
                    <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('services_list') }}" role="button">
                        <i class="fa fa-list"></i> view list
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
                    <form action="{{ route('submit_services_excel') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">
                                        Select Excel File
                                    </label>
                                    <input tabindex="100" type="file" name="add_services_excel" id="add_services_excel" class="inputs_up form-control-file form-control height-auto"
                                            accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                </div><!-- end input box -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                                <a href="{{ url('public/sample/add_services/add_services_pattern.xlsx') }}" tabindex="-1" type="reset" class="cancel_button btn-btn-sm btn-secondary">
                                    Download Sample Pattern
                                </a>
                                <button tabindex="101" type="submit" name="save" id="save2" class="save_button btn-btn-sm btn-success">
                                    <i class="fa fa-floppy-o"></i> Save
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <form name="f1" class="f1 mx-auto col-lg-6 col-md-6 col-sm-12 col-xs-12" id="f1" action="{{ route('submit_services') }}" onsubmit="return checkForm()" method="post" autocomplete="off">
            @csrf
            <div class="row">
            <div class="input_bx form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><!-- start input box -->
                <label class="required">
                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                        data-placement="bottom" data-html="true"
                        data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.service.service_title.description')}}</p>">
                        <i class="fa fa-info-circle"></i>
                    </a>
                    Service Title</label>
                <input tabindex=1 autofocus type="text" name="service_name" id="service_name" class="inputs_up form-control" data-rule-required="true" data-msg-required="Please Enter Service Title" value="{{old('service_name')}}" placeholder="Service Title" autofocus />
                <span id="demo1" class="validate_sign"> </span>
            </div><!-- end input box -->
            <div class="input_bx form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><!-- start input box -->
                <label class="">
                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                        data-placement="bottom" data-html="true"
                        data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                        <i class="fa fa-info-circle"></i>
                    </a>
                    Remarks</label>
                <textarea tabindex="2" name="remarks" id="remarks" class="remarks inputs_up form-control" placeholder="Remarks"> {{old('remarks')}}</textarea>
                <span id="demo2" class="validate_sign"> </span>
            </div><!-- end input box -->
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                <button tabindex="3" type="reset" name="cancel" id="cancel" class="cancel_button btn-btn-sm btn-secondary">
                    <i class="fa fa-eraser"></i> Cancel
                </button>
                <button tabindex="4" type="submit" name="save" id="save" class="save_button btn-btn-sm btn-success">
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
            let service_name = document.getElementById("service_name"),
            validateInputIdArray = [
                service_name.id,
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



        function form_validation()
        {
            var service_name  = document.getElementById("service_name").value;

            var flag_submit = true;
            var focus_once = 0;

            // if(service_name.trim() == "")
            // {
            //     document.getElementById("demo1").innerHTML = "Required";
            //     if (focus_once == 0) { jQuery("#service_name").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //     document.getElementById("demo1").innerHTML = "";
            // }

            return flag_submit;
        }

    </script>

@endsection


