
@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Delivery Option List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->



                <div class="search_form {{ ( !empty($search) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <form class="prnt_lst_frm" action="{{ route('delivery_option_list') }}" name="form1" id="form1" method="post">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            {{--                                                    <label>--}}
                                            {{--                                                        All Column Search--}}
                                            {{--                                                    </label>--}}
                                            <input type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="All Data Search" value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($do_title as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">

                                        <div class="row">


                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Start Date
                                                    </label>
                                                    <input type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
                                                           <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......"/>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        End Date
                                                    </label>
                                                    <input type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off"
                                                           <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......"/>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    <a class="save_button form-control" href="{{ route('delivery_option') }}" role="button">
                                                        <i class="fa fa-plus"></i> Delivery Option
                                                    </a>

                                                    @include('include/print_button')

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>
                </div><!-- search form end -->



                <div class="table-responsive" id="printTable">
                    <table class="table table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" align="center" lass="align_center text-center tbl_amnt_8">
                               Invoice No
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_18">
                               Party Name
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                               Invoice Date
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_15">
                               Collection Date/Time
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_12">
                               Delivery Type
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_27">
                                Remarks
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                                Created By
                            </th>

                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            $dr_pg = $cr_pg = 0;
                        @endphp
                        @forelse($datas as $delivery_option)

                            <tr data-remarks="{{$delivery_option->do_remarks}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Delivery Option">

                                <td class="align_center text-center tbl_amnt_8">
                                    {{$delivery_option->do_invoice_no}}
                                </td>
                                <td class="align_left text-left tbl_amnt_18">
                                    {{$delivery_option->do_party_name}}
                                </td>
                                <td class="align_right text-left tbl_amnt_10">
                                    {{date('d-M-y', strtotime(str_replace('/', '-', $delivery_option->do_date)))}}
                                </td>
                                <td class="align_left text-left tbl_amnt_15">
                                    {{date("d-M-y g:i a", strtotime($delivery_option->do_collection_datetime))}}
                                </td>
                                <td class="view align_left text-left tbl_amnt_12" data-id="{{$delivery_option->do_id}}" data-do-type="{{$delivery_option->do_type}}">
                                    {{$delivery_option->do_type}}
                                </td>
                                {{--                                    <td class="align_left">{{$delivery_option->jv_remarks}}</td>--}}
                                <td class="align_left edit text-left tbl_txt_27">
                                    {{$delivery_option->do_remarks}}
                                </td>

                                @php
                                    $ip_browser_info= ''.$delivery_option->do_ip_adrs.','.str_replace(' ','-',$delivery_option->do_brwsr_info).'';
                                @endphp

                                <td class="align_left text-left usr_prfl tbl_txt_10" data-usr_prfl="{{ $delivery_option->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{$delivery_option->user_name}}
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Delivery</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>


                    </table>
                </div>
                <span class="hide_column">  {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'to'=>$search_to, 'from'=>$search_from])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Delivery Option Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="itm_vchr form_manage">
                        <div class="form_header">
                            <h4 class="text-white file_name">
                                <span class="db sml_txt"> Delivery Option #: </span>
                            </h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" align="center" class="wdth_5">Name</th>
                                    <th scope="col" align="center" class="wdth_5">CNIC</th>
                                    <th scope="col" align="center" class="wdth_5 ">Mobile</th>
                                    <th scope="col" align="center" class="wdth_5 ">Remarks</th>
                                </tr>
                                </thead>
                                <tbody id="table_body">
                                </tbody>
                                <tfoot id="table_foot">
                                </tfoot>
                            </table>
                        </div>
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

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('delivery_option_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function () {

            jQuery("#table_body").html("");

            {{--var id = jQuery(this).attr("data-id");--}}
            {{--$(".modal-body").load('{{ url("self_collection_view_details/view/") }}/'+id,function () {--}}
            {{--    $("#myModal").modal({show:true});--}}
            {{--});--}}

            var id = jQuery(this).attr("data-id");
            var type = jQuery(this).attr("data-do-type");
            console.log(type);
            $(".modal-body").load('{{ url("delivery_option_view_details/view/") }}/'+id+'?type='+type, function ( response, status, xhr ) {

                console.log(response);
                $("#myModal").modal({show:true});
            });

        });
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#search").val('');

            $("#to").val('');
            $("#from").val('');

        });
    </script>

@endsection

