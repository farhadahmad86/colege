@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white file_name get-heading-text">Capital Registration List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                {{--                <div class="search_form  {{ ( !empty($search) || !empty($search_first_head) || !empty($search_group) ) ? '' : 'search_form_hidden' }}">--}}
                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('capital_registration_list') }}" name="form1" id="form1" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <datalist id="browsers">
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Group Account
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="second_head" id="second_head">
                                        <option value="">Select Second Head</option>
                                        @foreach($equity_second_accounts as $equity_second_account)
                                            <option value="{{$equity_second_account->coa_code}}" {{ $equity_second_account->coa_code == $search_second_head ? 'selected="selected"' : '' }}>
                                                {{$equity_second_account->coa_head_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Parent Account
                                    </label>
                                    <select tabindex="3" class="inputs_up form-control cstm_clm_srch" name="third_head" id="third_head">
                                        <option value="">Select Third Head</option>
                                        @foreach($equity_third_accounts as $equity_third_account)
                                            <option value="{{$equity_third_account->coa_code}}" {{ $equity_third_account->coa_code == $search_third_head ? 'selected="selected"' : '' }}>
                                                {{$equity_third_account->coa_head_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form_controls text-right mt-4">
                                @include('include.clear_search_button')
                                <!-- Call add button component -->
                                    <x-add-button tabindex="9" href="{{ route('capital_registration') }}"/>

                                @include('include/print_button')

                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>


                        </div>
                    </form>
                </div><!-- search form end -->

                <form name="edit" id="edit" action="{{ route('edit_capital_registration') }}" method="post">
                    @csrf
                    <input name="capital_registration" id="capital_registration" type="hidden">
                </form>

                <div class="table-responsive" id="printTable">

                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th tabindex="-1" scope="col" class="tbl_srl_4">
                                Sr#
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_srl_4">
                                ID
                            </th>
                            <th scope="col" class="tbl_txt_13">
                                Group Account
                            </th>
                            <th scope="col" class="tbl_txt_13">
                                Parent Account
                            </th>
                            <th scope="col" class="tbl_txt_15">
                                Name
                            </th>
                            <th scope="col" class="tbl_txt_6">
                                Nature
                            </th>
                            <th scope="col" class="tbl_amnt_11">
                                Initial Capital
                            </th>
                            <th scope="col" class="tbl_amnt_8">
                                System Calculated
                            </th>
                            <th scope="col" class="tbl_amnt_8">
                                Fixed Profit Ratio
                            </th>
                            <th scope="col" class="tbl_amnt_8">
                                Fixed Loss Ratio
                            </th>
                            <th scope="col" class="tbl_txt_10">
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
                        @forelse($datas as $index=> $account)


                            <tr data-cr_id="{{ $account->cr_id }}">

                                <th scope="row" class="edit ">
                                    {{$sr}}
                                </th>
                                <td class="edit ">
                                    {{$account->cr_id}}
                                </td>
                                <td class="edit ">
                                    {{ $account->grp_acnt_name }}
                                </td>
                                <td class="edit ">
                                    {{$account->prnt_acnt_name}}
                                </td>
                                <td class="edit ">
                                    {{$account->cr_username}}
                                </td>
                                <td class="edit ">
                                    {{ ($account->cr_partner_nature === 1) ? 'Acting' : 'Sleeping' }}
                                </td>
                                <td class="edit text-right ">
                                    {{ number_format($account->cr_initial_capital,2) }}
                                </td>
                                <td class=" edit">
                                    {{ number_format($account->cr_system_ratio,2) }}%
                                </td>
                                <td class=" edit">
                                    {{ number_format($account->cr_fixed_profit_per,2) }}%
                                </td>
                                <td class=" edit ">
                                    {{ number_format($account->cr_fixed_loss_per,2) }}%
                                </td>

                                @php
                                    $ip_browser_info= ''.$account->cr_ip_adrs.','.str_replace(' ','-',$account->cr_brwsr_info).'';
                                @endphp

                                <td class="align_left usr_prfl text-left " data-usr_prfl="{{ $account->user_id }}" data-user_info="{!! $ip_browser_info !!}"
                                    title="Click To See User Detail">
                                    {{ $account->user_name }}
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

                    </table>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                    </div>
                    <div class="col-md-9 text-right">
                        <span
                            class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'second_head'=>$search_second_head, 'head_code'=>$search_third_head ])->links() }}</span>
                    </div>
                </div>
                {{--                <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg ])->links() }}</span>--}}
            </div> <!-- white column form ends here -->

        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('capital_registration_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    <script>
        jQuery(".edit").click(function () {
            var cr_id = jQuery(this).parent('tr').attr("data-cr_id");

            jQuery("#capital_registration").val(cr_id);
            jQuery("#edit").submit();
        });

        jQuery("#cancel").click(function () {

            $("#second_head").select2().val(null).trigger("change");
            $("#second_head > option").removeAttr('selected');

            $("#third_head").select2().val(null).trigger("change");
            $("#third_head > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#second_head").select2();
            jQuery("#third_head").select2();
        });
    </script>

@endsection

