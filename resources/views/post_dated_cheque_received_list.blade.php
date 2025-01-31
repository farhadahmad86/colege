@extends('extend_index')

@section('content')

    @php
        $route='';
        if($title=='Confirmed Post Dated Cheque Received List'){
        $route='approve_post_dated_cheque_received_list';
        }elseif ($title=='Rejected Post Dated Cheque Received List'){
        $route='reject_post_dated_cheque_received_list';
        }else{
        $route='post_dated_cheque_received_list';
        }
    @endphp

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


                <!-- <div class="search_form {{ ( !empty($search) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{$route}}" name="form1" id="form1" method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers"
                                           class="inputs_up form-control" name="search" id="search"
                                           placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    {{--                                <datalist id="browsers">--}}
                                    {{--                                    @foreach($ccm_title as $value)--}}
                                    {{--                                        <option value="{{$value}}">--}}
                                    {{--                                    @endforeach--}}
                                    {{--                                </datalist>--}}
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->


                            {{--                            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 srch_brdr_left">--}}
                            {{--                                <div class="row">--}}
                            <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">Account From</label>
                                    <select tabindex="2" name="from_accounts" class="inputs_up form-control"
                                            id="from_accounts">
                                        <option value="">Select Account</option>
                                        @foreach($from_accounts as $from_account)
                                            <option
                                                value="{{$from_account->account_uid}}" {{ $from_account->account_uid == $search_account_from ? 'selected="selected"' : '' }} >
                                                {{$from_account->account_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>

                            <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">Account To</label>
                                    <select tabindex="3" name="to_accounts" class="inputs_up form-control"
                                            id="to_accounts">
                                        <option value="">Select Account</option>
                                        @foreach($to_accounts as $to_account)
                                            <option
                                                value="{{$to_account->account_uid}}" {{ $to_account->account_uid == $search_account_to ? 'selected="selected"' : '' }}>
                                                {{$to_account->account_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span id="demo2" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>

                            <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Start Date
                                    </label>
                                    <input tabindex="4" type="text" name="to" id="to"
                                           class="inputs_up form-control datepicker1" autocomplete="off"
                                           <?php if (isset($search_to)){ ?> value="{{$search_to}}"
                                           <?php } ?> placeholder="Start Date ......"/>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        End Date
                                    </label>
                                    <input tabindex="5" type="text" name="from" id="from"
                                           class="inputs_up form-control datepicker1" autocomplete="off"
                                           <?php if (isset($search_from)){ ?> value="{{$search_from}}"
                                           <?php } ?> placeholder="End Date ......"/>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                            <x-year-end-component search="{{$search_year}}"/>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-lg-4 text-right">
                                @include('include.clear_search_button')
                                <!-- Call add button component -->
                                <x-add-button tabindex="9" href="{{ route('add_post_dated_cheque_received') }}"/>
                                @include('include/print_button')
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                        </div>
                    </form>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th class="tbl_srl_4">
                                Sr#
                            </th>
                            <th class="tbl_srl_4">
                                ID
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Cheque Date
                            </th>
                            <th scope="col" class="tbl_txt_15">
                                Account From
                            </th>
                            <th scope="col" class="tbl_txt_15">
                                Account To
                            </th>
                            @if($title=='Rejected Post Dated Cheque Received List')
                                <th scope="col" class="tbl_txt_34">
                                    Reason
                                </th>
                            @else
                                <th scope="col"
                                    class="{{ ($title=='Pending Post Dated Cheque Issue List') ? 'tbl_txt_34' : 'tbl_txt_34' }} ">
                                    Remarks
                                </th>
                            @endif
                            <th scope="col" class="tbl_amnt_10">
                                Amount
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            @if($title=='Pending Post Dated Cheque Received List')
                                <th scope="col" class="tbl_srl_4 hide_column">
                                    Action
                                </th>
                            @endif
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
                        @forelse($datas as $cheque)

                            <tr>
                                <td>
                                    {{$sr}}
                                </td>
                                <td>
                                    {{$cheque->pdc_id}}
                                </td>
                                <td>
                                    {{date('d-M-y', strtotime(str_replace('/', '-', $cheque->pdc_cheque_date)))}}
                                </td>
                                <td>
                                    {{$cheque->from}}
                                </td>
                                <td>
                                    {{$cheque->to}}
                                </td>
                                @if($title=='Rejected Post Dated Cheque Received List')
                                    <td>
                                        {{$cheque->pdc_reason}}
                                    </td>
                                @else
                                    <td class="{{ ($title=='Pending Post Dated Cheque Issue List') ? 'tbl_txt_34' : 'tbl_txt_34' }} ">
                                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $cheque->pdc_remarks) !!}
                                    </td>
                                @endif
                                @php
                                    $ttlPrc = +($cheque->pdc_amount) + +$ttlPrc;
                                @endphp
                                <td class="text-right">
                                    {{ number_format($cheque->pdc_amount,2) }}
                                </td>

                                @php
                                    $ip_browser_info= ''.$cheque->pdc_ip_adrs.','.str_replace(' ','-',$cheque->pdc_brwsr_info).'';
                                @endphp

                                <td class="align_left usr_prfl text-left" data-usr_prfl="{{ $cheque->user_id }}"
                                    data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $cheque->user_name }}
                                </td>

                                @if($title=='Pending Post Dated Cheque Received List')
                                    <td class="text-center hide_column">
                                        <a class="btn btn-sm btn-success approve rjct_acpt_btn"
                                           data-id="{{$cheque->pdc_id}}"
                                           data-send_by_account="{{$cheque->pdc_account_code}}"
                                           data-send_by_account_name="{{$cheque->from}}"
                                           data-receive_by_account="{{$cheque->pdc_party_code}}"
                                           data-receive_by_account_name="{{$cheque->to}}"
                                           data-amount="{{$cheque->pdc_amount}}"
                                           data-cheque_date="{{$cheque->pdc_cheque_date}}"
                                           data-remarks="{{$cheque->pdc_remarks}}">
                                            <i class="fa fa-check approve"></i>
                                        </a>
                                        <a class="btn btn-sm btn-danger reject rjct_acpt_btn"
                                           data-id="{{$cheque->pdc_id}}" data-toggle="modal"
                                           data-target="#exampleModal">
                                            <i class="fa fa-ban reject"></i>
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
                                    <center><h3 style="color:#554F4F">No Entry</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                        <tfoot>
                        <tr>
                            <th colspan="6" class="text-right border-0">
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
                    <div class="col-md-9 text-right"><span
                            class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

    @if($title=='Pending Post Dated Cheque Received List')
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reject Transaction</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route("reject_post_dated_cheque_received")}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Reason:</label>
                                <textarea class="form-control" id="reason" name="reason" required></textarea>

                                <input type="hidden" name="reject" id="reject">
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

        <form name="approve_form" id="approve_form" action="{{route("approve_post_dated_cheque_received")}}"
              method="post">
            @csrf
            <input name="approve_id" id="approve_id" type="hidden">
            <input name="send_by_account" id="send_by_account" type="hidden">
            <input name="send_by_account_name" id="send_by_account_name" type="hidden">
            <input name="receive_by_account" id="receive_by_account" type="hidden">
            <input name="receive_by_account_name" id="receive_by_account_name" type="hidden">
            <input name="amount" id="amount" type="hidden">
            <input name="cheque_date" id="cheque_date" type="hidden">
            <input name="remarks" id="remarks" type="hidden">
        </form>
    @endif

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route($route) }}',
            url;

        @include('include.print_script_sh')

        jQuery("#from_accounts").select2();
        jQuery("#to_accounts").select2();
    </script>
    {{--    add code by shahzaib end --}}

    @if($title=='Pending Post Dated Cheque Received List')
        <script>
            jQuery(".approve").click(function () {

                var approve_id = jQuery(this).attr("data-id");
                var send_by_account = jQuery(this).attr("data-send_by_account");
                var send_by_account_name = jQuery(this).attr("data-send_by_account_name");
                var receive_by_account = jQuery(this).attr("data-receive_by_account");
                var receive_by_account_name = jQuery(this).attr("data-receive_by_account_name");
                var amount = jQuery(this).attr("data-amount");
                var cheque_date = jQuery(this).attr("data-cheque_date");
                var remarks = jQuery(this).attr("data-remarks");

                jQuery("#approve_id").val(approve_id);
                jQuery("#send_by_account").val(send_by_account);
                jQuery("#send_by_account_name").val(send_by_account_name);
                jQuery("#receive_by_account").val(receive_by_account);
                jQuery("#receive_by_account_name").val(receive_by_account_name);
                jQuery("#amount").val(amount);
                jQuery("#cheque_date").val(cheque_date);
                jQuery("#remarks").val(remarks);
                jQuery("#approve_form").submit();
            });


            jQuery(".reject").click(function () {
                var reject = jQuery(this).attr("data-id");
                jQuery("#reject").val(reject);
            });
        </script>
    @endif

    <script>
        jQuery("#cancel").click(function () {

            $("#from_accounts").select2().val(null).trigger("change");
            $("#from_accounts > option").removeAttr('selected');

            $("#to_accounts").select2().val(null).trigger("change");
            $("#to_accounts > option").removeAttr('selected');

            $("#search").val('');
            $("#to").val('');
            $("#from").val('');
        });
    </script>

@endsection

