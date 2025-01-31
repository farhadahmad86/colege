@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Budget Planning</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

            <!-- <div class="search_form {{ ( !empty($search) || !empty($search_order_list) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                            <form class="prnt_lst_frm" action="{{ route('budget_planning') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1" id="form1"
                                  method="post">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..."
                                                   value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($product as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Order List Title
                                                    </label>
                                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="order_list" id="order_list">
                                                        <option value="">Select Order List</option>
                                                        @foreach($order_lists as $order_list)
                                                            <option
                                                                value="{{$order_list->ol_id}}" {{ $order_list->ol_id == $search_order_list ? 'selected="selected"' : ''
                                                                }}>{{$order_list->ol_order_title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form_controls text-center">

                                            <button tabindex="7" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                <i class="fa fa-trash"></i> Clear
                                            </button>
                                            <button tabindex="8" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                <i class="fa fa-search"></i> Search
                                            </button>

                                            <a tabindex="9" class="save_button form-control" href="{{ route('budget_planning_list') }}" role="button">
                                                <i class="fa fa-plus"></i> Budget Planning List
                                            </a>

                                            @include('include/print_button')

                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                        </div>
                                    </div>

                                </div>

                            </form>


                        </div>

                    </div>
                </div><!-- search form end -->

                <form name="f1" class="f1" id="f1" action="{{ route('submit_budget_planning') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12" hidden>
                        <div class="input_bx"><!-- start input box -->
                            <label>
                                Order List
                            </label>
                            <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="order_list" id="order_list2">
                                <option value="">Select Order List</option>
                                @foreach($order_lists as $order_list)
                                    <option
                                        value="{{$order_list->ol_id}}" {{ $order_list->ol_id == $search_order_list ? 'selected="selected"' : ''}}>{{$order_list->ol_order_title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive" id="printTable">
                        <table class="table table-sm" id="fixTable">

                            <thead>
                            <tr>
                                <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                                    SR#
                                </th>
                                <th scope="col" align="center" class="text-center align_center tbl_txt_4" hidden>
                                    ID
                                </th>
                                <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                                    Zone
                                </th>
                                <th scope="col" align="center" class="text-center align_center tbl_txt_7">
                                    Region
                                </th>
                                <th scope="col" align="center" class="text-center align_center tbl_txt_15" hidden>
                                    Product Barcode
                                </th>

                                <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                                    Product Title
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                                    Qty
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_7">
                                    Total Per Unit Rate
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_7">
                                    Material Per Unit Rate
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_7">
                                    Expense Per Unit Rate
                                </th>

                                <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                                    Material Amount
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                                    Material %
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                                    Expense Amount
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                                    Expense %
                                </th>

                                <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                                    Total Amount
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_5" hidden>
                                    Total %
                                </th>

                                {{--                                <th scope="col" align="center" class="align_center text-center tbl_amnt_10">--}}
                                {{--                                    Bonus--}}
                                {{--                                </th>--}}

                            </tr>
                            </thead>

                            <tbody>
                            @php
                                $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                                $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                                $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                                $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                                $prchsPrc = $slePrc = $avrgPrc = 0;
                            @endphp

                            @forelse($datas as $product)

                                {{--                                <tr > <!--data-product_id="{{$product->pro_id}}"-->--}}
                                <tr>
                                    <td class="align_center text-center edit tbl_srl_4">
                                        {{$sr}}

                                    </td>
                                    <td class="align_center text-center edit tbl_srl_4" hidden>
                                        <input type="hidden" name="id[]" class="inputs_up form-control" id="id{{$product->id}}"
                                               value="{{$product->id}}" readonly/>
                                        {{$product->id}}

                                    </td>
                                    <td class="align_center text-center edit tbl_srl_4" hidden>
                                        <input type="hidden" name="status[]" class="inputs_up form-control" id="status{{$product->id}}"
                                               value="{{$product->status}}" readonly/>{{$product->status}}

                                    </td>

                                    <td class="align_center text-center edit tbl_txt_10" hidden>
                                        <input type="hidden" name="zone_id[]" class="inputs_up form-control" id="zone_id{{$product->id}}"
                                               value="{{$product->zone}}" readonly/>
                                        {{$product->zone}}
                                    </td>
                                    <td class="align_center text-center edit tbl_txt_8">
                                        <input type="hidden" name="zone_name[]" class="inputs_up form-control" id="zone_name{{$product->id}}"
                                               value="{{$product->zone_name}}" readonly/>
                                        {{$product->zone_name}}
                                    </td>

                                    <td class="align_left text-left edit tbl_txt_10" hidden>
                                        <input type="hidden" name="region_id[]" class="inputs_up form-control" id="region_id{{$product->id}}"
                                               value="{{$product->region}}" readonly/>
                                        {{$product->region}}
                                    </td>
                                    <td class="align_left text-left edit tbl_txt_7">
                                        <input type="hidden" name="region_name[]" class="inputs_up form-control" id="region_name{{$product->id}}"
                                               value="{{$product->region_name}}" readonly/>
                                        {{$product->region_name}}
                                    </td>
                                    <td class="align_left text-left edit tbl_txt_10" hidden>
                                        <input type="hidden" name="product_code[]" class="inputs_up form-control" id="product_code{{$product->id}}"
                                               value="{{$product->code}}" readonly/>
                                        {{$product->code}}
                                    </td>

                                    <td class="align_left text-left edit tbl_txt_15">
                                        <input type="hidden" name="product_name[]" class="inputs_up form-control" id="product_name{{$product->id}}"
                                               value="{{$product->name}}" readonly/>
                                        {{$product->name}}
                                    </td>

                                    <td class="align_left text-left edit tbl_txt_10">
                                        <input type="hidden" name="qty[]" class="inputs_up form-control" id="qty{{$product->id}}"
                                               value="{{$product->qty}}" readonly/>
                                        {{$product->qty}}
                                    </td>

                                    <td class="align_left text-left edit tbl_txt_7">
                                        <input type="hidden" name="rate[]" class="inputs_up form-control" id="rate{{$product->id}}"
                                               value="{{$product->rate}}" readonly/>
                                        {{$product->rate}}
                                    </td>
                                    <td class="align_left text-left edit tbl_txt_7">
                                        <input type="text" name="material_rate[]" class="inputs_up form-control" id="material_rate{{$product->id}}"
                                               placeholder="Per unit Rate"
                                               onkeyup="product_material_per_unit_calculation({{$product->id}})"
                                               />

                                    </td>
                                    <td class="align_left text-left edit tbl_txt_7">
                                        <input type="text" name="expense_rate[]" class="inputs_up form-control" id="expense_rate{{$product->id}}"
                                               placeholder="Per unit Rate"
                                               onkeyup="product_expense_per_unit_calculation({{$product->id}})"
                                               />

                                    </td>

                                    <td class="align_center text-center edit tbl_txt_10">
                                        <input type="text" name="material_amount[]" class="inputs_up form-control" id="material_amount{{$product->id}}"
                                               placeholder="Material Amount"
                                               onkeyup="product_material_pec_calculation({{$product->id}})"
                                               onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                    </td>
                                    <td class="align_center text-center edit tbl_txt_5">
                                        <input type="text" name="material_pec[]" class="inputs_up form-control" id="material_pec{{$product->id}}"
                                               placeholder="Material %"
                                               onkeyup="product_material_amount_calculation({{$product->id}})"
                                               onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                    </td>

                                    <td class="align_center text-center edit tbl_txt_10">
                                        <input type="text" name="expense_amount[]" class="inputs_up form-control" id="expense_amount{{$product->id}}"
                                               placeholder="Material Amount"
                                               onkeyup="product_expense_pec_calculation({{$product->id}})"
                                               onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                    </td>
                                    <td class="align_center text-center edit tbl_txt_5">
                                        <input type="text" name="expense_pec[]" class="inputs_up form-control" id="expense_pec{{$product->id}}"
                                               placeholder="Expense %"
                                               onkeyup="product_expense_amount_calculation({{$product->id}})"
                                               onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                    </td>

                                    <td class="align_left text-left edit tbl_txt_10">
                                        <input type="hidden" name="amount[]" class="inputs_up form-control" id="amount{{$product->id}}"
                                               value="{{$product->amount}}" readonly/>
                                        {{$product->amount}}
                                    </td>

                                    <td class="align_left text-left edit tbl_txt_5" hidden>
                                        <input type="hidden" name="amount_pec[]" class="inputs_up form-control" id="amount_pec{{$product->id}}"
                                               value="{{100}}" readonly/>
                                        100
                                    </td>
                                    {{--                                    <td class="align_center text-center edit tbl_amnt_4">--}}
                                    {{--                                        <input type="text" name="bonus[]" class="inputs_up form-control" id="bonus"--}}
                                    {{--                                               placeholder="Bonus"--}}
                                    {{--                                               onkeypress="return allow_only_number_and_decimals(this,event);"/>--}}
                                    {{--                                    </td>--}}

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
                    {{--                    <div class="col-lg-12 col-md-12 col-sm-12 form_controls">--}}
                    <div class="col-lg-2 col-md-2">
                        <button type="submit" name="save" id="save" class="save_button form-control">
                            <i class="fa fa-floppy-o"></i> SAVE
                        </button>

                        <span id="validate_msg" class="validate_sign"></span>
                        {{--                                    <input type="hidden" name="title" id="title" value="{{$title}}">--}}
                    </div>
                </form>
                {{--                <span--}}
                {{--                    class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'main_unit'=>$search_main_unit, 'unit'=>$search_unit, 'group'=>$search_group, 'category'=>$search_category ]) }}</span>--}}
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('budget_planning') }}',
            url;

        @include('include.print_script_sh')
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#order_list").select2().val(null).trigger("change");
            $("#order_list > option").removeAttr('selected');


            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#order_list").select2();
            jQuery("#order_list2").select2();

        });
    </script>
    <script>
        jQuery("#order_list").change(function () {

            var order_list = jQuery('option:selected', this).val();

            jQuery("#order_list2").select2("destroy");

            // jQuery("#product > option").each(function () {
            jQuery('#order_list2 option[value="' + order_list + '"]').prop('selected', true);
            // });

            jQuery("#order_list2").select2();

        });

    </script>


    <script>
        function product_material_amount_calculation(id) {

            var rate = jQuery("#rate" + id).val();
            var total_amount = jQuery("#amount" + id).val();
            var percentage = jQuery("#amount_pec" + id).val();
            var material_percentage = jQuery("#material_pec" + id).val();
            var expense_percentage = jQuery("#expense_pec" + id).val();

            if (material_percentage <= 100) {

                var expense_pec = percentage - material_percentage;
                jQuery("#expense_pec" + id).val(expense_pec);
                var expense_rate = rate / 100 * expense_pec;
                var material_rate = rate / 100 * material_percentage;
                var expense_amount = total_amount / 100 * expense_pec;
                var material_amount = total_amount / 100 * material_percentage;
                jQuery("#expense_amount" + id).val(expense_amount.toFixed(2));
                jQuery("#material_amount" + id).val(material_amount.toFixed(2));
                jQuery("#material_rate" + id).val(material_rate.toFixed(2));
                jQuery("#expense_rate" + id).val(expense_rate.toFixed(2));
            } else {
                jQuery("#material_pec" + id).val('');
                jQuery("#expense_pec" + id).val('');
                jQuery("#expense_amount" + id).val('');
                jQuery("#material_amount" + id).val('');
                jQuery("#expense_rate" + id).val('');
                jQuery("#material_rate" + id).val('');
            }

        }

        function product_expense_amount_calculation(id) {

            var rate = jQuery("#rate" + id).val();
            var total_amount = jQuery("#amount" + id).val();
            var percentage = jQuery("#amount_pec" + id).val();
            var material_percentage = jQuery("#material_pec" + id).val();
            var expense_percentage = jQuery("#expense_pec" + id).val();

            if (expense_percentage <= 100) {

                var material_pec = percentage - expense_percentage;
                jQuery("#material_pec" + id).val(material_pec);
                var expense_rate = rate / 100 * expense_percentage;
                var material_rate = rate / 100 * material_pec;

                var material_amount = total_amount / 100 * material_pec;
                var expense_amount = total_amount / 100 * expense_percentage;
                jQuery("#expense_amount" + id).val(expense_amount.toFixed(2));
                jQuery("#material_amount" + id).val(material_amount.toFixed(2));

                jQuery("#expense_rate" + id).val(expense_rate.toFixed(2));
                jQuery("#material_rate" + id).val(material_rate.toFixed(2));
            } else {
                jQuery("#material_pec" + id).val('');
                jQuery("#expense_pec" + id).val('');
                jQuery("#expense_amount" + id).val('');
                jQuery("#material_amount" + id).val('');
                jQuery("#expense_rate" + id).val('');
                jQuery("#material_rate" + id).val('');
            }

        }
    </script>

    <script>
        function product_material_pec_calculation(id) {

            var rate = jQuery("#rate" + id).val();
            var total_amount = jQuery("#amount" + id).val();
            var material_amount = jQuery("#material_amount" + id).val();
            var expense_amount = jQuery("#expense_amount" + id).val();

            if (material_amount <= parseFloat(total_amount)) {

                var expense_amount = total_amount - material_amount;
                jQuery("#expense_amount" + id).val(expense_amount);

                var expense_pec = expense_amount / total_amount * 100;
                var material_pec = material_amount / total_amount * 100;

                var expense_rate = rate / 100 * expense_pec;
                var material_rate = rate / 100 * material_pec;

                jQuery("#expense_amount" + id).val(expense_amount.toFixed(2));
                jQuery("#expense_pec" + id).val(expense_pec.toFixed(2));
                jQuery("#material_pec" + id).val(material_pec.toFixed(2));
                jQuery("#material_rate" + id).val(material_rate.toFixed(3));
                jQuery("#expense_rate" + id).val(expense_rate.toFixed(3));
            } else {
                jQuery("#material_pec" + id).val('');
                jQuery("#expense_pec" + id).val('');
                jQuery("#expense_amount" + id).val('');
                jQuery("#material_amount" + id).val('');
                jQuery("#expense_rate" + id).val('');
                jQuery("#material_rate" + id).val('');
            }

        }

        function product_expense_pec_calculation(id) {

            var rate = jQuery("#rate" + id).val();
            var total_amount = jQuery("#amount" + id).val();
            var material_amount = jQuery("#material_amount" + id).val();
            var expense_amount = jQuery("#expense_amount" + id).val();

            if (expense_amount <= parseFloat(total_amount)) {

                var material_amount = total_amount - expense_amount;
                jQuery("#material_amount" + id).val(material_amount);


                var material_pec = material_amount / total_amount * 100;
                var expense_pec = expense_amount / total_amount * 100;

                var expense_rate = rate / 100 * expense_pec;
                var material_rate = rate / 100 * material_pec;

                jQuery("#expense_pec" + id).val(expense_pec.toFixed(2));
                jQuery("#material_pec" + id).val(material_pec.toFixed(2));

                jQuery("#expense_rate" + id).val(expense_rate.toFixed(3));
                jQuery("#material_rate" + id).val(material_rate.toFixed(3));
            } else {
                jQuery("#material_pec" + id).val('');
                jQuery("#expense_pec" + id).val('');
                jQuery("#expense_amount" + id).val('');
                jQuery("#material_amount" + id).val('');
                jQuery("#expense_rate" + id).val('');
                jQuery("#material_rate" + id).val('');
            }

        }
    </script>

    <script>
        function product_material_per_unit_calculation(id) {

            var rate = jQuery("#rate" + id).val();
            var qty = jQuery("#qty" + id).val();
            var total_amount = jQuery("#amount" + id).val();

            var material_rate = jQuery("#material_rate" + id).val();
            var expense_rate = jQuery("#expense_rate" + id).val();

            if (material_rate <= parseFloat(rate)) {

                var expense_rate = rate - material_rate;
                jQuery("#expense_rate" + id).val(expense_rate);

                var material_amount = qty * material_rate;
                var expense_amount = qty * expense_rate;

                var expense_pec = expense_amount / total_amount * 100;
                var material_pec = material_amount / total_amount * 100;

                var expense_amount = total_amount / 100 * expense_pec;
                var material_amount = total_amount / 100 * material_pec;

                jQuery("#expense_amount" + id).val(expense_amount.toFixed(2));
                jQuery("#expense_pec" + id).val(expense_pec.toFixed(2));
                jQuery("#material_pec" + id).val(material_pec.toFixed(2));
                jQuery("#material_amount" + id).val(material_amount.toFixed(2));
                // jQuery("#expense_rate" + id).val(expense_rate.toFixed(2));
            } else {
                jQuery("#material_pec" + id).val('');
                jQuery("#expense_pec" + id).val('');
                jQuery("#expense_amount" + id).val('');
                jQuery("#material_amount" + id).val('');
                jQuery("#expense_rate" + id).val('');
                jQuery("#material_rate" + id).val('');
            }

        }

        function product_expense_per_unit_calculation(id) {

            var rate = jQuery("#rate" + id).val();
            var qty = jQuery("#qty" + id).val();
            var total_amount = jQuery("#amount" + id).val();

            var material_rate = jQuery("#material_rate" + id).val();
            var expense_rate = jQuery("#expense_rate" + id).val();

            if (expense_rate <= parseFloat(rate)) {

                var material_rate = rate - expense_rate;
                jQuery("#material_rate" + id).val(material_rate);
                var material_amount = qty * material_rate;
                var expense_amount = qty * expense_rate;


                var material_pec = material_amount / total_amount * 100;
                var expense_pec = expense_amount / total_amount * 100;

                var expense_amount = total_amount / 100 * expense_pec;
                var material_amount = total_amount / 100 * material_pec;


                jQuery("#expense_pec" + id).val(expense_pec.toFixed(2));
                jQuery("#material_pec" + id).val(material_pec.toFixed(2));

                jQuery("#expense_amount" + id).val(expense_amount.toFixed(2));
                jQuery("#material_amount" + id).val(material_amount.toFixed(2));
            } else {
                jQuery("#material_pec" + id).val('');
                jQuery("#expense_pec" + id).val('');
                jQuery("#expense_amount" + id).val('');
                jQuery("#material_amount" + id).val('');
                jQuery("#expense_rate" + id).val('');
                jQuery("#material_rate" + id).val('');
            }

        }
    </script>
@endsection

