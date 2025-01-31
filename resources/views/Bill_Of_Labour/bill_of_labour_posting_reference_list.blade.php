@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage" id="">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text file_name">Bill Of Labour Posting Reference List</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->

            <!-- <div class="search_form {{ !empty($search) || !empty($search_to) || !empty($search_from) ? '' : 'search_form_hidden' }}"> -->

            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm" action="{{ route('bill_of_labour_voucher_posting_ref_list') }}"
                      name="form1"
                      id="form1" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <!-- start input box -->
                                <label>
                                    All Column Search
                                </label>
                                <input tabindex="1" autofocus type="search" class="inputs_up form-control"
                                       name="search" id="search" placeholder="Search ..."
                                       value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                <span id="demo1" class="validate_sign" style="float: right !important">
                                        </span>
                            </div>
                        </div> <!-- left column ends here -->
                        <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label>
                                            Account
                                        </label>
                                        <select tabindex="4" name="account"
                                                class="inputs_up form-control" id="account">
                                            <option value="">Select Account</option>
                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->account_uid }}"
                                                    {{ $account->account_uid == $search_account ? 'selected="selected"' : '' }}>
                                                    {{ $account->account_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label>
                                            Posting References
                                        </label>
                                        <select tabindex="4" name="posting_reference"
                                                class="inputs_up form-control" id="posting_reference">
                                            <option value="">Select Posting Reference</option>
                                            @foreach ($posting_references as $posting_reference)
                                                <option value="{{ $posting_reference->pr_id }}"
                                                    {{ $posting_reference->pr_id == $search_posting_reference ? 'selected="selected"' : '' }}>
                                                    {{ $posting_reference->pr_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label>
                                            Start Date
                                        </label>
                                        <input tabindex="2" type="text" name="to" id="to"
                                               class="inputs_up form-control datepicker1" autocomplete="off"
                                               <?php if (isset($search_to)){ ?> value="{{ $search_to }}" <?php } ?>
                                               placeholder="Start Date ......"/>
                                        <span id="demo1" class="validate_sign"
                                              style="float: right !important"> </span>
                                    </div>
                                </div>

                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label>
                                            End Date
                                        </label>
                                        <input tabindex="3" type="text" name="from" id="from"
                                               class="inputs_up form-control datepicker1" autocomplete="off"
                                               <?php if (isset($search_from)){ ?> value="{{ $search_from }}" <?php } ?>
                                               placeholder="End Date ......"/>
                                        <span id="demo1" class="validate_sign"
                                              style="float: right !important"> </span>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 mt-lg-4 text-right">
                                    @include('include.clear_search_button')
                                    <!-- Call add button component -->
                                    <x-add-button tabindex="9" href="{{ route('bill_of_labour_voucher') }}"/>
                                    @include('include/print_button')
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- search form end -->


            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">
                    <thead>
                    <tr>
                        <th scope="col" class="tbl_srl_4">
                            Sr#
                        </th>
                        <th scope="col" class="tbl_amnt_10">
                            Date
                        </th>

                        <th scope="col" class="tbl_amnt_6">
                            Voucher#
                        </th>
                        <th scope="col" class="tbl_amnt_15">
                            Account
                        </th>
                        <th tabindex="-1" scope="col" class="tbl_txt_15">
                            Posting ref.
                        </th>
                        <th scope="col" class="tbl_txt_20">
                            Remarks
                        </th>
                        <th scope="col" class="tbl_txt_10">
                            QTY
                        </th>
                        <th scope="col" class="tbl_txt_10">
                            Rate
                        </th>
                        <th scope="col" class="tbl_amnt_15">
                            Amount
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                        $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                        $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                        $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                        $per_page_ttl_amnt = 0;
                    @endphp
                    @forelse($datas as $voucher)
                        @php $per_page_ttl_amnt = +$voucher->bli_amount + +$per_page_ttl_amnt; @endphp
                        <tr>
                            <th scope="row">
                                {{ $sr }}
                            </th>
                            <td>
                                {{ date('d-M-y', strtotime(str_replace('/', '-', $voucher->bl_day_end_date))) }}
                            </td>
                            <td>
                                BLV-{{ $voucher->bli_voucher_id }}
                            </td>
                            <td>
                                {{ $voucher->bli_account_name }}
                            </td>
                            <td>
                                {{ $voucher->pr_name }}
                            </td>
                            <td>
                                {{ $voucher->bli_remarks }}
                            </td>
                            <td>
                                {!! $voucher->bli_qty !!}
                            </td>
                            <td>
                                {!! $voucher->bli_rate !!}
                            </td>
                            <td class="align_right text-right">
                                {{ $voucher->bli_amount != 0 ? number_format($voucher->bli_amount, 2) : '' }}
                            </td>

                        </tr>
                        @php
                            $sr++;
                            !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center>
                                    <h3 style="color:#554F4F">No Voucher</h3>
                                </center>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                    <tfoot>
                    <tr class="border-0">
                        <th colspan="8" align="right" class="border-0 text-right align_right pt-0">
                            Per Page Total:
                        </th>
                        <td class="text-right border-left-0" align="right"
                            style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                            {{ number_format($per_page_ttl_amnt, 2) }}
                        </td>
                    </tr>
                    <tr class="border-0">
                        <th colspan="8" align="right" class="border-0 text-right align_right pt-0">
                            Grand Total:
                        </th>
                        <td class="text-right border-left-0" align="right"
                            style="border-bottom: 2px solid #000;border-bottom: 3px double #000;border-right: 0 solid transparent;">
                            {{ number_format($ttl_amnt, 2) }}
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
                        class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search, 'posting_reference'=>$search_posting_reference,'to' => $search_to, 'from' => $search_from])->links() }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('bill_of_labour_voucher_posting_ref_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    <script>
        jQuery("#cancel").click(function () {

            $("#search").val('');
            $("#to").val('');
            $("#from").val('');

            $("#account").select2().val(null).trigger("change");
            $("#account > option").removeAttr('selected');
            $("#posting_reference").select2().val(null).trigger("change");
            $("#posting_reference > option").removeAttr('selected');
        });

        jQuery("#account").select2();
        jQuery("#posting_reference").select2();
    </script>
@endsection
