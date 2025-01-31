@extends('extend_index')

@section('styles_get')
    <!-- Fancy box image gallery library start CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('public/image_gallery_source/jquery.fancybox.css?v=2.1.5')}}" media="screen"/>
    <!-- Add Button helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/image_gallery_source/helpers/jquery.fancybox-buttons.css?v=1.0.5') }}"/>

    <!-- Fancy box image gallery library end CSS -->
    <style type="text/css">
        .fancybox-custom .fancybox-skin {
            box-shadow: 0 0 50px #222;
        }

    </style>
@endsection

@section('content')


    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Fascia Calculator</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

{{--            <!-- <div class="search_form {{ ( !empty($search) || !empty($search_account) || !empty($search_product) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}"> -->--}}

                <div class="search_form">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

{{--                            <form class="prnt_lst_frm" action="{{ route('survey_list') }}" name="form1" id="form1" method="post">--}}
{{--                                @csrf--}}
{{--                                <div class="row">--}}

{{--                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">--}}
{{--                                        <div class="input_bx"><!-- start input box -->--}}
{{--                                            <label>--}}
{{--                                                All Column Search--}}
{{--                                            </label>--}}
{{--                                            <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."--}}
{{--                                                   value="{{ isset($search) ? $search : '' }}" autocomplete="off">--}}
{{--                                            <datalist id="browsers">--}}
{{--                                                @foreach($party as $value)--}}
{{--                                                    <option value="{{$value}}">--}}
{{--                                                @endforeach--}}
{{--                                            </datalist>--}}
{{--                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}

{{--                                        </div>--}}
{{--                                    </div> <!-- left column ends here -->--}}


{{--                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">--}}
{{--                                        <div class="row">--}}

{{--                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">--}}
{{--                                                <div class="input_bx"><!-- start input box -->--}}
{{--                                                    <label>--}}
{{--                                                        Account--}}
{{--                                                    </label>--}}
{{--                                                    <select tabindex="2" class="inputs_up  form-control" name="account" id="account">--}}
{{--                                                        <option value="">Select Account</option>--}}
{{--                                                        @foreach($accounts as $account)--}}
{{--                                                            <option--}}
{{--                                                                value="{{$account->account_uid}}" {{ $account->account_uid == $search_account ? 'selected="selected"' : '' }}>{{$account->account_name}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}
{{--                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">--}}
{{--                                                <div class="input_bx"><!-- start input box -->--}}
{{--                                                    <label>--}}
{{--                                                        Project--}}
{{--                                                    </label>--}}
{{--                                                    <select tabindex="3" class="inputs_up  form-control" name="project" id="project">--}}
{{--                                                        <option value="">Select Project</option>--}}
{{--                                                        @foreach($projects as $project)--}}
{{--                                                            <option--}}
{{--                                                                value="{{$project->proj_id}}" {{ $project->proj_id == $search_project ? 'selected="selected"' : ''--}}
{{--                                                                }}>{{$project->proj_project_name}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}
{{--                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">--}}
{{--                                                <div class="input_bx"><!-- start input box -->--}}
{{--                                                    <label>--}}
{{--                                                        Start Date--}}
{{--                                                    </label>--}}
{{--                                                    <input tabindex="5" type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"--}}
{{--                                                           <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......"/>--}}
{{--                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">--}}
{{--                                                <div class="input_bx"><!-- start input box -->--}}
{{--                                                    <label>--}}
{{--                                                        End Date--}}
{{--                                                    </label>--}}
{{--                                                    <input tabindex="6" type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off"--}}
{{--                                                           <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......"/>--}}
{{--                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 mt-lg-2">--}}
{{--                                                <div class="form_controls text-center text-lg-left">--}}

{{--                                                    <button tabindex="7" type="button" name="cancel" id="cancel" class="cancel_button form-control">--}}
{{--                                                        <i class="fa fa-trash"></i> Clear--}}
{{--                                                    </button>--}}
{{--                                                    <button tabindex="8" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">--}}
{{--                                                        <i class="fa fa-search"></i> Search--}}
{{--                                                    </button>--}}

{{--                                                    <button id="pptbtn" type="button" class="cancel_button form-control">--}}
{{--                                                        --}}{{--                                                        dropdown-item<i class="fa fa-file-excel-o"></i>--}}
{{--                                                        <i class="fa fa-arrow-down"></i> Export to PPTX--}}
{{--                                                    </button>--}}

{{--                                                    --}}{{--                                                    <a tabindex="9" class="save_button form-control" href="{{ route('sale_invoice') }}" role="button">--}}
{{--                                                    --}}{{--                                                        <i class="fa fa-plus"></i> Sale Invoice--}}
{{--                                                    --}}{{--                                                    </a>--}}

{{--                                                    @include('include/print_button')--}}

{{--                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}

{{--                                                </div>--}}
{{--                                            </div>--}}


{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </form>--}}



                        </div>

                    </div>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">
                                Sr#
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_6">
                                Company
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_6">
                                Project
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_8">
                                Shop Code
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_8">
                                Shop Name
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_10">
                                Shop Address
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_8">
                                Board Materials
                            </th>
                            {{--                                    <th scope="col" align="center">Detail Remarks</th>--}}
                            {{--<th scope="col" style="width:80px; text-align: center !important" align="center">Party Code</th>--}}
                            <th scope="col" align="center" class="align_center text-center tbl_txt_8">
                                Whatsapp Number
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_8">
                                type
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_15">
                                Images Before
                            </th>

                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Created At
                            </th>

                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            $ttlPrc = $cashPaid = 0;
                        @endphp
                        @forelse($fasica_calculator as $invoice)

                            <tr>
                                <td class="align_center text-center edit tbl_srl_4">
                                    {{$sr}}
                                </td>
                                <td class="align_center text-center edit tbl_srl_6">
                                    {{$invoice->sri_depth}}
                                </td>
                                <td class="align_center text-center edit tbl_srl_6">
                                    {{$invoice->sri_tapa_gauge}}
                                    {{--                                    {{$invoice->projectName}}--}}
                                </td>
                                <td class="align_center text-center edit tbl_srl_8">
                                    {{$invoice->sri_back_sheet_gauge}}
                                </td>
                                <td class="align_center text-center edit tbl_srl_8">
                                    {{$invoice->sri_lengthFeet}}
                                    {{$invoice->sri_total_length}}
                                </td>
                                <td class="align_center text-center tbl_txt_10">
                                    {{ $invoice->sri_quantity }}
                                </td>

{{--                                <td class="align_left text-left tbl_txt_8">--}}
{{--                                    {{$invoice->sr_contact}}--}}
{{--                                </td>--}}
{{--                                <td class="align_left text-left tbl_txt_8">--}}
{{--                                    {{$invoice->sr_contact2}}--}}
{{--                                </td>--}}
{{--                                <td class="align_left text-left tbl_txt_8">--}}
{{--                                    {{$invoice->sr_front_left_right_type}}--}}
{{--                                </td>--}}
                                <td nowrap="" class="align_left text-left tbl_txt_15">
                                    <table style="padding: 0; margin: 0" border="0" cellspacing="0" cellpadding="0">
                                        <tbody style="padding: 0; margin: 0">
                                        <tr style="padding: 0; margin: 0">
                                            <td style="padding: 0; margin: 0; border:none" class="">
                                                @foreach($materials[$invoice->abm_id] as $a)

                                                    {{--                                                   media-object  no-border-top-radius no-border-bottom-radius avatar avatar-sm pull-up--}}
                                                    <a class="fancybox" data-fancybox-group="gallery" href="{{$a->abmi_board_material_id}}" style="user-select: auto;">{{$a->pro_title}}
{{--                                                        <img class="rounded-circle" src="{{$a->pro_title}}" width="30px" height="30px" style="user-select: auto;">--}}
                                                    </a>,


                                                @endforeach

                                            </td>
                                        </tr>
{{--                                        <tr style="padding: 0;margin: 0">--}}
{{--                                            <td style="padding: 0; margin: 0; border:none">--}}

{{--                                                @foreach($imgs[$invoice->sr_id] as $a)--}}

{{--                                                    <a data-toggle="modal" data-target=".bd-example-modal-lg" data-id="{{ $a->sri_id}}" class="href" style="user-select: auto;--}}
{{--                                                                        padding-left: 10px; padding-right: 10px"><i class="fa fa-info-circle" style="user-select: auto;"></i></a>--}}


{{--                                                @endforeach--}}

{{--                                            </td>--}}
{{--                                            <td class="d-none sqft_values">--}}
{{--                                                @foreach($imgs[$invoice->sr_id] as $a)--}}
{{--                                                    <div class="d-none sqft_l">{{ $a->sri_image_type }}</div>--}}
{{--                                                    <div class="d-none sqft_f">{{ $a->sri_tapa_gauge }}</div>--}}
{{--                                                    <div class="d-none sqft_r">{{ $a->sri_depth }}</div>--}}
{{--                                                    <div class="d-none sqft_h">{{ $a->sri_front_left_right_height_feet }}'   {{ $a->sri_front_left_right_height_Inch }}";</div>--}}
{{--                                                    <div class="d-none sqft_q">{{ $a->sri_quantity }}</div>--}}
{{--                                                @endforeach--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
                                        </tbody>
                                    </table>

                                </td>


{{--                                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $invoice->sr_user_id }}"--}}
{{--                                    --}}{{--                                    data-user_info="{!! $ip_browser_info !!}" --}}
{{--                                    title="Click To See User--}}
{{--                                Detail">--}}
{{--                                    {{$invoice->username}}--}}
{{--                                </td>--}}
{{--                                <td class="align_left text-left usr_prfl tbl_txt_8" title="Click To See User--}}
{{--                                Detail">--}}
{{--                                    {{$invoice->_created_at}}--}}
{{--                                </td>--}}

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="15">
                                    <center><h3 style="color:#554F4F">No Invoice</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>


                    </table>
                </div>
{{--                <span--}}
{{--                    class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'account'=>$search_account, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>--}}
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg mdl_wdth">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Survey Image Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div id="table_body">

                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <!-- Fancy box image gallery library start js -->
    {{--    <script type="text/javascript" src="{{ asset('public/image_gallery_source/lib/jquery-1.10.2.min.js') }}"></script>--}}

    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="{{ asset('public/image_gallery_source/lib/jquery.mousewheel.pack.js?v=3.1.3') }}"></script>

    <!-- Add fancyBox main JS and CSS files -->
    <script type="text/javascript" src="{{ asset('public/image_gallery_source/jquery.fancybox.pack.js?v=2.1.5') }}"></script>
    <!-- Fancy box image gallery library en js -->


    <script>
        $(document).ready(function () {
            $('.fancybox').fancybox();
        });
    </script>


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('survey_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".href").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");

            $('.modal-body').load('{{url("survey_items_view_details/view/") }}' + '/' + id, function () {
                $('#myModal').modal({show: true});
            });

        });
    </script>

    <script>
        jQuery(".edit").click(function () {

            var account_id = jQuery(this).attr("data-id");

            jQuery("#account_id").val(account_id);
            jQuery("#edit").submit();
        });

    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#account").select2().val(null).trigger("change");
            $("#account > option").removeAttr('selected');

            $("#product").select2().val(null).trigger("change");
            $("#product > option").removeAttr('selected');

            $("#product_name").select2().val(null).trigger("change");
            $("#product_name > option").removeAttr('selected');

            $("#project").select2().val(null).trigger("change");
            $("#project > option").removeAttr('selected');

            $("#search").val('');

            $("#to").val('');
            $("#from").val('');
        });
    </script>

    <script>
        jQuery("#product_name").change(function () {
            var pcode = jQuery('option:selected', this).val();

            jQuery("#product").select2("destroy");

            // jQuery("#product > option").each(function () {
            //     jQuery('#product option[value="' + pcode + '"]').prop('selected', true);
            // });

            jQuery('#product option[value="' + pcode + '"]').prop('selected', true);
            jQuery("#product").select2();

        });


        jQuery("#product").change(function () {
            var pcode = jQuery('option:selected', this).val();

            jQuery("#product_name").select2("destroy");

            // jQuery("#product_name > option").each(function () {
            jQuery('#product_name option[value="' + pcode + '"]').prop('selected', true);
            // });

            jQuery("#product_name").select2();

        });


    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#account").select2();
            jQuery("#product").select2();
            jQuery("#product_name").select2();
            jQuery("#project").select2();
        });
    </script>

    {{--    ppt--}}
    <!-- Bundle: Easiest to use, supports all browsers -->
    <script src="https://cdn.jsdelivr.net/npm/pptxgenjs@3.4.0/dist/pptxgen.bundle.js"></script>
    {{--    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.5.0/dist/pptxgen.bundle.js"></script>--}}

    {{--    <!-- Individual files: Add only what's needed to avoid clobbering loaded libraries -->--}}
    {{--    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.5.0/libs/jquery.min.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.5.0/libs/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.5.0/dist/pptxgen.min.js"></script>


    {{--    <!-- Bundle: Easiest to use, supports all browsers -->--}}
    <script src=" {{ asset('PptxGenJS/libs/pptxgen.bundle.js') }}"></script>
    <script src=" {{ asset('PptxGenJS/dist/pptxgen.bundle.js') }}"></script>

    {{--    <!-- Individual files: Add only what's needed to avoid clobbering loaded libraries -->--}}
    <script src="{{ asset('PptxGenJS/libs/jquery.min.js') }}"></script>
    <script src="{{ asset('PptxGenJS/libs/jszip.min.js') }}"></script>
    <script src="{{ asset('PptxGenJS/dist/pptxgen.min.js') }}"></script>
    {{--    <!-- IE11 requires Promises polyfill -->--}}
    <!-- <script src="PptxGenJS/libs/promise.min.js"></script> -->
    <script>
        $('#pptbtn').on('click', function () {

            // $('#ppt tbody tr').each(function (i, row) {
            //     console.log(i, $(row).eq(i).find('td').eq(1)[0].innerText);
            // });




            var pptx = new PptxGenJS();
            var pptIndexCount = 1;
            $('#fixTable tbody>tr').each(function (i, row) {

                if (i % 3 == 0) {

                    // var rows = $(this).eq(0).find('td');
                    // console.log(rows[24].children);
                    // return 0;


                    var rows = $(this).eq(0).find('td');

                    var SQFT = '';
                    var LEFT = 0;
                    var FRONT = 0;
                    var RIGHT = 0;
                    var HEIGHT = 0;
                    var QUANTITY = 0;
                    var sqft_values = rows[12].children;

                    for (var k = 0; k < sqft_values.length; k = k + 5)
                    {

                        var l = sqft_values[k + 0].innerHTML;
                        var f = parseFloat(sqft_values[k + 1].innerHTML);
                        var r = parseFloat(sqft_values[k + 2].innerHTML);
                        var h = parseFloat(sqft_values[k + 3].innerHTML);
                        var q = parseFloat(sqft_values[k + 4].innerHTML);
                        console.log(l,f,r,h,q);
                        // SQFT += (((l + f + r) * h) * q);
                        SQFT += (((f + r) * h) * q);
                        "<br>";
                        LEFT +=l;
                        "<br>";
                        FRONT +=f;"<br>";
                        RIGHT +=r;"<br>";
                        HEIGHT +=h;
                        "<br>";
                        QUANTITY +=q;"<br>";


                    }
                    // console.log(LEFT);
                    // console.log(FRONT);
                    // console.log(RIGHT);
                    // console.log(HEIGHT);
                    // console.log(QUANTITY);
                    // console.log(SQFT);
                    pptx.layout='LAYOUT_WIDE';
                    var slide = pptx.addNewSlide();
                    var slideRows = [

                        // ['#', 'Region', 'Grid', 'Franchise', 'City', 'Project Name', 'Shop Name', 'address', 'Contact', 'BDO Name', 'BDO Number',
                        //     {text: 'Survey Size', options: {colspan: 5}}, 'L', 'F', 'R', 'H', 'Q', 'SQFT'],

                        [
                            {text: '#', options: {rowspan: 2}},
                            {text: 'Company', options: {rowspan: 2}},
                            {text: 'Order List', options: {rowspan: 2}},
                            {text: 'Shop Code', options: {rowspan: 2}},
                            {text: 'Shop Name', options: {rowspan: 2}},
                            // {text: 'Project Name', options: {rowspan: 2}},
                            {text: 'Contact', options: {rowspan: 2}},
                            {text: 'Address', options: {rowspan: 2}},
                            {text: 'Contact', options: {rowspan: 2}},
                            {text: 'BDO Name', options: {rowspan: 2}},
                            {text: 'BDO Number', options: {rowspan: 2}},
                            {text: 'Survey Size', options: {colspan: 5}},
                            {text: 'SQFT', options: {rowspan: 2}},
                        ],
                        [
                            {text: 'L'},
                            {text: 'F'},
                            {text: 'R'},
                            {text: 'H'},
                            {text: 'Q'},
                        ],


                        [pptIndexCount, rows[1].innerHTML, rows[2].innerHTML, rows[3].innerHTML, rows[4].innerHTML, rows[6].innerHTML, rows[5].innerHTML, rows[8].innerHTML, rows[8].innerHTML,
                            rows[7].innerHTML, ''+ LEFT+'', ''+FRONT+'', ''+RIGHT+'', ''+HEIGHT+'', ''+QUANTITY+'', '' + SQFT + ''],
                    ];

                    console.log(rows)
                    var tabOpts = { x:0.1, y:0.1, w:12, colW: [.3, .6, .6, .7, .6, .7, 2.2, 1.0, .6, 1.0, .2, .2, .2, .2, .2, .5], fill:'F7F7F7', fontSize:8, color:'363636' };
                    slide.addTable( slideRows, tabOpts );

                    slide.addText('Survey Image',  { x:0.2, y:1.6, w:2, color:'000000', fontSize:12 });
                    // slide.addText('After',   { x:5.2, y:1.6, w:2, color:'000000', fontSize:12 });

                    var positionX;
                    var positionXB1 = 0.2;
                    var positionXB2 = 3.5;
                    var positionXB3 = 6.8;
                    var positionY;
                    var positionXA1 = 5.0;
                    var positionXA2 = 6.2;
                    var positionXA3 = 7.4;
                    var ImageBeforeColumn = 10;
                    var ImageAfterColumn = 17;
                    // Before
                    positionY = 1.9;
                    for (let j = 0; j < rows[ImageBeforeColumn].children.length; j++)
                    {
                        if (j === 0 || j === 3 || j === 6) { positionX = positionXB1; }
                        if (j === 1 || j === 4 || j === 7) { positionX = positionXB2; }
                        if (j === 2 || j === 5 || j === 8) { positionX = positionXB3; }
                        // positionX = j % 2 === 0 ? 0.2 : 1.4;
                        // positionX = j === 0 ? positionX1 : j % 3 === 0 ? 2.6 : j % 2 === 0 ? 2.6 : 1.4;
                        positionY = j === 0 ? positionY : j % 3 === 0 ? positionY + 1.1 : positionY;
// Image from remote URL


                        var image_path = rows[ImageBeforeColumn].children[j].href.replace("www.","");

                        slide.addImage({ hyperlink:{ url:rows[ImageBeforeColumn].children[j].href }, path:image_path, x:positionX, y:positionY, w:3, h:3 });
                    }


                    positionY = 1.9;
                    // for (let j = 0; j < rows[ImageAfterColumn].children.length; j++)
                    // {
                    //     if (j === 0 || j === 3 || j === 6) { positionX = positionXA1; }
                    //     if (j === 1 || j === 4 || j === 7) { positionX = positionXA2; }
                    //     if (j === 2 || j === 5 || j === 8) { positionX = positionXA3; }
                    //     // positionX = j % 2 === 0 ? 5.0 : 6.2;
                    //     // positionX = j === 0 ? 5.0 : j % 3 === 0 ? 7.4 : j % 2 === 0 ? 5.0 : 6.2;
                    //     positionY = j === 0 ? positionY : j % 3 === 0 ? positionY + 1.1 : positionY;
                    //
                    //     slide.addImage({ hyperlink:{ url:rows[ImageAfterColumn].children[j].href }, path:rows[ImageAfterColumn].children[j].href, x:positionX, y:positionY, w:1, h:1 });
                    // }




                    // slide.addImage({ hyperlink:{ url:rows[10].children[0].href }, path:rows[8].children[0].href, x:0.2, y:1.6, w:1, h:1 });
                    // slide.addImage({ hyperlink:{ url:rows[10].children[1].href }, path:rows[8].children[1].href, x:1.4, y:1.6, w:1, h:1 });
                    // slide.addImage({ hyperlink:{ url:rows[10].children[2].href }, path:rows[8].children[2].href, x:0.2, y:2.8, w:1, h:1 });
                    // slide.addImage({ hyperlink:{ url:rows[10].children[3].href }, path:rows[8].children[3].href, x:1.4, y:2.8, w:1, h:1 });
                    // slide.addImage({ hyperlink:{ url:rows[10].children[4].href }, path:rows[8].children[4].href, x:0.2, y:4.0, w:1, h:1 });
                    // slide.addImage({ hyperlink:{ url:rows[10].children[5].href }, path:rows[8].children[5].href, x:1.4, y:4.0, w:1, h:1 });
                    // // After
                    // slide.addImage({ hyperlink:{ url:rows[10].children[0].href }, path:rows[10].children[0].href, x:5.0, y:1.6, w:1, h:1 });
                    // slide.addImage({ hyperlink:{ url:rows[10].children[1].href }, path:rows[10].children[1].href, x:6.4, y:1.6, w:1, h:1 });
                    // slide.addImage({ hyperlink:{ url:rows[10].children[2].href }, path:rows[10].children[2].href, x:5.0, y:2.8, w:1, h:1 });
                    // slide.addImage({ hyperlink:{ url:rows[10].children[3].href }, path:rows[10].children[3].href, x:6.4, y:2.8, w:1, h:1 });
                    // slide.addImage({ hyperlink:{ url:rows[10].children[4].href }, path:rows[10].children[4].href, x:5.0, y:4.0, w:1, h:1 });
                    // slide.addImage({ hyperlink:{ url:rows[10].children[5].href }, path:rows[10].children[5].href, x:6.4, y:4.0, w:1, h:1 });


                    pptIndexCount++;
                }
            });
            var d = new Date();
            var strDate = d.getDate() + "_" + (d.getMonth()+1) + "_" + d.getFullYear() + "_" + d.getHours() + "_" + d.getMinutes() + "_" + d.getSeconds();
            pptx.save('Survey_Report_'+strDate);



        });

    </script>
    {{--ppt    --}}

@endsection

