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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                <div class="close_info_bx"><!-- info bx start -->
                    <i class="fa fa-expand"></i>
                </div><!-- info bx end -->

                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text file_name">Advertising Measurement Config List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i tabindex="-1" class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <!-- <div class="search_form  {{ ( !empty($search) || !empty($search_region) ) ? '' : 'search_form_hidden' }}"> -->
                <div
                    class="search_form">
                    <div class="row">


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <form class="prnt_lst_frm"
                                  action="{{ route('product_measurement_config_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}"
                                  name="form1" id="form1" method="post">
                                <div class="row">
                                    @csrf

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
                                                {{--                                                @foreach($area_title as $value)--}}
                                                {{--                                                    <option value="{{$value}}">--}}
                                                {{--                                                @endforeach--}}
                                            </datalist>
                                            <span id="demo1" class="validate_sign"
                                                  style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        Select Advertisement
                                                    </label>
                                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch"
                                                            name="product" id="product" style="width: 90%">
                                                        <option value="">Select Advertisement</option>
                                                        @foreach($products as $product)
                                                            <option
                                                                value="{{$product->pro_p_code}}" {{ $product->pro_p_code == $search_product ? 'selected="selected"' : '' }}>{{$product->pro_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign"
                                                          style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        Select Output Unit
                                                    </label>
                                                    <select tabindex="3" class="inputs_up form-control cstm_clm_srch" name="unit"
                                                            id="unit" style="width: 90%">
                                                        <option value="">Select Output Unit</option>
                                                        @foreach($units as $unit)
                                                            <option
                                                                value="{{$unit->unit_id}}" {{ $unit->unit_id == $search_unit ? 'selected="selected"' : '' }}>{{$unit->unit_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign"
                                                          style="float: right !important"> </span>
                                                </div>
                                            </div>


                                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button tabindex="4" type="button" type="button" name="cancel" id="cancel"
                                                            class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button tabindex="5" type="submit" name="filter_search" id="filter_search"
                                                            class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    <a tabindex="6" class="save_button form-control"
                                                       href="product_measurement_config" role="button">
                                                        <l class="fa fa-plus"></l>
                                                        Product Measurement Config
                                                    </a>

                                                    @include('include/print_button')

                                                    <span tabindex="-7" id="demo1" class="validate_sign"
                                                          style="float: right !important"> </span>

                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                </div><!-- end row -->
                            </form>

                            <form name="edit" id="edit" action="{{ route('edit_product_measurement_config') }}"
                                  method="post">
                                @csrf
                                <input name="company_id" id="company_id" type="hidden">
                                <input name="company_title" id="company_title" type="hidden">
                                <input name="project_id" id="project_id" type="hidden">
                                <input name="project_title" id="project_title" type="hidden">
                                <input name="product_title" id="product_title" type="hidden">
                                <input name="before_title" id="before_title" type="hidden">
                                <input name="after_title" id="after_title" type="hidden">
                                <input name="output_title" id="output_title" type="hidden">
                                <input name="remarks" id="remarks" type="hidden">
                                <input name="pmc_id" id="pmc_id" type="hidden">
                                <input name="product_id" id="product_id" type="hidden">
{{--                                <input name="before_id" id="before_id" type="hidden">--}}
{{--                                <input name="after_id" id="after_id" type="hidden">--}}
{{--                                <input name="output_id" id="output_id" type="hidden">--}}

                                <input name="post_survey" id="post_survey" type="hidden">
                                <input name="pre_survey" id="pre_survey" type="hidden">

                                <input name="advertising_type" id="advertising_type" type="hidden">

                                <input name="depth" id="depth" type="hidden">
                                <input name="tapa_gauge" id="tapa_gauge" type="hidden">
                                <input name="back_sheet_gauge" id="back_sheet_gauge" type="hidden">


                            </form>

                            <form name="delete" id="delete" action="{{ route('delete_product_measurement_config') }}"
                                  method="post">
                                @csrf
                                <input name="pmc_id" id="del_pmc_id" type="hidden">
                            </form>


                        </div>
                    </div>
                </div>

                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">Sr#</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">ID</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_18">Company
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_18">Project
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_20">Product Title
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_7">Before Decimal Uom</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_7">After Decimal Uom</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_7">Output Uom</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_5">Pre Survey</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_5">Post Survey</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_10">Remarks</th>

                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_20">Type of Measurement</th>

                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_8">Created By</th>

                            <th tabindex="-1" scope="col" class="text-center align_center hide_column tbl_srl_4">Enable</th>
                            <th tabindex="-1" scope="col" class="text-center align_center hide_column tbl_srl_4">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                        @endphp
                        @forelse($datas as $product)

                            <tr
                                data-company_title="{{$product->account_name}}"
                                data-project_title="{{$product->proj_project_name}}"
                                data-product_title="{{$product->pro_title}}"
                                data-before_title="{{$product->before}}"
                                data-after_title="{{$product->after}}"
                                data-output_title="{{$product->output}}"
                                data-remarks="{{$product->pmc_remarks}}" data-pmc_id="{{$product->pmc_id}}"
                                data-company_id="{{$product->pmc_company_id}}"
                                data-project_id="{{$product->pmc_project_id}}"
                                data-product_id="{{$product->pmc_pro_code}}"
                                data-before_id="{{$product->pmc_before_decimal}}"
                                data-after_id="{{$product->pmc_after_decimal}}"
                                data-output_id="{{$product->pmc_uom_after_cal}}"

                                data-post_survey="{{$product->pmc_post_survey}}"
                                data-pre_survey="{{$product->pmc_pre_survey}}"

                                data-advertising_type="{{$product->pmc_adv_type}}"

                                data-depth="{{$product->pmc_depth}}"
                                data-tapa_gauge="{{$product->pmc_tapa_gauge}}"
                                data-back_sheet_gauge="{{$product->pmc_back_sheet_gauge}}"


                            >

                                <td class="align_center text-center edit tbl_srl_4">{{$sr}}</td>
                                <td class="align_center text-center edit tbl_srl_4">{{$product->pmc_id}}</td>

                                <td class="align_left text-left edit tbl_txt_18">{{$product->account_name}}</td>
                                <td class="align_left text-left edit tbl_txt_18">{{$product->proj_project_name}}</td>
                                <td class="align_left text-left edit tbl_txt_20">{{$product->pro_title}}</td>

                                <td class="align_left text-left edit tbl_txt_7">{{$product->pmc_before_decimal}}</td>
                                <td class="align_left text-left edit tbl_txt_7">{{$product->pmc_after_decimal}}</td>
                                <td class="align_left text-left edit tbl_txt_7">{{$product->pmc_uom_after_cal}}</td>
                                <td class="align_left text-left edit tbl_txt_5">{{$product->pmc_pre_survey == 1 ? 'Yes': 'No'}}</td>
                                <td class="align_left text-left edit tbl_txt_5">{{$product->pmc_post_survey == 1 ? 'Yes': 'No'}}</td>
                                <td class="align_left text-left edit tbl_txt_10">{{$product->pmc_remarks }}</td>

                                    @if ($product->pmc_adv_type == 1)

                                <td class="align_left text-left edit tbl_txt_20">Depth: {{$product->pmc_depth}}<br> Tapa Gauge: {{$product->pmc_tapa_gauge}}<br>
                                    Back Sheet Gauge:{{$product->pmc_back_sheet_gauge}}
                                </td>

                                @endif
                                @if ($product->pmc_adv_type == 2)
                                    <td class="align_left text-left edit tbl_txt_15">{{$product->pmc_adv_type == 2 ? 'Quantity': ''}}</td>

                                @endif

                                @if ($product->pmc_adv_type == 3)
                                    <td class="align_left text-left edit tbl_txt_15">{{$product->pmc_adv_type == 3 ? 'Height, Width': ''}}</td>

                                @endif

                                @php
                                    $ip_browser_info= ''.$product->pmc_ip_adrs.','.str_replace(' ','-',$product->pmc_brwsr_info).'';
                                @endphp

                                <td class="align_left text-left usr_prfl tbl_txt_8"
                                    data-usr_prfl="{{ $product->user_id }}"
                                    data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $product->user_name }}
                                </td>

                                <td class="align_right text-right hide_column tbl_amnt_4">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($product->pmc_disabled == 0) {
                                            echo 'checked="true"' . ' ' . 'value=' . $product->pmc_disabled;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?>  class="enable_disable" data-id="{{$product->pmc_id}}"
                                            {{ $product->pmc_disabled == 0 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                <td class="align_center  text-right hide_column tbl_srl_4">
                                    <a data-pmc_id="{{$product->pmc_id}}" class="delete" data-toggle="tooltip"
                                       data-placement="left" title="" data-original-title="Are you sure?">
                                        <i class="fa fa-{{$product->pmc_deleted_status == 1 ? 'undo':'trash'}}"></i>
                                        {{--                                            <i class="fa fa-trash"></i>--}}
                                    </a>
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Product Measurement Config</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>

                <span
                    class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'region'=>$search_product, 'unit'=>$search_unit ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')



    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('product_measurement_config_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let pmcId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_product_measurement_config') }}',
                    data: {'status': status, 'pmc_id': pmcId},
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>

    <script>

        jQuery(".edit").click(function () {

            var company_title = jQuery(this).parent('tr').attr("data-company_title");
            var project_title = jQuery(this).parent('tr').attr("data-project_title");
            var product_title = jQuery(this).parent('tr').attr("data-product_title");
            var before_title = jQuery(this).parent('tr').attr("data-before_title");
            var after_title = jQuery(this).parent('tr').attr("data-after_title");

            var post_survey = jQuery(this).parent('tr').attr("data-post_survey");
            var pre_survey = jQuery(this).parent('tr').attr("data-pre_survey");

            var output_title = jQuery(this).parent('tr').attr("data-output_title");

            var advertising_type = jQuery(this).parent('tr').attr("data-advertising_type");

            var depth = jQuery(this).parent('tr').attr("data-depth");
            var tapa_gauge = jQuery(this).parent('tr').attr("data-tapa_gauge");
            var back_sheet_gauge = jQuery(this).parent('tr').attr("data-back_sheet_gauge");


            var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var pmc_id = jQuery(this).parent('tr').attr("data-pmc_id");
            var company_id = jQuery(this).parent('tr').attr("data-company_id");
            var project_id = jQuery(this).parent('tr').attr("data-project_id");
            var product_id = jQuery(this).parent('tr').attr("data-product_id");
            // var before_id = jQuery(this).parent('tr').attr("data-before_id");
            // var after_id = jQuery(this).parent('tr').attr("data-after_id");
            // var output_id = jQuery(this).parent('tr').attr("data-output_id");

            jQuery("#company_title").val(company_title);
            jQuery("#project_title").val(project_title);
            jQuery("#product_title").val(product_title);
            // jQuery("#before_title").val(before_title);
            // jQuery("#after_title").val(after_title);
            // jQuery("#output_title").val(output_title);
            jQuery("#remarks").val(remarks);
            jQuery("#pmc_id").val(pmc_id);
            jQuery("#company_id").val(company_id);
            jQuery("#project_id").val(project_id);
            jQuery("#product_id").val(product_id);
            // jQuery("#before_id").val(before_id);
            // jQuery("#after_id").val(after_id);
            // jQuery("#output_id").val(output_id);

            jQuery("#post_survey").val(post_survey);
            jQuery("#pre_survey").val(pre_survey);

            jQuery("#advertising_type").val(advertising_type);

            jQuery("#depth").val(depth);
            jQuery("#tapa_gauge").val(tapa_gauge);
            jQuery("#back_sheet_gauge").val(back_sheet_gauge);


            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var pmc_id = jQuery(this).attr("data-pmc_id");

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
                    jQuery("#del_pmc_id").val(pmc_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });




        {{--$(function() {--}}
        {{--var availableTutorials  =  JSON.parse('{!! json_encode($before_title) !!}');--}}
        {{--$( "#search" ).autocomplete({--}}
        {{--source: availableTutorials,--}}
        {{--});--}}
        {{--});--}}

    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#product").select2().val(null).trigger("change");
            $("#product > option").removeAttr('selected');

            $("#unit").select2().val(null).trigger("change");
            $("#unit > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#product").select2();
            jQuery("#unit").select2();
        });
    </script>

    <style>
        input::-webkit-calendar-picker-indicator {
            display: none;
        }
    </style>

@endsection

