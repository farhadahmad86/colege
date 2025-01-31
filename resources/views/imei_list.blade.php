@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">IMEI List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('imei_list') }}" name="form1" id="form1"
                        method="post">
                        <div class="row">
                            @csrf
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers"
                                        class="inputs_up form-control all_clm_srch" name="search" id="search"
                                        placeholder="Search ..." value="{{ isset($search) ? $search : '' }}"
                                        autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach ($mi_title as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="required">
                                       Products
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="region"
                                        id="region" style="width: 90%">
                                        <option value="">Select Products</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->mi_id }}"
                                                {{ $region->mi_id == $search_region ? 'selected="selected"' : '' }}>
                                                {{ $region->pro_title }}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo2" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12 mt-4 text-right form_controls">
                                @include('include.clear_search_button')
                                <!-- Call add button component -->
                                <x-add-button tabindex="9" href="{{ route('create_imei') }}" />

                                @include('include/print_button')
                                <span id="demo3" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div><!-- end row -->
                    </form>
                    <form name="edit" id="edit" action="{{ route('edit_area') }}" method="post">
                        @csrf
                        <input name="region_title" id="region_title" type="hidden">
                        <input name="area_title" id="area_title" type="hidden">
                        <input name="remarks" id="remarks" type="hidden">
                        <input name="area_id" id="area_id" type="hidden">
                        <input name="region_id" id="region_id" type="hidden">
                    </form>
                    <form name="delete" id="delete" action="{{ route('delete_imei') }}" method="post">
                        @csrf
                        <input name="mi_id" id="del_mi_id" type="hidden">
                    </form>
                </div>
                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">
                        <thead>
                            <tr>
                                <th scope="col" class="borderedtbl_txt_25">Product Name</th>
                                <th scope="col" class="borderedtbl_txt_25">IMEI 1</th>
                                {{-- <th scope="col" class="borderedtbl_txt_8">IMEI 2</th>
                                <th scope="col" class="borderedtbl_txt_8">IMEI 3</th>
                                <th scope="col" class="borderedhide_column tbl_srl_8">IMEI 4</th>
                                <th scope="col" class="borderedhide_column tbl_srl_8">IMEI 5</th>
                                <th scope="col" class="borderedhide_column tbl_srl_8">IMEI 6</th>
                                <th scope="col" class="borderedhide_column tbl_srl_10">IMEI 6</th> --}}
                                <th scope="col" class="borderedhide_column tbl_srl_25">Purchase#</th>
                                <th scope="col" class="borderedhide_column tbl_srl_25">Sale#</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                        @endphp --}}
                            @foreach ($datas as $imei)
                                {{-- <tr data-region_title="{{$area->reg_title}}" data-area_title="{{$area->area_title}}" data-remarks="{{$area->reg_remarks}}" data-area_id="{{$area->area_id}}"
                            data-region_id="{{$area->area_reg_id}}"> --}}
                                <tr>
                                    <td class="borderededit ">{{ $imei->pro_title }}</td>
                                    <td class="borderededit ">{{ $imei->mi_imei_1 }}</td>
                                    {{-- <td class="borderededit ">{{ $imei->mi_imei_2 }}</td>
                                    <td class="borderededit ">{{ $imei->mi_imei_3 }}</td>
                                    <td class="borderededit ">{{ $imei->mi_imei_4 }}</td>
                                    <td class="borderededit ">{{ $imei->mi_imei_5 }}</td>
                                    <td class="borderededit ">{{ $imei->mi_imei_6 }}</td> --}}
                                    <td class="borderededit ">{{ $imei->mi_purchase_id }}</td>
                                    <td class="borderededit ">{{ $imei->mi_sale_id }}</td>
                                </tr>

                                {{-- <th scope="row" class="borderededit tbl_srl_4"></th> --}}
                            @endforeach
                            {{-- @php
                                    $ip_browser_info= ''.$area->area_ip_adrs.','.str_replace(' ','-',$area->area_brwsr_info).'';
                                @endphp --}}

                            {{-- <td class="borderedusr_prfl " data-usr_prfl="{{ $area->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $area->user_name }}
                                </td> --}}


                            {{-- <td class="text-center hide_column ">
                                    <a data-area_id="{{$area->area_id}}" class="delete" data-toggle="tooltip" data-placement="left" title="" data-original-title="Are you sure?">
                                        <i class="fa fa-{{$area->area_delete_status == 1 ? 'undo':'trash'}}"></i>
                                        {{--                                            <i class="fa fa-trash"></i> --}}
                            {{-- </a>
                                </td> --}}

                            {{-- </tr> --}}
                            {{-- @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp --}}
                            {{-- @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Area</h3></center>
                                </td>
                            </tr>
                        @endforelse --}}
                        </tbody>

                    </table>

                </div>
                <div class="row">
                    {{-- <div class="col-md-3">
                        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                    </div>
                    <div class="col-md-9 text-right">
                        <span class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'region'=>$search_region ])->links() }}</span>
                    </div> --}}
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->
@endsection

@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('area_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function() {
            $('.enable_disable').change(function() {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let areaId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_area') }}',
                    data: {
                        'status': status,
                        'area_id': areaId
                    },
                    success: function(data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>

    <script>
        jQuery(".edit").click(function() {

            var region_title = jQuery(this).parent('tr').attr("data-region_title");
            var area_title = jQuery(this).parent('tr').attr("data-area_title");
            var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var area_id = jQuery(this).parent('tr').attr("data-area_id");
            var region_id = jQuery(this).parent('tr').attr("data-region_id");

            jQuery("#region_title").val(region_title);
            jQuery("#area_title").val(area_title);
            jQuery("#remarks").val(remarks);
            jQuery("#area_id").val(area_id);
            jQuery("#region_id").val(region_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function(event) {

            var mi_id = jQuery(this).attr("data-area_id");

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
                    jQuery("#del_mi_id").val(mi_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>

    <script>
        jQuery("#cancel").click(function() {

            $("#region").select2().val(null).trigger("change");
            $("#region > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function() {
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
