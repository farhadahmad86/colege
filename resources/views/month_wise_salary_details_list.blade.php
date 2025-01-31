@extends('extend_index')

@section('content')

    <div class="row">
        <div class="container-fluid search-filter form-group form_manage" id="">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text file_name">Salary Detail For The Month Of ( {{$search_month}} )</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
        <!-- <div class="search_form {{ ( !empty($search_month) ) ? '' : 'search_form_hidden' }}"> -->
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm" action="{{ route('month_wise_salary_detail_list') }}" name="form1" id="form1" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label>
                                    Month
                                </label>
                                <input tabindex="2" type="text" name="month" id="month" class="inputs_up form-control month-picker" autocomplete="off" <?php if(isset
                                ($search_month)){?> value="{{$search_month}}" <?php } ?>
                                       placeholder="Start Month ......">
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-10 col-md-9 col-sm-12 col-xs-12 text-right mt-4">
                            @include('include.clear_search_button')
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
                        <th tabindex="-1" scope="col" class=" tbl_srl_4">
                            Sr#
                        </th>
                        <th tabindex="-1" scope="col" class=" tbl_txt_30">
                            Department
                        </th>
                        <th tabindex="-1" scope="col" class=" tbl_txt_10">
                            Gross Salary
                        </th>
                        <th tabindex="-1" scope="col" class=" tbl_txt_10">
                            Advance Salary
                        </th>
                        <th tabindex="-1" scope="col" class=" tbl_txt_10">
                            Loan
                        </th>
                        <th tabindex="-1" scope="col" class=" tbl_txt_10">
                            Net Salary
                        </th>
                        <th tabindex="-1" scope="col" class=" tbl_txt_10">
                            Advance Salary %
                        </th>
                        <th tabindex="-1" scope="col" class=" tbl_txt_10">
                            # Of Employee
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
                        $ttl_employees = 0;
                        $ttl_gross_salary = 0;
                        $ttl_net_salary = 0;
                        $ttl_advance_salary = 0;
                        $ttl_loan = 0;
                    @endphp
                    @forelse($datas as $voucher)

                        <tr>
                            <td class=" edit tbl_srl_4">
                                {{$sr}}
                            </td>
                            <td class="align_left text-left tbl_txt_30">
                                {{$voucher->dep_title}}
                            </td>
                            @php $ttl_employees = +$voucher->employee + +$ttl_employees;
                            $ttl_gross_salary = +$voucher->gross + +$ttl_gross_salary;
                            $ttl_net_salary = +$voucher->net + +$ttl_net_salary;
                            $ttl_advance_salary = +$voucher->advance + +$ttl_advance_salary;
                            $ttl_loan = +$voucher->loan + +$ttl_loan;
                            if($voucher->gross !=null){
                            $advance_pec=($voucher->advance/$voucher->gross)*100;
                            }
                            @endphp

                            <td class="align_right text-right tbl_amnt_10">

                                {{number_format($voucher->gross,2)}}
                            </td>
                            <td class="align_right text-right tbl_amnt_10">

                                {{number_format($voucher->advance,2)}}
                            </td>
                            <td class="align_right text-right tbl_amnt_10">

                                {{number_format($voucher->loan,2)}}
                            </td>
                            <td class="align_right text-right tbl_amnt_10">

                                {{number_format(($voucher->net - $voucher->advance - $voucher->loan),2)}}
                            </td>
                            <td class="align_right text-right tbl_amnt_10">
                                {{number_format($advance_pec,0).'%'}}
                            </td>
                            <td class="align_right text-right tbl_amnt_10">

                                {{$voucher->employee}}
                            </td>

                        </tr>
                        @php
                            $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center><h3 style="color:#554F4F">No List Found</h3></center>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                    <tfoot>
                    <tr class="border-0">
                        <th colspan="2" align="right" class="border-0 text-right align_right pt-0">
                            Page Total:
                        </th>
                        <td class="text-right border-left-0" align="right" style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                            {{ number_format($ttl_gross_salary,2) }}
                        </td>
                        <td class="text-right border-left-0" align="right" style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                            {{ number_format($ttl_advance_salary,2) }}
                        </td>
                        <td class="text-right border-left-0" align="right" style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                            {{ number_format($ttl_loan,2) }}
                        </td>
                        <td class="text-right border-left-0" align="right" style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                            {{ number_format($ttl_net_salary - $ttl_advance_salary - $ttl_loan,2) }}
                        </td>
                        <td class="text-right border-left-0" align="right" style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                            @php $ttl_percent=0; if($ttl_advance_salary!=null){
                            $ttl_percent=($ttl_advance_salary/$ttl_gross_salary)*100;
                            }
                            @endphp
                            {{number_format($ttl_percent,0) .'%'}}
                        </td>
                        <td class="text-right border-left-0" align="right" style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                            {{ $ttl_employees }}
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
                    <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'month'=>$search_month ])->links() }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('month_wise_salary_detail_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery("#cancel").click(function () {
            $("#month").val('');
        });

    </script>

@endsection

