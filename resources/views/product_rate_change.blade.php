@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Product Rate Change</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <div class="search_form">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <form class="prnt_lst_frm" action="{{ route('product_rate_change') }}" name="form1" id="form1" method="post" autocomplete="off">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."
                                                   value="{{ isset($search) ? $search : '' }}">
                                            <datalist id="browsers">
                                                @foreach($product_names as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                        <div class="form_controls text-center text-lg-left">

                                            <button type="reset" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                <i class="fa fa-trash"></i> Clear
                                            </button>
                                            <button type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                <i class="fa fa-search"></i> Search
                                            </button>

                                            @include('include/print_button')

                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                        </div>
                                    </div>

                                </div>
                            </form>


                        </div>
                    </div>
                </div><!-- search form end -->


                <form name="f1" class="f1" id="f1" action="{{ route('update_product_rate_change') }}" onsubmit="return form_validation()" method="post" autocomplete="off">
                    @csrf

                    <div class="table-responsive" id="parent">
                        <table class="table fixed_header table-sm" id="fixTable">

                            <thead>
                            <tr>
                                <th nowrap="" scope="col" align="center" class="align_center text-center tbl_srl_4">
                                    Sr.
                                </th>
                                <th nowrap="" scope="col" align="center" class="align_center text-center tbl_amnt_15">
                                    Product Code
                                </th>
                                <th nowrap="" scope="col" align="center" class="align_center text-center tbl_txt_28">
                                    Product Title
                                </th>
                                <th nowrap="" scope="col" align="center" class="align_center text-center tbl_amnt_15">
                                    Purchase Price
                                </th>
                                <th nowrap="" scope="col" align="center" class="align_center text-center tbl_amnt_15">
                                    Bottom Price
                                </th>
                                <th nowrap="" scope="col" align="center" class="align_center text-center tbl_amnt_15">
                                    Sale Price
                                </th>
                                <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                                    Created By
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @php
                                $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                                $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                                $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                                $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            @endphp

                            @forelse($datas as $index=> $product)

                                <tr>
                                    <td class="align_center text-center tbl_srl_4">
                                        {{$sr}}
                                    </td>
                                    <td nowrap="" class="align_center text-center tbl_amnt_15">
                                        {{$product->pro_code}}
                                    </td>
                                    <td nowrap="" class="align_left text-left tbl_txt_28">
                                        {{$product->pro_title}}
                                    </td>
                                    <td nowrap="" class="align_right text-right tbl_amnt_15">
                                        <span id="p{{$index}}" class="validate_sign"> </span>
                                        <input type="number" class="form-control w-100 border-radius-0 border-0 text-right" value="{{old('p_rate.'.$index) ?  old('p_rate.'.$index)
                                            :$product->pro_purchase_price}}" name="p_rate[]" id="p_rate{{$index}}" data-id="{{$index}}" onkeypress="return allow_only_number_and_decimals(this,event);">

                                        <input type="hidden" name="id[]" class="form-control" value="{{$product->pro_code}}"/>
                                    </td>
                                    <td nowrap="" class="align_right text-right tbl_amnt_15">
                                        <span id="b{{$index}}" class="validate_sign"> </span>
                                        <input type="number" class="form-control w-100 border-radius-0 border-0 text-right" value="{{old('b_rate.'.$index) ?  old('b_rate.'.$index)
                                            :$product->pro_bottom_price}}" name="b_rate[]" id="b_rate{{$index}}" data-id="{{$index}}" onkeypress="return allow_only_number_and_decimals(this,event);">
                                    </td>
                                    <td nowrap="" class="align_right text-right tbl_amnt_15">
                                        <span id="s{{$index}}" class="validate_sign"> </span>
                                        <input type="number" class="form-control w-100 border-radius-0 border-0 text-right" value="{{old('s_rate.'.$index) ?  old('s_rate.'.$index)
                                            :$product->pro_sale_price}}" name="s_rate[]" id="s_rate{{$index}}" data-id="{{$index}}" onkeypress="return allow_only_number_and_decimals(this,event);">
                                    </td>

                                    @php
                                        $ip_browser_info= ''.$product->pro_ip_adrs.','.str_replace(' ','-',$product->pro_brwsr_info).'';
                                    @endphp

                                    <td class="align_left usr_prfl text-left tbl_txt_8" data-usr_prfl="{{ $product->user_id }}" data-user_info="{!! $ip_browser_info !!}"
                                        title="Click To See User Detail">
                                        {{ $product->user_name }}
                                    </td>

                                </tr>
                                @php
                                    $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="11">
                                        <center><h3 style="color:#554F4F">No Product</h3></center>
                                    </td>
                                </tr>
                            @endforelse


                            </tbody>

                        </table>
                    </div>

                    <span style="float: right">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search ])->links() }}</span>


                    <div class="form-group row">
                        <div class="col-lg-2 col-md-2">
                            <button type="submit" name="save" id="save" class="save_button form-control" onclick="return form_validation()">
                                Update Rates
                            </button>
                            <span id="validate_msg" class="validate_sign"></span>
                        </div>
                    </div>


                </form>

            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('product_rate_change') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <style>
        /* Hide HTML5 Up and Down arrows. */
        input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none !important;
            margin: 0 !important;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>

    <script>

        $('.number').on('keypress keyup blur keydown', function () {
            var currentInput = $(this).val();
            var fixedInput = currentInput.replace(/[A-Za-z!@#$%^&*()]/g, '');
            $(this).val(fixedInput);
        });

        function form_validation() {
            var flag_submit = true;
            var focus_once = 0;

            $('input[name^="p_rate"]').each(function () {

                var id = jQuery(this).attr('data-id');

                if ($(this).val().trim() == "") {
                    document.getElementById("p" + id).innerHTML = "Required";

                    if (focus_once == 0) {
                        jQuery(this).focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    if (!validatebcode($(this).val())) {

                        document.getElementById("p" + id).innerHTML = "Only Digits";

                        if (focus_once == 0) {
                            jQuery(this).focus();
                            focus_once = 1;

                        }
                        flag_submit = false;
                    } else {
                        document.getElementById("p" + id).innerHTML = "";
                    }
                }
            });

            $('input[name^="b_rate"]').each(function () {

                var id = jQuery(this).attr('data-id');

                if ($(this).val().trim() == "") {
                    document.getElementById("b" + id).innerHTML = "Required";

                    if (focus_once == 0) {
                        jQuery(this).focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    if (!validatebcode($(this).val())) {

                        document.getElementById("b" + id).innerHTML = "Only Digits";

                        if (focus_once == 0) {
                            jQuery(this).focus();
                            focus_once = 1;

                        }
                        flag_submit = false;
                    } else {
                        document.getElementById("b" + id).innerHTML = "";
                    }
                }
            });

            $('input[name^="s_rate"]').each(function () {

                var id = jQuery(this).attr('data-id');

                if ($(this).val().trim() == "") {
                    document.getElementById("s" + id).innerHTML = "Required";

                    if (focus_once == 0) {
                        jQuery(this).focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    if (!validatebcode($(this).val())) {

                        document.getElementById("s" + id).innerHTML = "Only Digits";

                        if (focus_once == 0) {
                            jQuery(this).focus();
                            focus_once = 1;

                        }
                        flag_submit = false;
                    } else {
                        document.getElementById("s" + id).innerHTML = "";
                    }
                }
            });

            if (!flag_submit) {

                document.getElementById("validate_msg").innerHTML = "Check Invalid Entry!";
            } else {
                document.getElementById("validate_msg").innerHTML = "";
            }
            return flag_submit;
        }

        function validatebcode(pas) {
            var pass = /^-?[0-9]\d*(\.\d+)?$/;
            if (pass.test(pas)) {
                return true;
            } else {
                return false;
            }
        }
    </script>

@endsection

