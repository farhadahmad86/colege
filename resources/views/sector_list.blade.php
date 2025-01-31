@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Sector List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


            <!-- <div class="search_form  {{ ( !empty($search) || !empty($search_area) || !empty($search_region) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('sector_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1" id="form1"
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
                                        @foreach($sec_title as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Select Region
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="region" id="region">
                                        <option value="">Select Region</option>
                                        @foreach($regions as $region)
                                            <option value="{{$region->reg_id}}" {{ $region->reg_id == $search_region ? 'selected="selected"' : '' }}>{{$region->reg_title}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Select Area
                                    </label>
                                    <select tabindex="3" class="inputs_up form-control cstm_clm_srch" name="area" id="area">
                                        <option value="">Select Area</option>
                                        @foreach($areas as $area)
                                            <option value="{{$area->area_id}}" {{ $area->area_id == $search_area ? 'selected="selected"' : '' }}>{{$area->area_title}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-4 form_controls text-right">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                                <x-add-button tabindex="9" href="{{ route('add_sector') }}"/>

                                @include('include/print_button')

                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div><!-- end row -->
                    </form>


                    <form name="edit" id="edit" action="{{ route('edit_sector') }}" method="post">
                        @csrf
                        <input name="region_id" id="region_id" type="hidden">
                        <input name="area_title" id="area_title" type="hidden">
                        <input name="sector_title" id="sector_title" type="hidden">
                        <input name="remarks" id="remarks" type="hidden">
                        <input name="sector_id" id="sector_id" type="hidden">
                        <input name="area_id" id="area_id" type="hidden">

                    </form>

                    <form name="delete" id="delete" action="{{ route('delete_sector') }}" method="post">
                        @csrf
                        <input name="sector_id" id="del_sector_id" type="hidden">

                    </form>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">ID</th>
                            <th scope="col" class="tbl_txt_16">Region Title</th>
                            <th scope="col" class="tbl_txt_17">Area Title</th>
                            <th scope="col" class="tbl_txt_17">Sector Title</th>
                            <th scope="col" class="tbl_txt_22">Remarks</th>
                            <th scope="col" class="tbl_txt_8">Created By</th>
                            <th scope="col" class="tbl_srl_6 hide_column">Enable</th>
                            <th scope="col" class="tbl_srl_6 hide_column">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                        @endphp
                        @forelse($datas as $sector)

                            <tr data-region_id="{{$sector->reg_id}}" data-area_title="{{$sector->area_title}}" data-sector_title="{{$sector->sec_title}}" data-remarks="{{$sector->sec_remarks}}"
                                data-area_id="{{$sector->area_id}}" data-sector_id="{{$sector->sec_id}}">

                                <th scope="row" class="edit tbl_srl_4">
                                    {{$sector->sec_id}}
                                </th>
                                <td class="edit ">
                                    {{$sector->reg_title}}
                                </td>
                                <td class="edit ">
                                    {{$sector->area_title}}
                                </td>
                                <td class="edit ">
                                    {{$sector->sec_title}}
                                </td>
                                <td class="edit ">
                                    {{$sector->sec_remarks}}
                                </td>
                                @php
                                    $ip_browser_info= ''.$sector->sec_ip_adrs.','.str_replace(' ','-',$sector->sec_brwsr_info).'';
                                @endphp

                                <td class="usr_prfl " data-usr_prfl="{{ $sector->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $sector->user_name }}
                                </td>

                                <td class="text-center hide_column ">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($sector->sec_disabled == 0) {
                                            echo 'checked="true"' . ' ' . 'value=' . $sector->sec_disabled;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?>  class="enable_disable" data-id="{{$sector->sec_id}}"
                                            {{ $sector->sec_disabled == 0 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                <td class="text-center hide_column ">
                                    <a data-sector_id="{{$sector->sec_id}}" class="delete" data-toggle="tooltip" data-placement="left" title="" data-original-title="Are you sure?">
                                        <i class="fa fa-{{$sector->sec_delete_status == 1 ? 'undo':'trash'}}"></i>
                                    </a>
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Sector</h3></center>
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
                        <span class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'area'=>$search_area, 'region'=>$search_region ])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('sector_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let secId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_sector') }}',
                    data: {'status': status, 'sec_id': secId},
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>

    <script>
        jQuery(".edit").click(function () {

            var region_id = jQuery(this).parent('tr').attr("data-region_id");
            var area_title = jQuery(this).parent('tr').attr("data-area_title");
            var sector_title = jQuery(this).parent('tr').attr("data-sector_title");
            var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var area_id = jQuery(this).parent('tr').attr("data-area_id");
            var sector_id = jQuery(this).parent('tr').attr("data-sector_id");

            jQuery("#region_id").val(region_id);
            jQuery("#area_title").val(area_title);
            jQuery("#sector_title").val(sector_title);
            jQuery("#remarks").val(remarks);
            jQuery("#area_id").val(area_id);
            jQuery("#sector_id").val(sector_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var sector_id = jQuery(this).attr("data-sector_id");

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
                    jQuery("#del_sector_id").val(sector_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });

    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#region").select2().val(null).trigger("change");
            $("#region > option").removeAttr('selected');

            $("#area").select2().val(null).trigger("change");
            $("#area > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#region").select2();
            jQuery("#area").select2();
        });
    </script>

@endsection

