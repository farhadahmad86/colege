{{--@extends('extend_index')--}}

{{--@section('content')--}}
{{--    <div class="container">--}}
{{--        <div class="content-justify-center row">--}}
{{--            <div class="col-md-12">--}}

{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="m-0">--}}
{{--                            Regions <small>({{ $regions->total() }})</small>--}}
{{--                            <a href="{{ route('regions.create') }}" class="btn btn-sm btn-primary float-right">Create</a>--}}
{{--                        </h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        @include('modules.prerequisites.region._table')--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}



{{--<div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">--}}

{{--        <div class="close_info_bx"><!-- info bx start -->--}}
{{--            <i class="fa fa-expand"></i>--}}
{{--        </div><!-- info bx end -->--}}

{{--        <div class="form_header"><!-- form header start -->--}}
{{--            <div class="clearfix">--}}
{{--                <div class="pull-left">--}}
{{--                    <h4 class="text-white get-heading-text file_name">Region List</h4>--}}
{{--                </div>--}}
{{--                <div class="list_btn list_mul">--}}
{{--                    <div class="srch_box_opn_icon">--}}
{{--                        <i class="fa fa-search"></i>--}}
{{--                    </div>--}}
{{--                </div><!-- list btn -->--}}
{{--            </div>--}}
{{--        </div><!-- form header close -->--}}

{{--       --}}
{{--        @include('modules.prerequisites.region._table')--}}
{{--        --}}{{--        </div>--}}
{{--        --}}{{--        <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search ])->links() }}</span>--}}
{{--    </div> <!-- white column form ends here -->--}}

{{--@stop--}}

@extends('extend_index')

@section('content')

    <div class="row">

        @php
            $company_info = Session::get('company_info');
            if(isset($company_info) || !empty($company_info)){
                $win = $company_info->info_bx;
            }else{
                $win = '';
            }

        @endphp
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" id="main_col" data-win="{{ ($win === 'full') ? 'min' : 'full' }} " data-win-time="0">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                <div class="close_info_bx"><!-- info bx start -->
                    <i class="fa fa-expand"></i>
                </div><!-- info bx end -->

                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Zone List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
                <!-- <div class="search_form  {{ ( !empty($search) || !empty($search_region) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="">
                    <div class="row">


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
{{--                            . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '')}}--}}
                            {{-- . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') --}}
                            <form class="prnt_lst_frm" action="{{ route('regions.list')}}" name="form1" id="form1" method="post">
                                <div class="row">
                                    @csrf

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($region_title as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">
                                                        Select Company
                                                    </label>
                                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="region" id="region" style="width: 90%">
                                                        <option value="">Select Company</option>
                                                        @foreach($companies as $company)
                                                            <option value="{{$company->account_uid}}" {{ $company->account_uid == $search_region ? 'selected="selected"' : '' }}>{{$company->account_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>


                                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button tabindex="3" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button tabindex="4" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    <a tabindex="5" class="save_button form-control" href="{{ route('regions.create') }}" role="button">
                                                        <l class="fa fa-plus"></l> Zone
                                                    </a>

                                                    @include('include/print_button')

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                </div><!-- end row -->
                            </form>

{{--                            <form name="edit" id="edit" action="{{ route('edit_area') }}" method="post">--}}
{{--                                @csrf--}}
{{--                                <input tabindex="-1" name="region_title" id="region_title" type="hidden">--}}
{{--                                <input name="area_title" id="area_title" type="hidden">--}}
{{--                                <input name="remarks" id="remarks" type="hidden">--}}
{{--                                <input name="reg_id" id="reg_id" type="hidden">--}}
{{--                                <input name="region_id" id="region_id" type="hidden">--}}

{{--                            </form>--}}

                            <form name="delete" id="delete" action="{{ route('regions.destroy') }}" method="post">
                                @csrf
                            @method('delete')
                                <input name="reg_id" id="del_reg_id" type="hidden">
                            </form>


                        </div>
                    </div>
                </div>

                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" align="center" class="text-center align_center tbl_srl_4">Sr#</th>
{{--                           <th scope="col" align="center" class="text-center align_center tbl_srl_4">ID</th>--}}
                            <th scope="col" align="center" class="text-center align_center tbl_txt_23">Company Title</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_23">Zone Title</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_25">Remarks</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">Created By</th>
                            {{--<th scope="col" style="width:80px; text-align: center !important" align="center">Date/Time</th>--}}
                            <th scope="col" class="text-center align_center hide_column tbl_srl_6">Status</th>
                            <th scope="col" class="text-center align_center hide_column tbl_srl_6">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                        @endphp
                        @forelse($datas as $region)

                            <tr data-region_title="{{$region->account_name}}" data-area_title="{{$region->name}}" data-remarks="{{$region->remarks}}" data-reg_id="{{$region->id}}" data-region_id="{{$region->account_uid}}">

                                <td class="align_center text-center edit tbl_srl_4">{{$sr}}</td>
{{--                                 <td class="align_center text-center edit tbl_srl_4">{{$region->account_id}}</td>--}}

                                <td class="align_left text-left edit tbl_txt_23">{{$region->account_name}}</td>

                                <td class="align_left text-left edit tbl_txt_23">{{$region->name}}</td>
                                <td class="align_left text-left edit tbl_txt_25">{{$region->remarks }}</td>
                                <td class="align_left text-left edit tbl_txt_6">{{$region->status }}</td>


{{--                                @php--}}
{{--                                    $ip_browser_info= ''.$region->area_ip_adrs.','.str_replace(' ','-',$region->area_brwsr_info).'';--}}
{{--                                @endphp--}}
{{--                                data-user_info="{!! $ip_browser_info !!}"--}}
                                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $region->user_id }}"  title="Click To See User Detail">
                                    {{ $region->user_name }}
                                </td>

{{--                                <td class="align_right text-right hide_column tbl_amnt_6">--}}

{{--                                </td>--}}

                                <td class="align_center  text-right hide_column tbl_srl_6">

                                    <a href="{{ route('regions.edit', $region->id) }}" class="float-left" data-toggle="tooltip" data-placement="left" title="" data-original-title="Are you sure want to edit?"><i
                                            class="fa fa-edit"></i></a>

                                    <a data-reg_id="{{$region->id}}" class="delete" data-toggle="tooltip" data-placement="left" title="" data-original-title="Are you sure want to delete?">
                                        {{--                                        <i class="fa fa-{{$region->area_delete_status == 1 ? 'undo':'trash'}}"></i>--}}
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
                                    <center><h3 style="color:#554F4F">No Zone</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>

                <span class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'region'=>$search_region ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')



    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('regions.list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}



    <script>

        // jQuery(".edit").click(function () {
        //
        //     var region_title = jQuery(this).parent('tr').attr("data-region_title");
        //     var area_title = jQuery(this).parent('tr').attr("data-area_title");
        //     var remarks = jQuery(this).parent('tr').attr("data-remarks");
        //     var reg_id = jQuery(this).parent('tr').attr("data-reg_id");
        //     var region_id = jQuery(this).parent('tr').attr("data-region_id");
        //
        //     jQuery("#region_title").val(region_title);
        //     jQuery("#area_title").val(area_title);
        //     jQuery("#remarks").val(remarks);
        //     jQuery("#reg_id").val(reg_id);
        //     jQuery("#region_id").val(region_id);
        //     jQuery("#edit").submit();
        // });

        $('.delete').on('click', function (event) {

            var reg_id = jQuery(this).attr("data-reg_id");

            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
            }).then(function(result) {

                if (result.value) {
                    jQuery("#del_reg_id").val(reg_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });




        {{--$(function() {--}}
        {{--var availableTutorials  =  JSON.parse('{!! json_encode($area_title) !!}');--}}
        {{--$( "#search" ).autocomplete({--}}
        {{--source: availableTutorials,--}}
        {{--});--}}
        {{--});--}}

    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#region").select2().val(null).trigger("change");
            $("#region > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#region").select2();
        });
    </script>

    <style>
        input::-webkit-calendar-picker-indicator {
            display: none;
        }
    </style>

@endsection

