@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Push Voucher</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('exam_list') }}"
                           role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->

                </div>
            </div><!-- form header close -->
            <form name="f1" class="f1" id="f1" action="{{ route('store_exam') }}" method="post"
                  onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Voucher No
                            </label>
                            <input tabindex="1" type="text" name="voucher_no" id="voucher_no" class="form-control"
                                   placeholder="Voucher No" autofocus data-rule-required="true"
                                   data-msg-required="Please  Voucher No" autocomplete="off"
                                   value="{{ old('voucher_no') }}" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                Registration No#
                            </label>
                            <input tabindex="2" type="text" name="std_id" id="std_id"
                                   class="inputs_up form-control" autocomplete="off" value=""
                                   placeholder="Registration No">
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                Amount
                            </label>
                            <input tabindex="2" type="text" name="amount" id="amount"
                                   class="inputs_up form-control" autocomplete="off" value=""
                                   placeholder="Amount" onkeypress="return allow_only_number_and_decimals(this,event);">
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                 Date
                            </label>
                            <input tabindex="3" type="text" name="date" id="date"
                                   class="inputs_up form-control datepicker1" autocomplete="off" value=""
                                   placeholder="Date ......">
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                        <button tabindex="1" type="submit" name="save" id="save"
                                class="save_button btn btn-sm btn-success">
                            <i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </div>
            </form>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection

