@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white file_name get-heading-text">Fixed Asset List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
            <!-- <div class="search_form  {{ ( !empty($search) || !empty($search_first_head) || !empty($search_group) ) ? '' : 'search_form_hidden' }}"> -->


                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('fixed_asset_list') }}" name="form1" id="form1" method="post">
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
                                        {{--                                                    @foreach($account_list as $value)--}}
                                        {{--                                                        <option value="{{$value}}">--}}
                                        {{--                                                    @endforeach--}}
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Parent Account
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="first_head" id="first_head">
                                        <option value="">Select Parent Account</option>
                                        @foreach($third_heads as $third_head)
                                            <option
                                                value="{{$third_head->coa_code}}" {{ $third_head->coa_code == $search_first_head ? 'selected="selected"' : '' }}>{{$third_head->coa_head_name}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Group
                                    </label>
                                    <select tabindex="3" class="inputs_up form-control cstm_clm_srch" name="group" id="group">
                                        <option value="">Select Group</option>
                                        @foreach($groups as $group)
                                            <option value="{{$group->ag_id}}" {{ $group->ag_id == $search_group ? 'selected="selected"' : '' }}>{{$group->ag_title}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form_controls text-right mt-4">
                                @include('include.clear_search_button')
                                <!-- Call add button component -->
                                    <x-add-button tabindex="9" href="{{ route('fixed_asset') }}"/>
                                @include('include/print_button')

                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                            </div>


                        </div>
                    </form>
                </div><!-- search form end -->


                <form name="edit" id="edit" action="{{ route('edit_fixed_asset') }}" method="post">
                    @csrf
                    <input name="fixed_asset" id="fixed_asset" type="hidden">
                </form>


                <div class="table-responsive" id="printTable">

                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">
                                Sr#
                            </th>
                            <th scope="col" class="tbl_srl_4">
                                ID
                            </th>
                            <th scope="col" class="tbl_txt_6">
                                Parent Account
                            </th>
                            <th scope="col" class="tbl_txt_15">
                                Name
                            </th>
                            <th scope="col" class="tbl_amnt_5">
                                Useful Life In Year(s)
                            </th>
                            <th scope="col" class="tbl_txt_7">
                                Dep. Method
                            </th>
                            <th scope="col" class="tbl_amnt_4">
                                Dep. %
                            </th>
                            <th scope="col" class="tbl_amnt_7">
                                Residual Val
                            </th>
                            <th scope="col" class="tbl_amnt_11">
                                Basis
                            </th>
                            <th scope="col" class="tbl_amnt_11">
                                Posting
                            </th>

                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" class="tbl_txt_9">
                                Account View Group
                            </th>
                            <th scope="col" class="hide_column tbl_srl_6">
                                Enable
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            $bal = 0;
                        @endphp
                        @forelse($datas as $index=> $account)


                            <tr data-id="{{$account->fa_id}}">


                                <th scope="row" class="edit ">
                                    {{$sr}}
                                </th>
                                <th class="edit ">
                                    {{$account->fa_id}}
                                </th>
                                <td class="edit ">
                                    {{ $account->prnt_acnt_name }}
                                </td>
                                <td class="edit ">
                                    {{$account->fa_account_name}}
                                </td>
                                <td class="edit ">
                                    {{$account->fa_useful_life_year}}
                                </td>
                                <td class="edit ">
                                    {{ ($account->fa_method === 1) ? 'Straight Balance' : 'Reducing Balance' }}
                                </td>
                                <td class="edit">
                                    {{ number_format($account->fa_dep_percentage_year,2) }}
                                </td>
                                <td class="edit text-right">
                                    {{ $account->fa_residual_value }}
                                </td>
                                <td class="edit ">
                                    @if($account->fa_dep_period == 1)
                                        Per Annum
                                    @elseif($account->fa_dep_period == 2)
                                        Per Month
                                    @else
                                        Daily Basis
                                    @endif
                                </td>
                                <td class="edit ">
                                    {{ $account->fa_posting == 1 ?  'Auto': 'Manual'}}
                                </td>

                                @php
                                    $ip_browser_info= ''.$account->fa_ip_adrs.','.str_replace(' ','-',$account->fa_brwsr_info).'';
                                @endphp

                                <td class="usr_prfl" data-usr_prfl="{{ $account->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $account->user_name }}
                                </td>
                                <td class="edit ">
                                    {{$account->ag_title}}
                                </td>

                                <td class="text-center hide_column ">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($account->fa_disabled == 0) {
                                            echo 'checked="true"' . ' ' . 'value=' . $account->fa_disabled;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?>  class="enable_disable" data-id="{{$account->fa_id}}"
                                            {{ $account->fa_disabled == 0 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
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
                <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'first_head'=>$search_first_head, 'group'=>$search_group ])->links() }}</span>
            </div> <!-- white column form ends here -->

        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('fixed_asset_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery(".edit").click(function () {

            var fixed_asset = jQuery(this).parent('tr').attr("data-id");

            jQuery("#fixed_asset").val(fixed_asset);
            jQuery("#edit").submit();
        });
    </script>

    <script>
        $('.enable_disable').change(function () {
            let status = $(this).prop('checked') === true ? 0 : 1;
            let faId = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('enable_disable_fixed_asset') }}',
                data: {'status': status, 'fa_id': faId},
                success: function (data) {
                    console.log(data.message);
                }
            });
        });
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#first_head").select2().val(null).trigger("change");
            $("#first_head > option").removeAttr('selected');

            $("#group").select2().val(null).trigger("change");
            $("#group > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#first_head").select2();
            jQuery("#group").select2();
        });
    </script>

@endsection

