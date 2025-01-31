@extends('extend_index')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Salary Account List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
            <!-- <div class="search_form {{ ( !empty($search) || !empty($search_account) || !empty($search_product) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}"> -->
                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('salary_account_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1" id="form1"
                          method="post">
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
                                        Control Account
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="first_head" id="first_head">
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
                                        Parent Account
                                    </label>
                                    <select tabindex="3" class="inputs_up form-control cstm_clm_srch" name="second_head" id="second_head">
                                        <option value="">Select Parent Account</option>
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
                                        Child Account
                                    </label>
                                    <select tabindex="4" class="inputs_up form-control cstm_clm_srch" name="third_head" id="third_head">
                                        <option value="">Select Child Account</option>
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
                                        Account Ledger Access Group
                                    </label>
                                    <select tabindex="5" class="inputs_up form-control cstm_clm_srch" name="group" id="group">
                                        <option value="">Select Account Ledger Access Group</option>
                                        @foreach($groups as $group)
                                            <option value="{{$group->ag_id}}" {{ $group->ag_id == $search_group ? 'selected="selected"' : '' }}>{{$group->ag_title}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                            <x-year-end-component search="{{$search_year}}"/>
                            <div class="col-lg-12 col-md-3 col-sm-12 col-xs-12 mt-4 text-right form_controls">
                                @include('include.clear_search_button')
                                <!-- Call add button component -->
                                    <x-add-button tabindex="9" href="{{ route('salary_account_registration') }}"/>
                                @include('include/print_button')
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>


                        </div><!-- end row -->
                    </form>


                    <form name="edit" id="edit" action="{{ route('edit_account') }}" method="post">
                        @csrf
                        <input tabindex="-1" name="acc_id" id="acc_id" type="hidden">
                    </form>

                    <form name="ledger" id="ledger" action="{{ route('account_ledger') }}" method="post" target="_blank">
                        @csrf
                        <input tabindex="-1" name="account_id" id="account_id" type="hidden">
                        <input tabindex="-1" name="account_name" id="account_name" type="hidden">
                    </form>

                    <form name="delete" id="delete" action="{{ route('delete_account') }}" method="post">
                        @csrf
                        <input tabindex="-1" name="account_id" id="del_account_id" type="hidden">
                        <input tabindex="-1" name="parent_account_id" id="del_parent" type="hidden">
                    </form>
                </div>


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
                            <th scope="col" class="tbl_amnt_7">
                                ID NO.
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Control Account
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Parent Account
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Child Account
                            </th>
                            <th scope="col" class="tbl_txt_12">
                                Account Ledger
                            </th>
                            <th scope="col" class="tbl_amnt_8">
                                Lib - Salary
                            </th>
                            <th scope="col" class="tbl_amnt_9">
                                Advance
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Account Ledger Access Group
                            </th>
                            <th scope="col" class="hide_column tbl_srl_4">
                                Enable
                            </th>
                            <th scope="col" class="hide_column tbl_srl_4">
                                Action
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @php

                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            $bal = 0; $advSal = 0;
                        @endphp
                        @forelse($datas as $index=> $account)

                            @if($account->account_type==0)
                                <tr data-id="{{$account->account_id}}">
                                    @endif

                                    <th scope="row" class="edit">
                                        {{$sr}}
                                    </th>
                                    <td class="edit">
                                        {{$account->account_id}}
                                    </td>
                                    <td class="edit">
                                        {{$account->account_uid}}
                                    </td>
                                    <td class="editedit">
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
                                    <td class="editedit">
                                        {{$account->grp_acnt_name}}
                                    </td>
                                    <td class="editedit">
                                        {{$account->parnt_acnt_name}}
                                    </td>
                                    <td class="align_left text-left ">
                                        <a data-id="{{$account->account_uid}}" data-name="{{$account->account_name}}" class="ledger" data-toggle="tooltip" data-placement="bottom" title=""
                                           data-original-title="View Ledger of {{$account->account_name}}">
                                            {{$account->account_name}}
                                        </a>
                                    </td>
                                    @php
                                        $bal = +($balance[$index]) + +$bal;
                                    @endphp
                                    <td class="align_right text-right edit">
                                        {{$balance[$index]!=0 ? number_format($balance[$index],2):''}}
                                    </td>
                                    @php
                                        $advSal = +($account->as_amount) + +$advSal;
                                    @endphp
                                    <td class="align_right text-right edit">
                                        {{ $account->as_amount }}
                                    </td>

                                    @php
                                        $ip_browser_info= ''.$account->account_ip_adrs.','.str_replace(' ','-',$account->account_brwsr_info).'';
                                    @endphp

                                    <td class="align_left usr_prfl text-left " data-usr_prfl="{{ $account->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                        {{ $account->user_name }}
                                    </td>
                                    <td class="edit">
                                        {{$account->ag_title}}
                                    </td>
                                    {{--    add code by mustafa start --}}
                                    <td class="text-center hide_column ">
                                        <label class="switch">
                                            <input type="checkbox" <?php if ($account->account_disabled == 0) {
                                                echo 'checked="true"' . ' ' . 'value=' . $account->account_disabled;
                                            } else {
                                                echo 'value=DISABLE';
                                            } ?>  class="enable_disable" data-id="{{$account->account_id}}"
                                                {{ $account->account_disabled == 0 ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    {{--    add code by mustafa end --}}
                                    @if($account->account_type==0)

                                        <td class="text-center hide_column ">
                                            <a data-id="{{$account->account_uid}}" data-parent="{{$account->account_parent_code}}" class="delete" data-toggle="tooltip" data-placement="left" title=""
                                               data-original-title="Are you sure?">
                                                <i class="fa fa-{{$account->account_delete_status == 1 ? 'undo':'trash'}}"></i>
                                            </a>
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
                                Per Page Total
                            </th>
                            <td class="align_right text-right border-0">
                                {{ number_format($bal,2) }}
                            </td>
                            <td class="align_right text-right border-0">
                                {{ number_format($advSal,2) }}
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
                    class="hide_column"> {{ $datas->appends(['segmentSr'=>$countSeg,'search'=>$search, 'first_head'=>$search_first_head, 'second_head'=>$search_second_head, 'third_head'=>$search_third_head, 'group'=>$search_group ])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->

        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')



    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('salary_account_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    {{--    add code by mustafa start --}}
    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let accountId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_account') }}',
                    data: {'status': status, 'account_id': accountId},
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>
    {{--    add code by mustafa end --}}


    <script>
        jQuery(".edit").click(function () {

            var account_id = jQuery(this).parent('tr').attr("data-id");

            jQuery("#acc_id").val(account_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var account_id = jQuery(this).attr("data-id");
            var parent = jQuery(this).attr("data-parent");

            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
            }).then(function (result) {

                if (result.value) {
                    jQuery("#del_account_id").val(account_id);
                    jQuery("#del_parent").val(parent);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });

        // jQuery(".receivable").click(function () {
        //
        //     var account_id = jQuery(this).attr("data-id");
        //     var account_type = jQuery(this).attr("data-account_type");
        //
        //     jQuery("#accounts_id").val(account_id);
        //     jQuery("#account_type").val(account_type);
        //     jQuery("#edit_receivable_payable").submit();
        // });
        //
        // jQuery(".payable").click(function () {
        //
        //     var account_id = jQuery(this).attr("data-id");
        //     var account_type = jQuery(this).attr("data-account_type");
        //
        //     jQuery("#accounts_id").val(account_id);
        //     jQuery("#account_type").val(account_type);
        //     jQuery("#edit_receivable_payable").submit();
        // });

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
        jQuery("#cancel").click(function () {

            $("#group").select2().val(null).trigger("change");
            $("#group > option").removeAttr('selected');

            $("#first_head").select2().val(null).trigger("change");
            $("#first_head > option").removeAttr('selected');

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
            jQuery("#first_head").select2();
            jQuery("#second_head").select2();
            jQuery("#third_head").select2();
            jQuery("#group").select2();
        });
    </script>

@endsection

