@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Sale Order List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

            <!-- <div class="search_form {{ !empty($search) || !empty($search_account) || !empty($search_product) || !empty($search_to) || !empty($search_from) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('sale_order_list') }}" name="form1" id="form1"
                          method="post">
                        @csrf
                        <div class="row">
                            @if ($user->user_status == 'Employee')
                                <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label>
                                            All Column Search
                                        </label>
                                        <input type="search" list="browsers" class="inputs_up form-control"
                                               name="search" id="search" placeholder="Search ..."
                                               value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                        <datalist id="browsers">
                                            @foreach ($party as $value)
                                                <option value="{{ $value }}">
                                            @endforeach
                                        </datalist>
                                        <span id="demo1" class="validate_sign" style="float: right !important">
                                                </span>
                                        <input type="checkbox" name="check_desktop" id="check_desktop"
                                               value="1" {{ $check_desktop == 1 ? 'checked' : '' }}>
                                        <label class="d-inline" for="check_desktop">Desktop Order</label>
                                    </div>
                                </div> <!-- left column ends here -->
                            @endif

                            <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    @if ($user->user_status == 'Employee')
                                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label>
                                                    Account
                                                </label>
                                                <select class="inputs_up  form-control" name="account"
                                                        id="account">
                                                    <option value="">Select Account</option>
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->account_uid }}"
                                                            {{ $account->account_uid == $search_account ? 'selected="selected"' : '' }}>
                                                            {{ $account->account_name }}</option>
                                                    @endforeach
                                                </select>
                                                <span id="demo1" class="validate_sign"
                                                      style="float: right !important"> </span>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Select Code
                                            </label>
                                            <select class="inputs_up form-control" name="product" id="product">
                                                <option value="">Select Code</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->pro_code }}"
                                                        {{ $product->pro_code == $search_product ? 'selected="selected"' : '' }}>
                                                        {{ $product->pro_code }}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign"
                                                  style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Select Product
                                            </label>
                                            <select class="inputs_up  form-control" name="product_name"
                                                    id="product_name">
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->pro_code }}"
                                                        {{ $product->pro_code == $search_product ? 'selected="selected"' : '' }}>
                                                        {{ $product->pro_title }}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign"
                                                  style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Start Date
                                            </label>
                                            <input type="text" name="to" id="to"
                                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                                   <?php if(isset($search_to)){?> value="{{ $search_to }}" <?php } ?>
                                                   placeholder="Start Date ......"/>
                                            <span id="demo1" class="validate_sign"
                                                  style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                End Date
                                            </label>
                                            <input type="text" name="from" id="from"
                                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                                   <?php if(isset($search_from)){?> value="{{ $search_from }}" <?php } ?>
                                                   placeholder="End Date ......"/>
                                            <span id="demo1" class="validate_sign"
                                                  style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 mt-4 text-right">
                                    @include('include.clear_search_button')

                                    @if ($user->user_status == 'Employee')
                                        <!-- Call add button component -->
                                            <x-add-button tabindex="9" href="{{ route('sale_order') }}"/>
                                        @endif
                                        @include('include/print_button')

                                        <span id="demo1" class="validate_sign"
                                              style="float: right !important"> </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                    <form name="edit" id="edit" action="{{ route('edit_account') }}" method="post">
                        @csrf
                        <input name="account_id" id="account_id" type="hidden">
                    </form>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">
                                Sr#
                            </th>
                            <th scope="col" class="tbl_amnt_9">
                                Date
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Order No.
                            </th>

                            <th scope="col" class="tbl_txt_15">
                                Party Name
                            </th>
                            <th scope="col" class="tbl_txt_40">
                                Detail Remarks
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Total Price
                            </th>

                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                            $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                            $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                            $ttlPrc = $cashPaid = 0;
                        @endphp
                        @forelse($datas as $order)
                            <tr>
                                <th scope="row" class="edit">
                                    {{ $sr }}
                                </th>
                                <td nowrap>
                                    {{ date('d-M-y', strtotime(str_replace('/', '-', $order->so_day_end_date))) }}
                                </td>
                                <td class="view" data-id="{{ $order->so_id }}">
                                    SO-{{ $order->so_id }}
                                </td>

                                <td>
                                    {{ $order->so_party_name }}
                                </td>
                                <td>
                                    {!! str_replace(["\r\n", "\r", "\n", "\\r", "\\n", "\\r\\n"], '<br />', $order->so_detail_remarks) !!}
                                </td>
                                @php
                                    $ttlPrc = +$order->so_grand_total + +$ttlPrc;
                                @endphp
                                <td class="align_right text-right">
                                    {{ $order->so_grand_total != 0 ? number_format($order->so_grand_total, 2) : '' }}
                                </td>

                                @php
                                    $ip_browser_info = '' . $order->so_ip_adrs . ',' . str_replace(' ', '-', $order->so_brwsr_info) . '';
                                @endphp

                                <td class="usr_prfl"
                                    data-usr_prfl="{{ $order->user_id }}" data-user_info="{!! $ip_browser_info !!}"
                                    title="Click To See User Detail">
                                    {{ $order->user_name }}
                                </td>
                            </tr>
                            @php
                                $sr++;
                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="15">
                                    <center>
                                        <h3 style="color:#554F4F">No Order</h3>
                                    </center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                        <tfoot>
                        <tr>
                            <th colspan="5" class="align_right text-right border-0">
                                Per Page Total:-
                            </th>
                            <td class="align_right text-right border-0">
                                {{ number_format($ttlPrc, 2) }}
                            </td>
                            <td class="align_right text-right border-0">
                                {{ number_format($cashPaid, 2) }}
                            </td>
                        </tr>
                        </tfoot>


                    </table>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                    </div>
                    <div class="col-md-9 text-right">
                <span
                    class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search, 'account' => $search_account, 'product_code' => $search_product, 'to' => $search_to, 'from' => $search_from])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg mdl_wdth">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Sales Order Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div id="table_body">

                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button"
                                    data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection

@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('sale_order_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        // jQuery("#order_no").blur(function () {
        jQuery(".view").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");

            $('.modal-body').load('{{ url('sale_order_items_view_details/view/') }}' + '/' + id, function () {
                $('#myModal').modal({
                    show: true
                });
            });
        // {{-- jQuery.ajaxSetup({ --}}
        // {{--    headers: { --}}
        // {{--        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') --}}
        // {{--    } --}}
        // {{-- }); --}}

        // {{-- jQuery.ajax({ --}}
        // {{--    url: "{{ route('sale_items_view_details') }}", --}}
        // {{--    data: {id: id}, --}}
        // {{--    type: "POST", --}}
        // {{--    cache: false, --}}
        // {{--    dataType: 'json', --}}
        // {{--    success: function (data) { --}}

        // {{--        $.each(data, function (index, value) { --}}

        // {{--            var qty; --}}
        // {{--            var rate; --}}
        // {{--            var discount; --}}
        // {{--            var saletax; --}}
        // {{--            var amount; --}}

        // {{--            if(value['sii_qty']==0){ --}}
        // {{--                qty=''; --}}
        // {{--            }else{ --}}
        // {{--                qty=value['sii_qty']; --}}
        // {{--            } --}}
        // {{--            if(value['sii_rate']==0){ --}}
        // {{--                rate=''; --}}
        // {{--            }else{ --}}
        // {{--                rate=value['sii_rate']; --}}
        // {{--            } --}}
        // {{--            if(value['sii_discount']==0){ --}}
        // {{--                discount=''; --}}
        // {{--            }else{ --}}
        // {{--                discount=value['sii_discount']; --}}
        // {{--            } --}}
        // {{--            if(value['sii_saletax']==0){ --}}
        // {{--                saletax=''; --}}
        // {{--            }else{ --}}
        // {{--                saletax=value['sii_saletax']; --}}
        // {{--            } --}}
        // {{--            if(value['sii_amount']==0){ --}}
        // {{--                amount=''; --}}
        // {{--            }else{ --}}
        // {{--                amount=value['sii_amount']; --}}
        // {{--            } --}}

        // {{--            jQuery("#table_body").append( --}}
        // {{--            '<div class="itm_vchr form_manage">' + --}}
        // {{--            '<div class="form_header">' + --}}
        // {{--            '<h4 class="text-white file_name">' + --}}
        // {{--            '<span class="db sml_txt"> Product #: </span>' + --}}
        // {{--            '' + value['sii_product_code'] + '' + --}}
        // {{--            '</h4>' + --}}
        // {{--            '</div>' + --}}
        // {{--            '<div class="table-responsive">' + --}}
        // {{--            '<table class="table table-bordered table-sm">' + --}}
        // {{--            '<thead>' + --}}
        // {{--            '<tr>' + --}}
        // {{--            '<th scope="col" align="center" class="width_2">Product Name</th>' + --}}
        // {{--            '<th scope="col" align="center" class="width_5">Rate</th>' + --}}
        // {{--            '<th scope="col" align="center" class="width_5 text-right">Quantity</th>' + --}}
        // {{--            '</tr>' + --}}
        // {{--            '</thead>' + --}}
        // {{--            '<tbody>' + --}}
        // {{--            '<tr>' + --}}
        // {{--            '<td class="align_left"> <div class="max_txt"> ' + value['sii_product_name'] + '</div> </td>' + --}}
        // {{--            '<td class="align_left">' + rate + '</td>' + --}}
        // {{--            '<td class="align_left text-right">' + qty + '</td>' +'</td>' + --}}
        // {{--            '</tr>' + --}}
        // {{--            '</tbody>' + --}}
        // {{--            '<tfoot class="side-section">'+ --}}
        // {{--            '<tr class="border-0">'+ --}}
        // {{--            '<td colspan="7" align="right" class="p-0 border-0">'+ --}}
        // {{--            '<table class="table table-bordered table-sm chk_dmnd">'+ --}}
        // {{--            '<tfoot>'+ --}}
        // {{--            '<tr>'+ --}}
        // {{--            '<td class="border-top-0 border-right-0">'+ --}}
        // {{--            '<label class="total-items-label text-right">Discounts</label>'+ --}}
        // {{--            '</td>'+ --}}
        // {{--            '<td class="text-right border-top-0 border-left-0">'+ --}}
        // {{--            ((discount != null && discount != "") ? discount : '0.00') + --}}
        // {{--            '</td>'+ --}}
        // {{--            '</tr>'+ --}}
        // {{--            '<tr>'+ --}}
        // {{--            '<td colspan="" align="right" class="border-right-0">'+ --}}
        // {{--            '<label class="total-items-label text-right">Sale Tax</label>'+ --}}
        // {{--            '</td>'+ --}}
        // {{--            '<td class="text-right border-left-0" align="right">'+ --}}
        // {{--            ((saletax != null && saletax != "") ? saletax : '0.00') + --}}
        // {{--            '</td>'+ --}}
        // {{--            '</tr>'+ --}}
        // {{--            '<tr>'+ --}}
        // {{--            '<td colspan="" align="right" class="border-right-0">'+ --}}
        // {{--            '<label class="total-items-label text-right">Total Amount</label>'+ --}}
        // {{--            '</td>'+ --}}
        // {{--            '<td class="text-right border-left-0" align="right">'+ --}}
        // {{--            ((amount != null && amount != "") ? amount : '0.00') + --}}
        // {{--            '</td>'+ --}}
        // {{--            '</tr>'+ --}}
        // {{--            '</tfoot>'+ --}}
        // {{--            '</table>'+ --}}
        // {{--            '</td>'+ --}}
        // {{--            '</tr>'+ --}}
        // {{--            '</tfoot>'+ --}}
        // {{--            '</table>' + --}}
        // {{--            '</div>' + --}}
        // {{--            '<div class="itm_vchr_rmrks '+((value['sii_remarks'] != null && value['sii_remarks'] != "") ? '' : 'search_form_hidden') +'">' + --}}
        // {{--            '<h5 class="title_cus bold"> Remarks: </h5>' + --}}
        // {{--            '<p class="m-0 p-0">' + value['sii_remarks'] + '</p>' + --}}
        // {{--            '</div>' + --}}
        // {{--            '<div class="input_bx_ftr"></div>' + --}}
        // {{--            '</div>'); --}}

        // {{--        }); --}}
        // {{--    }, --}}
        // {{--    error: function (jqXHR, textStatus, errorThrown) { --}}
        // {{--        // alert(jqXHR.responseText); --}}
        // {{--        // alert(errorThrown); --}}
        // {{--    } --}}
        // {{-- }); --}}
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

            $("#account").select2().val(null).trigger("change");
            $("#account > option").removeAttr('selected');

            $("#product").select2().val(null).trigger("change");
            $("#product > option").removeAttr('selected');

            $("#product_name").select2().val(null).trigger("change");
            $("#product_name > option").removeAttr('selected');

            $("#search").val('');

            $("#to").val('');
            $("#from").val('');
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
        });
    </script>
@endsection
