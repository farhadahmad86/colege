@extends('extend_index')

@section('content')
    <div class="row">
        <form id="edit" action="{{ route('account_ledger') }}" target="_blank" method="post">
            @csrf
            <input name="account_name" id="account_name" type="hidden">
            <input name="account_id" id="account_id" type="hidden">
        </form>
            <div class="container-fluid search-filter form-group form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white file_name get-heading-text">Project Wise Expense Report</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm"
                          action="{{ route('project_wise_expense_report') .((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}"
                          name="form1" id="form1" method="post">
                        @csrf

                        <div class="row">
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Project
                                    </label>
                                    <select tabindex="4" class="inputs_up form-control cstm_clm_srch"
                                            name="third_head" id="third_head">
                                        <option value="">Select Project</option>
                                        @foreach($third_heads as $third_head)
                                            <option
                                                value="{{$third_head->pr_id}}" {{ $third_head->pr_id == $search_third_head ? 'selected="selected"' : '' }}>{{$third_head->pr_name}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign"
                                          style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Start Date
                                    </label>
                                    <input tabindex="5" type="text" name="to" id="to"
                                           class="inputs_up form-control datepicker1" autocomplete="off"
                                           <?php if(isset($search_to)){?> value="{{$search_to}}"
                                           <?php } ?> placeholder="Start Date ......"/>
                                    <span id="demo1" class="validate_sign"
                                          style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        End Date
                                    </label>
                                    <input tabindex="6" type="text" name="from" id="from"
                                           class="inputs_up form-control datepicker1" autocomplete="off"
                                           <?php if(isset($search_from)){?> value="{{$search_from}}"
                                           <?php } ?> placeholder="End Date ......"/>
                                    <span id="demo1" class="validate_sign"
                                          style="float: right !important"> </span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 mt-lg-4 text-right">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('account_registration') }}"/>
                             @include('include/print_button')
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                    </form>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">
                        <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">
                                Sr#
                            </th>
                            <th scope="col" class="tbl_txt_16">
                                Project Name
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Parent Account
                            </th>

                            <th scope="col" class="tbl_txt_16">
                                Account Ledger
                            </th>

                            <th scope="col" class="tbl_amnt_9">
                                Opening Balance
                            </th>
                            <th scope="col" class="tbl_amnt_9">
                                DR
                            </th>
                            <th scope="col" class="tbl_amnt_9">
                                CR
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
                            $bal = 0;
                            $deb_bal = 0;
                            $cre_bal = 0;
                            $balances = 0;
                        @endphp
                        @forelse($datas as $index=> $account)


                            <th scope="row">
                                {{$sr}}
                            </th>
                            <td>
                                {{$account->pr_name}}
                            </td>
                            <td>
                                {{$account->parent_name}}
                            </td>

                            <td>
                                <a class="" data-account_id="{{$account->bal_account_id}}"
                                   data-account_name="{{$account->account_name}}" style="cursor: pointer;">{{$account->account_name}}</a>

                            </td>


                            @php
                                $bal = +($balance[$index]) + +$bal;
                                $opening_balance = ($balance[$index]);
                            $deb_bal = +$deb_bal + +$account->dr;
                            $cre_bal = +$cre_bal + +$account->cr;
                            $balances = +$opening_balance - +$account->cr + +$account->dr;
                            @endphp


                            <td class="align_right text-right">
                                {{number_format($opening_balance,2)}}
                            </td>
                            <td class="align_right text-right">
                                {{number_format($account->dr,2)}}
                            </td>

                            <td class="align_right text-right">
                                {{number_format($account->cr,2)}}
                            </td>

                            <td class="align_right text-right">
                                {{number_format($balances,2)}}
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
                            <th colspan="4" class="align_right text-right border-0">
                                Per Page Total:-
                            </th>
                            <td class="align_right text-right border-0">
                                {{ number_format($bal,2) }}
                            </td>
                            <td class="align_right text-right border-0">
                                {{ number_format($deb_bal,2) }}
                            </td>
                            <td class="align_right text-right border-0">
                                {{ number_format($cre_bal,2) }}
                            </td>
                            <td class="align_right text-right border-0">
                                {{ number_format($bal + $deb_bal - $cre_bal,2) }}
                            </td>
                        </tr>
                        </tfoot>

                    </table>

                </div>
                {{--                <span--}}
                {{--                    class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'third_head'=>$search_third_head, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>--}}
            </div> <!-- white column form ends here -->


    </div><!-- row end -->

@endsection

@section('scripts')



    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('project_wise_expense_report') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

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

    <script>
        jQuery("#cancel").click(function () {

            $("#third_head").select2().val(null).trigger("change");
            $("#third_head > option").removeAttr('selected');

            $("#to").val('');
            $("#from").val('');
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

