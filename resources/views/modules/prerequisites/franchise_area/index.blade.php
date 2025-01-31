@extends('extend_index')

@section('content')
    {{--    <div class="container">--}}
    {{--        <div class="content-justify-center row">--}}
    {{--            <div class="col-md-12">--}}

    {{--                <div class="card">--}}
    {{--                    <div class="card-header">--}}
    {{--                        <h3 class="m-0">--}}
    {{--                            Franchise / Area <small>({{ $franchiseAreas->total() }})</small>--}}
    {{--                            <a href="{{ route('franchise-area.create') }}" class="btn btn-sm btn-primary float-right">Create</a>--}}
    {{--                        </h3>--}}
    {{--                    </div>--}}
    {{--                    <div class="card-body">--}}
    {{--                        @include('modules.prerequisites.franchise_area._table')--}}
    {{--                    </div>--}}
    {{--                </div>--}}

    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--@stop--}}




    {{--<div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">--}}

    {{--    <div class="close_info_bx"><!-- info bx start -->--}}
    {{--        <i class="fa fa-expand"></i>--}}
    {{--    </div><!-- info bx end -->--}}

    {{--    <div class="form_header"><!-- form header start -->--}}
    {{--        <div class="clearfix">--}}
    {{--            <div class="pull-left">--}}
    {{--                <h4 class="text-white get-heading-text file_name">Franchise / Area List</h4>--}}
    {{--            </div>--}}
    {{--            <div class="list_btn list_mul">--}}
    {{--                <div class="srch_box_opn_icon">--}}
    {{--                    <i class="fa fa-search"></i>--}}
    {{--                </div>--}}
    {{--            </div><!-- list btn -->--}}
    {{--        </div>--}}
    {{--    </div><!-- form header close -->--}}
    {{--   --}}
    {{--    @include('modules.prerequisites.franchise_area._table')--}}
    {{--   --}}
    {{--</div> <!-- white column form ends here -->--}}

    {{--@stop--}}
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
                            <h4 class="text-white get-heading-text file_name">Franchise / Area List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

{{--                <div--}}
{{--                        class="search_form  {{ ( !empty($search) || !empty($search_company) || !empty($search_region) ) ? '' : 'search_form_hidden' }}">--}}
{{--                    <div class="row">--}}
                <div
                    class="search_form">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <form class="prnt_lst_frm"
                                  action="{{ route('franchise-area.list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}"
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
                                                @foreach($franchise_areas_title as $value)
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
                                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="company"
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
                                                    <select tabindex="3" class="inputs_up form-control cstm_clm_srch" name="region"
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

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Zone
                                                    </label>
                                                    <select tabindex="4" class="inputs_up form-control cstm_clm_srch" name="zone"
                                                            id="zone">
                                                        <option value="">Select Zone</option>
                                                        @foreach($zones as $zone)
                                                            <option
                                                                value="{{$zone->id}}" {{ $zone->id == $search_zone ? 'selected="selected"' : '' }}>{{$zone->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign"
                                                          style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select City
                                                    </label>
                                                    <select tabindex="5" class="inputs_up form-control cstm_clm_srch" name="city"
                                                            id="city">
                                                        <option value="">Select City</option>
                                                        @foreach($cities as $city)
                                                            <option
                                                                value="{{$city->id}}" {{ $city->id == $search_city ? 'selected="selected"' : '' }}>{{$city->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign"
                                                          style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Grid
                                                    </label>
                                                    <select tabindex="6" class="inputs_up form-control cstm_clm_srch" name="grid"
                                                            id="grid">
                                                        <option value="">Select Grid</option>
                                                        @foreach($grids as $grid)
                                                            <option
                                                                value="{{$grid->id}}" {{ $grid->id == $search_grid ? 'selected="selected"' : '' }}>{{$grid->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign"
                                                          style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button tabindex="7" type="button" type="button" name="cancel" id="cancel"
                                                            class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button tabindex="-8" type="submit" name="filter_search" id="filter_search"
                                                            class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    <a tabindex="9" class="save_button form-control"
                                                       href="{{ route('franchise-area.create') }}" role="button">
                                                        <l class="fa fa-plus"></l>
                                                        Franchise Area
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
                            {{--                                <input tabindex="-1" name="franchise_id" id="franchise_id" type="hidden">--}}
                            {{--                                <input tabindex="-1" name="company_id" id="company_id" type="hidden">--}}

                            {{--                            </form>--}}

                            <form name="delete" id="delete" action="{{ route('franchise-area.destroy') }}" method="post">
                                @csrf
                                @method('delete')
                                <input name="franchise_id" id="del_franchise_id" type="hidden">

                            </form>

                        </div>
                    </div>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_3">
                                Sr#
                            </th>
{{--                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_3">--}}
{{--                                ID--}}
{{--                            </th>--}}
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Code
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_9">
                                Title
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_10">
                                BDO Name
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_5">
                                BDO Contact
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_10">
                                MO Name
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_5">
                                MO Contact
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_9">
                                Grid
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_7">
                                City
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_7">
                                Region
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_10">
                                Zone
                            </th>
                            <th tabindex="-1"scope="col" align="center" class="text-center align_center tbl_txt_10">
                                Company
                            </th>

                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_6">
                                Status
                            </th>

                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Created By
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center hide_column tbl_srl_6">
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
                        @forelse($datas as $franchise)

                            <tr data-region_id="{{$grid->region_id}}" data-company_title="{{$grid->account_name}}"
                                data-zone_title="{{$grid->name}}" data-remarks="{{$grid->remarks}}"
                                data-company_id="{{$grid->company_id}}" data-franchise_id="{{$grid->franchise_id}}">
                                {{--<tr>--}}
                                <td class="align_center text-center edit tbl_srl_3">
                                    {{$sr}}
                                    {{--                                    {{$index + 1}}--}}
                                </td>
{{--                                <td class="align_center text-center edit tbl_srl_3">--}}
{{--                                    {{$franchise->id}}--}}
{{--                                    --}}{{--                                    {{$index + 1}}--}}
{{--                                </td>--}}
                                <td class="align_left text-left edit tbl_txt_10">
                                    {{$franchise->code}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_10">
                                    {{$franchise->name}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_10">
                                    {{$franchise->bdoName }}
                                </td>
                                <td class="align_left text-left edit tbl_txt_5">
                                    {{$franchise->bdoContact }}
                                </td>
                                <td class="align_left text-left edit tbl_txt_10">
                                    {{$franchise->moName }}
                                </td>
                                <td class="align_left text-left edit tbl_txt_5">
                                    {{$franchise->moContact }}
                                </td>
                                <td class="align_left text-left edit tbl_txt_9">
                                    {{$franchise->grid_name }}
                                </td>
                                <td class="align_left text-left edit tbl_txt_7">
                                    {{$franchise->city_name }}
                                </td>
                                <td class="align_left text-left edit tbl_txt_7">
                                    {{$franchise->zone_name }}
                                </td>
                                <td class="align_left text-left edit tbl_txt_10">
                                    {{$franchise->reg_name }}
                                </td>
                                <td class="align_left text-left edit tbl_txt_10">
                                    {{$franchise->account_name }}
                                </td>

                                <td class="align_left text-left edit tbl_srl_6">
                                    {{$franchise->status}}
                                </td>
                                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $franchise->user_id }}"
                                    title="Click To See User Detail">
                                    {{ $franchise->user_name }}
                                </td>

                                <td class="align_center  text-right hide_column tbl_srl_6">

                                    <a href="{{ route('franchise-area.edit', $franchise->franchise_id) }}"
                                       class="float-left" data-toggle="tooltip"
                                       data-placement="left" title=""
                                       data-original-title="Are you sure want to edit?"><i
                                            class="fa fa-edit"></i></a>

                                    <a data-franchise_id="{{$franchise->franchise_id}}" class="delete" data-toggle="tooltip"
                                       data-placement="left" title=""
                                       data-original-title="Are you sure want to delete?">
                                        {{--                                        <i class="fa fa-{{$franchise->area_delete_status == 1 ? 'undo':'trash'}}"></i>--}}
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Franchise-Area</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>
                <span
                    class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'company'=>$search_company, 'region'=>$search_region, 'zone'=>$search_zone, 'city'=>$search_city,'grid'=>$search_grid ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->


@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('grids.list') }}',
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
        //     var franchise_id = jQuery(this).parent('tr').attr("data-franchise_id");
        //
        //     jQuery("#region_id").val(region_id);
        //     jQuery("#company_title").val(company_title);
        //     jQuery("#zone_title").val(zone_title);
        //     jQuery("#remarks").val(remarks);
        //     jQuery("#company_id").val(company_id);
        //     jQuery("#franchise_id").val(franchise_id);
        //     jQuery("#edit").submit();
        // });

        $('.delete').on('click', function (event) {

            var franchise_id = jQuery(this).attr("data-franchise_id");

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
                    jQuery("#del_franchise_id").val(franchise_id);
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

            $("#company").select2().val(null).trigger("change");
            $("#company > option").removeAttr('selected');

            $("#zone").select2().val(null).trigger("change");
            $("#zone > option").removeAttr('selected');

            $("#city").select2().val(null).trigger("change");
            $("#city > option").removeAttr('selected');

            $("#grid").select2().val(null).trigger("change");
            $("#grid > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#region").select2();
            jQuery("#company").select2();
            jQuery("#zone").select2();
            jQuery("#city").select2();
            jQuery("#grid").select2();

        });
    </script>
@endsection
