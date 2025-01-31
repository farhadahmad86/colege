@extends('extend_index')
@section('content')


    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Create Batch</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

            <!-- <div class="search_form {{ ( !empty($search) || !empty($search_account) || !empty($search_product) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <form class="prnt_lst_frm" action="{{ route('create_batch') }}" name="form1" id="form1" method="post">
                                @csrf
                                <input type="hidden" id="data"

                                       data-zone-id=""
                                       data-zone-action="{{ route('api.zones.options') }}"
                                       data-city-id=""
                                       data-city-action="{{ route('api.cities.options') }}"
                                       data-grid-id=""
                                       data-grid-action="{{ route('api.grids.options') }}"
                                       data-franchise-area-id=""
                                       data-franchise-area-action="{{ route('api.franchise-area.options') }}">
                                <div class="row">

                                    {{--                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">--}}
                                    {{--                                        <div class="input_bx"><!-- start input box -->--}}
                                    {{--                                            <label>--}}
                                    {{--                                                All Column Search--}}
                                    {{--                                            </label>--}}
                                    {{--                                            <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."--}}
                                    {{--                                                   value="{{ isset($search) ? $search : '' }}" autocomplete="off">--}}
                                    {{--                                            <datalist id="browsers">--}}
                                    {{--                                                @foreach($party as $value)--}}
                                    {{--                                                    <option value="{{$value}}">--}}
                                    {{--                                                @endforeach--}}
                                    {{--                                            </datalist>--}}
                                    {{--                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div> <!-- left column ends here -->--}}


                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                        <div class="row">

                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        Company
                                                    </label>
                                                    <select tabindex="2" class="inputs_up  form-control" name="account" id="account">
                                                        <option value="" disabled selected>Select Company</option>
                                                        @foreach($accounts as $account)
                                                            <option
                                                                value="{{$account->account_uid}}" {{ $account->account_uid == $search_account ? 'selected="selected"' : '' }}>{{$account->account_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Order List
                                                    </label>
                                                    <select tabindex="3" class="inputs_up  form-control" name="order_list" id="order_list">
                                                        <option value="" selected disabled>Select Order List</option>
                                                        @foreach($order_lists as $order_list)
                                                            <option
                                                                value="{{$order_list->ol_id}}" {{ $order_list->ol_id == $search_order_list ? 'selected="selected"' : ''
                                                                }}>{{$order_list->ol_order_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

{{--                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">--}}
{{--                                                <div class="input_bx"><!-- start input box -->--}}
{{--                                                    <label>--}}
{{--                                                        Region--}}
{{--                                                    </label>--}}

{{--                                                    <select tabindex="6" name="zone" id="zone"--}}
{{--                                                            class="inputs_up form-control @error('zone') is-invalid @enderror"--}}
{{--                                                    >--}}
{{--                                                        <option value="" selected disabled>--}}
{{--                                                            Select Order List--}}
{{--                                                            First--}}
{{--                                                        </option>--}}
{{--                                                    </select>--}}
{{--                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">--}}
{{--                                                <div class="input_bx"><!-- start input box -->--}}
{{--                                                    <label>--}}
{{--                                                        City--}}
{{--                                                    </label>--}}

{{--                                                    <select tabindex="7" name="city" id="city"--}}
{{--                                                            class="inputs_up form-control @error('city') is-invalid @enderror"--}}
{{--                                                    >--}}
{{--                                                        <option value="" selected disabled>--}}
{{--                                                            Select Zone First--}}
{{--                                                        </option>--}}
{{--                                                    </select>--}}
{{--                                                    <span id="city_error" style="color: red"></span>--}}
{{--                                                </div><!-- invoice column box end -->--}}
{{--                                            </div><!-- invoice column end -->--}}

{{--                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">--}}
{{--                                                <div class="input_bx"><!-- start input box -->--}}
{{--                                                    <label>--}}
{{--                                                        Grid--}}
{{--                                                    </label>--}}

{{--                                                    <select tabindex="8" name="grid" id="grid"--}}
{{--                                                            class="inputs_up form-control @error('grid') is-invalid @enderror"--}}
{{--                                                    >--}}
{{--                                                        <option value="" selected disabled>--}}
{{--                                                            Select City First--}}
{{--                                                        </option>--}}
{{--                                                    </select>--}}

{{--                                                </div><!-- invoice column box end -->--}}
{{--                                            </div><!-- invoice column end -->--}}

{{--                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">--}}
{{--                                                <div class="input_bx"><!-- start input box -->--}}
{{--                                                    <label>--}}
{{--                                                        Franchise--}}
{{--                                                    </label>--}}
{{--                                                    <select tabindex="9" name="franchiseArea"--}}
{{--                                                            id="franchiseArea"--}}
{{--                                                            class="inputs_up form-control @error('franchiseArea') is-invalid @enderror"--}}
{{--                                                    >--}}
{{--                                                        <option value="" selected disabled>--}}
{{--                                                            Select Grid First--}}
{{--                                                        </option>--}}
{{--                                                    </select>--}}
{{--                                                </div><!-- invoice column box end -->--}}
{{--                                            </div><!-- invoice column end -->--}}

                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Product Name
                                                    </label>
                                                    <select tabindex="3" class="inputs_up  form-control" name="product_name" id="product_name">
                                                        <option value="">Select Product Name</option>

                                                        @foreach($products as $product_name)
                                                            <option
                                                                value="{{$product_name->pro_p_code}}" {{ $product_name->pro_p_code == $search_product ? 'selected="selected"' : ''
                                                                }}>{{$product_name->pro_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12" hidden>
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Start Date
                                                    </label>
                                                    <input tabindex="5" type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
                                                           <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......"/>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12" hidden>
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        End Date
                                                    </label>
                                                    <input tabindex="6" type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off"
                                                           <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......"/>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button tabindex="7" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button tabindex="8" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>
                                                    <a tabindex="7" class="save_button form-control" href="{{ route('batch_list') }}" role="button">
                                                        View Batch
                                                    </a>

{{--                                                    @include('include/print_button')--}}

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>
                </div><!-- search form end -->

                <form method="post" action="{{route('submit_batch')}}" onsubmit="return checkForm()">

                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                        <div class="input_bx"><!-- start input box -->
                            <label class="required">
                                Batch Name
                            </label>
                            <input tabindex="2" type="text" name="batch_name" id="batch_name" class="inputs_up form-control" placeholder="Batch Title" autocomplete="off" value="{{ old('batch_name')
                            }}"
                                   data-rule-required="true" data-msg-required="Please Enter Batch Title">

                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div>
                    <input type="hidden" name="order_list" id="order_list" value="{{$search_order_list}}">
                    <input type="hidden" name="product_name" id="product_name" value="{{$search_product}}">

                    <div class="table-responsive" id="printTable">
                        <table class="table table-sm" id="fixTable">

                            <thead>
                            <tr>
                                <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">
                                    <input type="checkbox" name="select-all" id="select-all"/>
                                </th>
                                <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">
                                    Sr#
                                </th>
                                <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_6">
                                    City
                                </th>
                                <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_6">
                                    Franchise
                                </th>

                                <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_8">
                                    Shop Name
                                </th>
                                <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_10">
                                    Product Title
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                                    Board Type
                                </th>
                                <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_8">
                                    Story
                                </th>

                                <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                                    Width Feet
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                                    Width Inch
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                                    Total Width
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                                    Length Feet
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                                    Length Inch
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                                    Total Length
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                                    Height Feet
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                                    Height Inch
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                                    Total Height
                                </th>

                                <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                                    Depth
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                                    Tapa Gauge
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                                    Back Sheet Gauge
                                </th>

                            </tr>
                            </thead>

                            <tbody>
                            @php
                                $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                                $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                                $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                                $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                               $ttlWidthFeet= $ttlWidthInch = $ttlWidthTotal = $ttlLengthFeet = $ttlLengthInch = $ttlLengthTotal = $ttlHeightFeet = $ttlHeightInch = $ttlHeightTotal = $ttlDepth = 0;
                            @endphp

                            @csrf
                            @forelse($datas as $invoice)
                                @php
                                    $ttlWidthFeet = $ttlWidthFeet + $invoice->sri_widthFeet;
                                    $ttlWidthInch = $ttlWidthInch + $invoice->sri_widthInch;
                                    $ttlWidthTotal = $ttlWidthTotal + $invoice->sri_total_width;
                                    $ttlLengthFeet = $ttlLengthFeet + $invoice->sri_lengthFeet;
                                    $ttlLengthInch = $ttlLengthInch + $invoice->sri_lengthInch;
                                    $ttlLengthTotal = $ttlLengthTotal + $invoice->sri_total_length;
                                    $ttlHeightFeet = $ttlHeightFeet + $invoice->sri_front_left_right_height_feet;
                                    $ttlHeightInch = $ttlHeightInch + $invoice->sri_front_left_right_height_Inch;
                                    $ttlHeightTotal = $ttlHeightTotal + $invoice->sri_height;
                                    $ttlDepth = $ttlDepth + $invoice->sri_depth;

                                @endphp

                                <tr>
                                    <td class="align_center text-center edit tbl_srl_4">
                                        <input type="checkbox" name="checkbox[]" value="{{$invoice->sri_id}}" id="{{$invoice->sri_id}}"/>
                                    </td>
                                    <td class="align_center text-center edit tbl_srl_4">
                                        {{$sr}}
                                    </td>
                                    <td class="align_center text-center edit tbl_srl_6">
                                        {{$invoice->city}}
                                    </td>
                                    <td class="align_center text-center edit tbl_srl_6">
                                        {{$invoice->franchise_code}} {{$invoice->franchise}}
                                    </td>
                                    <td class="align_center text-center edit tbl_srl_8">
                                        {{$invoice->sr_shop_name}}
                                    </td>

                                    <td class="align_center text-center edit tbl_srl_10">                                    {{$invoice->pro_title}}
                                    </td>
                                    <td class="align_left text-left tbl_txt_5">
                                        {{$invoice->sri_image_type}}
                                    </td>
                                    <td class="align_center text-center tbl_txt_8">
                                        {{ $invoice->sri_shop_story }}
                                    </td>

                                    <td class="align_left text-left tbl_txt_5">
                                        {{$invoice->sri_widthFeet}}
                                    </td>

                                    <td class="align_left text-left tbl_txt_5">
                                        {{$invoice->sri_widthInch}}
                                    </td>
                                    <td class="align_left text-left tbl_txt_5">
                                        {{$invoice->sri_total_width}}
                                    </td>
                                    <td class="align_left text-left tbl_txt_5">
                                        {{$invoice->sri_lengthFeet}}
                                    </td>
                                    <td class="align_left text-left tbl_txt_5">
                                        {{$invoice->sri_lengthInch}}
                                    </td>
                                    <td class="align_left text-left tbl_txt_5">
                                        {{$invoice->sri_total_length}}
                                    </td>
                                    <td class="align_left text-left tbl_txt_5">
                                        {{$invoice->sri_front_left_right_height_feet}}
                                    </td>
                                    <td class="align_left text-left tbl_txt_5">
                                        {{$invoice->sri_front_left_right_height_Inch}}
                                    </td>
                                    <td class="align_left text-left tbl_txt_5">
                                        {{$invoice->sri_height}}
                                    </td>
                                    <td class="align_left text-left tbl_txt_5">
                                        {{$invoice->sri_depth}}
                                    </td>

                                    <td class="align_left text-left tbl_txt_5">
                                        {{ $invoice->sri_tapa_gauge }}
                                    </td>

                                    <td class="align_left text-left tbl_txt_5">
                                        {{ $invoice->sri_back_sheet_gauge }}
                                    </td>

                                </tr>
                                @php
                                    $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="21">
                                        <center><h3 style="color:#554F4F">No List Found</h3></center>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="8" class="atext-left text-left border-0">
                                    Per Page Total:-
                                </th>

                                <td class="atext-left text-left border-0">
                                    {{ $ttlWidthFeet }}
                                </td>
                                <td class="atext-left text-left border-0">
                                    {{ $ttlWidthInch }}
                                </td>
                                <td class="atext-left text-left border-0">
                                    {{ $ttlWidthTotal }}
                                </td>
                                <td class="atext-left text-left border-0">
                                    {{ $ttlLengthFeet }}
                                </td>
                                <td class="atext-left text-left border-0">
                                    {{ $ttlLengthInch }}
                                </td>
                                <td class="atext-left text-left border-0">
                                    {{ $ttlLengthTotal }}
                                </td>
                                <td class="atext-left text-left border-0">
                                    {{ $ttlHeightFeet }}
                                </td>
                                <td class="atext-left text-left border-0">
                                    {{ $ttlHeightInch }}
                                </td>
                                <td class="atext-left text-left border-0">
                                    {{ $ttlHeightTotal }}
                                </td>
                                <td class="atext-left text-left border-0">
                                    {{ $ttlDepth }}
                                </td>

                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <button type="submit" class="save_button form-control">Save</button>
                </form>
                <span
                    class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'account'=>$search_account, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>
            </div> <!-- white column form ends here -->
            {{--            'franchise'=>$search_franchise,--}}

        </div><!-- col end -->


    </div><!-- row end -->


@endsection

@section('scripts')

    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let batch_name = document.getElementById("batch_name"),

                validateInputIdArray = [
                    batch_name.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('survey_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".href").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");

            $('.modal-body').load('{{url("survey_items_view_details/view/") }}' + '/' + id, function () {
                $('#myModal').modal({show: true});
            });

        });
    </script>

    <script>
        jQuery(".edit").click(function () {

            var account_id = jQuery(this).attr("data-id");

            jQuery("#account_id").val(account_id);
            jQuery("#edit").submit();
        });

    </script>

    <script>
        jQuery("#cancel").click(function () {

            // alert("123");
            $("#account").select2().val('');
            $("#account > option").removeAttr('selected');

            // $("#account").select2().val(0).trigger("change");
            // $("#account > option").removeAttr('selected');
            //
            // $("#product").select2().val(null).trigger("change");
            // $("#product > option").removeAttr('selected');
            //
            $("#product_name").select2().val('');
            $("#product_name > option").removeAttr('selected');
            // $("#product_name").select2().val('').trigger("change");
            // $("#product_name > option").removeAttr('selected');

            $("#order_list").select2().val('');
            $("#order_list > option").removeAttr('selected');




            // $("#survey_name").select2().val(null).trigger("change");
            // $("#survey_name > option").removeAttr('selected');

            // $("#search").val('');
            //
            // $("#to").val('');
            // $("#from").val('');
        });
    </script>

    <script>
        jQuery("#product_name").change(function () {
            var pcode = jQuery('option:selected', this).val();

            jQuery("#product").select2("destroy");

            // jQuery("#product > option").each(function () {
            //     jQuery('#product option[value="' + pcode + '"]').prop('selected', true);
            // });

            jQuery('#product option[value="' + pcode + '"]').prop('selected', true);
            jQuery("#product").select2();

        });


        jQuery("#product").change(function () {
            var pcode = jQuery('option:selected', this).val();

            jQuery("#product_name").select2("destroy");

            // jQuery("#product_name > option").each(function () {
            jQuery('#product_name option[value="' + pcode + '"]').prop('selected', true);
            // });

            jQuery("#product_name").select2();

        });


    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#account").select2();
            jQuery("#product").select2();
            jQuery("#product_name").select2();
            jQuery("#order_list").select2();
            // jQuery("#survey_name").select2();
            jQuery("#designer_name").select2();
            jQuery("#zone").select2();
            jQuery("#city").select2();
            jQuery("#grid").select2();
            jQuery("#franchiseArea").select2();
        });
    </script>

    <script>
        function dis_approve(id) {
            var rej_id = id
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "survey_reject",
                data: {id: rej_id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data.message);
                    location.reload();
                },

            });
            location.reload();
        }

        function approve_survey(id) {

            var designer_id = $('#designer_name').val();
            var flag_submit1 = true;
            var focus_once1 = 0;

            if (designer_id == "" || designer_id == null) {

                if (focus_once1 == 0) {
                    jQuery("#designer_name").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            alert(designer_id);
            if (flag_submit1) {

                var ap_id = id

                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });

                jQuery.ajax({
                    url: "survey_approve",
                    data: {id: ap_id, designer_id: designer_id},
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    success: function (data) {
                        console.log(data.message);
                        location.reload();
                    },

                });
                location.reload();
            }

        }
    </script>

    <script>
        $('#select-all').click(function (event) {
            if (this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function () {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function () {
                    this.checked = false;
                });
            }
        });
    </script>

    <script>
        $('#order_list').change(function () {
            var order_list = $(this).val();


            if (order_list != '') {
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "order_list_region",
                    data: {order_list: order_list},
                    type: "GET",
                    cache: false,
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        // console.log(data.services);
                        var option = "<option value='' disabled selected>Select Region</option>";
                        var option_pro = "<option value='' disabled selected>Select Product</option>";
                        var option_ser = "<option value='' disabled selected>Select Service</option>";

                        $.each(data.regions, function (index, value) {
                            option += "<option value='" + value.id + "' data-zone-id='" + value.id + "'>" + value.name + "</option>";
                        });
                        $.each(data.products, function (index, value) {
                            option_pro += "<option value='" + value.pro_p_code + "' >" + value.pro_title + "</option>";
                        });
                        $.each(data.services, function (index, value) {
                            option_ser += "<option value='" + value.osi_service_code + "' data-qty='" + value.osi_qty + "' data-rate='" + value.osi_rate + "'>" + value.osi_service_name + "</option>";
                        });

                        jQuery("#zone").html(" ");
                        jQuery("#zone").append(option);
                        jQuery("#zone").select2();

                        jQuery("#product_name").html(" ");
                        jQuery("#product_name").append(option_pro);
                        jQuery("#product_name").select2();

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(jqXHR.responseText);
                        alert(errorThrown);
                    }
                });
            }

        });

    </script>

@endsection



