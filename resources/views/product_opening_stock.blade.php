@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Product Opening Stock</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <div
                    class="search_form m-0 p-0 {{ ( !empty($search) || !empty($search_group) || !empty($search_category) || !empty($search_product_reporting_group) || !empty($search_main_unit) || !empty($search_unit) ) ? '' : 'search_form_hidden' }}">

                    <form class="highlight prnt_lst_frm" action="{{ route('product_opening_stock') }}" name="form1"
                          id="form1" method="post" autocomplete="off">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input type="search" list="browsers" class="inputs_up form-control"
                                           name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}">
                                    <datalist id="browsers">
                                        @foreach($product_names as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign"
                                          style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Group
                                    </label>
                                    <select class="inputs_up form-control" name="group" id="group">
                                        <option value="">Select Group</option>
                                        @foreach($groups as $group)
                                            <option
                                                value="{{$group->grp_id}}" {{ $group->grp_id == $search_group ? 'selected="selected"' : '' }}>{{$group->grp_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Category
                                    </label>
                                    <select class="inputs_up form-control" name="category" id="category">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option
                                                value="{{$category->cat_id}}" {{ $category->cat_id == $search_category ? 'selected="selected"' : '' }}>{{$category->cat_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Product Reporting Group
                                    </label>
                                    <select class="inputs_up form-control" name="product_reporting_group"
                                            id="product_reporting_group">
                                        <option value="">Select Product Reporting Group</option>
                                        @foreach($product_reporting_groups as $product_reporting_group)
                                            <option value="{{$product_reporting_group->pg_id}}"
                                                {{ $product_reporting_group->pg_id == $search_product_reporting_group ? 'selected="selected"' :''}}>
                                                {{$product_reporting_group->pg_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Main Unit
                                    </label>
                                    <select class="inputs_up form-control" name="main_unit" id="main_unit">
                                        <option value="">Select Main Unit</option>
                                        @foreach($main_units as $main_unit)
                                            <option
                                                value="{{$main_unit->mu_id}}" {{ $main_unit->mu_id == $search_main_unit ? 'selected="selected"' : '' }}>{{$main_unit->mu_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Unit
                                    </label>
                                    <select class="inputs_up form-control" name="unit" id="unit">
                                        <option value="">Select Unit</option>
                                        @foreach($units as $unit)
                                            <option
                                                value="{{$unit->unit_id}}" {{ $unit->unit_id == $search_unit ? 'selected="selected"' : '' }}>{{$unit->unit_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form_controls text-right">
                                @include('include.clear_search_button')

                                @include('include/print_button')

                                <span id="demo1" class="validate_sign"
                                      style="float: right !important"> </span>

                            </div>

                        </div>
                    </form>

                </div><!-- search form end -->

                <div class="excel_con gnrl-mrgn-pdng gnrl-blk">
                    <div class="excel_box gnrl-mrgn-pdng gnrl-blk">
                        <div class="excel_box_hdng gnrl-mrgn-pdng gnrl-blk">
                            <h2 class="gnrl-blk gnrl-mrgn-pdng gnrl-font-bold">
                                Upload Excel File
                            </h2>
                        </div>
                        <div class="excel_box_content gnrl-mrgn-pdng gnrl-blk">

                            <form action="{{ route('update_product_opening_stock_excel') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                Select Excel File
                                            </label>
                                            <input tabindex="100" type="file" name="add_create_product_opening_stock_excel" id="product_opening_stock_excel"
                                                   class="inputs_up form-control-file form-control height-auto"
                                                   accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        </div><!-- end input box -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                        <a href="{{ url('public/sample/opening_stock/add_opening_stock_pattern.xlsx') }}" tabindex="-1" type="reset" class="cancel_button form-control">
                                            Download Sample Pattern
                                        </a>
                                        <button tabindex="101" type="submit" name="save" id="save2" class="save_button form-control">
                                            <i class="fa fa-floppy-o"></i> Save
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>


                <form name="f1" class="f1" id="f1" action="{{ route('update_product_opening_stock') }}"
                      onsubmit="return form_validation()" method="post" autocomplete="off">
                    @csrf

                    <div class="table-responsive" id="parent">
                        <table class="table table-bordered table-sm" id="fixTable">

                            <thead>
                            <tr>
                                <th nowrap="" scope="col" class="tbl_srl_4">
                                    Sr.
                                </th>
                                <th scope="col" class="tbl_amnt_8">
                                    Group
                                </th>
                                <th scope="col" class="tbl_amnt_8">
                                    Category
                                </th>
                                <th nowrap="" scope="col" class="tbl_amnt_10">
                                    Product Code
                                </th>
                                <th nowrap="" scope="col" class="tbl_txt_15">
                                    Product Title
                                </th>

                                <th nowrap="" scope="col" class="tbl_amnt_8">
                                    Purchase Price
                                </th>
                                <th nowrap="" scope="col" class="tbl_amnt_8">
                                    Bottom Price
                                </th>
                                <th nowrap="" scope="col" class="tbl_amnt_8">
                                    Sale Price
                                </th>

                                <th nowrap="" scope="col" class="tbl_amnt_5">
                                    Pack Qty
                                </th>
                                <th nowrap="" scope="col" class="tbl_amnt_5">
                                    Loose Qty
                                </th>
                                <th nowrap="" scope="col" class="tbl_amnt_8">
                                    Total Qty
                                </th>
                                <th nowrap="" scope="col" class="tbl_amnt_10">
                                    Total
                                </th>

                            </tr>
                            </thead>

                            <tbody id="product-data">
                            @include('infinite_scroll.product_opening_stock_data')
                            {{--                            @php--}}
                            {{--                               // $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';--}}
                            {{--                               // $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';--}}
                            {{--                               // $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;--}}
                            {{--                                $sr = 1;--}}
                            {{--                               // $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;--}}
                            {{--                            @endphp--}}

                            {{--                            @forelse($datas as $index=> $product)--}}

                            {{--                                <tr>--}}
                            {{--                                    <td>--}}
                            {{--                                        {{$sr}}--}}
                            {{--                                    </td>--}}
                            {{--                                    <td>--}}
                            {{--                                        {{$product->grp_title}}--}}
                            {{--                                    </td>--}}
                            {{--                                    <td>--}}
                            {{--                                        {{$product->cat_title}}--}}
                            {{--                                    </td>--}}
                            {{--                                    <td nowrap="">--}}
                            {{--                                        {{$product->pro_p_code}}--}}
                            {{--                                    </td>--}}
                            {{--                                    <td >--}}
                            {{--                                        {{$product->pro_title}}--}}
                            {{--                                    </td>--}}

                            {{--                                    <td nowrap="" class="align_right text-right">--}}
                            {{--                                        <span id="p{{$index}}" class="validate_sign"> </span>--}}
                            {{--                                        <input type="text"--}}
                            {{--                                               class="form-control w-100 border-radius-0 border-0 text-right"--}}
                            {{--                                               value="{{old('p_rate.'.$index, $product->pro_purchase_price)}}"--}}
                            {{--                                               name="p_rate[]"--}}
                            {{--                                               id="p_rate{{$index}}" data-id="{{$index}}"--}}
                            {{--                                               onkeyup="balance_calculation({{$index}});"--}}
                            {{--                                               onkeypress="return allow_only_number_and_decimals(this,event);"--}}
                            {{--                                               onfocus="this.select();">--}}

                            {{--                                        <input type="hidden" name="id[]" class="form-control"--}}
                            {{--                                               value="{{$product->pro_p_code}}"/>--}}
                            {{--                                    </td>--}}
                            {{--                                    <td nowrap="" class="align_right text-right">--}}
                            {{--                                        <span id="b{{$index}}" class="validate_sign"> </span>--}}
                            {{--                                        <input type="text"--}}
                            {{--                                               class="form-control w-100 border-radius-0 border-0 text-right"--}}
                            {{--                                               value="{{old('b_rate.'.$index, $product->pro_bottom_price)}}"--}}
                            {{--                                               name="b_rate[]"--}}
                            {{--                                               id="b_rate{{$index}}" data-id="{{$index}}"--}}
                            {{--                                               onkeypress="return allow_only_number_and_decimals(this,event);"--}}
                            {{--                                               onfocus="this.select();">--}}
                            {{--                                    </td>--}}
                            {{--                                    <td nowrap="" class="align_right text-right">--}}
                            {{--                                        <span id="s{{$index}}" class="validate_sign"> </span>--}}
                            {{--                                        <input type="text"--}}
                            {{--                                               class="form-control w-100 border-radius-0 border-0 text-right"--}}
                            {{--                                               value="{{old('s_rate.'.$index, $product->pro_sale_price)}}"--}}
                            {{--                                               name="s_rate[]"--}}
                            {{--                                               id="s_rate{{$index}}" data-id="{{$index}}"--}}
                            {{--                                               onkeypress="return allow_only_number_and_decimals(this,event);"--}}
                            {{--                                               onfocus="this.select();">--}}
                            {{--                                    </td>--}}


                            {{--                                    <td nowrap="" class="align_right text-right" hidden>--}}
                            {{--                                        <span id="sca{{$index}}" class="validate_sign"> </span>--}}
                            {{--                                        <input type="text"--}}
                            {{--                                               class="form-control w-100 border-radius-0 border-0 text-right"--}}
                            {{--                                               value="{{$product->unit_scale_size}}"--}}
                            {{--                                               name="scale_size[]"--}}
                            {{--                                               id="scale_size{{$index}}" data-id="{{$index}}"--}}
                            {{--                                               onkeyup="balance_calculation({{$index}})" ; onkeypress="return allow_only_number_and_decimals(this,--}}
                            {{--                                               event);"--}}
                            {{--                                               onfocus="this--}}
                            {{--                                               .select();">--}}
                            {{--                                    </td>--}}
                            {{--                                    @php--}}
                            {{--                                        $scale_size = $product->unit_scale_size;--}}
                            {{--                                        $product_qty = $product->pro_quantity;--}}
                            {{--                                            $pack_qty =(int)($product_qty / $scale_size);--}}

                            {{--                                    @endphp--}}
                            {{--                                    <td nowrap="" class="align_right text-right">--}}
                            {{--                                        <span id="pq{{$index}}" class="validate_sign"> </span>--}}
                            {{--                                        <input type="text"--}}
                            {{--                                               class="form-control w-100 border-radius-0 border-0 text-right"--}}
                            {{--                                               value="{{$pack_qty}}"--}}
                            {{--                                               name="pack_quantity[]"--}}
                            {{--                                               id="pack_quantity{{$index}}" data-id="{{$index}}"--}}
                            {{--                                               onkeyup="balance_calculation({{$index}})" ; onkeypress="return allow_only_number_and_decimals(this,--}}
                            {{--                                               event);"--}}
                            {{--                                               onfocus="this--}}
                            {{--                                               .select();">--}}
                            {{--                                    </td>--}}
                            {{--                                    @php--}}
                            {{--                                        $loose_qty = fmod($product_qty, $scale_size);--}}
                            {{--                                    @endphp--}}
                            {{--                                    <td nowrap="" class="align_right text-right">--}}
                            {{--                                        <span id="lq{{$index}}" class="validate_sign"> </span>--}}
                            {{--                                        <input type="text"--}}
                            {{--                                               class="form-control w-100 border-radius-0 border-0 text-right"--}}
                            {{--                                               value="{{$loose_qty}}"--}}
                            {{--                                               name="loose_quantity[]"--}}
                            {{--                                               id="loose_quantity{{$index}}" data-id="{{$index}}"--}}
                            {{--                                               onkeyup="balance_calculation({{$index}})" ; onkeypress="return allow_only_number_and_decimals(this,--}}
                            {{--                                               event);"--}}
                            {{--                                               onfocus="this--}}
                            {{--                                               .select();">--}}
                            {{--                                    </td>--}}

                            {{--                                    <td nowrap="" class="align_right text-right" readonly>--}}
                            {{--                                        <span id="q{{$index}}" class="validate_sign"> </span>--}}
                            {{--                                        <input type="text"--}}
                            {{--                                               class="form-control w-100 border-radius-0 border-0 text-right"--}}
                            {{--                                               value="{{old('quantity.'.$index, $product->pro_quantity)}}"--}}
                            {{--                                               name="quantity[]"--}}
                            {{--                                               id="quantity{{$index}}" data-id="{{$index}}"--}}
                            {{--                                               onkeyup="balance_calculation({{$index}})" ;--}}
                            {{--                                               onkeypress="return allow_only_number_and_decimals(this,event);"--}}
                            {{--                                               onfocus="this--}}
                            {{--                                               .select();" readonly>--}}
                            {{--                                    </td>--}}

                            {{--                                    @php--}}
                            {{--                                        $total_amount=$product->pro_purchase_price * $product->pro_quantity;--}}
                            {{--                                    @endphp--}}
                            {{--                                    <td nowrap="" class="align_right text-right td_total" id="td_total">--}}

                            {{--                                        <input type="text"--}}
                            {{--                                               class="form-control w-100 border-radius-0 border-0 text-right total_amount"--}}
                            {{--                                               name="total_amount[]" value="{{$total_amount}}"--}}
                            {{--                                               id="total_amount{{$index}}" data-id="{{$index}}"--}}
                            {{--                                               onkeypress="return allow_only_number_and_decimals(this,event);"--}}
                            {{--                                               readonly>--}}

                            {{--                                    </td>--}}

                            {{--                                    @php--}}
                            {{--                                        $ip_browser_info= ''.$product->pro_ip_adrs.','.str_replace(' ','-',$product->pro_brwsr_info).'';--}}
                            {{--                                    @endphp--}}

                            {{--                                </tr>--}}
                            {{--                                @php--}}
                            {{--                                    $sr++;--}}
                            {{--                                    //$sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;--}}
                            {{--                                @endphp--}}
                            {{--                            @empty--}}
                            {{--                                <tr>--}}
                            {{--                                    <td colspan="11">--}}
                            {{--                                        <center><h3 style="color:#554F4F">No Product</h3></center>--}}
                            {{--                                    </td>--}}
                            {{--                                </tr>--}}
                            {{--                            @endforelse--}}

                            @if($datas == null)
                                <tr>
                                    <td colspan="12">
                                        <center><h3 style="color:#554F4F">No Product</h3></center>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="11" class="align_right text-right border-0">
                                    Total:-
                                </th>

                                <td class="align_right text-right border-0 td_tb" id="td_tb" style="font-weight: bold">
                                <!-- {{ number_format(0,2) }} -->

                                </td>
                            </tr>

                            </tfoot>

                        </table>
                    </div>

                    {{--                    <span--}}
                    {{--                        style="float: right">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'group'=>$search_group, 'category'=>$search_category, 'product_reporting_group'=>$search_product_reporting_group, 'main_unit'=>$search_main_unit, 'unit'=>$search_unit ])->links() }}</span>--}}


                    <div class="form-group row">
                        <div class="col-lg-2 col-md-2">
                            <button type="submit" name="save" id="save" class="save_button form-control"
                                    onclick="return form_validation()" disabled="disabled">
                                Opening Stock Confirmation

                            </button>

                            <span id="validate_msg" class="validate_sign"></span>
                        </div>
                    </div>


                </form>

            </div> <!-- white column form ends here -->
            <div class="ajax-load text-center" style="display: none" id="loading">
                {{--                <p><img src="{{asset('loader_image/Spinner-2.gif')}}" alt="">Loading More Product</p>--}}
            </div>

        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    infinite scrol script start--}}
    <script>
        function loadMoreData(page) {
            var search = $('#search').val();
            var group = $('#group').val();
            var category = $('#category').val();
            var product_reporting_group = $('#product_reporting_group').val();
            var main_unit = $('#main_unit').val();
            var unit = $('#unit').val();
            $.ajax({
                url: '?page=' + page,
                type: 'get',
                data: {search: search,group:group,category:category,product_reporting_group:product_reporting_group,main_unit:main_unit,unit:unit},
                beforeSend: function () {
                    jQuery(".pre-loader").fadeToggle("medium");
                }
            })
                .done(function (data) {
                    console.log(data.html , 'dddd');
                    if (data.html == "") {
                        let loadMSG = `<p> No More Records Found</p>`;
                        alert(loadMSG);
                        $('#save').prop('disabled', false);
                        jQuery(".pre-loader").fadeToggle("medium");
                        $('.ajax-load').html(loadMSG);
                        return;
                    }
                    jQuery(".pre-loader").fadeToggle("medium");
                    $('#product-data').append(data.html);
                })
                .fail(function (jqXHR, ajaxOption, thrownError) {
                    alert("server not responding...");
                })
        }

        var page = 1;
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
                page++;
                loadMoreData(page)
            }
        })
    </script>
    {{--    infinite scrol script end--}}
    <script>
        function total_balance_calculation() {
            var total = 0;
            $(".total_amount").each(function () {
                total += +$(this).val();
            });
            $('#td_tb').text(total.toFixed(2));
        }
    </script>
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('product_opening_stock') }}',
            url;

        @include('include.print_script_sh')

        {{--    add code by shahzaib end --}}

        jQuery("#group").select2();
        jQuery("#category").select2();
        jQuery("#product_group").select2();
        jQuery("#main_unit").select2();
        jQuery("#unit").select2();
        jQuery("#product_reporting_group").select2();
        total_balance_calculation();

    </script>
    <script>
        $(document).ready(function () {
            total_balance_calculation();

        });
    </script>
    <script>
        $('.save_button').click(function () {
            jQuery(".pre-loader").fadeToggle("medium");
        });
    </script>
    <script>
        function balance_calculation(id) {
            var purchase_rate = $("#p_rate" + id).val(),
                // quantity = $("#quantity" + id).val(),
                pack_quantity = $("#pack_quantity" + id).val(),
                loose_quantity = $("#loose_quantity" + id).val(),
                scale_size = $("#scale_size" + id).val();
            if (loose_quantity >= parseFloat(scale_size)) {
                loose_quantity = 0;
                jQuery("#loose_quantity" + id).val('');
            }
            var pack_qty = pack_quantity * scale_size;
            var quantity = +pack_qty + +loose_quantity;
            var total_amount = purchase_rate * quantity;
            console.log(total_amount);

            $("#quantity" + id).val(quantity);
            $('#total_amount' + id).val(total_amount.toFixed(2));
            $('#td_total' + id).text(total_amount.toFixed(2));
            total_balance_calculation();

        }

        document.addEventListener('keydown', function (e) {

            if (e.keyCode == 13) {
                e.cancelBubble = true;
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;

            }
        });

    </script>

@endsection

