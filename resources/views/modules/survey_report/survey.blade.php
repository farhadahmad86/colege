@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/css/lightgallery.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/core/colors/palette-gradient.css') }}">
    <style>
        .lg-backdrop.in,
        .lg-outer {
            z-index: 1060;
        }
    </style>
@stop

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-wrapper-before"></div>
            <div class="content-header row">
                <div class="content-header-left col-md-4 col-12 mb-2">
                </div>
            </div>
            <div class="card search d-none">
                <div class="card-header">Search</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12" style="width: 100%; margin: 0 0 20px auto">

                            {{--                                <form id="filterForm" class="prnt_lst_frm" action="{{ route('show-voucher') }}" method="get">--}}
                            <form class="prnt_lst_frm" action="{{ route('survey') }}" method="get">
                                <div class="row">
                                    {{--                                    --}}{{--                                        <div class="col-lg-3">--}}
                                    {{--                                    --}}{{--                                            <label>Global Search:</label>--}}
                                    {{--                                    --}}{{--                                            <input type="search" name="search" id="search" value="" class="form-control" placeholder="Search using Fuzzy searching">--}}
                                    {{--                                    --}}{{--                                        </div>--}}
                                    <div class="col-lg-3">
                                        <label>From:</label>
                                        <input type="date" class="form-control" name="from_date" value="{{$from_date}}"></div>
                                    <div class="col-lg-3">
                                        <label>To:</label>
                                        <input type="date" class="form-control" name="to_date" value="{{$to_date}}"></div>

                                    <div class="col-lg-3">
                                        <label for="filter">Created By:</label>

                                        <select class="custom-select" name="createdby" id="filter">
                                            <option value="" selected>-- Choose one --</option>
                                            @foreach($user as $vis)
                                                <option value="{{$vis->id}}"
                                                        {{ $createdby == $vis->id ? 'selected="selected"' : ''}}
                                                >{{$vis->full_name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    {{--                                </div>--}}
                                    {{--                                <div class="row">--}}
                                    <div class="col-lg-3">
                                        <label for="filter">Execution:</label>

                                        <select class="custom-select" name="execution">
                                            <option value="" selected>-- Choose one --</option>
                                            <option value="YES" {{ (isset($execution) ? $execution : '') == 'YES' ? 'selected' : '' }}>Yes</option>
                                            <option value="NO" {{ (isset($execution) ? $execution : '') == 'NO' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>
                                    {{--                                </div>--}}
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-12 text-center">
                                        <button id="submit" type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body"><!-- BasicPackage Tables start -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Survey Report ({{ count($datas) }})</h4>

                                <div class="col-md-1 float-right">
                                    <button id="refresh" class="fa fa-refresh form-control-sm"></button>
                                </div>
                                <button class="fa fa-search float-right form-control-sm" id="searches"></button>

                                <div class="btn-group btn-sm float-right" style="margin-top: 0px">
                                    <button type="button" class="btn btn-primary grp_btn" onclick="prnt_cus('pdf')">Print</button>
                                    <button type="button" class="btn btn-primary dropdown-toggle grp_btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-right print_act_drp hide_column" x-placement="bottom-end">
                                        <button type="button" class="dropdown-item" id="" onclick="prnt_cus('download_pdf')">
                                            <i class="fa fa-print"></i> Download PDF
                                        </button>
                                        <button type="button" class="dropdown-item" onclick="prnt_cus('download_excel')">
                                            <i class="fa fa-file-excel-o"></i> Excel Sheet
                                        </button>
                                        <button id="pptbtn" type="button" class="dropdown-item">
                                            <i class="fa fa-file-excel-o"></i> Export to PPTX
                                        </button>
                                    </div>
                                </div>
                                @include('inc._messages')
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="ppt" class="table">
                                            <thead>
                                            <tr>
                                                <th data-pptx-min-width="0.6" style="width: 5%" nowrap="">#</th>
{{--                                                <th nowrap="">Id</th>--}}
                                                <th nowrap="">Region</th>
                                                <th nowrap="">Grid</th>
                                                <th nowrap="">Franchise</th>
                                                <th nowrap="">City</th>

                                                <th nowrap="">Project Name</th>
                                                <th nowrap="">Shop Name</th>
                                                <th nowrap="">Shop Keeper Name</th>
                                                <th nowrap="">Shop Address</th>
                                                <th nowrap="">Contact 0ne</th>
                                                <th nowrap="">Contact Two</th>
                                                <th nowrap="">BDO Name</th>
                                                <th nowrap="">BDO Number</th>
                                                <th nowrap="">type</th>
                                                <th nowrap="">Images Before</th>
                                                <th nowrap="">Images After</th>
                                                <th nowrap="">Approved</th>
                                                <th nowrap="">Execution</th>
                                                <th nowrap="">Created By</th>
                                                <th nowrap="">Created At</th>
                                                <th nowrap="">Updated By</th>
                                                <th nowrap="">Updated At</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($datas as $index=>$survey)
                                                <tr>
                                                    <td nowrap="">{{$index+1}}</td>
{{--                                                    <td nowrap="">{{ $survey->id }}</td>--}}
                                                    <td nowrap="">{{$survey->region }}</td>
                                                    <td nowrap="">{{ $survey->grid }}</td>
                                                    <td nowrap="">{{ $survey->franchise }}</td>
                                                    <td nowrap="">{{ $survey->city }}</td>

                                                    <td nowrap="">{{ $survey->projectName }}</td>
                                                    <td nowrap="">{{ $survey->shop_name }}</td>
                                                    <td nowrap="">{{ $survey->shop_keeper_name }}</td>
                                                    <td nowrap="">{{ $survey->shop_address_auto }}</td>
                                                    <td nowrap="">{{ $survey->contact_one }}</td>
                                                    <td nowrap="">{{ $survey->contact_two }}</td>
                                                    <td nowrap="">{{ $survey->bdo_name }}</td>
                                                    <td nowrap="">{{ $survey->bdo_number }}</td>
{{--                                                    <td nowrap="">{{ $survey->whats_app_number }}</td>--}}
                                                    {{--                                                    <td nowrap="">{{ $survey->type }}</td>--}}
                                                    <td nowrap="">{{ $survey->types_lable }}</td>

                                                    <td nowrap="">
                                                        <table style="padding: 0; margin: 0" border="0" cellspacing="0" cellpadding="0">
                                                            <tbody style="padding: 0; margin: 0">
                                                            <tr style="padding: 0; margin: 0">
                                                                <td style="padding: 0; margin: 0; border:none" class=" lightgallery">
                                                                    @foreach($imgs[$survey->id] as $a)
                                                                        <a href="{{$a->complete_url}}" style="user-select: auto;"> <img class="media-object rounded-circle no-border-top-radius no-border-bottom-radius avatar avatar-sm pull-up" src="{{$a->complete_url}}" width="30px" height="30px" alt="" style="user-select: auto;"></a>
                                                                    @endforeach

                                                                </td>
                                                            </tr>
                                                            <tr style="padding: 0;margin: 0">
                                                                <td style="padding: 0; margin: 0; border:none">

                                                                    @foreach($imgs[$survey->id] as $a)

                                                                        <a data-toggle="modal" data-target=".bd-example-modal-lg" id="{{ $a->id}}" class="href" style="user-select: auto; padding-left: 10px; padding-right: 10px"><i class="fa fa-info-circle" style="user-select: auto;"></i></a>
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>

                                                    <td nowrap="" class=" lightgallery">
                                                        @foreach($imgAf[$survey->id] as $a)

                                                            <a href="{{$a->complete_url}}"> <img class="media-object rounded-circle no-border-top-radius no-border-bottom-radius avatar avatar-sm pull-up" src="{{$a->complete_url}}" width="30px" height="30px" alt=""></a>
                                                           {{-- {{ $a->left_side }}
                                                            {{ $a->front_side }}
                                                            {{ $a->right_side }}
                                                            {{ $a->height }}
                                                            {{ $a->quantity }}--}}
                                                        @endforeach
                                                    </td>
                                                    <td nowrap="">{{ $survey->approved }}</td>
                                                    <td nowrap="">{{ $survey->execution }}</td>
                                                    <td nowrap="">{{ $survey->cname }}</td>

                                                    {{--                                                    <td nowrap="">{{ $survey->created_at }}</td>--}}
                                                    <td nowrap="">{{date('d-M-Y h:i a', strtotime($survey->created_at))}}</td>
                                                    {{--                                                    <td nowrap="">{{ $survey->created_at }}</td>--}}
                                                    <td nowrap="">{{ $survey->uname }}</td>
                                                    @if($survey->updated_by >0)
                                                        <td nowrap="">{{date('d-M-Y h:i a', strtotime($survey->updated_at))}}</td>
                                                        {{--                                                    <td nowrap="">{{ $survey->updated_at }}</td>--}}
                                                    @else
                                                        <td nowrap=""></td>
                                                    @endif

                                                    <td class="d-none sqft_values">
                                                        @foreach($imgs[$survey->id] as $a)
                                                            <div class="d-none sqft_l">{{ $a->left_side }}</div>
                                                            <div class="d-none sqft_f">{{ $a->front_side }}</div>
                                                            <div class="d-none sqft_r">{{ $a->right_side }}</div>
                                                            <div class="d-none sqft_h">{{ $a->height }}</div>
                                                            <div class="d-none sqft_q">{{ $a->quantity }}</div>
                                                        @endforeach
                                                    </td>


                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    <!-- Large modal -->--}}


    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h2>Image Details</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <table class="table visitor_log"></table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


{{--    <table id="tabAutoPaging" class="tabCool">--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th data-pptx-min-width="0.6" style="width: 5%">Row</th>--}}
{{--            <th data-pptx-min-width="0.8" style="width:10%">Last Name</th>--}}
{{--            <th data-pptx-min-width="0.8" style="width:10%">First Name</th>--}}
{{--            <th data-pptx-width="8.5"     style="width:75%">Description</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody></tbody>--}}
{{--    </table>--}}

@endsection

@section('script')

    {{--    ppt--}}
    <!-- Bundle: Easiest to use, supports all browsers -->
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.5.0/dist/pptxgen.bundle.js"></script>

    <!-- Individual files: Add only what's needed to avoid clobbering loaded libraries -->
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.5.0/libs/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.5.0/libs/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.5.0/dist/pptxgen.min.js"></script>



    <!-- Bundle: Easiest to use, supports all browsers -->
    {{--<script src=" {{ asset('PptxGenJS/libs/pptxgen.bundle.js') }}"></script>--}}
    <script src=" {{ asset('PptxGenJS/dist/pptxgen.bundle.js') }}"></script>

    <!-- Individual files: Add only what's needed to avoid clobbering loaded libraries -->
    <script src="{{ asset('PptxGenJS/libs/jquery.min.js') }}"></script>
    <script src="{{ asset('PptxGenJS/libs/jszip.min.js') }}"></script>
    <script src="{{ asset('PptxGenJS/dist/pptxgen.min.js') }}"></script>
    <!-- IE11 requires Promises polyfill -->
    <!-- <script src="PptxGenJS/libs/promise.min.js"></script> -->
    <script>
        $('#pptbtn').on('click', function () {


            // $('#ppt tbody tr').each(function (i, row) {
            //     console.log(i, $(row).eq(i).find('td').eq(1)[0].innerText);
            // });




            var pptx = new PptxGenJS();
            var pptIndexCount = 1;
            $('#ppt tbody>tr').each(function (i, row) {
                if (i % 3 == 0) {

                    // var rows = $(this).eq(0).find('td');
                    // console.log(rows[24].children);
                    // return 0;


                    var rows = $(this).eq(0).find('td');

                    var SQFT = 0;
                    var LEFT = 0;
                    var FRONT = 0;
                    var RIGHT = 0;
                    var HEIGHT = 0;
                    var QUANTITY = 0;
                    var sqft_values = rows[24].children;
                    for (var k = 0; k < sqft_values.length; k = k + 5)
                    {

                        var l = parseFloat(sqft_values[k + 0].innerHTML);
                        var f = parseFloat(sqft_values[k + 1].innerHTML);
                        var r = parseFloat(sqft_values[k + 2].innerHTML);
                        var h = parseFloat(sqft_values[k + 3].innerHTML);
                        var q = parseFloat(sqft_values[k + 4].innerHTML);

                        SQFT += (((l + f + r) * h) * q);
                        LEFT +=l;
                        FRONT +=f;
                        RIGHT +=r;
                        HEIGHT +=h;
                        QUANTITY +=q;


                    }
                    // console.log(LEFT);
                    // console.log(FRONT);
                    // console.log(RIGHT);
                    // console.log(HEIGHT);
                    // console.log(QUANTITY);
                    // console.log(SQFT);

                    var slide = pptx.addNewSlide();
                    var slideRows = [

                        // ['#', 'Region', 'Grid', 'Franchise', 'City', 'Project Name', 'Shop Name', 'address', 'Contact', 'BDO Name', 'BDO Number',
                        //     {text: 'Survey Size', options: {colspan: 5}}, 'L', 'F', 'R', 'H', 'Q', 'SQFT'],

                        [
                            {text: '#', options: {rowspan: 2}},
                            {text: 'Region', options: {rowspan: 2}},
                            {text: 'Grid', options: {rowspan: 2}},
                            {text: 'Franchise', options: {rowspan: 2}},
                            {text: 'City', options: {rowspan: 2}},
                            // {text: 'Project Name', options: {rowspan: 2}},
                            {text: 'Shop Name', options: {rowspan: 2}},
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


                        [pptIndexCount, rows[1].innerHTML, rows[2].innerHTML, rows[3].innerHTML, rows[4].innerHTML, rows[6].innerHTML, rows[8].innerHTML, rows[9].innerHTML, rows[11].innerHTML, rows[12].innerHTML, ''+ LEFT+'', ''+FRONT+'', ''+RIGHT+'', ''+HEIGHT+'', ''+QUANTITY+'', '' + SQFT + ''],
                    ];
                    var tabOpts = { x:0.1, y:0.1, w:12, colW: [.3, .6, .6, .7, .6, .7, 2.2, 1.0, .6, 1.0, .2, .2, .2, .2, .2, .5], fill:'F7F7F7', fontSize:10, color:'363636' };
                    slide.addTable( slideRows, tabOpts );

                    slide.addText('Before',  { x:0.2, y:1.6, w:2, color:'000000', fontSize:12 });
                    slide.addText('After',   { x:5.2, y:1.6, w:2, color:'000000', fontSize:12 });

                    var positionX;
                    var positionXB1 = 0.2;
                    var positionXB2 = 1.4;
                    var positionXB3 = 2.6;
                    var positionY;
                    var positionXA1 = 5.0;
                    var positionXA2 = 6.2;
                    var positionXA3 = 7.4;
                    var ImageBeforeColumn = 15;
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

                        slide.addImage({ hyperlink:{ url:rows[ImageBeforeColumn].children[j].href }, path:rows[ImageBeforeColumn].children[j].href, x:positionX, y:positionY, w:1, h:1 });
                    }

                    positionY = 1.9;
                    for (let j = 0; j < rows[ImageAfterColumn].children.length; j++)
                    {
                        if (j === 0 || j === 3 || j === 6) { positionX = positionXA1; }
                        if (j === 1 || j === 4 || j === 7) { positionX = positionXA2; }
                        if (j === 2 || j === 5 || j === 8) { positionX = positionXA3; }
                        // positionX = j % 2 === 0 ? 5.0 : 6.2;
                        // positionX = j === 0 ? 5.0 : j % 3 === 0 ? 7.4 : j % 2 === 0 ? 5.0 : 6.2;
                        positionY = j === 0 ? positionY : j % 3 === 0 ? positionY + 1.1 : positionY;

                        slide.addImage({ hyperlink:{ url:rows[ImageAfterColumn].children[j].href }, path:rows[ImageAfterColumn].children[j].href, x:positionX, y:positionY, w:1, h:1 });
                    }
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
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('survey') }}',
            url;

        @include('print.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/js/lightgallery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".lightgallery").lightGallery({
                loop: false,
            });
        });
    </script>

    <script>
        $(document).ready(function () {

            $(".href").click(function () {

                var bf_id = $(this).attr('id');
// alert(vis_id);
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "get",
                    data: {bf_id: bf_id},
                    url: "{{route('before-image')}}",
                    success: function (data) {
                        // console.log(data);
                        // $('.modal-body .visitor_log').html(data.table);
                        $(".modal-body").html(data)

                    }

                });
            });
        });
    </script>
    <script>
        $("#searches").click(function () {
            $(".search").toggleClass('d-none');
        });
    </script>
    <script>
        $('#refresh').click(function () {
            window.location.replace("http://finead.digitalmunshi.com//survey");
            // location.reload();
        })
    </script>
@stop

