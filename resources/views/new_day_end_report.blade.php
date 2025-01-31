@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="container-fluid search-filter form-group form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Day End Report</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
            <!-- <div class="search_form  {{ ( !empty($search_to)) ? '' : 'search_form_hidden' }}"> -->
                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('day_end_reports') }}" name="form1" id="form1" method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Start Date
                                    </label>
                                    <input tabindex="1" autofocus type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
                                           <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......"/>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-10 col-md-9 col-sm-12 col-xs-12 text-right mt-4">

                                @include('include.clear_search_button')


                                @include('include/print_button')

                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">Sr#</th>
                            <th scope="col" class="tbl_srl_4">ID</th>
                            <th scope="col" class="tbl_txt_18">Date</th>
                            <th scope="col" class="tbl_txt_18">Time</th>
                            <th scope="col" class="tbl_txt_20">Day Report</th>
                            <th scope="col" class="tbl_txt_20">Month Report</th>
                            <th scope="col" class="tbl_txt_20">Created By</th>

                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                        @endphp
                        @forelse($datas as $area)

                            <tr>

                                <td class="edit tbl_srl_4">{{$sr}}</td>
                                <td class="edit tbl_srl_4">{{$area->de_id}}</td>

                                <td class="edit tbl_txt_18">{{$area->de_datetime}}</td>
                                <td class="edit tbl_txt_18">{{$area->de_current_datetime}}</td>

                                <td class="align_left text-center edit tbl_txt_20"><a href="{{$area->de_report_url}}" target="_blank">View Report</a></td>

                                <td class="align_left text-center edit tbl_txt_20">
                                    @if(empty($area->de_month_end_report_url))
                                        -
                                    @else
                                        <a href="{{$area->de_month_end_report_url}}" target="_blank">View Report</a>
                                    @endif
                                </td>

                                <td class="usr_prfl tbl_txt_20" data-usr_prfl="{{ $area->user_id }}" title="Click To See User Detail">
                                    {{ $area->user_name }}
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Day End Report</h3></center>
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
                        <span class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'to'=>$search_to])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')



    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('day_end_reports') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let areaId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_area') }}',
                    data: {'status': status, 'area_id': areaId},
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
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

