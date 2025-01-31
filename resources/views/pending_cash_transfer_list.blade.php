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


            <!-- <div class="search_form {{ ( !empty($search) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{route("$route")}}" name="form1" id="form1" method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 mt-4 form_controls text-right">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                                <x-add-button tabindex="9" href="{{ route('cash_transfer') }}"/>
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
                            <th>
                                Sr#
                            </th>
                            <th>
                                ID
                            </th>
                            <th>
                                ID No.
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Date/Time
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                V.#
                            </th>
                            <th scope="col" class="tbl_txt_15">
                                Send From
                            </th>
                            <th scope="col" class="tbl_txt_15">
                                Send To
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Status
                            </th>
                            @if($route=="reject_cash_transfer_list")
                                <th scope="col" class="tbl_txt_36">
                                    Reason
                                </th>
                            @else
                                <th scope="col" class="tbl_txt_28">
                                    Remarks
                                </th>
                            @endif
                            <th scope="col" class="tbl_amnt_10">
                                Amount
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
                        @forelse($datas as $cash_transfer)

                            <tr>
                                <th scope="row">
                                    {{$sr}}
                                </th>
                                <td>
                                    {{$cash_transfer->ct_id}}
                                </td>
                                <td>
                                    {{$cash_transfer->ct_id}}
                                </td>
                                <td>
                                    {{--                                        {{  date('d-M-Y h:i:sA', $cash_transfer->ct_send_datetime)  }}--}}
                                    {{date('d-M-y h:i:sA', strtotime(str_replace('/', '-', $cash_transfer->ct_send_datetime)))}}
                                </td>

                                <td>
                                    {{config('global_variables.CASH_TRANSFER_CODE').$cash_transfer->ct_id}}
                                </td>

                                @php
                                    $ip_browser_info= ''.$cash_transfer->ct_ip_adrs.','.str_replace(' ','-',$cash_transfer->ct_brwsr_info).'';
                                @endphp

                                <td class="usr_prfl " data-usr_prfl="{{ $cash_transfer->SndById }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{$cash_transfer->SndByUsrName}}
                                </td>

                                <td class="usr_prfl " data-usr_prfl="{{ $cash_transfer->RcdById }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{$cash_transfer->RcdByUsrName}}
                                </td>
                                <td>
                                    {{$cash_transfer->ct_status}}
                                </td>
                                @if($route=="reject_cash_transfer_list")
                                    <td>
                                        {{$cash_transfer->ct_reason}}
                                    </td>
                                @else
                                    <td>
                                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $cash_transfer->ct_remarks) !!}
                                    </td>
                                @endif
                                @php
                                    $ttlPrc = +($cash_transfer->ct_amount) + +$ttlPrc;
                                @endphp
                                <td>
                                    {{ number_format($cash_transfer->ct_amount,2) }}
                                </td>
                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Cash Transfer</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                        <tfoot>
                        <tr>
                            <th colspan="7" class="text-right border-0">
                                Per Page Total:-
                            </th>
                            <td class="text-right border-0">
                                {{ number_format($ttlPrc,2) }}
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
                        <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    @php
        $pgRoute = (isset($route) && !empty($route)) ? $route : '';
    @endphp

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route($pgRoute) }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery("#cancel").click(function () {

            $("#search").val('');
        });
    </script>

@endsection

