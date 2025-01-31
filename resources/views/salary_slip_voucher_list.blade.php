
@extends('extend_index')

@section('content')

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text file_name">Salary Slip Voucher List</h4>
                            </div>
                            <div class="list_btn list_mul">
                                <div class="srch_box_opn_icon">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->

                    <!-- <div class="search_form {{ ( !empty($search) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}"> -->

                    <div class="search_form">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <form class="prnt_lst_frm" action="{{ route('salary_slip_voucher_list') }}" name="form1" id="form1" method="post">
                                    @csrf
                                    <div class="row">

                                        <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label>
                                                    All Column Search
                                                </label>
                                                <input tabindex="1" autofocus type="search" class="inputs_up form-control" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                            </div>
                                        </div> <!-- left column ends here -->


                                        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                            <div class="row">

                                                <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label>
                                                            Start Date
                                                        </label>
                                                        <input tabindex="2" type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......" />
                                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label>
                                                            End Date
                                                        </label>
                                                        <input tabindex="3" type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......" />
                                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label>
                                                            Employee
                                                        </label>
                                                        <select tabindex="4" name="employee" class="inputs_up form-control" id="employee">
                                                            <option value="">Select Employee</option>
                                                            @foreach($employees as $employee)
                                                                <option value="{{$employee->user_id}}"  {{ $employee->user_id == $search_employee ? 'selected="selected"' :
                                                                ''}}>{{$employee->user_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                    <div class="form_controls text-center text-lg-left">

                                                        <button tabindex="5" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                            <i class="fa fa-trash"></i> Clear
                                                        </button>
                                                        <button tabindex="6" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                            <i class="fa fa-search"></i> Search
                                                        </button>

                                                        <a tabindex="7" class="save_button form-control" href="{{ route('salary_slip_voucher') }}" role="button">
                                                            <i class="fa fa-plus"></i> Salary
                                                        </a>

                                                        @include('include/print_button')

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
                        <table class="table table-bordered table-sm" id="fixTable">

                            <thead>
                            <tr>
                                <th tabindex="-1" scope="col"  class="text-center  tbl_srl_4">
                                    Sr#
                                </th>
                                <th tabindex="-1" scope="col"  class="text-center  tbl_srl_4">
                                    ID
                                </th>
                                <th scope="col"  class=" text-center tbl_amnt_6">
                                    Date
                                </th>
                                <th scope="col"  class=" text-center tbl_amnt_9">
                                    Voucher No.
                                </th>
                                <th tabindex="-1" scope="col"  class=" text-center tbl_txt_15">
                                    Remarks
                                </th>
                                <th scope="col"  class=" text-center tbl_txt_44">
                                    Detail Remarks
                                </th>
                                <th scope="col"  class=" text-center tbl_amnt_10">
                                    Total Amount
                                </th>
                                <th scope="col"  class="text-center  tbl_txt_8">
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
                                $per_page_ttl_amnt = 0;
                            @endphp
                            @forelse($datas as $voucher)

                                <tr>
                                    <td class=" text-center edit tbl_srl_4">
                                        {{$sr}}
                                    </td>
                                    <td class=" text-center edit tbl_srl_4">
                                        {{$voucher->ss_id}}
                                    </td>
                                    <td class=" text-center tbl_amnt_6">
                                        {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->ss_day_end_date)))}}
                                    </td>
                                    <td class="view  text-center tbl_amnt_9" data-id="{{$voucher->ss_id}}">
                                        SSV-{{$voucher->ss_id}}
                                    </td>
                                    <td class="align_left text-left tbl_txt_15">
                                        {{$voucher->ss_remarks}}
                                    </td>
                                    <td class="align_left text-left tbl_txt_44">
                                        {!! str_replace("&oS;",'<br />', $voucher->ss_detail_remarks) !!}
                                    </td>
                                    @php $per_page_ttl_amnt = +$voucher->ss_net_salary + +$per_page_ttl_amnt; @endphp

                                    <td class="align_right text-right tbl_amnt_10">
                                        {{$voucher->ss_net_salary !=0 ? number_format($voucher->ss_net_salary,2):''}}
                                    </td>

                                    @php
                                        $ip_browser_info= ''.$voucher->ss_ip_adrs.','.str_replace(' ','-',$voucher->ss_brwsr_info).'';
                                    @endphp

                                    <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                        {{$voucher->user_name}}
                                    </td>

                                </tr>
                                @php
                                    $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="11">
                                        <center><h3 style="color:#554F4F">No Vocuher</h3></center>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>

                            <tfoot>
                            <tr class="border-0">
                                <th colspan="5" align="right" class="border-0 text-right align_right pt-0">
                                    Page Total:
                                </th>
                                <td class="text-right border-left-0" align="right" style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                                    {{ number_format($per_page_ttl_amnt,2) }}
                                </td>
                            </tr>
                            </tfoot>

                        </table>
                    </div>
                    <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>
                </div> <!-- white column form ends here -->


            </div><!-- col end -->


        </div><!-- row end -->

    <!-- Modal g-->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Salary Slip Voucher Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="itm_vchr form_manage">
                        <div class="form_header">
                            <h4 class="text-white file_name">
                                <span class="db sml_txt"> Voucher #: </span>
                            </h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                <tr>
                                    <th scope="col"  class="wdth_5">Account No.</th>
                                    <th scope="col"  class="wdth_2">Account Name</th>
                                    <th scope="col"  class="wdth_5 text-right">Amount</th>
                                </tr>
                                </thead>
                                <tbody id="table_body">
                                </tbody>
                                <tfoot id="table_foot">
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('salary_slip_voucher_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function () {

            jQuery("#table_body").html("");
            // jQuery(".pre-loader").fadeToggle("medium");

            var id = jQuery(this).attr("data-id");
            $(".modal-body").load('{{ url('salary_slip_items_view_details/view/') }}/'+id, function () {
                // jQuery(".pre-loader").fadeToggle("medium");
               $("#myModal").modal({show:true});
            });

        });
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#search").val('');
            $("#to").val('');
            $("#from").val('');

            $("#employee").select2().val(null).trigger("change");
            $("#employee > option").removeAttr('selected');
        });

        jQuery("#employee").select2();
    </script>

@endsection

