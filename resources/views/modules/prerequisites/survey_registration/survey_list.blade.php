@extends('extend_index')

@section('style')

    <link rel="stylesheet" type="text/css" href="{{asset('image_gallery_source/jquery.fancybox.css?v=2.1.5')}}" media="screen" />
    <!-- Add Button helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="{{ asset('image_gallery_source/helpers/jquery.fancybox-buttons.css?v=1.0.5') }}" />
    <!-- Add Thumbnail helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="{{ asset('image_gallery_source/helpers/jquery.fancybox-thumbs.css?v=1.0.7') }}" />


{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/css/lightgallery.min.css"/>--}}
{{--    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/core/menu/menu-types/vertical-menu.css') }}">--}}
{{--    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/core/colors/palette-gradient.css') }}">--}}
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
                                    <button id="refresh" class="fa fa-refresh form-control form-control-sm"></button>
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
                                    </div>
                                </div>
                                @include('inc._messages')
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th nowrap="">#</th>
                                                <th nowrap="">Company Name</th>
                                                <th nowrap="">Shop Name</th>
                                                <th nowrap="">Shop Address</th>
                                                <th nowrap="">Load Number</th>
                                                <th nowrap="">Whatsapp Number</th>
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
{{--                                                    <td nowrap="">{{ $survey->companyName }}</td>--}}
                                                    <td nowrap="">{{ $survey->sr_shop_name }}</td>
                                                    <td nowrap="">{{ $survey->sr_address }}</td>
                                                    <td nowrap="">{{ $survey->sr_contact }}</td>
                                                    <td nowrap="">{{ $survey->sr_contact2 }}</td>
                                                    {{--                                                    <td nowrap="">{{ $survey->type }} //$survey->types_lable</td>--}}
{{--                                                    <td nowrap="">{{ $survey->sr_front_left_right_type }}</td>--}}

                                                    <td nowrap="">
                                                        <table style="padding: 0; margin: 0" border="0" cellspacing="0" cellpadding="0">
                                                            <tbody style="padding: 0; margin: 0">
                                                            <tr style="padding: 0; margin: 0">
                                                                <td style="padding: 0; margin: 0; border:none" class="">
                                                                    @foreach($imgs[$survey->sr_id] as $a)


                                                                        <a class="fancybox-thumbs" href="{{$a->sri_before_image}}" style="user-select: auto;"> <img class="media-object rounded-circle
                                                                        no-border-top-radius no-border-bottom-radius avatar avatar-sm pull-up" src="{{$a->sri_before_image}}" width="30px"
                                                                                                                                            height="30px"
                                                                                                                                            alt="" style="user-select: auto;"></a>
{{--                                                                        <a class="fancybox-thumbs" data-fancybox-group="thumb" rel="gallery1" href={{$a->sri_before_image}}>--}}
{{--                                                                            <img src={{$a->sri_before_image}} alt="" />--}}
{{--                                                                        </a>--}}
{{--                                                                        <a class="fancybox-thumbs" data-fancybox-group="thumb" rel="gallery1" href="http://farm2.staticflickr.com/1459/23610702803_83655c7c56_b.jpg" >--}}
{{--                                                                            <img src={{$a->sri_before_image}} alt="" />--}}
{{--                                                                        </a>--}}

                                                                    @endforeach

                                                                </td>
                                                            </tr>
                                                            <tr style="padding: 0;margin: 0">
                                                                <td style="padding: 0; margin: 0; border:none">

                                                                    @foreach($imgs[$survey->sr_id] as $a)

                                                                        <a data-toggle="modal" data-target=".bd-example-modal-lg" id="{{ $a->sri_id}}" class="href" style="user-select: auto;
                                                                        padding-left: 10px; padding-right: 10px"><i class="fa fa-info-circle" style="user-select: auto;"></i></a>


                                                                    @endforeach

                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>


                                                    </td>


{{--                                                    <td nowrap="" class=" lightgallery">--}}
{{--                                                        @foreach($imgAf[$survey->id] as $a)--}}

{{--                                                            <a href="{{$a->complete_url}}"> <img class="media-object rounded-circle no-border-top-radius no-border-bottom-radius avatar avatar-sm pull-up" src="{{$a->complete_url}}" width="30px" height="30px" alt=""></a>--}}
{{--                                                        @endforeach--}}
{{--                                                    </td>--}}
{{--                                                    <td nowrap="">{{ $survey->approved }}</td>--}}
{{--                                                    <td nowrap="">{{ $survey->execution }}</td>--}}
                                                    <td nowrap="">
{{--                                                        {{ $survey->name }}--}}
                                                        {{ $survey->sr_user_id }}</td>

                                                    {{--                                                    <td nowrap="">{{ $survey->created_at }}</td>--}}
{{--                                                    <td nowrap="">{{date('d-M-Y h:i a', strtotime($survey->created_at))}}</td>--}}
                                                    {{--                                                    <td nowrap="">{{ $survey->created_at }}</td>--}}
{{--                                                    <td nowrap="">{{ $survey->sr_shop_code }}</td>--}}
{{--                                                    @if($survey->updated_by >0)--}}
{{--                                                        <td nowrap="">{{date('d-M-Y h:i a', strtotime($survey->updated_at))}}</td>--}}
{{--                                                        --}}{{--                                                    <td nowrap="">{{ $survey->updated_at }}</td>--}}
{{--                                                    @else--}}
{{--                                                        <td nowrap=""></td>--}}
{{--                                                    @endif--}}
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


@endsection

@section('script')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('survey') }}',
            url;

{{--        @include('print.print_script_sh')--}}
    </script>
    {{--    add code by shahzaib end --}}
    <script type="text/javascript" src="{{ asset('image_gallery_source/lib/jquery-1.10.2.min.js') }}"></script>

    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="{{ asset('image_gallery_source/lib/jquery.mousewheel.pack.js?v=3.1.3') }}"></script>

    <!-- Add fancyBox main JS and CSS files -->
    <script type="text/javascript" src="{{ asset('image_gallery_source/jquery.fancybox.pack.js?v=2.1.5') }}"></script>
    <script type="text/javascript" src="{{ asset('image_gallery_source/helpers/jquery.fancybox-buttons.js?v=1.0.5') }}"></script>
    <script type="text/javascript" src="{{ asset('image_gallery_source/helpers/jquery.fancybox-thumbs.js?v=1.0.7') }}"></script>

    <!-- Add Media helper (this is optional) -->
    <script type="text/javascript" src="{{ asset('image_gallery_source/helpers/jquery.fancybox-media.js?v=1.0.6') }}"></script>

{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/js/lightgallery.min.js"></script>--}}
    <script type="text/javascript">
        // $(document).ready(function () {
        //     $(".lightgallery").lightGallery({
        //         loop: false,
        //     });
        // });
        $(document).ready(function() {
            $('.fancybox-thumbs').fancybox({
                prevEffect : 'none',
                nextEffect : 'none',

                closeBtn  : false,
                arrows    : false,
                nextClick : true,

                helpers : {
                    thumbs : {
                        width  : 50,
                        height : 50
                    }
                }
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
console.log(data)
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

