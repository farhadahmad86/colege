@extends('extend_index')

@section('content')
    {{--    <div class="container">--}}
    {{--        <div class="content-justify-center row">--}}
    {{--            <div class="col-md-12">--}}

    {{--                <div class="card">--}}
    {{--                    <div class="card-header">--}}
    {{--                        <h3 class="m-0">--}}
    {{--                            Zones <small>({{ $zones->total() }})</small>--}}
    {{--                            <a href="{{ route('zones.create') }}" class="btn btn-sm btn-primary float-right">Create</a>--}}
    {{--                        </h3>--}}
    {{--                    </div>--}}
    {{--                    <div class="card-body">--}}
    {{--                        @include('modules.prerequisites.zone._table')--}}
    {{--                    </div>--}}
    {{--                </div>--}}

    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <div class="row">

        @php
            $company_info = Session::get('company_info');
            if(isset($company_info) || !empty($company_info)){
                $win = $company_info->info_bx;
            }else{
                $win = '';
            }

        @endphp
        <div
            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"
            id="main_col" data-win="{{ ($win === 'full') ? 'min' : 'full' }} " data-win-time="0">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                <div class="close_info_bx"><!-- info bx start -->
                    <i class="fa fa-expand"></i>
                </div><!-- info bx end -->

                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Region List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

{{--                <div class="search_form  {{ ( !empty($search) || !empty($search_company) || !empty($search_region) ) ? '' : --}}
{{-- 'search_form_hidden' }}">--}}
                <div
                    class="search_form">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                            <form class="prnt_lst_frm"
                                  action="{{ route('zones.list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}"
                                  name="form1" id="form1" method="post">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input tabindex="1" autofocus type="search" list="browsers"
                                                   class="inputs_up form-control all_clm_srch" name="search" id="search"
                                                   placeholder="Search ..." value="{{ isset($search) ? $search : '' }}"
                                                   autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($zone_title as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                            <span id="demo1" class="validate_sign"
                                                  style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Company
                                                    </label>
                                                    <select tabindex="3" class="inputs_up form-control cstm_clm_srch" name="company"
                                                            id="company">
                                                        <option value="">Select Company</option>
                                                        @foreach($companies as $company)
                                                            <option
                                                                value="{{$company->account_uid}}" {{ $company->account_uid == $search_company ? 'selected="selected"' : '' }}>{{$company->account_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign"
                                                          style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Region
                                                    </label>
                                                    <select tabindex="4" class="inputs_up form-control cstm_clm_srch" name="region"
                                                            id="region">
                                                        <option value="">Select Region</option>
                                                        @foreach($regions as $region)
                                                            <option
                                                                value="{{$region->id}}" {{ $region->id == $search_region ? 'selected="selected"' : '' }}>{{$region->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign"
                                                          style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button tabindex="5" type="button" type="button" name="cancel" id="cancel"
                                                            class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button tabindex="6" type="submit" name="filter_search" id="filter_search"
                                                            class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    <a tabindex="7" class="save_button form-control"
                                                       href="{{ route('zones.create') }}" role="button">
                                                        <l class="fa fa-plus"></l>
                                                        Region
                                                    </a>

                                                    @include('include/print_button')

                                                    <span id="demo1" class="validate_sign"
                                                          style="float: right !important"> </span>

                                                </div>
                                            </div>

                                        </div><!-- end row -->
                                    </div>
                                </div><!-- end row -->
                            </form>


                            {{--                            <form name="edit" id="edit" action="{{ route('edit_sector') }}" method="post">--}}
                            {{--                                @csrf--}}
                            {{--                                <input tabindex="-1" name="region_id" id="region_id" type="hidden">--}}
                            {{--                                <input tabindex="-1" name="company_title" id="company_title" type="hidden">--}}
                            {{--                                <input tabindex="-1" name="zone_title" id="zone_title" type="hidden">--}}
                            {{--                                <input tabindex="-1" name="remarks" id="remarks" type="hidden">--}}
                            {{--                                <input tabindex="-1" name="zone_id" id="zone_id" type="hidden">--}}
                            {{--                                <input tabindex="-1" name="company_id" id="company_id" type="hidden">--}}

                            {{--                            </form>--}}

                            <form name="delete" id="delete" action="{{ route('zones.destroy') }}" method="post">
                                @csrf
                                @method('delete')
                                <input tabindex="-1" name="zone_id" id="del_zone_id" type="hidden">

                            </form>


                        </div>
                    </div>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">Sr#</th>
{{--                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">ID</th>--}}
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_10">Company Title
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_12">Zone Title</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_12">Region Title</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_12">Zonal Name</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_10">Zonal Contact </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_20">Remarks</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_6">Created By</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4 hide_column">
                                Enable
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_6 hide_column">
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
                        @forelse($datas as $zone)

                            <tr data-region_id="{{$zone->region_id}}" data-company_title="{{$zone->account_name}}"
                                data-zone_title="{{$zone->name}}" data-remarks="{{$zone->remarks}}"
                                data-company_id="{{$zone->company_id}}" data-zone_id="{{$zone->zone_id}}">
                                {{--<tr>--}}
                                <td class="text-center align_center edit tbl_srl_4">
                                    {{$sr}}
                                </td>
{{--                                <td class="text-center align_center edit tbl_srl_4">--}}
{{--                                    {{$zone->account_id}}--}}
{{--                                </td>--}}
                                <td class="align_left text-left edit tbl_txt_10">
                                    {{$zone->account_name}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_12">
                                    {{$zone->reg_name}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_12">
                                    {{$zone->zone_name}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_12">
                                    {{$zone->zonal_name}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_10">
                                    {{$zone->zonal_contact}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_20">
                                    {{$zone->remarks}}
                                </td>
                                {{--                                @php--}}
                                {{--                                    $ip_browser_info= ''.$zone->sec_ip_adrs.','.str_replace(' ','-',$zone->sec_brwsr_info).'';--}}
                                {{--                                @endphp--}}

                                <td class="align_left text-left usr_prfl tbl_txt_6" data-usr_prfl="{{ $zone->user_id }}"
                                    title="Click To See User Detail">
                                    {{ $zone->user_name }}
                                </td>

                                <td class="align_right text-right hide_column tbl_amnt_4">
                                    {{$zone->status}}
                                </td>

                                <td class="align_center  text-right hide_column tbl_srl_6">


                                    <a href="{{ route('zones.edit', $zone->zone_id) }}"
                                       class="float-left" data-toggle="tooltip"
                                       data-placement="left" title="" data-original-title="Are you sure want to edit?"><i
                                            class="fa fa-edit"></i></a>

                                    <a data-zone_id="{{$zone->zone_id}}" class="delete" data-toggle="tooltip"
                                       data-placement="left" title="" data-original-title="Are you sure want to delete?">
                                        {{--                                        <i class="fa fa-{{$zone->area_delete_status == 1 ? 'undo':'trash'}}"></i>--}}
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                                {{--                                data-zone_id="{{$zone->id}}"--}}


                                {{----}}
                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Region</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>
                <span
                    class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'company'=>$search_company, 'region'=>$search_region ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->


@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('zones.list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    <script>
        // jQuery(".edit").click(function () {
        //
        //     var region_id = jQuery(this).parent('tr').attr("data-region_id");
        //     var company_title = jQuery(this).parent('tr').attr("data-company_title");
        //     var zone_title = jQuery(this).parent('tr').attr("data-zone_title");
        //     var remarks = jQuery(this).parent('tr').attr("data-remarks");
        //     var company_id = jQuery(this).parent('tr').attr("data-company_id");
        //     var zone_id = jQuery(this).parent('tr').attr("data-zone_id");
        //
        //     jQuery("#region_id").val(region_id);
        //     jQuery("#company_title").val(company_title);
        //     jQuery("#zone_title").val(zone_title);
        //     jQuery("#remarks").val(remarks);
        //     jQuery("#company_id").val(company_id);
        //     jQuery("#zone_id").val(zone_id);
        //     jQuery("#edit").submit();
        // });

        $('.delete').on('click', function (event) {

            var zone_id = jQuery(this).attr("data-zone_id");

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
                    jQuery("#del_zone_id").val(zone_id);
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
