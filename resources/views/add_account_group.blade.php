@extends('extend_index')

@section('styles_get')
    <style>
        input,
        textarea,
        select,
        .select2 {
            border: 1px solid #8e8e8e !important;
            border-radius: 4px !important;
            height: 32px !important;
            padding: 0 10px !important;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }

        .select2 {
            padding: 5px 10px !important;
        }
    </style>
@endsection

@section('content')

    <div class="row">
            <div class="container-fluid search-filter form-group form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Create Account Group</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('account_group_list') }}" role="button">
                                <l class="fa fa-list"></l>
                                view list
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

                            <form action="{{ route('submit_account_group_excel') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                Select Excel File
                                            </label>
                                            <input tabindex="100" type="file" name="add_create_account_group_pattern_excel" id="add_create_account_group_pattern_excel"
                                                   class="inputs_up form-control-file form-control height-auto"
                                                   accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        </div><!-- end input box -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                        <a href="{{ url('public/sample/account_reporting_group/add_create_account_group_pattern.xlsx') }}" tabindex="-1" type="reset" class="cancel_button btn btn-sm btn-info">
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

                <form name="f1" class="f1 mx-auto col-lg-6 col-md-6 col-sm-12 col-xs-12" id="f1" action="{{ route('submit_account_group') }}" onsubmit="return checkForm()" method="post">
                    @csrf
                    <div class="row">

<div class="form-group col-lg-12 col-md-12 col-sm-12">
    <div class="input_bx"><!-- start input box -->
        <label class="required">
            <a data-container="body" data-toggle="popover" data-trigger="hover"
               data-placement="bottom" data-html="true"
               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.account_registration.reporting_group.account_viewing_group_name.description')}}</p>
            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.account_registration.reporting_group.account_viewing_group_name.benefits')}}</p>
            <h6>Example</h6><p>{{config('fields_info.about_form_fields.account_registration.reporting_group.account_viewing_group_name.example')}}</p>
            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.account_registration.reporting_group.account_viewing_group_name.validations')}}</p>">
                <i class="fa fa-info-circle"></i>
            </a>
            Account Ledger Access Group Name</label>
        <input tabindex=1 autofocus type="text" name="group_name" id="group_name" class="inputs_up form-control shadow rounded" data-rule-required="true"
               data-msg-required="Please Enter  Account Ledger Access Group"
               placeholder="Account Ledger Access Group Name" autofocus autocomplete="off" data-inputmask="'mask': '99/99/9999'" value="{{old('group_name')}}"/>
        <span id="demo1" class="validate_sign"> </span>
    </div><!-- end input box -->
</div>

<div class="form-group col-lg-12 col-md-12 col-sm-12">
    <div class="input_bx"><!-- start input box -->
        <label class="">
            <a
                data-container="body" data-toggle="popover" data-trigger="hover"
                data-placement="bottom" data-html="true"
                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
                config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
                config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                <i class="fa fa-info-circle"></i>
            </a>
            Remarks</label>
        <textarea tabindex="2" name="remarks" id="remarks" class="remarks inputs_up form-control shadow rounded" placeholder="Remarks"
                  style="height: 180px !important;">{{old('remarks')}}</textarea>
        <span id="demo2" class="validate_sign"> </span>
    </div><!-- end input box -->
</div>

</div>
<div class="form-group row">
<div class="col-lg-12 col-md-12 col-sm-12 form_controls">
    <button tabindex="3" type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-info">
        <i class="fa fa-eraser"></i> Cancel
    </button>
    <button tabindex="4" type="submit" name="save" id="save" class="save_button btn btn-sm btn-success">
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
            let group_name = document.getElementById("group_name"),
                validateInputIdArray = [
                    group_name.id,
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

        function form_validation() {
            var group_name = document.getElementById("group_name").value;
            var remarks = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;

            // if(group_name.trim() == "")
            // {
            //     document.getElementById("demo1").innerHTML = "Required";
            //     if (focus_once == 0) { jQuery("#group_name").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //     document.getElementById("demo1").innerHTML = "";
            // }

            // if(remarks.trim() == "")
            // {
            //     document.getElementById("demo2").innerHTML = "Required";
            //     if (focus_once == 0) { jQuery("#remarks").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //     document.getElementById("demo2").innerHTML = "";
            // }
            return flag_submit;
        }
    </script>

@endsection


