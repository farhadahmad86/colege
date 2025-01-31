@extends('extend_index')

@section('content')
    <style>
        .table thead th {
            background-color: rgb(222 222 222);
            color: #000;
            height: 50px;
        }
    </style>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">{{$title}} Opening Balance</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <div class="search_form m-0 p-0 {{ ( !empty($search) || !empty($search_first_head) || !empty($search_second_head) || !empty($search_third_head) ) ? '' : 'search_form_hidden' }}">
                    <form class="highlight prnt_lst_frm" action="{{$route}}" name="form1" id="form1" method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach($account_names as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Control Account
                                    </label>
                                    <select class="inputs_up form-control cstm_clm_srch" name="first_head" id="first_head">
                                        <option value="">Select Control Account</option>
                                        @foreach($first_heads as $first_head)
                                            <option
                                                value="{{$first_head->coa_code}}" {{ $first_head->coa_code == $search_first_head ? 'selected="selected"' : '' }}>{{$first_head->coa_head_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Group Account
                                    </label>
                                    <select class="inputs_up form-control cstm_clm_srch" name="second_head" id="second_head">
                                        <option value="">Select Group Account</option>
                                        @foreach($second_heads as $second_head)
                                            <option
                                                value="{{$second_head->coa_code}}" {{ $second_head->coa_code == $search_second_head ? 'selected="selected"' : '' }}>{{$second_head->coa_head_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Parent Account
                                    </label>
                                    <select class="inputs_up form-control cstm_clm_srch" name="third_head" id="third_head">
                                        <option value="">Select Parent Account</option>
                                        @foreach($third_heads as $third_head)
                                            <option
                                                value="{{$third_head->coa_code}}" {{ $third_head->coa_code == $search_third_head ? 'selected="selected"' : '' }}>{{$third_head->coa_head_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Accounts
                                    </label>
                                    <select class="inputs_up form-control cstm_clm_srch" name="account_name" id="account_name">
                                        <option value="">Select Account</option>
                                        @foreach($account_names as $account_name)
                                            <option value="{{$account_name}}" {{ $account_name == $search_account_name ? 'selected="selected"' : '' }}>{{$account_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Select Region
                                    </label>
                                    <select class="inputs_up form-control cstm_clm_srch" name="region" id="region" style="width: 90%">
                                        <option value="">Select Region</option>
                                        @foreach($regions as $region)
                                            <option value="{{$region->reg_id}}" {{ $region->reg_id == $search_region ? 'selected="selected"' : '' }}>{{$region->reg_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="">
                                        Select Area
                                    </label>
                                    <select class="inputs_up form-control cstm_clm_srch" name="area" id="area" style="width: 90%">
                                        <option value="">Select Area</option>
                                        @foreach($areas as $area)
                                            <option value="{{$area->area_id}}" {{ $area->area_id == $search_area ? 'selected="selected"' : '' }}>{{$area->area_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="">
                                        Select Sector
                                    </label>
                                    <select class="inputs_up form-control cstm_clm_srch" name="sector" id="sector" style="width: 90%">
                                        <option value="">Select Sector</option>
                                        @foreach($sectors as $sector)
                                            <option value="{{$sector->sec_id}}" {{ $sector->sec_id == $search_sector ? 'selected="selected"' : '' }}>{{$sector->sec_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 form_controls text-right">
                                @include('include.clear_search_button')

                                @include('include/print_button')

                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>

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

                            <form action="{{ route('update_account_opening_balance_excel') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                Select Excel File
                                            </label>
                                            <input tabindex="100" type="file" name="add_account_opening_balance_excel" id="account_opening_balance_excel"
                                                   class="inputs_up form-control-file form-control height-auto"
                                                   accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        </div><!-- end input box -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                        {{--                                        <a href="{{ url('public/sample/pos_add_product/add_create_product_pattern.xlsx') }}" tabindex="-1" type="reset" class="cancel_button form-control">--}}
                                        {{--                                            Download Sample Pattern--}}
                                        {{--                                        </a>--}}
                                        <button tabindex="101" type="submit" name="save" id="save2" class="save_button form-control">
                                            <i class="fa fa-floppy-o"></i> Save
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>


                <form name="f1" class="f1" id="f1" action="{{ route('update_account_opening_balance') }}" method="post" autocomplete="off" onsubmit="return checkForm()">
                    @csrf

                    <input tabindex="-1" type="hidden" name="accountsval" id="jsonOutput" data-rule-required="true" data-msg-required="Please Json">
                    <div class="table-responsive" id="printTable">
                        <table class="table table-bordered table-sm" id="fixTable">

                            <thead>
                            <tr>
                                <th scope="col" class="tbl_srl_4">
                                    Sr#
                                </th>
                                <th scope="col" class="tbl_amnt_10">
                                    Account ID
                                </th>

                                @if($title !== 'Parties')

                                    <th scope="col" class="tbl_txt_10">
                                        Control Account
                                    </th>
                                    <th scope="col" class="tbl_txt_13">
                                        Group Account
                                    </th>
                                    <th scope="col" class="tbl_txt_13">
                                        Parent Account
                                    </th>

                                @elseif($title === 'Parties')

                                    <th scope="col" class="tbl_txt_10">
                                        Region
                                    </th>
                                    <th scope="col" class="tbl_txt_13">
                                        Area
                                    </th>
                                    <th scope="col" class="tbl_txt_13">
                                        Sector
                                    </th>

                                @endif


                                <th scope="col" class="tbl_txt_20">
                                    Account Name
                                </th>
                                <th scope="col" class="tbl_amnt_15">
                                    Dr.
                                </th>
                                <th scope="col" class="tbl_amnt_15">
                                    Cr.
                                </th>
                            </tr>
                            </thead>

                            <tbody id="product-data">
                            {{--                            @include('infinite_scroll.account_opening_balance_data')--}}
                            @php
                                $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                                $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                                $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                                $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            @endphp

                            @forelse($datas as $index=> $account)

                                <tr>
                                    <th scope="row">
                                        {{$sr}}
                                    </th>
                                    <td>
                                        {{$account->account_uid}}
                                    </td>

                                    @if($title !== 'Parties')

                                        <td>
                                                <?php
                                                if (substr($account->account_uid, 0, 1) == 1) {
                                                    echo 'Asset';
                                                } elseif (substr($account->account_uid, 0, 1) == 2) {
                                                    echo 'Liability';
                                                } elseif (substr($account->account_uid, 0, 1) == 3) {
                                                    echo 'Revenue';
                                                } elseif (substr($account->account_uid, 0, 1) == 4) {
                                                    echo 'Expense';
                                                } else {
                                                    echo 'Equity';
                                                }
                                                ?>
                                        </td>
                                        <td>
                                            {{$account->grp_acnt_name}}
                                        </td>
                                        <td>
                                            {{$account->parnt_acnt_name}}
                                        </td>



                                    @elseif($title === 'Parties')

                                        <td>
                                            {{$account->reg_title}}
                                        </td>
                                        <td>
                                            {{$account->area_title}}
                                        </td>
                                        <td>
                                            {{$account->sec_title}}
                                        </td>

                                    @endif

                                    <td>
                                        {{$account->account_name}}
                                    </td>

                                    @if($account->account_uid == config('global_variables.stock_in_hand'))

                                        <td class="align_right text-right">
                                            <input type="text" class="form-control inputs_up test-right dr" value="{{$total_stock}}" name="dr_balances[]" id="dr_balances{{$index}}"
                                                   data-id="{{$index}}" onkeyup="balance_calculation();" onkeypress="return allow_positive_negative_with_decimals(this,event);" onfocus="this.select();"
                                                   readonly>
                                        </td>
                                        <td class="align_right text-right edit">
                                            <input type="text" class="form-control inputs_up test-right cr" value="" name="cr_balances[]" id="cr_balances{{$index}}" data-id="{{$index}}"
                                                   onkeyup="balance_calculation();" onkeypress="return allow_positive_negative_with_decimals(this,event);" onfocus="this.select();" readonly>

                                            <input type="hidden" name="id[]" class="form-control" id="id{{$index}}" value="{{$account->account_uid}}" autocomplete="off"/>
                                            <input type="hidden" name="name[]" id="name{{$index}}" class="form-control" value="{{$account->account_name}}" autocomplete="off"/>
                                            <span id="demo{{$index}}" class="validate_sign"> </span>
                                        </td>
                                    @else
                                        <td class="align_right text-right">
                                            <input type="text" class="form-control inputs_up test-right dr" value="{{$account->tb_total_debit == 0 ?  '' : $account->tb_total_debit}}"
                                                   name="dr_balances[]" id="dr_balances{{$index}}" data-id="{{$index}}" onkeyup="balance_calculation();"
                                                   onkeypress="return allow_positive_negative_with_decimals(this,event);" onfocus="this.select();">
                                        </td>
                                        <td class="align_right text-right edit">
                                            <input type="text" class="form-control inputs_up test-right cr" value="{{$account->tb_total_credit == 0 ?  '' : $account->tb_total_credit}}"
                                                   name="cr_balances[]" id="cr_balances{{$index}}" data-id="{{$index}}" onkeyup="balance_calculation();"
                                                   onkeypress="return allow_positive_negative_with_decimals(this,event);" onfocus="this.select();">

                                            <input type="hidden" name="id[]" id="id{{$index}}" class="form-control" value="{{$account->account_uid}}" autocomplete="off"/>
                                            <input type="hidden" name="name[]" id="name{{$index}}" class="form-control" value="{{$account->account_name}}" autocomplete="off"/>
                                            <span id="demo{{$index}}" class="validate_sign"> </span>
                                        </td>

                                    @endif

                                </tr>

                                @php
                                    $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="11">
                                        <center><h3 style="color:#554F4F">No Account</h3></center>
                                    </td>
                                </tr>
                            @endforelse

                            </tbody>

                            <tfoot>
                            <tr>
                                <th colspan="6" class="align_right text-right border-0">
                                    Total:-
                                </th>
                                <td class="align_right text-right border-0" id="total_dr">
                                    <!-- {{ number_format(0,2) }} -->
                                    {{ number_format($drBalanceSum,2) }}
                                </td>
                                <td class="align_right text-right border-0" id="total_cr">
                                    <!-- {{ number_format(0,2) }} -->
                                    {{ number_format($crBalanceSum,2) }}
                                </td>
                            </tr>
                            <tr>
                                <th colspan="6" class="align_right text-right border-0">
                                    Difference:-
                                </th>

                                <td colspan="2" class="align_right text-right border-0" id="difference" style="color: red; font-size: 25px;font-weight: bold">
                                    <!-- {{ number_format(0,2) }} -->
                                    {{ number_format($crBalanceSum - $drBalanceSum,2) }}
                                </td>
                            </tr>
                            <input type="hidden" id="ttlDrInput" value="{{ $drBalanceSum }}"/>
                            <input type="hidden" id="ttlCrInput" value="{{ $crBalanceSum }}"/>
                            </tfoot>

                        </table>
                    </div>


                    <div class="form-group row">
                        <div class="col-lg-9 col-md-9 col-sm-12">

                            @if($title !== 'Parties')
                                {{--                                <span--}}
                                {{--                                    class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'first_head'=>$search_first_head, 'second_head'=>$search_second_head, 'third_head'=>$search_third_head, 'account_name'=>$search_account_name ])->links() }}</span>--}}


                                {{--                                @elseif($title === 'Parties')--}}

                                {{--                                    <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'region'=>$search_region,  'area'=>$search_area,  'sector'=>$search_sector ])->links() }}</span>--}}

                            @endif

                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 form_controls">
                            <button type="submit" name="save" id="save" class="save_button form-control">
                                <i class="fa fa-floppy-o"></i> Update
                            </button>
                            @if( $title !== "Account" )
                                <a href="{{route('view_account_opening_balance')}}" class="save_button form-control">
                                    Continue To Process
                                </a>
                            @endif
                            <span id="validate_msg" class="validate_sign"></span>
                            <input type="hidden" name="title" id="title" value="{{$title}}">
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
    <script src="{{ asset('public/plugins/nabeel_blue/jquery.floatThead.js') }}"></script>
    <script type="text/javascript">
        function checkForm() {

            jQuery("#jsonOutput").val('');
            const jsonData = {};
            $('input[name="id[]"]').each(function (pro_index) {
                var id = $(this).val();

                var dr_balances = $('#dr_balances' + pro_index).val();
                var cr_balances = $('#cr_balances' + pro_index).val();
                var id = $('#id' + pro_index).val();
                var name = $('#name' + pro_index).val();

                jsonData[pro_index] = {
                    'dr_balances': dr_balances,
                    'cr_balances': cr_balances,
                    'name': name,
                    'id': id,
                };
            });
            jQuery("#jsonOutput").val(JSON.stringify(jsonData));
            let month = document.getElementById("total")
                , validateInputIdArray = [
                month.id
                ,];
            let check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{--    infinite scrol script start--}}
    <script>
        function loadMoreData(page) {
            var search = $('#search').val();
            $.ajax({
                url: '?page=' + page,
                type: 'get',
                data: {search: search},
                beforeSend: function () {
                    $('.ajax-load').show();
                }
            })
                .done(function (data) {
                    console.log(data);
                    if (data.html == " ") {
                        let loadMSG = `<p> No More Records Found</p>`;
                        $('.ajax-load').html(loadMSG);
                        return;
                    }
                    $('.ajax-load').hide();
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
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route($route) }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        function balance_calculation() {
            var dr = 0,
                cr = 0,
                ttlDr = 0,
                ttlCr = 0,
                diff = 0,
                ttlDrVal = $("#ttlDrInput").val(),
                ttlCrVal = $("#ttlCrInput").val();

            $(".dr").each(function () {
                dr += +$(this).val();
            });

            $(".cr").each(function () {
                cr += +$(this).val();
            });
            diff = cr - dr;
            // ttlDr = parseFloat( ttlDrVal ) + dr;
            // ttlCr = parseFloat( ttlCrVal ) + cr;

            $('#total_dr').text("")
            $('#total_cr').text("")
            $('#total_dr').text(dr.toFixed(2));
            $('#total_cr').text(cr.toFixed(2));
            $('#difference').text(diff.toFixed(2));
            // $('#total_cr').text(ttlCr.toFixed(2));
        }

        $(document).on('keyup', '.dr', function (event) {

            var keyCode = event.keyCode || event.which;

            if ((keyCode >= 96 && keyCode <= 105) || (keyCode >= 48 && keyCode <= 57) || keyCode == 109 || keyCode == 110 || keyCode == 189) {
                var valueField = $(this).attr('data-id');
                $('#cr_balances' + valueField).val('');
            }
        });

        $(document).on('keyup', '.cr', function (event) {
            var keyCode = event.keyCode || event.which;

            if ((keyCode >= 96 && keyCode <= 105) || (keyCode >= 48 && keyCode <= 57) || keyCode == 109 || keyCode == 110 || keyCode == 189) {

                var valueField = $(this).attr('data-id');
                $('#dr_balances' + valueField).val('');
            }
        });

        // balance_calculation();

    </script>
    <script>
        $('.save_button').click(function () {
            jQuery(".pre-loader").fadeToggle("medium");
        });
    </script>
    <script>
        jQuery(document).ready(function () {
            $('table').floatThead({
                position: 'absolute'
            });

            // Initialize select2
            jQuery("#first_head").select2();
            jQuery("#second_head").select2();
            jQuery("#third_head").select2();
            jQuery("#account_name").select2();
            jQuery("#region").select2();
            jQuery("#area").select2();
            jQuery("#sector").select2();
        });
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#first_head").select2().val(null).trigger("change");
            $("#first_head > option").removeAttr('selected');

            $("#second_head").select2().val(null).trigger("change");
            $("#second_head > option").removeAttr('selected');

            $("#third_head").select2().val(null).trigger("change");
            $("#third_head > option").removeAttr('selected');

            $("#account_name").select2().val(null).trigger("change");
            $("#account_name > option").removeAttr('selected');

            $("#region").select2().val(null).trigger("change");
            $("#region > option").removeAttr('selected');

            $("#area").select2().val(null).trigger("change");
            $("#area > option").removeAttr('selected');

            $("#sector").select2().val(null).trigger("change");
            $("#sector > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>
    <script>
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

