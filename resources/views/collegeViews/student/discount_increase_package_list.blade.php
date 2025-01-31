@extends('extend_index')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Discount / Increment Package List</h4>
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
                    <form class="highlight prnt_lst_frm" action="{{ route('discount_increase_package_list') }}" name="form1"
                          id="form1" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers"
                                           class="inputs_up form-control" name="search" id="search"
                                           placeholder="All Data Search" value="{{ isset($search) ? $search : '' }}"
                                           autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach ($student_title as $value)
                                            <option value="{{ $value }}">
                                        @endforeach
                                    </datalist>
                                </div>
                            </div> <!-- left column ends here -->
                            <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
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

                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
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
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12 text-right mt-4">
                                    @include('include.clear_search_button')
                                    <!-- Call add button component -->
{{--                                        <x-add-button tabindex="9" href="{{ route('bill_of_labour_voucher') }}"/>--}}
                                        @include('include/print_button')

                                        <span id="demo1" class="validate_sign"
                                              style="float: right !important"> </span>
                                    </div>
                                </div>
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
                            <th scope="col" class="tbl_srl_4">
                                File
                            </th>
                            <th scope="col" class="tbl_srl_6">
                                Date
                            </th>
                            <th scope="col" class="tbl_txt_20">
                                Student
                            </th>
                            <th scope="col" class="tbl_txt_20">
                                Class
                            </th>
                            <th scope="col" class="tbl_amnt_4">
                                Section
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Entry Type
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                               Amount
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Branch
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Action
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
                            @php $per_page_ttl_amnt = +$voucher->di_amount + +$per_page_ttl_amnt; @endphp

                            <tr>
                                <th scope="row" class="edit">
                                    {{ $sr }}
                                </th>

                                <td>
                                    <a href="{{$voucher->di_image}}"><img src="{{$voucher->di_image}}" style="height: 40px;"/></a>
                                </td>
                                <td>
                                    {{ date('d-M-y', strtotime(str_replace('/', '-', $voucher->di_created_datetime))) }}
                                </td>
                                <td>
                                    {!! $voucher->full_name !!}
                                </td>
                                <td>
                                    {!! $voucher->class_name !!}
                                </td>
                                <td>
                                    {!! $voucher->cs_name !!}
                                </td>
                                <td>
                                    {!! $voucher->di_entry_type == 1 ? 'Discount': 'Increase' !!}
                                </td>

                                <td class="align_right text-right">
                                    {{ $voucher->di_amount != 0 ? number_format($voucher->di_amount, 2) : '' }}
                                </td>
                                <td>
                                    {{ $voucher->branch_name }}
                                </td>

                                <td class="usr_prfl"
                                    data-usr_prfl="{{ $voucher->user_id }}"
                                    title="Click To See User Detail">
                                    {{ $voucher->user_name }}
                                </td>
                                <td class="text-center"
                                    title="Click To Post Voucher">
                                    <form method="post" action="{{ route('post_discount_increment_package',$voucher->di_id) }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $voucher->di_id }}">
                                        <input type="hidden" name="student_id" value="{{ $voucher->di_std_id }}">
                                        <input type="hidden" name="package_id" value="{{ $voucher->di_sp_id }}">
                                        <input type="hidden" name="entry_type" value="{{ $voucher->di_entry_type }}">
                                        <input type="hidden" name="amount" value="{{ $voucher->di_amount }}">
                                        <button type="submit" class="btn btn-primary fianlize">Posting</button>

                                    </form>
                                </td>
                            </tr>
                            @php
                                $sr++;
                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="13">
                                    <center>
                                        <h3 style="color:#554F4F">No Voucher</h3>
                                    </center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                        <tfoot>
                        <tr class="border-0">
                            <th colspan="7" align="right" class="border-0 text-right align_right pt-0">
                                Per Page Total:
                            </th>
                            <td class="text-right border-left-0" align="right"
                                style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                                {{ number_format($per_page_ttl_amnt, 2) }}
                            </td>
                        </tr>
                        <tr class="border-0">
                            <th colspan="7" align="right" class="border-0 text-right align_right pt-0">
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
                <span
                    class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search, 'class' => $search_class, 'section' => $search_section])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->


@endsection

@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('discount_increase_package_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery(".edit").click(function () {

            var account_id = jQuery(this).attr("data-id");

            jQuery("#account_id").val(account_id);
            jQuery("#edit").submit();
        });

        $('.fianlize').click(function () {
            jQuery(".pre-loader").fadeToggle("medium");
        });
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#search").val('');

            $("#class").select2().val(null).trigger("change");
            $("#class > option").removeAttr('selected');
            $("#section").select2().val(null).trigger("change");
            $("#section > option").removeAttr('selected');
        });

        jQuery("#class").select2();
        jQuery("#section").select2();
    </script>
@endsection
