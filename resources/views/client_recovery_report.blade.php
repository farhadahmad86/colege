@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text">Client Recovery Report</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm" action="{{ route('client_recovery_report')}}" name="form1"
                      id="form1" method="post">
                    {{--                                    onsubmit="return validate_form()"--}}
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label>
                                    Select Region
                                </label>
                                <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="region" id="region" style="width: 90%">
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
                                <label class="required">
                                    Select Area
                                </label>
                                <select tabindex="3" class="inputs_up form-control cstm_clm_srch" name="area" id="area" style="width: 90%">
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
                                <label class="required">
                                    Select Sector
                                </label>
                                <select tabindex="4" class="inputs_up form-control cstm_clm_srch" name="sector" id="sector" style="width: 90%">
                                    <option value="">Select Sector</option>
                                    @foreach($sectors as $sector)
                                        <option value="{{$sector->sec_id}}" {{ $sector->sec_id == $search_sector ? 'selected="selected"' : '' }}>{{$sector->sec_title}}</option>
                                    @endforeach
                                </select>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label class="required">
                                    Select Town
                                </label>
                                <select tabindex="4" class="inputs_up form-control cstm_clm_srch" name="town" id="town" style="width: 90%">
                                    <option value="">Select Town</option>
                                    @foreach($towns as $town)
                                        <option value="{{$town->town_id}}" {{ $town->town_id == $search_town ? 'selected="selected"' : '' }}>{{$town->town_title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label class="required">
                                    Select Sale Person
                                </label>
                                <select tabindex="5" class="inputs_up form-control cstm_clm_srch" name="sale_person" id="sale_person" style="width: 90%">
                                    <option value="">Select Sale Person</option>
                                    @foreach($sale_persons as $sale_person)
                                        <option
                                            value="{{$sale_person->user_id}}" {{ $sale_person->user_id == $search_sale_persons ? 'selected="selected"' : '' }}>{{$sale_person->user_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label>
                                    Start Date
                                </label>
                                <input tabindex="6" type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off"
                                       <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="Start Date ......"/>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label>
                                    End Date
                                </label>
                                <input tabindex="6" type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
                                       <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="End Date ......"/>
                            </div>
                        </div>
                        <x-year-end-component search="{{$search_year}}"/>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                            @include('include.clear_search_button')
                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                <form class="hidden" action="{{ route('account_receivable_payable_list') }}" name="form" id="form" method="post">
                    @csrf
                    <fieldset>
                        <legend>Get All Data:</legend>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <button tabindex="-1" type="submit" name="save" id="save" class="save_button form-control m-0 fl_srch_btn">
                                    <i class="fa fa-search"></i> All Data
                                </button>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div> <!-- right columns ends here -->
                    </fieldset>
                </form>
            </div>

            <div class="table-responsive" id="printTable">

                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                    <tr>
                        <th scope="col" class="tbl_srl_4">
                            Sr#
                        </th>
                        <th scope="col" class="tbl_amnt_9">
                            Account
                        </th>
                        <th scope="col" class="tbl_txt_10">
                            Region
                        </th>
                        <th scope="col" class="tbl_txt_10">
                            Area
                        </th>
                        <th scope="col" class="tbl_txt_10">
                            Sector
                        </th>
                        <th scope="col" class="tbl_txt_10">
                            Town
                        </th>
                        <th scope="col" class="tbl_txt_10">
                            Name
                        </th>
                        <th scope="col" class="tbl_txt_10">
                            Sale Man
                        </th>
                        <th scope="col" class="tbl_amnt_9">
                            Balance
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                        $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                        $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                        $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                        $per_page_ttl_amnt = 0;

                    @endphp
                    @forelse($datas as $index=> $account)
                        @php $per_page_ttl_amnt = +$balance[$index] + +$per_page_ttl_amnt; @endphp
                        @if($account->account_type==0)
                        @elseif($account->account_type==1)
                            <tr data-id="{{$account->account_id}}" data-account_type="Receivable">
                        @else
                            <tr data-id="{{$account->account_id}}" data-account_type="Payable">
                                @endif
                                @php
                                    $rcv_pay = ($account->account_type == 1 || $account->account_type == 0) ? 'receivable' : 'payable';
                                @endphp
                                <th scope="row" class="edit {{ $rcv_pay }}">
                                    {{$sr}}
                                </th>
                                <td class="{{ $rcv_pay }}">
                                    {{$account->account_uid}}
                                </td>
                                <td class="{{ $rcv_pay }}">
                                    {{$account->reg_title}}
                                </td>
                                <td class="{{ $rcv_pay }}">
                                    {{$account->area_title}}
                                </td>
                                <td class="{{ $rcv_pay }}">
                                    {{$account->sec_title}}
                                </td>
                                <td class="{{ $rcv_pay }}">
                                    {{$account->town_title}}
                                </td>
                                <td>
                                    <a data-id="{{$account->account_uid}}" data-name="{{$account->account_name}}" class="tbl_links ledger">
                                        {{$account->account_name}}
                                    </a>
                                </td>
                                <td>{{$account->user_name}}</td>

                                <td class="align_right text-right {{ $rcv_pay }}">
                                    {{$balance[$index]!=0 ? number_format($balance[$index],2):0}}
                                </td>

                                {{--                                <td class="align_right text-right {{ $rcv_pay }}">--}}
                                {{--                                    {{$balance_date_array[$index]}}--}}
                                {{--                                </td>--}}
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
                    <tr class="border-0">
                        <th colspan="8" align="right" class="border-0 text-right align_right pt-0">
                            Per Page Total:
                        </th>
                        <td class="text-right border-left-0" align="right"
                            style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                            {{ number_format($per_page_ttl_amnt, 2) }}
                        </td>
                    </tr>
                    <tr class="border-0">
                        <th colspan="8" align="right" class="border-0 text-right align_right pt-0">
                            Grand Total:
                        </th>
                        <td class="text-right border-left-0" align="right"
                            style="border-bottom: 2px solid #000;border-bottom: 3px double #000;border-right: 0 solid transparent;">
                            {{ number_format($ttl_amnt, 2) }}
                        </td>
                    </tr>
                    </tfoot>
                </table>

            </div>
            <div class="row">
                <div class="col-md-3">
                    <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                </div>
                <div class="col-md-9 text-right"><span
                        class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'region'=>$search_region,  'area'=>$search_area, 'sector'=>$search_sector, 'town'=>$search_town,
                        'sale_person'=>$search_sale_persons, 'from'=>$search_from, 'to'=>$search_to ])->links() }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('account_receivable_payable_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery(".ledger").click(function () {

            var account_id = jQuery(this).attr("data-id");
            var account_name = jQuery(this).attr("data-name");

            jQuery("#account_id").val(account_id);
            jQuery("#account_name").val(account_name);
            jQuery("#ledger").submit();
        });

        // jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);

        jQuery("#cancel").click(function () {

            $("#region").select2().val(null).trigger("change");
            $("#region > option").removeAttr('selected');

            $("#area").select2().val(null).trigger("change");
            $("#area > option").removeAttr('selected');

            $("#sector").select2().val(null).trigger("change");
            $("#sector > option").removeAttr('selected');

            $("#town").select2().val(null).trigger("change");
            $("#town > option").removeAttr('selected');

            $("#group").select2().val(null).trigger("change");
            $("#group > option").removeAttr('selected');

            $("#sale_person").select2().val(null).trigger("change");
            $("#sale_person > option").removeAttr('selected');

            $("#search").val('');
            $("#from").val('');
            $("#to").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#region").select2();
            jQuery("#area").select2();
            jQuery("#sector").select2();
            jQuery("#town").select2();
            jQuery("#sale_person").select2();
        });
    </script>

@endsection

