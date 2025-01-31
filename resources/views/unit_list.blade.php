@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage" id="">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text file_name">Unit List</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
        <!-- <div class="search_form {{ ( !empty($search) || !empty($search_main_unit) ) ? '' : 'search_form_hidden' }}"> -->
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm" action="{{ route('unit_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1" id="form1"
                      method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label>
                                    All Column Search
                                </label>
                                <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..."
                                       value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                <datalist id="browsers">
                                    @foreach($unit as $value)
                                        <option value="{{$value}}">
                                    @endforeach
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div> <!-- left column ends here -->
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label>
                                    Select Main Unit
                                </label>
                                <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="main_unit" id="main_unit">
                                    <option value="">Select Main Unit</option>
                                    @foreach($main_units as $main_unit)
                                        <option value="{{$main_unit->mu_id}}" {{ $main_unit->mu_id == $search_main_unit ? 'selected="selected"' : '' }}>{{$main_unit->mu_title}}</option>
                                    @endforeach
                                </select>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12 mt-4 form_controls text-right">
                        @include('include.clear_search_button')
                        <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('add_unit') }}"/>
                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div>
                </form>
                <form name="edit" id="edit" action="{{ route('edit_unit') }}" method="post">
                    @csrf
                    <input tabindex="-1" name="main_unit" id="main_unit" type="hidden">
                    <input tabindex="-1" name="unit_title" id="unit_title" type="hidden">
                    <input name="unit_allow_decimal" id="unit_allow_decimal" type="hidden">
                    <input name="unit_symbol" id="unit_symbol" type="hidden">
                    <input name="remarks" id="remarks" type="hidden">
                    <input name="main_unit_id" id="main_unit_id" type="hidden">
                    <input name="unit_id" id="unit_id" type="hidden">
                    <input name="size" id="size" type="hidden">
                </form>
                <form name="delete" id="delete" action="{{ route('delete_unit') }}" method="post">
                    @csrf
                    <input name="unit_id" id="del_unit_id" type="hidden">
                </form>
            </div><!-- search form end -->
            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">
                    <thead>
                    <tr>
                        <th scope="col" class="tbl_srl_4">
                            ID
                        </th>
                        <th scope="col" class="tbl_txt_20">
                            Main Unit
                        </th>
                        <th scope="col" class="tbl_txt_20">
                            Unit Title
                        </th>
                        <th scope="col" class="tbl_txt_20">
                            Unit Symbol
                        </th>
                        <th scope="col" class="tbl_amnt_5">
                            Packing Size
                        </th>
                        <th scope="col" class="tbl_txt_25">
                            Remarks
                        </th>
                        <th scope="col" class="tbl_txt_8">
                            Created By
                        </th>
                        <th scope="col" class="hide_column tbl_srl_4">
                            Enable
                        </th>
                        <th scope="col" class="hide_column tbl_srl_4">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                        $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                        $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                        $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                    @endphp
                    @forelse($datas as $unit)
                        <tr data-main_unit="{{$unit->mu_title}}" data-unit_title="{{$unit->unit_title}}" data-unit_allow_decimal="{{$unit->unit_allow_decimal}}"
                            data-unit_symbol="{{$unit->unit_symbol}}" data-remarks="{{$unit->unit_remarks}}" data-main_unit_id="{{$unit->mu_id}}" data-unit_id="{{$unit->unit_id}}"
                            data-size="{{$unit->unit_scale_size}}">
                            <th scope="row" class="edit ">
                                {{$unit->unit_id}}
                            </th>
                            <td class="edit ">
                                {{$unit->mu_title}}
                            </td>
                            <td class="edit ">
                                {{$unit->unit_title}}
                            </td>
                            <td class="edit ">
                                {{$unit->unit_symbol}}
                            </td>
                            <td class="edit ">
                                {{$unit->unit_scale_size}}
                            </td>
                            <td class="edit ">
                                {{$unit->unit_remarks}}
                            </td>

                            @php
                                $ip_browser_info= ''.$unit->unit_ip_adrs.','.str_replace(' ','-',$unit->unit_brwsr_info).'';
                            @endphp

                            <td class="usr_prfl" data-usr_prfl="{{ $unit->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{ $unit->user_name }}
                            </td>


                            {{--    add code by mustafa start --}}
                            <td class="text-center hide_column ">
                                <label class="switch">
                                    <input type="checkbox" <?php if ($unit->unit_disabled == 0) {
                                        echo 'checked="true"' . ' ' . 'value=' . $unit->unit_disabled;
                                    } else {
                                        echo 'value=DISABLE';
                                    } ?>  class="enable_disable" data-id="{{$unit->unit_id}}"
                                        {{ $unit->unit_disabled == 0 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            {{--    add code by mustafa end --}}


                            <td class="text-center hide_column ">
                                <a data-unit_id="{{$unit->unit_id}}" class="delete" data-toggle="tooltip" data-placement="left" title="" data-original-title="Are you sure?">
                                    <i class="fa fa-{{$unit->unit_delete_status == 1 ? 'undo':'trash'}}"></i>
                                </a>
                            </td>

                        </tr>
                        @php
                            $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center><h3 style="color:#554F4F">No Unit</h3></center>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>

            </div>
            <div class="row">
                <div class="col-md-3">
                    <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                </div>
                <div class="col-md-9 text-right">
                    <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'main_unit'=>$search_main_unit ])->links() }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')



    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('unit_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    {{--    add code by mustafa start --}}
    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let unitId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_unit') }}',
                    data: {'status': status, 'unit_id': unitId},
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>
    {{--    add code by mustafa end --}}


    <script>
        jQuery(".edit").click(function () {

            var main_unit = jQuery(this).parent('tr').attr("data-main_unit");
            var unit_title = jQuery(this).parent('tr').attr("data-unit_title");
            var unit_allow_decimal = jQuery(this).parent('tr').attr("data-unit_allow_decimal");
            var unit_symbol = jQuery(this).parent('tr').attr("data-unit_symbol");
            var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var main_unit_id = jQuery(this).parent('tr').attr("data-main_unit_id");
            var unit_id = jQuery(this).parent('tr').attr("data-unit_id");
            var size = jQuery(this).parent('tr').attr("data-size");

            jQuery("#main_unit").val(main_unit);
            jQuery("#unit_title").val(unit_title);
            jQuery("#unit_allow_decimal").val(unit_allow_decimal);
            jQuery("#unit_symbol").val(unit_symbol);
            jQuery("#remarks").val(remarks);
            jQuery("#main_unit_id").val(main_unit_id);
            jQuery("#unit_id").val(unit_id);
            jQuery("#size").val(size);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var unit_id = jQuery(this).attr("data-unit_id");

            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
            }).then(function (result) {

                if (result.value) {
                    jQuery("#del_unit_id").val(unit_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });


    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#main_unit").select2().val(null).trigger("change");
            $("#main_unit > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#main_unit").select2();
        });
    </script>

@endsection

