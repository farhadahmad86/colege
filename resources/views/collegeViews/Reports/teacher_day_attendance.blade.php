@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Absent Staff</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('teacher_day_attendance') }}" name="form1" id="form1"
                          method="post">
                        <div class="row">
                            @csrf
                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Start Date
                                    </label>
                                    <input tabindex="1" type="text" name="date" id="date"
                                           class="inputs_up form-control datepicker1" autocomplete="off"
                                           <?php if(isset($search_date)){?> value="{{ $search_date }}" <?php } ?>
                                           placeholder="Start Date ......"/>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 mt-4 text-right form_controls">
                                @include('include.clear_search_button')

                                @include('include/print_button')
                                <span id="demo3" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div><!-- end row -->
                    </form>
                </div>

                <div class="row">
                    @php
                        $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                        $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                        $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                        $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;

                    @endphp
                    @foreach($datas as $data)
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                            <div class="card">
                                <div class="card-header">
                                    {{$data->user_name}} <span class="badge badge-light float-right">{{$data->absent != null ? $data->absent : ($data->short_leave != null ? $data->short_leave :
                                    $data->leaves)}}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div> <!-- white column form ends here -->
        </div><!-- col end -->
    </div><!-- row end -->
@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('teacher_day_attendance') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery("#cancel").click(function () {
            $("#date").val('');
        });
    </script>

@endsection

