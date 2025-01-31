@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Capital Registration</h4>
                        </div>
                        <div class="list_btn">
                            <a class="btn list_link add_more_button" href="{{ route('capital_registration_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <form action="{{ route('update_capital_registration') }}" onsubmit="return checkForm()" method="post" autocomplete="off" id="f1">
                    @csrf

                    <input type="hidden" id="cr_id" name="cr_id" value="{{ $capital_registration->cr_id }}" hidden>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <div class="row">

                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.parent_account.description')}}</p>
                                                                 <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.parent_account.benefits')}}</p>
                                                                <h6>Example</h6><p>{{config('fields_info.about_form_fields.parent_account.example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Select Parent Account
                                        </label>
                                        <select name="second_head" id="second_head" class="inputs_up form-control cstm_clm_srch" disabled
                                                data-rule-required="true" data-msg-required="Please Enter Parent Account"
                                        >
                                            <option value="">Select Parent Account</option>
                                            @foreach($equity_second_accounts as $equity_second_account)
                                                <option value="{{$equity_second_account->coa_code}}"{{$equity_second_account->coa_code == substr($capital_registration->cr_parent_account_uid, 0, 3) ? 'selected="selected"' : ''}}>
                                                    {{$equity_second_account->coa_head_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span id="second_head_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">Name
                                            <a href="{{ route('add_employee') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                <l class="fa fa-plus"></l>
                                            </a>
                                            <a id="refresh_user_name" class="add_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                <l class="fa fa-refresh"></l>
                                            </a>

                                        </label>
                                        <select name="user_name" id="user_name" class="inputs_up form-control cstm_clm_srch" disabled  data-rule-required="true" data-msg-required="Please Enter Name">
                                            <option value="">Select Name</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->user_id}}" {{$user->user_id == $capital_registration->cr_user_id ? 'selected="selected"' : ''}}>{{$user->user_name}}</option>
                                            @endforeach
                                        </select>

                                        <span id="user_name_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.Capital_Registration.Relation_With_Director.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Relation With Director</label>
                                        <input type="text" name="relation" id="relation" value="{{ $capital_registration->cr_relation_with_director }}" class="inputs_up form-control" placeholder="Relation With Director">
                                        <span id="relation_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-2 col-md-3 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required weight-600">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.Capital_Registration.Nature.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Nature</label>
                                        <div class="custom-control custom-radio mb-5 mt-1">
                                            <input type="radio" id="acting" name="nature" value="1" {{ $capital_registration->cr_partner_nature == 1  ? 'checked' : '' }} class="custom-control-input">
                                            <label class="custom-control-label" for="acting">Acting</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-5 mt-1">
                                            <input type="radio" id="sleeping" name="nature" value="2" {{ $capital_registration->cr_partner_nature == 2  ? 'checked' : '' }} class="custom-control-input">
                                            <label class="custom-control-label" for="sleeping">Sleeping</label>
                                        </div>
                                        <span id="nature_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">Initial Capital</label>
                                        <input type="text" name="initial_capital" id="initial_capital" data-rule-required="true" data-msg-required="Please Enter Initial Capital" value="{{ $capital_registration->cr_initial_capital }}" class="inputs_up form-control" placeholder="Initial Capital"
                                               onkeypress="return allow_only_number_and_decimals(this,event);" disabled>
                                        <span id="initial_capital_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">System Calculated</label>
                                        <input type="text" name="system_calculated" id="system_calculated" data-rule-required="true" data-msg-required="Please Enter System Calculated" value="{{ $capital_registration->cr_system_ratio }}" class="inputs_up form-control" placeholder="System Calculated" disabled readonly/>
                                        <input type="hidden" name="cptl" id="cptl"  class="inputs_up form-control" placeholder="System Calculated" readonly value="{{$total_capital}}"/>
                                        <span id="system_calculated_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>


                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6"><!-- col start -->
                                        <fieldset class="cstm_ratio_fldset">
                                            <legend>
                                                <div class="custom-control custom-checkbox cstm_ratio">
                                                    <input type="checkbox" name="custom_profit_ratio" class="custom-control-input" id="custom_profit_ratio" data-cstm-ratio="prft_" value="1" {{ $capital_registration->cr_is_custom_profit == 1 ? 'checked' : '' }}/>
                                                    <label class="custom-control-label" for="custom_profit_ratio">
                                                        <b> CUSTOM PROFIT RATIO </b>
                                                    </label>
                                                </div>
                                            </legend>

                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                                                    <ul class="list-group cptl_invst">
                                                        <li class="list-group-item border-0">
                                                            Fixed Profit of its actual ratio =
                                                            <input type="text" placeholder="Add Ratio" value="{{ $capital_registration->cr_fixed_profit_per }}" name="prft_fxd_prft_actl_ratio"
                                                                   id="prft_fxd_prft_actl_ratio" class="inputs_up form-control cptl_rtio disabled"
                                                                   disabled="disabled" data-cstm-ratio="prft_"
                                                                   onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                                            <p class="mb-0 mt-1">
                                                                Current Ratio is =
                                                                <input class="inputs_up form-control cptl_rtio disabled" value="{{ $capital_registration->cr_custom_profit_ratio }}" type="text" placeholder="Add Ratio" name="prft_crnt_ratio"
                                                                       id="prft_crnt_ratio" disabled="disabled" readonly/>
                                                            </p>
                                                        </li>
                                                        <li class="list-group-item border-0">
                                                            Remaining
                                                            <input type="text" placeholder="Add Ratio" value="{{ $capital_registration->cr_ramaning_profit_per }}" name="prft_remaining_ratio" id="prft_remaining_ratio"
                                                                   class="inputs_up form-control cptl_rtio disabled" disabled="disabled" readonly/> Ratio

                                                            <div class="d-block">
                                                                <div class="custom-control custom-radio mb-5">
                                                                    <input type="radio" id="prft_equal_devide" name="prft_stck_hldrs" {{ $capital_registration->cr_remaning_profit_division == 1 ? 'checked' : '' }} class="custom-control-input disabled" disabled="disabled"
                                                                           value="1"
                                                                           checked>
                                                                    <label class="custom-control-label" for="prft_equal_devide">
                                                                        Divide equally to all Stack holders
                                                                    </label>
                                                                </div>

                                                                <div class="custom-control custom-radio mb-5">
                                                                    <input type="radio" id="prft_owner_equity" name="prft_stck_hldrs" {{ $capital_registration->cr_remaning_profit_division == 2 ? 'checked' : '' }} class="custom-control-input disabled" disabled="disabled"
                                                                           value="2">
                                                                    <label class="custom-control-label" for="prft_owner_equity">
                                                                        Divide equally to all Owners
                                                                    </label>
                                                                </div>

                                                                <div class="custom-control custom-radio mb-5">
                                                                    <input type="radio" id="prft_investors" name="prft_stck_hldrs" {{ $capital_registration->cr_remaning_profit_division == 3 ? 'checked' : '' }} class="custom-control-input disabled" disabled="disabled"
                                                                           value="3">
                                                                    <label class="custom-control-label" for="prft_investors">
                                                                        Divide equally to all Investors
                                                                    </label>
                                                                </div>

                                                                <div class="custom-control custom-radio mb-5">
                                                                    <input type="radio" id="prft_active_equal_devide" name="prft_stck_hldrs" {{ $capital_registration->cr_remaning_profit_division == 4 ? 'checked' : '' }} class="custom-control-input disabled"
                                                                           disabled="disabled" value="4">
                                                                    <label class="custom-control-label" for="prft_active_equal_devide">
                                                                        Divide equally to all Active partners
                                                                    </label>
                                                                </div>

                                                                <div class="custom-control custom-radio mb-5">
                                                                    <input type="radio" id="prft_sleep_equal_devide" name="prft_stck_hldrs" {{ $capital_registration->cr_remaning_profit_division == 5 ? 'checked' : '' }} class="custom-control-input disabled" disabled="disabled"
                                                                           value="5">
                                                                    <label class="custom-control-label" for="prft_sleep_equal_devide">
                                                                        Divide equally to all Sleeping partners
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </li>

                                                    </ul>

                                                </div>
                                            </div>

                                        </fieldset>
                                    </div><!-- col end -->
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6"><!-- col start -->
                                        <fieldset class="cstm_ratio_fldset">
                                            <legend>
                                                <div class="custom-control custom-checkbox cstm_ratio">
                                                    <input type="checkbox" name="custom_loss_ratio" class="custom-control-input" id="custom_loss_ratio" {{ $capital_registration->cr_is_custom_loss == 1 ? 'checked' : '' }} data-cstm-ratio="loss_" value="1"/>
                                                    <label class="custom-control-label" for="custom_loss_ratio">
                                                        <b> CUSTOM LOSS RATIO </b>
                                                    </label>
                                                </div>
                                            </legend>

                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                                                    <ul class="list-group cptl_invst">
                                                        <li class="list-group-item border-0">
                                                            Fixed Loss of its actual ratio =
                                                            <input type="text" placeholder="Add Ratio" value="{{ $capital_registration->cr_fixed_loss_per }}" name="loss_fxd_prft_actl_ratio"
                                                                   id="loss_fxd_prft_actl_ratio" class="inputs_up form-control cptl_rtio disabled"
                                                                   disabled="disabled" data-cstm-ratio="loss_"
                                                                   onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                                            <p class="mb-0 mt-1">
                                                                Current Ratio is =
                                                                <input type="text" placeholder="Add Ratio" value="{{ $capital_registration->cr_custom_loss_ratio }}" name="loss_crnt_ratio" id="loss_crnt_ratio"
                                                                       class="inputs_up form-control cptl_rtio disabled" disabled="disabled" readonly/>
                                                            </p>
                                                        </li>
                                                        <li class="list-group-item border-0">
                                                            Remaining
                                                            <input type="text" placeholder="Add Ratio" value="{{ $capital_registration->cr_remaning_loss_per }}" name="loss_remaining_ratio" id="loss_remaining_ratio"
                                                                   class="inputs_up form-control cptl_rtio disabled" disabled="disabled" readonly/> Ratio

                                                            <div class="d-block">
                                                                <div class="custom-control custom-radio mb-5">
                                                                    <input type="radio" id="loss_equal_devide" name="loss_stck_hldrs" {{ $capital_registration->cr_remaning_loss_division == 1 ? 'checked' : '' }} class="custom-control-input disabled" disabled="disabled"
                                                                           value="1" checked>
                                                                    <label class="custom-control-label" for="loss_equal_devide">
                                                                        Divide Equally to all Stack Holders.
                                                                    </label>
                                                                </div>

                                                                <div class="custom-control custom-radio mb-5">
                                                                    <input type="radio" id="loss_owner_equity" name="loss_stck_hldrs" {{ $capital_registration->cr_remaning_loss_division == 2 ? 'checked' : '' }} class="custom-control-input disabled" disabled="disabled"
                                                                           value="2">
                                                                    <label class="custom-control-label" for="loss_owner_equity">
                                                                        Divide equally to all Owners
                                                                    </label>
                                                                </div>

                                                                <div class="custom-control custom-radio mb-5">
                                                                    <input type="radio" id="divide_equal_to_investor" name="loss_stck_hldrs" {{ $capital_registration->cr_remaning_loss_division == 3 ? 'checked' : '' }} class="custom-control-input disabled" disabled="disabled"
                                                                           value="3">
                                                                    <label class="custom-control-label" for="divide_equal_to_investor">
                                                                        Divide equally to all Investors
                                                                    </label>
                                                                </div>

                                                                <div class="custom-control custom-radio mb-5">
                                                                    <input type="radio" id="loss_active_equal_devide" name="loss_stck_hldrs" {{ $capital_registration->cr_remaning_loss_division == 4 ? 'checked' : '' }} class="custom-control-input disabled"
                                                                           disabled="disabled" value="4">
                                                                    <label class="custom-control-label" for="loss_active_equal_devide">
                                                                        Divide equally to all Active partners
                                                                    </label>
                                                                </div>

                                                                <div class="custom-control custom-radio mb-5">
                                                                    <input type="radio" id="loss_sleep_equal_devide" name="loss_stck_hldrs" {{ $capital_registration->cr_remaning_loss_division == 5 ? 'checked' : '' }} class="custom-control-input disabled" disabled="disabled"
                                                                           value="5">
                                                                    <label class="custom-control-label" for="loss_sleep_equal_devide">
                                                                        Divide equally to all Sleeping partners
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </li>

                                                    </ul>

                                                </div>
                                            </div>


                                        </fieldset>
                                    </div><!-- col end -->
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button type="reset" name="cancel" id="cancel" class="cancel_button form-control">
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


        </div>


    </div>

@endsection

@section('scripts')

    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let second_head = document.getElementById("second_head"),
                user_name = document.getElementById("user_name"),
                initial_capital = document.getElementById("initial_capital"),
                system_calculated = document.getElementById("system_calculated"),
                validateInputIdArray = [
                    second_head.id,
                    user_name.id,
                    initial_capital.id,
                    system_calculated.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">

        $(document).ready(function () {
            $("#custom_profit_ratio").trigger('change');
            $("#custom_loss_ratio").trigger('change');
        });

        $("#custom_profit_ratio, #custom_loss_ratio").change(function () {
            loss_prft = $(this).data('cstm-ratio');
            if ($(this).is(':checked')) {
                enbldInpts(loss_prft, prft_a, prft_b, prft_c, prft_d);
            } else {
                dsabldInpts(loss_prft, prft_a, prft_b, prft_c, prft_d);
            }
        });


        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });


        var prft_a = 'fxd_prft_actl_ratio',
            prft_b = 'crnt_ratio',
            prft_c = 'remaining_ratio',
            prft_d = 'stck_hldrs',
            loss_prft = '',
            custom_profit_ratio = $("#custom_profit_ratio"),
            custom_loss_ratio = $("#custom_loss_ratio"),
            sstm_clcltd = $("#system_calculated"),
            cptl = $("#cptl"),
            intl_cptl = $("#initial_capital");

        $("#custom_profit_ratio, #custom_loss_ratio").click(function () {
            loss_prft = $(this).data('cstm-ratio');
            if ($(this).is(':checked')) {
                enbldInpts(loss_prft, prft_a, prft_b, prft_c, prft_d);
            } else {
                dsabldInpts(loss_prft, prft_a, prft_b, prft_c, prft_d);
            }

        });

        function dsabldInpts(e_loss_prft, a, b, c, d) {
            $("#" + e_loss_prft + a).attr('disabled', 'disabled').addClass('disabled').val('');
            $("#" + e_loss_prft + b).attr('disabled', 'disabled').addClass('disabled').val(sstm_clcltd.val());
            $("#" + e_loss_prft + c).attr('disabled', 'disabled').addClass('disabled').val('');
            $("input[name = '" + e_loss_prft + d + "']").attr('disabled', 'disabled').addClass('disabled');
        }

        function enbldInpts(e_loss_prft, a, b, c, d) {
            $("#" + e_loss_prft + a).removeAttr('disabled').removeClass('disabled');
            $("#" + e_loss_prft + b).removeAttr('disabled').removeClass('disabled');
            $("#" + e_loss_prft + c).removeAttr('disabled').removeClass('disabled');
            $("input[name = '" + e_loss_prft + d + "']").removeAttr('disabled').removeClass('disabled');
        }

        // system calculator start
        $(intl_cptl).keyup(function () {
            var e_intl_cptl = (intl_cptl.val() > 0) ? intl_cptl.val() : 0,
                e_cptl = (cptl.val() > 0) ? cptl.val() : 0;
            if (e_intl_cptl > 0 || e_intl_cptl !== '') {
                sstmClcltd(e_intl_cptl, e_cptl);

                if (custom_profit_ratio.is(':checked')) {
                    loss_prft = custom_profit_ratio.data('cstm-ratio');
                    if ($("#" + loss_prft + prft_a).val() > 0) {
                        cstmRatioPrftLss(loss_prft, prft_a, prft_b, prft_c);
                    }
                }
                if (custom_loss_ratio.is(':checked')) {
                    loss_prft = custom_loss_ratio.data('cstm-ratio');
                    if ($("#" + loss_prft + prft_a).val() > 0) {
                        cstmRatioPrftLss(loss_prft, prft_a, prft_b, prft_c);
                    }
                }
            } else {
                sstm_clcltd.val(0);
            }
        });

        function sstmClcltd(e_intl_cptl, e_cptl) {
            var intl_cptl_pls_cptl = +(e_intl_cptl) + +(e_cptl),
                remaining = intl_cptl_pls_cptl / e_intl_cptl,
                remaining_ratio = 100 / remaining;
            sstm_clcltd.val(remaining_ratio.toFixed(4));
            $("#prft_" + prft_b).val(remaining_ratio.toFixed(4));
            $("#loss_" + prft_b).val(remaining_ratio.toFixed(4));
        }

        // system calculator end


        // custom profit & loss calculator start
        $("#prft_fxd_prft_actl_ratio, #loss_fxd_prft_actl_ratio").keyup(function () {

            if ($(this).val() < 0) $(this).val(0);
            if ($(this).val() > 100) $(this).val(100);

            if ($(this).val() < 101) {
                if ($(this).val() < 101) {
                    loss_prft = $(this).data('cstm-ratio');
                    cstmRatioPrftLss(loss_prft, prft_a, prft_b, prft_c);
                } else {
                    return preventDefault();
                }
            } else {
                return preventDefault();
            }
        });

        function cstmRatioPrftLss(e_loss_prft, a, b, c) {
            var e_a = $("#" + e_loss_prft + a),
                e_b = $("#" + e_loss_prft + b),
                e_c = $("#" + e_loss_prft + c),
                e_sstm_clcltd = (sstm_clcltd.val() > 0) ? sstm_clcltd.val() : 0,
                crrnt_ratio = e_sstm_clcltd * e_a.val() / 100,
                remaining_ratio = +100 - +e_a.val();
            if (e_a.val() > 0) {
                e_b.val(crrnt_ratio.toFixed(4));
                e_c.val(remaining_ratio);
            } else {
                e_b.val(e_a.val()*sstm_clcltd.val());
                e_c.val(100);
            }
        }
        // custom profit & loss calculator end


        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#user_name").select2();
            jQuery("#second_head").select2();
            // jQuery("#head_code").select2();
        });

    </script>

    <script>
        function handleChange(input) {
            if (input.value < 0) input.value = 0;
            if (input.value > 100) input.value = 100;
        }
    </script>

    <script>
        jQuery("#user_name").change(function () {

            var user_id = jQuery('option:selected', this).val();

            var user_name = jQuery("#user_name option:selected").text();

            if (user_id.trim() != "") {
                jQuery("#account_name").val(user_name.trim());
            } else {
                jQuery("#account_name").val('');
            }
        });


        function validate_form() {
            var second_head = $("#second_head").val();
            // var head_code = $("#head_code").val();
            var user_name = $("#user_name").val();
            var initial_capital = $("#initial_capital").val();
            var system_calculated = $("#system_calculated").val();


            var flag_submit = true;
            var focus_once = 0;


            if (second_head.trim() == "") {
                document.getElementById("second_head_msg").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#second_head").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("second_head_msg").innerHTML = "";
            }

            // if (head_code.trim() == "") {
            //     document.getElementById("head_code_msg").innerHTML = "Required";
            //     if (focus_once == 0) {
            //         jQuery("#head_code").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // } else {
            //     document.getElementById("head_code_msg").innerHTML = "";
            // }

            if (user_name.trim() == "") {
                document.getElementById("user_name_msg").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#user_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("user_name_msg").innerHTML = "";
            }

            if (initial_capital.trim() == "") {
                document.getElementById("initial_capital_msg").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#initial_capital").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("initial_capital_msg").innerHTML = "";
            }

            if (system_calculated.trim() == "") {
                document.getElementById("system_calculated_msg").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#system_calculated").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("system_calculated_msg").innerHTML = "";
            }


            return flag_submit;
        }


        // jQuery("#second_head").change(function () {
        //
        //     var dropDown = document.getElementById('second_head');
        //     var second_head_code = dropDown.options[dropDown.selectedIndex].value;
        //
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //
        //     jQuery.ajax({
        //         url: "get_head",
        //         data: {second_head_code: second_head_code},
        //         type: "POST",
        //         cache: false,
        //         dataType: 'json',
        //         success: function (data) {
        //
        //             jQuery("#head_code").html("");
        //             jQuery("#head_code").append(data);
        //         },
        //         error: function (jqXHR, textStatus, errorThrown) {
        //             // alert(jqXHR.responseText);
        //             // alert(errorThrown);
        //         }
        //     });
        // });

    </script>

@endsection


