@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Supplier List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <div class="search_form m-0 p-0 {{ ( !empty($search) || !empty($search_region) || !empty($search_area) || !empty($search_sector) || !empty($search_group) ) ? '' : '' }}">
                    <form class="highlight prnt_lst_frm" action="{{ route('account_payable_list') }}" name="form1" id="form1" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}"
                                           autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach($account_list as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Select Region
                                    </label>
                                    {{--                                                        <div class="input-group">--}}
                                    <select class="inputs_up form-control cstm_clm_srch" name="region" id="region" style="width: 90%">
                                        <option value="">Select Region</option>
                                        @foreach($regions as $region)
                                            <option value="{{$region->reg_id}}" {{ $region->reg_id == $search_region ? 'selected="selected"' : '' }}>{{$region->reg_title}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                    {{--                                                        </div>--}}
                                </div>
                            </div>

                            
                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            {{--                                                        <div class="input-group">--}}
                                            <label class="required">
                                                Select Area
                                            </label>
                                            <select class="inputs_up form-control cstm_clm_srch" name="area" id="area" style="width: 90%">
                                                <option value="">Select Area</option>
                                                @foreach($areas as $area)
                                                    <option value="{{$area->area_id}}" {{ $area->area_id == $search_area ? 'selected="selected"' : '' }}>{{$area->area_title}}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                            {{--                                                        </div>--}}
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            {{--                                                        <div class="input-group">--}}
                                            <label class="required">
                                                Select Sector
                                            </label>
                                            <select class="inputs_up form-control cstm_clm_srch" name="sector" id="sector" style="width: 90%">
                                                <option value="">Select Sector</option>
                                                @foreach($sectors as $sector)
                                                    <option value="{{$sector->sec_id}}" {{ $sector->sec_id == $search_sector ? 'selected="selected"' : '' }}>{{$sector->sec_title}}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                            {{--                                                        </div>--}}
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            {{--                                                        <div class="input-group">--}}
                                            <label class="required">
                                                Select Reporting Group
                                            </label>
                                            <select class="inputs_up form-control cstm_clm_srch" name="group" id="group" style="width: 90%">
                                                <option value="">Select Reporting Group</option>
                                                @foreach($groups as $group)
                                                    <option value="{{$group->ag_id}}" {{ $group->ag_id == $search_group ? 'selected="selected"' : '' }}>{{$group->ag_title}}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                            {{--                                                        </div>--}}
                                        </div>
                                    </div>
<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 mt-lg-4 text-right">
                            @include('include.clear_search_button')

                                @include('include/print_button')

                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                    </form>

                    <form name="ledger" id="ledger" action="{{ route('account_ledger') }}" method="post" target="_blank">
                        @csrf
                        <input name="account_id" id="account_id" type="hidden">
                        <input name="account_name" id="account_name" type="hidden">
                    </form>

                </div><!-- search form end -->

                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">
                                Sr#
                            </th>
                            <th scope="col" class="tbl_txt_6">
                                Head
                            </th>
                            <th scope="col" class="tbl_amnt_9">
                                Id
                            </th>
                            <th scope="col" class="tbl_txt_13">
                                Region
                            </th>
                            <th scope="col" class="tbl_txt_13">
                                Area
                            </th>
                            <th scope="col" class="tbl_txt_13">
                                Sector
                            </th>
                            <th scope="col" class="tbl_txt_15">
                                Name
                            </th>
                            <th scope="col" class="tbl_amnt_11">
                                Balance
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Account View Group
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            $ttlPrc = 0;
                        @endphp
                        @forelse($datas as $index=> $account)

                            <tr>
                                <th scope="row" class="edit">
                                    {{$sr}}
                                </th>
                                <td class="align_left text-left tbl_txt_6">
                                    <?php if (substr($account->account_uid, 0, 1) == 1) {
                                        echo 'Asset';
                                    } elseif (substr($account->account_uid, 0, 1) == 2) {
                                        echo 'Liability';
                                    } elseif (substr($account->account_uid, 0, 1) == 3) {
                                        echo 'Revenue';
                                    } elseif (substr($account->account_uid, 0, 1) == 4) {
                                        echo 'Expense';
                                    } else {
                                        echo 'Equity';
                                    } ?>
                                </td>
                                <td>
                                    {{$account->account_uid}}
                                </td>
                                <td>
                                    {{$account->reg_title}}
                                </td>
                                <td>
                                    {{$account->area_title}}
                                </td>
                                <td>
                                    {{$account->sec_title}}
                                </td>
                                <td>
                                    <a data-id="{{$account->account_uid}}" data-name="{{$account->account_name}}" class="ledger">
                                        {{$account->account_name}}
                                    </a>
                                </td>
                                @php
                                    $ttlPrc = +($balance[$index]) + +$ttlPrc;
                                @endphp
                                <td class="align_right text-right">
                                    {{$balance[$index]!=0 ? number_format($balance[$index],2):''}}
                                </td>
                                @php
                                    $ip_browser_info= ''.$account->account_ip_adrs.','.str_replace(' ','-',$account->account_brwsr_info).'';
                                @endphp
                                <td class="usr_prfl " data-usr_prfl="{{ $account->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $account->user_name }}
                                </td>
                                <td class="edit ">
                                    {{$account->ag_title}}
                                </td>
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
                            <th colspan="7" class="align_right text-right border-0">
                                Page Total:-
                            </th>
                            <td class="align_right text-right border-0">
                                {{ number_format($ttlPrc,2) }}
                            </td>
                        </tr>
                        </tfoot>

                    </table>

                </div>
                <span
                    class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'region'=>$search_region, 'area'=>$search_area, 'sector'=>$search_sector, 'group'=>$search_group ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('account_payable_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery("#cancel").click(function () {

            $("#region").select2().val(null).trigger("change");
            $("#region > option").removeAttr('selected');

            $("#area").select2().val(null).trigger("change");
            $("#area > option").removeAttr('selected');

            $("#sector").select2().val(null).trigger("change");
            $("#sector > option").removeAttr('selected');

            $("#group").select2().val(null).trigger("change");
            $("#group > option").removeAttr('selected');

            $("#search").val('');

            $("#to").val('');
            $("#from").val('');
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

    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#region").select2();
            jQuery("#area").select2();
            jQuery("#sector").select2();
            jQuery("#group").select2();
        });
    </script>

@endsection

