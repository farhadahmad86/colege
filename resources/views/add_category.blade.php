@extends('extend_index')
@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Category</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('category_list') }}" role="button">
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
                        <form action="{{ route('submit_category_excel') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Select Excel File
                                        </label>
                                        <input tabindex="100" type="file" name="add_create_category_excel" id="add_create_category_pattern_excel"
                                                class="inputs_up form-control-file form-control height-auto"
                                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                    </div><!-- end input box -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <a href="{{ url('public/sample/create_category/add_create_category_pattern.xlsx') }}" tabindex="-1" type="reset" class="cancel_button btn btn-sm btn-info">
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
            <form name="f1" class="f1 col-lg-7 col-md-12 mx-auto" id="f1" action="{{ route('submit_category') }}" onsubmit="return checkForm()" method="post" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="input_bx form-group col-lg-4 col-md-6 col-sm-12"><!-- start input box -->
                                <label class="required">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                        data-placement="bottom" data-html="true"
                                        data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.category.group_title.description')}}</p>
                                        <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.category.group_title.benefits')}}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Product Group Title
                                    <a href="{{ route('add_group') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover"
                                        data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    <a id="refresh_group_name" class="add_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                        data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                        <l class="fa fa-refresh"></l>
                                    </a>
                                </label>
                            
                                <select tabindex="1" autofocus name="group_name" class="inputs_up form-control" id="group_name" data-rule-required="true"
                                        data-msg-required="Please Enter Product Group Title">
                                    <option value="">Select Product Group Title</option>
                                    @foreach($groups as $group)
                                        <option value="{{$group->grp_id}}" {{$group->grp_id == old('group_name') ? 'selected="selected"' : ''}} data-tax="{{$group->grp_tax}}"
                                                data-retailer="{{$group->grp_retailer_discount}}"
                                                data-wholesaler="{{$group->grp_whole_seller_discount}}"
                                                data-loyalty_card="{{$group->grp_loyalty_card_discount}}">{{$group->grp_title}}</option>
                                    @endforeach
                                </select>
                                <span id="demo1" class="validate_sign"> </span>
                            </div><!-- end input box -->
                            <div class="input_bx form-group col-lg-4 col-md-6 col-sm-12"><!-- start input box -->
                                <label class="required">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                        data-placement="bottom" data-html="true"
                                        data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.category.category_title.description')}}</p>
                                        <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.category.category_title.benefits')}}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Product Category Title</label>
                                <input tabindex="2" type="text" name="category_name" id="category_name" class="inputs_up form-control" data-rule-required="true"
                                        data-msg-required="Please Enter Product Category Title" value="{{old('category_name')}}" placeholder="Product Category Title">
                                <span id="demo2" class="validate_sign"> </span>
                            </div><!-- end input box -->
                            <div class="input_bx form-group col-lg-4 col-md-6 col-sm-12 mt-lg-4">
                                <div class="custom-checkbox float-left">
                                    <input tabindex="-1" type="checkbox" name="check_group" id="check_group" class="custom-control-input company_info_check_box" value="1">
                                    <label class="custom-control-label chck_pdng" for="check_group">
                                        <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="
                                                <h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.category.use_group_Tax/Discount.description')}}</p>
                                                <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.category.use_group_Tax/Discount.benefits')}}</p>">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        Use Group Tax/Discount
                                    </label>
                                </div>
                                <span id="demo3" class="validate_sign"> </span>
                            </div>
                            <div class="input_bx form-group col-lg-6 col-md-6 col-sm-12">
                                <label class="">
                                    <a tabindex="-1" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="
                                            <h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.category.tax_%.description')}}</p>
                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.category.tax_%.benefits')}}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Tax %
                                </label>
                                <input tabindex="3" type="text" name="tax" id="tax" class="inputs_up form-control" placeholder="Tax %" value="{{old('tax')}}"
                                        onkeypress="return allow_only_number_and_decimals(this,event);">
                                <span id="demo4" class="validate_sign"> </span>
                            </div>
                            <div class="input_bx form-group col-lg-6 col-md-6 col-sm-12"><!-- start input box -->
                                <label class="">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                        data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.category.retailer_discount_%.description')}}</p>
                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.category.retailer_discount_%.benefits')}}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Retailer Discount %</label>
                                    
                                <input tabindex="4" type="text" name="retailer" id="retailer" class="inputs_up form-control" placeholder="Retailer Discount %"
                                        value="{{old('retailer')}}"
                                        onkeypress="return allow_only_number_and_decimals(this,event);">
                                <span id="demo5" class="validate_sign"> </span>
                            </div><!-- end input box -->
                            <div class="input_bx form-group col-lg-6 col-md-6 col-sm-12"><!-- start input box -->
                                <label class="">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                        data-placement="bottom" data-html="true"
                                        data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.category.whole_seller_discount_%.description')}}</p>
                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.category.whole_seller_discount_%.benefits')}}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Whole Saler Discount %</label>
                                <input tabindex="5" type="text" name="wholesaler" id="wholesaler" class="inputs_up form-control" placeholder="Whole Saler %" value="{{old('wholesaler')}}" onkeypress="return allow_only_number_and_decimals(this,event);">
                                <span id="demo6" class="validate_sign"> </span>
                            </div><!-- end input box -->
                            <div class="input_bx form-group col-lg-6 col-md-6 col-sm-12"><!-- start input box -->
                                <label class="">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.category.loyalty_card_%.description')}}</p>
                                        <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.category.loyalty_card_%.benefits')}}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Loyalty Card %</label>
                                <input tabindex="6" type="text" name="loyalty_card" id="loyalty_card" class="inputs_up form-control" placeholder="Loyalty Card %" value="{{old('loyalty_card')}}" onkeypress="return allow_only_number_and_decimals(this,event);">
                                <span id="demo7" class="validate_sign"> </span>
                            </div><!-- end input box -->
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                        <div class="input_bx form-group"><!-- start input box -->
                            <label class="">
                                <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                        <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                        <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                        <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                    <i class="fa fa-info-circle"></i>
                                </a>
                                Remarks</label>
                            <textarea tabindex="7" name="remarks" id="remarks" class="remarks inputs_up form-control" placeholder="Remarks" style="height: 165px">{{old('remarks')}}</textarea>
                            <span id="demo8" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                        <button tabindex="8" type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-secondary">
                            <i class="fa fa-eraser"></i> Cancel
                        </button>
                        <button tabindex="9" type="button" name="save" id="save" class="save_button btn btn-sm btn-success">
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
                category_name = document.getElementById("category_name");
            validateInputIdArray = [
                group_name.id,
                category_name.id,
            ];

            var check = validateInventoryInputs(validateInputIdArray);

            if (check == true) {
                let remarks = document.getElementById("remarks").value,
                    tax = document.getElementById("tax").value,
                    retailer = document.getElementById("retailer").value,
                    wholesaler = document.getElementById("wholesaler").value,
                    loyalty_card = document.getElementById("loyalty_card").value;
                var check_group = $("input:checkbox[name=check_group]:checked").val();

                jQuery(".pre-loader").fadeToggle("medium");

                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('submit_category')}}",
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'group_name': group_name.value,
                        'category_name': category_name.value,
                        'tax': tax,
                        'retailer': retailer,
                        'wholesaler': wholesaler,
                        'loyalty_card': loyalty_card,
                        'check_group': check_group,
                        'remarks': remarks,
                    },

                    success: function (data) {
                        console.log(data);
                        console.log(data.message);
                        if (data.already_exist != null) {
                            swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Already Exist Category Name Try Another Name',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-success',
                                timer: 4000
                            });

                        } else {
                            $('#category_name').val('');
                            $('#tax').val('');
                            $('#retailer').val('');
                            $('#wholesaler').val('');
                            $('#loyalty_card').val('');
                            $('#remarks').val('');
                            $("#check_group").prop("checked", false);
                            swal.fire({
                                title: 'Successfully Saved' + '  ' + data.name,
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

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });


        jQuery("#refresh_group_name").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_Group_cat_group",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#group_name").html(" ");
                    jQuery("#group_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>

    <script type="text/javascript">
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

        });
    </script>

@endsection

