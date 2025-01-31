@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">View {{$title}} Opening Balance</h4>
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

                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            @if($title !== 'Parties')


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
                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
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
                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
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
                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
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
                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
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



                            @elseif($title === 'Parties')

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

                            @endif


                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 form_controls text-right">

                                @include('include.clear_search_button')

                                @include('include/print_button')

                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                            </div>
                        </div><!-- end row -->
                    </form>
                </div><!-- search form end -->


                <form name="f1" class="f1" id="f1" action="{{ route('submit_account_opening_balance') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="table-responsive" id="printTable">
                        <table class="table table-bordered table-sm" id="fixTable">

                            <thead>
                            <tr>
                                <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                                    Sr#
                                </th>
                                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                                    Account ID
                                </th>

                                @if($title !== 'Parties')

                                    <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                                        Control Account
                                    </th>
                                    <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                                        Group Account
                                    </th>
                                    <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                                        Parent Account
                                    </th>

                                @elseif($title === 'Parties')

                                    <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                                        Region
                                    </th>
                                    <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                                        Area
                                    </th>
                                    <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                                        Sector
                                    </th>

                                @endif


                                <th scope="col" align="center" class="text-center align_center tbl_txt_20">
                                    Account Name
                                </th>
                                <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                                    Dr.
                                </th>
                                <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                                    Cr.
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @php
                                $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                                $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                                $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                                $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;

                            $total_dr = 0;
                            $total_cr = 0;
                            @endphp

                            @forelse($datas as $index=> $account)

                                @php
                                    $total_dr += $account->tb_total_debit;
                                    $total_cr += $account->tb_total_credit;
                                @endphp

                                <tr>
                                    <td class="align_center text-center tbl_srl_4">
                                        {{$sr}}
                                    </td>
                                    <td class="align_center text-center tbl_amnt_10">
                                        {{$account->account_uid}}
                                    </td>

                                    @if($title !== 'Parties')

                                        <td class="text-left align_left tbl_txt_10">
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
                                        <td class="text-left align_left tbl_txt_13">
                                            {{$account->grp_acnt_name}}
                                        </td>
                                        <td class="text-left align_left tbl_txt_13">
                                            {{$account->parnt_acnt_name}}
                                        </td>



                                    @elseif($title === 'Parties')

                                        <td class="align_left text-left tbl_txt_10">
                                            {{$account->reg_title}}
                                        </td>
                                        <td class="align_left text-left tbl_txt_13">
                                            {{$account->area_title}}
                                        </td>
                                        <td class="align_left text-left tbl_txt_13">
                                            {{$account->sec_title}}
                                        </td>

                                    @endif

                                    <td class="align_left text-left tbl_txt_20">
                                        {{$account->account_name}}
                                    </td>
                                    <td class="align_right text-right tbl_amnt_15">
                                        {{$account->tb_total_debit == 0 ?  '' : $account->tb_total_debit}}
                                    </td>
                                    <td class="align_right text-right edit tbl_amnt_15">
                                        {{$account->tb_total_credit == 0 ?  '' : $account->tb_total_credit}}

                                        <input type="hidden" name="id[]" class="form-control" value="{{$account->account_uid}}" autocomplete="off"/>
                                        <input type="hidden" name="name[]" class="form-control" value="{{$account->account_name}}" autocomplete="off"/>
                                        <span id="demo{{$index}}" class="validate_sign"> </span>
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
                                <th colspan="6" class="align_right text-right border-0">
                                    Total:-
                                </th>
                                <td class="align_right text-right border-0" id="total_dr">
                                    {{ number_format($total_dr,2) }}
                                </td>
                                <td class="align_right text-right border-0" id="total_cr">
                                    {{ number_format($total_cr,2) }}
                                </td>
                            </tr>
                            </tfoot>

                        </table>
                    </div>


                    <div class="form-group row">
                        <div class="col-lg-9 col-md-9 col-sm-12">

                            @if($title !== 'Parties')
                                <span
                                    class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'first_head'=>$search_first_head, 'second_head'=>$search_second_head, 'third_head'=>$search_third_head, 'account_name'=>$search_account_name ])->links() }}</span>
                            @endif

                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 form_controls">
                            <button type="submit" name="save" id="save" class="save_button form-control">
                                <i class="fa fa-floppy-o"></i> Start Processing
                            </button>
                            <span id="validate_msg" class="validate_sign"></span>
                            <input type="hidden" name="title" id="title" value="{{$title}}">
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
        var base = '{{ route($route) }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}
    <script>
        $("#save").click(function () {
            jQuery(".pre-loader").fadeToggle("medium");
        });
    </script>

    <script>
        jQuery(document).ready(function () {
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

@endsection

