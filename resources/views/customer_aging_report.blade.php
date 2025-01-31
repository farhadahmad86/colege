@extends('extend_index')

@section('content')

    <style>
        .table thead th {
            vertical-align: middle;
        }

        .rborder {
            border-right: 5px double black !important;
        }

        .table thead th {
            background-color: rgb(222 222 222);
            color: #000;
        }

    </style>


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="printTable">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white file_name get-heading-text"> Customer Aging Report </h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

            <!-- <div class="search_form {{ ( !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('customer_aging_report') }}" name="form1" id="f1" method="post" class="accountLedger w-80p d-inline" autocomplete="off">
                        @csrf

                        <div class="row">

                            <div class="end form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">From :</label>
                                    <input tabindex="1" autofocus type="text" name="from" id="from" class="inputs_up form-control date-picker" <?php if(isset($search_from)){?> value="{{$search_from}}"
                                           <?php } ?> placeholder="From..." data-rule-required="true" data-msg-required="Please Select From Date"/>
                                    <span id="demo2" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>

                            <div class="start form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">To :</label>
                                    <input tabindex="2" type="text" name="to" id="to" class="inputs_up form-control date-picker" <?php if(isset($search_to)){?> value="{{$search_to}}"
                                           <?php } ?> placeholder="To..." data-rule-required="true" data-msg-required="Please Select Date To"/>
                                    <span id="demo1" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>

                            <div class="start form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>Account Title :</label>
                                    <select tabindex="3" class="inputs_up form-control cstm_clm_srch" name="account_id_aging" id="account_id_aging">
                                        <option value="">Select Account</option>
                                        <option value="All" {{ "All" == $search_account_id ? 'selected="selected"' : '' }}>All</option>
                                        @foreach($account_lists as $account_list)
                                            <option value="{{$account_list->account_uid}}" {{ $account_list->account_uid == $search_account_id ? 'selected="selected"' : '' }}>
                                                {{--                                                        <option value="{{$account_list->account_uid}}">--}}
                                                {{$account_list->account_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div><!-- end input box -->
                            </div>

                            <div class="start form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>Sale Person:</label>

                                    <select tabindex="4" name="sale_person" id="sale_person" class="inputs_up form-control">
                                        <option value="">Select Sale Person</option>
                                        @foreach($sale_persons as $sale_person)
                                            <option
                                                value="{{$sale_person->user_id}}" {{ $sale_person->user_id == $search_sale_person ? 'selected="selected"' : '' }}>{{$sale_person->user_name}}</option>
                                        @endforeach
                                    </select>
                                </div><!-- end input box -->
                            </div>

                            <input value="{{$search_account_name}}" name="account_name_aging" id="account_name_aging" type="hidden">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Select Region
                                    </label>
                                    <select tabindex="5" class="inputs_up form-control cstm_clm_srch" name="region" id="region">
                                        <option value="">Select Region</option>
                                        @foreach($regions as $region)
                                            <option value="{{$region->reg_id}}" {{ $region->reg_id == $search_region ? 'selected="selected"' : '' }}>{{$region->reg_title}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Select Area
                                    </label>
                                    <select tabindex="6" class="inputs_up form-control cstm_clm_srch" name="area" id="area">
                                        <option value="">Select Area</option>
                                        @foreach($areas as $area)
                                            <option value="{{$area->area_id}}" {{ $area->area_id == $search_area ? 'selected="selected"' : '' }}>{{$area->area_title}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Select Sector
                                    </label>
                                    <select tabindex="7" class="inputs_up form-control cstm_clm_srch" name="sector" id="sector">
                                        <option value="">Select Sector</option>
                                        @foreach($sectors as $sector)
                                            <option value="{{$sector->sec_id}}" {{ $sector->sec_id == $search_sector ? 'selected="selected"' : '' }}>{{$sector->sec_title}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 mt-lg-4 text-right">
                            @include('include.clear_search_button')
                                @include('include/print_button')
                            </div>


                        </div>
                    </form>


                    <form name="ledger" id="ledger" action="{{ route('account_ledger') }}" method="post" target="_blank">
                        @csrf
                        <input name="account_id" id="account_id" type="hidden">
                        <input name="account_name" id="account_name" type="hidden">

                    </form>
                </div><!-- search form end -->


                <div class="table-responsive" id="">
                    <table class="table table-bordered table-sm" id="">

                        <thead>
                        <tr>
                            <th tabindex="-1" scope="col" class="tbl_srl_7">
                                Account Code
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_srl_4">
                                ID
                            </th>
                            <th scope="col" class="tbl_srl_9">
                                Account Title
                            </th>
                            <th scope="col" class="tbl_srl_7">
                                Opening Balance
                            </th>
                            <th scope="col" class="tbl_srl_8">
                                Total Inwards
                            </th>
                            <th scope="col" class="tbl_srl_8">
                                Total Outwards
                            </th>
                            <th scope="col" class="tbl_srl_8 rborder">
                                Ledger Balance Of Customer
                            </th>
                            <th scope="col" class="tbl_srl_7">
                                Last Inward Transaction Date
                            </th>
                            <th scope="col" class="tbl_srl_5">
                                Inward Not Received Since Last Days
                            </th>
                            <th scope="col" class="tbl_srl_7">
                                Last Inward Transaction Type
                            </th>
                            <th scope="col" class="tbl_srl_9 rborder">
                                Last Inward Transaction Amount
                            </th>
                            <th scope="col" class="tbl_srl_7">
                                Last Outward Transaction Date
                            </th>
                            <th scope="col" class="tbl_srl_5">
                                Outward Not Execute Since Last Days
                            </th>
                            <th scope="col" class="tbl_srl_7">
                                Last Outward Transaction Type
                            </th>
                            <th scope="col" class="tbl_srl_9">
                                Last Outward Transaction Amount
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
                        @forelse($datas as $ledger)

                            <tr>
                                <th scope="row">
                                    {{$ledger->account_uid}}
                                </th>
                                <td>
                                    {{$ledger->account_uid}}
                                </td>
                                <td>
                                    <a data-id="{{$ledger->account_uid}}" data-name="{{$ledger->account_name}}" class="tbl_links ledger">
                                        {{$ledger->account_name}}
                                    </a>
                                </td>
                                <td align="right" class="align_right text-right">
                                    {{$ledger->opening_balance !=0 ? number_format($ledger->opening_balance,2):''}}
                                </td>
                                <td align="right" class="align_right text-right">
                                    {{$ledger->total_inwards !=0 ? number_format($ledger->total_inwards,2):''}}
                                </td>
                                <td align="right" class="align_right text-right">
                                    {{$ledger->total_outwards !=0 ? number_format($ledger->total_outwards,2):''}}
                                </td>
                                <td align="right" class="align_right text-right rborder">
                                    {{$ledger->ledger_balance_of_customer !=0 ? number_format($ledger->ledger_balance_of_customer,2):''}}
                                </td>
                                <td>
                                    {{ (isset($ledger->last_inward_transaction_date) && !empty($ledger->last_inward_transaction_date) ) ? date('d-M-y', strtotime(str_replace('/', '-', $ledger->last_inward_transaction_date))) : "" }}
                                </td>
                                <td>
                                    {{ $ledger->inward_not_received_last_days }}
                                </td>
                                <td>
                                    {{ str_replace("_", " ", $ledger->last_inward_transaction_type) }}
                                </td>
                                <td align="right" class="align_right text-right rborder">
                                    {{$ledger->last_inward_transaction_amount !=0 ? number_format($ledger->last_inward_transaction_amount,2):''}}
                                </td>
                                <td>
                                    {{(isset($ledger->last_outward_transaction_date) && !empty($ledger->last_outward_transaction_date) ) ? date('d-M-y', strtotime(str_replace('/', '-', $ledger->last_outward_transaction_date))) : "" }}
                                </td>
                                <td>
                                    {{ $ledger->outward_not_received_last_days }}
                                </td>
                                <td>
                                    {{ str_replace("_", " ", $ledger->last_outward_transaction_type) }}
                                </td>
                                <td align="right" class="align_right text-right">
                                    {{$ledger->last_outward_transaction_amount !=0 ? number_format($ledger->last_outward_transaction_amount,2):''}}
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="17">
                                    <h3 style="color:#554F4F" class="text-center">No Ledger</h3>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>


                    </table>


                </div>
                <span
                    class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'account_id'=>$search_account_id, 'from'=>$search_from, 'to'=>$search_to, 'account_name'=>$search_account_name, 'region'=>$search_region, 'area'=>$search_area, 'sector'=>$search_sector, 'sale_person'=>$search_sale_person ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="purchase_modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="width: 1250px; margin-left: -220px;">
                <div class="modal-header">
                    <h4 class="modal-title text-blue">Items Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" style="width:50px; text-align: center !important">Pro #</th>
                                <th scope="col" style="width:80px; text-align: center !important">Pro-Name</th>
                                <th scope="col" style="width:50px; text-align: center !important">Qty</th>
                                <th scope="col" style="width:80px; text-align: center !important">Rate</th>
                                <th scope="col" style="width:80px; text-align: center !important">Discount</th>
                                <th scope="col" style="width:80px; text-align: center !important">Sale Tax</th>
                                <th scope="col" style="width:80px; text-align: center !important">Amount</th>
                                <th scope="col" style="width:80px; text-align: center !important">G.Rate</th>
                                <th scope="col" style="width:80px; text-align: center !important">Expense per Pro.</th>
                                <th scope="col" style="width:80px; text-align: center !important">Net Rate</th>
                                <th scope="col" style="width:80px; text-align: center !important">Remarks</th>
                            </tr>
                            </thead>
                            <tbody id="table_body1">

                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-6 col-md-6"></div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-blue table-header">Items Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive table-values">
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-6 col-md-6"></div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script src="{{ asset('public/plugins/nabeel_blue/jquery.floatThead.js') }}"></script>

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('customer_aging_report') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery(".view").click(function () {

            var transcation_id = jQuery(this).attr("data-transcation_id");

            jQuery(".table-header").html("");
            jQuery(".table-values").html("");

            $(".modal-body").load('{{ url('/transaction_view_details_SH/') }}/' + transcation_id, function () {
                $('#myModal').modal({show: true});
            });
        });

    </script>


    <script>

        jQuery("#account_id").change(function () {
            var account_name = jQuery("#account_id option:selected").text();
            jQuery("#account_name").val(account_name);
        });

        jQuery(document).ready(function () {
            // Initialize select2

            $('table').floatThead({
                position: 'absolute'
            });

            jQuery("#account_id_aging").select2();
            jQuery("#sale_person").select2();
            jQuery("#region").select2();
            jQuery("#area").select2();
            jQuery("#sector").select2();
        });

    </script>

    <script>

        jQuery(".ledger").click(function () {

            var account_id = jQuery(this).attr("data-id");
            var account_name = jQuery(this).attr("data-name");

            jQuery("#account_id").val(account_id);
            jQuery("#account_name").val(account_name);
            jQuery("#ledger").submit();
        });


        jQuery("#cancel").click(function () {

            $("#account_id").select2().val(null).trigger("change");
            $("#account_id > option").removeAttr('selected');

            $("#invoice_type").select2().val(null).trigger("change");
            $("#invoice_type > option").removeAttr('selected');

        });
    </script>

@endsection

