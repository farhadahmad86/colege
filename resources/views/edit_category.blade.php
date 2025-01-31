
@extends('extend_index')

@section('content')

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Edit Category</h4>
                            </div>
                        </div>
                    </div><!-- form header close -->

                    <form name="f1" class="f1" id="f1" action="{{ route('update_category') }}" onsubmit="return checkForm()" method="post" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                        <div class="row">

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.category.group_title.description')}}</p>
                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.category.group_title.benefits')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Product Group Title
                                                    </label>
                                                    <select name="group_name" class="inputs_up form-control" id="group_name"
                                                            data-rule-required="true" data-msg-required="Please Enter Group Title"
                                                    >
                                                        <option value="">Select Group</option>
                                                        @foreach($groups as $group)
                                                            <option value="{{$group->grp_id}}" data-tax="{{$group->grp_tax}}" data-retailer="{{$group->grp_retailer_discount}}"
                                                                    data-wholesaler="{{$group->grp_whole_seller_discount}}"
                                                                    data-loyalty_card="{{$group->grp_loyalty_card_discount}}" {{ $group->grp_id == $category->cat_group_id ? 'selected="selected"' : ''
                                                            }}>{{$group->grp_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.category.category_title.description')}}</p>
                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.category.category_title.benefits')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Product Category Title
                                                    </label>
                                                    <input type="text" name="category_name" id="category_name" class="inputs_up form-control" placeholder="Product Category Title"
                                                           data-rule-required="true" data-msg-required="Please Enter Product Category Title"
                                                           value="{{$category->cat_title}}" autocomplete="off">
                                                    <span id="demo2" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="
                                                                       <h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.category.use_group_Tax/Discount.description')}}</p>
                                                                       <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.category.use_group_Tax/Discount.benefits')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Use Group Tax/Discount</label>
                                                    <input type="checkbox" name="check_group" id="check_group" class="inputs_up form-control" value="1" {{$category->cat_use_group_fields ==0 ?
                                                    '':'Checked'}}>
                                                    <span id="demo3" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="
                                                                   <h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.category.tax_%.description')}}</p>
                                                                   <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.category.tax_%.benefits')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Tax %</label>
                                                    <input type="text" name="tax" id="tax" value="{{$category->cat_tax ==0 ? '':$category->cat_tax}}" class="inputs_up form-control" placeholder="Tax %"
                                                           onkeypress="return allow_only_number_and_decimals(this,event);">
                                                    <span id="demo4" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.category.retailer_discount_%.description')}}</p>
                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.category.retailer_discount_%.benefits')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Retailer Discount %</label>
                                                    <input type="text" name="retailer" id="retailer" value="{{$category->cat_retailer_discount ==0 ? '':$category->cat_retailer_discount}}"
                                                           class="inputs_up form-control" placeholder="Retailer Discount %"
                                                           onkeypress="return allow_only_number_and_decimals(this,event);">
                                                    <span id="demo5" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.category.whole_seller_discount_%.description')}}</p>
                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.category.whole_seller_discount_%.benefits')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Whole Saler Discount %</label>
                                                    <input type="text" name="wholesaler" id="wholesaler" value="{{$category->cat_whole_seller_discount ==0 ? '':$category->cat_whole_seller_discount}}"
                                                           class="inputs_up form-control" placeholder="Whole Saler %"
                                                           onkeypress="return allow_only_number_and_decimals(this,event);">
                                                    <span id="demo6" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.category.loyalty_card_%.description')}}</p>
                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.category.loyalty_card_%.benefits')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Loyalty Card %</label>
                                                    <input type="text" name="loyalty_card" id="loyalty_card"
                                                           value="{{$category->cat_loyalty_card_discount ==0 ? '':$category->cat_loyalty_card_discount}}" class="inputs_up form-control"
                                                           placeholder="Loyalty Card %"
                                                           onkeypress="return allow_only_number_and_decimals(this,event);">
                                                    <span id="demo7" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>


                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                        <div class="row">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
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
                                                    <textarea name="remarks" id="remarks" class="remarks inputs_up form-control" placeholder="Remarks">{{$category->cat_remarks}}</textarea>
                                                    <span id="demo3" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <input value="{{$category->cat_id}}" type="hidden" name="category_id">
                                        </div>

                                    </div>

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
            let group_name = document.getElementById("group_name"),
                category_name = document.getElementById("category_name"),
                validateInputIdArray = [
                    group_name.id,
                    category_name.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">

        function validate_form() {
            var group_name = document.getElementById("group_name").value;
            var category_name = document.getElementById("category_name").value;
            var remarks = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;

            if (group_name.trim() == "") {
                document.getElementById("demo1").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#group_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo1").innerHTML = "";
            }

            if (category_name.trim() == "") {
                document.getElementById("demo2").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#category_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo2").innerHTML = "";
            }

            // if(remarks.trim() == "")
            // {
            //     document.getElementById("demo3").innerHTML = "Required";
            //     if (focus_once == 0) { jQuery("#remarks").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //     document.getElementById("demo3").innerHTML = "";
            // }


            return flag_submit;
        }


        var tax = '';
        var retailer = '';
        var wholesaler = '';
        var loyalty_card = '';

        jQuery("#group_name").change(function () {

            tax = jQuery('option:selected', this).attr('data-tax');
            retailer = jQuery('option:selected', this).attr('data-retailer');
            wholesaler = jQuery('option:selected', this).attr('data-wholesaler');
            loyalty_card = jQuery('option:selected', this).attr('data-loyalty_card');
            $("#check_group").trigger("change");
        });


        $("#check_group").change(function () {
            if (this.checked) {

                $('#tax').attr('readonly', true);
                $('#retailer').attr('readonly', true);
                $('#wholesaler').attr('readonly', true);
                $('#loyalty_card').attr('readonly', true);

                jQuery("#tax").val(tax);
                jQuery("#retailer").val(retailer);
                jQuery("#wholesaler").val(wholesaler);
                jQuery("#loyalty_card").val(loyalty_card);
            } else {

                $('#tax').attr('readonly', false);
                $('#retailer').attr('readonly', false);
                $('#wholesaler').attr('readonly', false);
                $('#loyalty_card').attr('readonly', false);

                jQuery("#tax").val('');
                jQuery("#retailer").val('');
                jQuery("#wholesaler").val('');
                jQuery("#loyalty_card").val('');
            }
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#group_name").select2();

            $("#group_name").trigger("change");
            $("#check_group").trigger("change");

        });
    </script>

@endsection

