@extends('extend_index')

@section('content')
<div class="row">
    <div class="container-fluid search-filter form-group form_manage">
        <div class="form_header"><!-- form header start -->
            <div class="clearfix">
                <div class="pull-left">
                    <h4 tabindex="-1" class="text-white get-heading-text">Create Group</h4>
                </div>
                <div class="list_btn">
                    <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('group_list') }}" role="button">
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

                    <form action="{{ route('submit_group_excel') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">
                                        Select Excel File
                                    </label>
                                    <input tabindex="100" type="file" name="add_group_excel" id="add_group_pattern_excel" class="inputs_up form-control-file form-control height-auto"
                                            accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                </div><!-- end input box -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                <a href="{{ url('public/sample/create_group/add_group_pattern.xlsx') }}" tabindex="-1" type="reset" class="cancel_button btn btn-sm btn-info">
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
        <form name="f1" class="f1 col-lg-6 col-md-6 mx-auto" id="f1" action="{{ route('submit_group') }}" onsubmit="return checkForm()" method="post" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="input_bx form-group"><!-- start input box -->
                        <label class="required">
                            <a tabindex="-1" data-container="body" data-toggle="popover" data-trigger="hover"
                                data-placement="bottom" data-html="true"
                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.group.group_title.description')}}</p>
                                <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.group.group_title.benefits')}}</p>">
                                <i class="fa fa-info-circle"></i>
                            </a>
                            Product Group Title</label>
                        <input tabindex=1 autofocus type="text" name="group_name" id="group_name" class="inputs_up form-control" data-rule-required="true" data-msg-required="Please Enter Product Group Title" value="{{ old('group_name') }}" placeholder="Product Group Title">
                        <span id="demo1" class="validate_sign"> </span>
                    </div><!-- end input box -->
                    <div class="input_bx form-group"><!-- start input box -->
                        <label class="">
                            <a
                                data-container="body" data-toggle="popover" data-trigger="hover"
                                data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
                                config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
                                config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                <i class="fa fa-info-circle"></i>
                            </a>
                            Remarks</label>
                        <textarea tabindex="2" name="remarks" id="remarks" class="remarks inputs_up form-control" placeholder="Remarks" style="height: 145px;"> {{ old('remarks') }}</textarea>
                        <span id="demo2" class="validate_sign"> </span>
                    </div><!-- end input box -->
                </div> <!-- left column ends here -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="input_bx form-group"><!-- start input box -->
                        <label class="">
                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                data-placement="bottom" data-html="true"
                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.group.Tax_%.description')}}</p>
                        <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.group.Tax_%.benefits')}}</p>">
                                <i class="fa fa-info-circle"></i>
                            </a>
                            Tax %</label>
                        <input tabindex="3" type="text" name="tax" id="tax" class="inputs_up form-control" value="{{ old('tax') }}" placeholder="Tax %" onkeypress="return allow_only_number_and_decimals(this,event);">
                        <span id="demo3" class="validate_sign"> </span>
                    </div><!-- end input box -->
                    <div class="input_bx"><!-- start input box -->
                        <label class="">
                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                data-placement="bottom" data-html="true"
                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.group.retailer_discount_%.description')}}</p>
                        <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.group.retailer_discount_%.benefits')}}</p>">
                                <i class="fa fa-info-circle"></i>
                            </a>
                            Retailer Discount %</label>
                        <input tabindex="4" type="text" name="retailer" id="retailer" class="inputs_up form-control" value="{{ old('retailer') }}" placeholder="Retailer Discount %" onkeypress="return allow_only_number_and_decimals(this,event);">
                        <span id="demo4" class="validate_sign"> </span>
                    </div><!-- end input box -->
                    <div class="input_bx"><!-- start input box -->
                        <label class="">
                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                data-placement="bottom" data-html="true"
                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.group.whole_seller_discount_%.description')}}</p>
                        <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.group.whole_seller_discount_%.benefits')}}</p>">
                                <i class="fa fa-info-circle"></i>
                            </a>
                            Whole Saler Discount %</label>
                        <input tabindex="5" type="text" name="wholesaler" id="wholesaler" class="inputs_up form-control" value="{{ old('wholesaler') }}" placeholder="Whole Saler %" onkeypress="return allow_only_number_and_decimals(this,event);">
                        <span id="demo5" class="validate_sign"> </span>
                    </div><!-- end input box -->
                    <div class="input_bx"><!-- start input box -->
                        <label class="">
                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                data-placement="bottom" data-html="true"
                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.group.loyalty_card_%.description')}}</p>
                        <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.group.loyalty_card_%.benefits')}}</p>">
                                <i class="fa fa-info-circle"></i>
                            </a>
                            Loyalty Card %</label>
                        <input tabindex="6" type="text" name="loyalty_card" id="loyalty_card" class="inputs_up form-control" value="{{ old('loyalty_card') }}" placeholder="Loyalty Card %" onkeypress="return allow_only_number_and_decimals(this,event);">
                        <span id="demo6" class="validate_sign"> </span>
                    </div><!-- end input box -->
                    <div class="form-group row">
                        <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                            <button tabindex="7" type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-secondary">
                                <i class="fa fa-eraser"></i> Cancel
                            </button>
                            <button tabindex="8" type="submit" name="save" id="save" class="save_button btn btn-sm btn-success">
                                <i class="fa fa-floppy-o"></i> Save
                            </button>
                        </div>
                    </div>
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

    </script>

@endsection

