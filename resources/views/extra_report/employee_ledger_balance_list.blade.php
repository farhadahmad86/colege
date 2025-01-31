@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Employee Ledger Balance</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

            <!-- <div class="search_form {{ ( !empty($search_department) ||!empty($search_employee) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <form class="prnt_lst_frm" action="{{ route('employee_ledger_balance_list') }}" name="form1" id="form1" method="post">
                                @csrf
                                <div class="row">

                                    {{--                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">--}}
                                    {{--                                        <div class="input_bx"><!-- start input box -->--}}
                                    {{--                                            <label>--}}
                                    {{--                                                All Column Search--}}
                                    {{--                                            </label>--}}
                                    {{--                                            <input tabindex="1" autofocus type="search" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."--}}
                                    {{--                                                   value="{{ isset($search) ? $search : '' }}" autocomplete="off">--}}
                                    {{--                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div> <!-- left column ends here -->--}}


                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">
                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Department
                                                    </label>
                                                    <select tabindex="3" class="inputs_up form-control" name="department" id="department">
                                                        <option value="">Select Department</option>
                                                        @foreach($departments as $department)
                                                            <option value="{{$department->dep_id}}" {{ $department->dep_id == $search_department ? 'selected="selected"' : ''
                                                            }}>{{$department->dep_title}}</option>
                                                        @endforeach
                                                    </select>

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Employee
                                                    </label>
                                                    <select tabindex="3" class="inputs_up form-control" name="employee" id="employee">
                                                        <option value="">Select Employee</option>
                                                        @foreach($employees as $employee)
                                                            <option value="{{$employee->user_id}}" {{ $employee->user_id == $search_employee ? 'selected="selected"' : ''
                                                            }}>{{$employee->user_name}}</option>
                                                        @endforeach
                                                    </select>

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>


                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button tabindex="5" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button tabindex="6" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    @include('include.print_button')

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </form>


                        </div>

                    </div>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">
                                Sr#
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_15">
                                Department
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_10">
                                Account Title
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_10">
                                Employee Name
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_10">
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
                            $ttl_balance = 0;

                        @endphp
                        @forelse($datas as $voucher)

                            <tr>
                                <td class="align_center text-center edit tbl_srl_4">
                                    {{$sr}}
                                </td>
                                <td class="align_left text-left tbl_txt_15">
                                    {{$voucher->dep_title}}
                                </td>
                                @php $ttl_balance = +$voucher->account_balance + +$ttl_balance;

                                @endphp

                                <td class="align_right text-right tbl_amnt_10">

                                    {{$voucher->account_name}}
                                </td>
                                <td class="align_right text-right tbl_amnt_10">
                                    {{$voucher->user_name}}
                                </td>
                                <td class="align_right text-right tbl_amnt_10">
                                    {{$voucher->account_balance !=0 ? number_format($voucher->account_balance,2):'0.00'}}
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
                            <th colspan="4" align="right" class="border-0 text-right align_right pt-0">
                                Page Total:
                            </th>

                            <td class="text-right border-left-0" align="right" style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                                {{ number_format($ttl_balance,2) }}
                            </td>
                        </tr>
                        </tfoot>

                    </table>
                </div>
                <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'department'=>$search_department, 'employee'=>$search_employee ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('employee_ledger_balance_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery("#cancel").click(function () {
            $("#department").select2().val(null).trigger("change");
            $("#department > option").removeAttr('selected');

            $("#employee").select2().val(null).trigger("change");
            $("#employee > option").removeAttr('selected');
        });

    </script>
    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#department").select2();
            jQuery("#employee").select2();
        });
    </script>

@endsection

