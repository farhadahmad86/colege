@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Update Fee Voucher Number</h4>
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
                    <form class="highlight prnt_lst_frm" action="{{ route('update_fee_voucher_no') }}" name="form1"
                          id="form1" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                <div class="row">
                                    <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input tabindex="1" autofocus type="search" list="browsers"
                                                   class="inputs_up form-control" name="search" id="search"
                                                   placeholder="Search ..." value="{{ isset($search) ? $search : '' }}"
                                                   autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach ($students as $value)
                                                    <option value="{{ $value }}">
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Class
                                            </label>
                                            <select tabindex="4" name="class"
                                                    class="inputs_up form-control" id="class">
                                                <option value="">Select Class</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->class_id }}"
                                                        {{ $class->class_id == $search_class ? 'selected="selected"' : '' }}>
                                                        {{ $class->class_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Section
                                            </label>
                                            <select tabindex="4" name="section"
                                                    class="inputs_up form-control" id="section">
                                                <option value="">Select Section</option>
                                                @foreach ($sections as $section)
                                                    <option value="{{ $section->cs_id }}"
                                                        {{ $section->cs_id == $search_section ? 'selected="selected"' : '' }}>
                                                        {{ $section->cs_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Month
                                            </label>
                                            <select tabindex="4" name="month"
                                                    class="inputs_up form-control" id="month">
                                                <option value="">Select Month</option>
                                                @foreach ($months as $month)
                                                    <option value="{{ $month->fv_month }}"
                                                        {{ $month->fv_month == $search_month ? 'selected="selected"' : '' }}>
                                                        {{ $month->fv_month }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mt-lg-4 text-right">
                                    @include('include.clear_search_button')

                                    <!-- Call add button component -->
                                        <x-add-button tabindex="9" href="{{ route('fee_voucher') }}"/>
{{--                                        @include('include/print_button')--}}
                                    </div>

                                </div>
                            </div>

                        </div>
                    </form>
                </div><!-- search form end -->

                <form name="f1" id="f1" action="{{ route('submit_fee_voucher_no') }}" method="post">
                    @csrf
                    <div class="table-responsive" id="printTable">
                        <table class="table table-bordered table-sm" id="fixTable">

                            <thead>
                            <tr>
                                <th tabindex="-1" scope="col" class="tbl_srl_4">
                                    Sr#
                                </th>

                                <th scope="col" class="tbl_amnt_10">
                                    Date
                                </th>
                                <th tabindex="-1" scope="col" class="tbl_txt_15">
                                    Registration
                                </th>
                                <th tabindex="-1" scope="col" class="tbl_txt_15">
                                    Student Name
                                </th>
                                <th tabindex="-1" scope="col" class="tbl_txt_15">
                                    Class
                                </th>
                                <th scope="col" class="tbl_amnt_10">
                                    Total Amount
                                </th>
                                <th scope="col" class="tbl_amnt_6">
                                    Voucher#
                                </th>
                                <th scope="col" class="tbl_txt_8">
                                    New Voucher No
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
                                @php $per_page_ttl_amnt = +$voucher->fv_total_amount + +$per_page_ttl_amnt; @endphp

                                <tr>
                                    <th scope="row">
                                        {{ $sr }}
                                        <input type="hidden" name="v_id[]" value="{{ $voucher->fv_id }}" class="form-control">
                                        <input type="hidden" name="v_no[]" value="{{ $voucher->fv_v_no }}" class="form-control">
                                    </th>
                                    <td>
                                        {{ $voucher->fv_month }}
                                    </td>

                                    <td>
                                        {{ $voucher->registration_no }}
                                    </td>
                                    <td>
                                        {{ $voucher->full_name }}
                                    </td>
                                    <td>
                                        {{ $voucher->class_name }}
                                    </td>

                                    <td class="align_right text-right">
                                        {{ $voucher->fv_total_amount != 0 ? number_format($voucher->fv_total_amount, 2) : '' }}
                                    </td>
                                    <td>
                                        {{ $voucher->fv_v_no }}
                                    </td>
                                    <td>
                                        <input type="text" name="voucher_no[]" class="form-control">
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
                                            <h3 style="color:#554F4F">No voucher</h3>
                                        </center>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>

                            <tfoot>
                            <tr class="border-0">
                                <th colspan="5" align="right" class="border-0 text-right align_right pt-0">
                                    Per Page Total:
                                </th>
                                <td class="text-right border-left-0" align="right"
                                    style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                                    {{ number_format($per_page_ttl_amnt, 2) }}
                                </td>
                            </tr>
                            <tr class="border-0">
                                <th colspan="5" align="right" class="border-0 text-right align_right pt-0">
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
                    <button tabindex="101" type="submit" name="save" id="save2" class="save_button btn btn-sm btn-success">
                        <i class="fa fa-floppy-o"></i> Save
                    </button>
                </form>
                <div class="row">
                    <div class="col-md-3">
{{--                        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>--}}
                    </div>
                    <div class="col-md-9 text-right">
{{--                        <span class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'class' => $search_class, 'month' => $search_month])->links() }}</span>--}}
                    </div>
                </div>
            </div> <!-- white column form ends here -->

        </div><!-- col end -->

    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('update_fee_voucher_no') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    <script>
        jQuery("#save2").click(function () {
            jQuery(".pre-loader").fadeToggle("medium");
        });
            jQuery("#cancel").click(function () {

                $("#search").val('');
                $("#section").val('');
                $("#to").val('');
                $("#from").val('');

                $("#class").select2().val(null).trigger("change");
                $("#class > option").removeAttr('selected');
                $("#section").select2().val(null).trigger("change");
                $("#section > option").removeAttr('selected');
                $("#month").select2().val(null).trigger("change");
                $("#month > option").removeAttr('selected');
            });

        jQuery("#class").select2();
        jQuery("#month").select2();
        jQuery("#section").select2();
    </script>
@endsection
