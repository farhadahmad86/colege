@extends('extend_index')

@section('content')
    <style>
        @font-face {
            font-family: Jameel;
            src: url({{ asset('public/urdu_font/Jameel.ttf') }});
        }

        /*.table th, .table td {*/
        /*    font-family: Jameel;*/
        /*}*/

        .fonti {
            font-family: Jameel;
        }
    </style>

    <div class="row">
            <div class="container-fluid search-filter form-group form_manage" id="">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Profit And Loss Generator</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('profit_n_loss2') }}" name="form1"
                          id="form1" method="post">
                        @csrf
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                <div class="row">

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Start Date
                                            </label>
                                            <input tabindex="5" type="text" name="to" id="to"
                                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                                   placeholder="Start Date ......"/>
                                            <span id="demo1" class="validate_sign"
                                                  style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                End Date
                                            </label>
                                            <input tabindex="6" type="text" name="from" id="from"
                                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                                   placeholder="End Date ......"/>
                                            <span id="demo1" class="validate_sign"
                                                  style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <x-year-end-component search="{{$search_year}}"/>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right mt-4">

                                        @include('include.clear_search_button')

                                        {{-- @include('include.print_button')

                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span> --}}

                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>
                </div><!-- search form end -->

            </div> <!-- white column form ends here -->
    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg mdl_wdth">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Sales Invoice Detail</h4>
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


    {{--    <script> --}}
    {{--        $('#submit_btn').click(function(){ // click to --}}
    {{--            alert(); --}}
    {{--            event.preventDefault(); --}}
    {{--            // $('#submit_btn').attr('disabled',false); // removing disabled in this class --}}
    {{--        }); --}}
    {{--    </script> --}}
@endsection
