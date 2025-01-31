
@extends('extend_index')

@section('content')

    <div class="row">


            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">



                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text file_name">{{$title}}</h4>
                            </div>
                            <div class="list_btn list_mul">
                                <div class="srch_box_opn_icon">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->


                    <div class="search_form {{ ( !empty($search) ) ? '' : 'search_form_hidden' }}">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                @php
                                    $pgRoute = (isset($route) && !empty($route)) ? $route : '';
                                @endphp

                                <form class="prnt_lst_frm" action="{{ route($pgRoute) }}" name="form1" id="form1" method="post">
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

                                        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                            <div class="form_controls text-center text-lg-left">

                                                <button tabindex="2" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                    <i class="fa fa-trash"></i> Clear
                                                </button>
                                                <button tabindex="3" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                    <i class="fa fa-search"></i> Search
                                                </button>

                                                <a tabindex="4" class="save_button form-control" href="{{ route('reject_cash_receive_list') }}" role="button" target="_blank" data-toggle="tooltip" data-placement="bottom" title="View Reject Cash Receive List">
                                                    <i class="fa fa-ban"></i> Reject Cash
                                                </a>
                                                <a tabindex="5" class="save_button form-control" href="{{ route('approve_cash_receive_list') }}" role="button" target="_blank" data-toggle="tooltip" data-placement="bottom" title="View Approve Cash Receive List">
                                                    <i class="fa fa-check"></i> Approve Cash
                                                </a>
                                                <a tabindex="6" class="save_button form-control" href="{{ route('pending_cash_receive_list') }}" role="button" target="_blank" data-toggle="tooltip" data-placement="bottom" title="View Pending Cash Receive List">
                                                    <i class="fa fa-clock-o"></i> Pending Cash
                                                </a>

                                                @include('include/print_button')

                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                            </div>
                                        </div>

                                    </div>
                                </form>


                                @if($route=='pending_cash_receive_list')
                                    <form name="approve_form" id="approve_form" action="{{route("approve_cash_receive")}}" method="post">
                                        @csrf
                                        <input tabindex="7" name="approve" id="approve" type="hidden">
                                    </form>
                                @endif

                            </div>
                        </div>
                    </div><!-- search form end -->


                    <div class="table-responsive" id="printTable">
                        <table class="table table-sm" id="fixTable">

                            <thead>
                            <tr>
                                <th tabindex="-1" class="text-center align_center tbl_srl_4">
                                    Sr#
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                                    Date/Time
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                                    V.#
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_15">
                                    Send From
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_15">
                                    Send To
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                                    Status
                                </th>
                                @if($route=="reject_cash_receive_list")
                                    <th scope="col" align="center" class="align_center text-center tbl_txt_36">
                                        Reason
                                    </th>
                                @else
                                    <th scope="col" align="center" class="align_center text-center {{ ($route==='pending_cash_receive_list') ? 'tbl_txt_30' : 'tbl_txt_36' }} ">
                                        Remarks
                                    </th>
                                @endif
                                <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                                    Amount
                                </th>
                                @if($route=='pending_cash_receive_list')
                                <th scope="col" align="center" class="align_center text-center tbl_srl_6 hide_column">
                                    Action
                                </th>
                                @endif
                                {{--<th scope="col" style="width:80px; text-align: center !important" align="center">Reject</th>--}}
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
                            @forelse($datas as $cash_receive)

                                <tr>
                                    <td class="align_center text-center tbl_srl_4">
                                        {{$sr}}
                                    </td>
                                    <td class="align_center text-center tbl_amnt_10">
                                        {{date('d-M-y h:i:sA', strtotime(str_replace('/', '-', $cash_receive->ct_send_datetime)))}}
                                    </td>
                                    <td class="align_center text-center tbl_amnt_10">
                                        {{config('global_variables.CASH_TRANSFER_CODE').$cash_receive->ct_id}}
                                    </td>
                                    @php
                                        $ip_browser_info= ''.$cash_receive->ct_ip_adrs.','.str_replace(' ','-',$cash_receive->ct_brwsr_info).'';
                                    @endphp

                                    <td class="align_left text-left usr_prfl tbl_txt_15" data-usr_prfl="{{ $cash_receive->SndById }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                        {{$cash_receive->SndByUsrName}}
                                    </td>

                                    <td class="align_left text-left usr_prfl tbl_txt_15" data-usr_prfl="{{ $cash_receive->RcdById }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                        {{$cash_receive->RcdByUsrName}}
                                    </td>
                                    <td class="align_center text-center tbl_txt_10">
                                        {{$cash_receive->ct_status}}
                                    </td>
                                    @if($route=="reject_cash_receive_list")
                                        <td class="align_left text-left tbl_txt_36">
                                            {{$cash_receive->ct_reason}}
                                        </td>
                                    @else
                                        <td class="align_left text-left tbl_txt_36">
                                            {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $cash_receive->ct_remarks) !!}
                                        </td>
                                    @endif
                                    @php
                                        $ttlPrc = +($cash_receive->ct_amount) + +$ttlPrc;
                                    @endphp
                                    <td class="align_right text-right tbl_amnt_10">
                                        {{ number_format($cash_receive->ct_amount,2) }}
                                    </td>


                                    @if($route=='pending_cash_receive_list')
                                    <td class="align_right text-right hide_column tbl_srl_6">
                                        <a class="btn btn-success btn-sm rjct_acpt_btn" data-id="{{$cash_receive->ct_id}}" id="approve_payment">
                                            <i class="fa fa-check approve"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm rjct_acpt_btn" data-id="{{$cash_receive->ct_id}}" data-toggle="modal" data-target="#exampleModal" id="reject_payment">
                                            <i class="fa fa-ban reject"></i>
                                        </a>
                                    </td>
                                    @endif
                                    {{--<td class="align_center"><li class="fa fa-ban"></li></td>--}}
                                </tr>
                                @php
                                    $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="11">
                                        <center><h3 style="color:#554F4F">No Entry</h3></center>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>

                            <tfoot>
                            <tr>
                                <th colspan="7" class="align_right text-right border-0">
                                    Per Page Total:-
                                </th>
                                <td class="align_right text-right border-0">
                                    {{ number_format($ttlPrc,2) }}
                                </td>
                            </tr>
                            </tfoot>

                        </table>

                    </div>

                    <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search ])->links() }}</span>
                </div> <!-- white column form ends here -->


            </div><!-- col end -->


        </div><!-- row end -->

    @if($route=='pending_cash_receive_list')
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reject Transaction</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route("reject_cash_receive")}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label for="message-text" class="col-form-label">Reason:</label>
                                        <textarea class="inputs_up form-control" id="reason" name="reason" required></textarea>
                                        <input type="hidden" name="reject" id="reject">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Send message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route($pgRoute) }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    @if($route=='pending_cash_receive_list')
    <script>
        jQuery("#approve_payment").click(function () {

            var approve = jQuery(this).attr("data-id");

            jQuery("#approve").val(approve);
            jQuery("#approve_form").submit();
        });


        jQuery("#reject_payment").click(function () {
            var reject = jQuery(this).attr("data-id");
            jQuery("#reject").val(reject);
        });
    </script>
    @endif

    <script>
        jQuery("#cancel").click(function () {

            $("#search").val('');
        });
    </script>

@endsection

