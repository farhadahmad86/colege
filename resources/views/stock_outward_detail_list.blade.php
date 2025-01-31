@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Stock Outward Detail List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <div class="search_form {{ ( !empty($search) || !empty($search_to) || !empty($search_from) || !empty($search_outward_type) ) ? '' : '' }}">
                    <div class="row">



                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <form class="prnt_lst_frm" action="{{ route('stock_outward_detail_list') }}" name="form1" id="form1" method="post">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="">
                                                Inward Type
                                            </label>
                                            <select tabindex="1" required autofocus name="inward_type" class="inputs_up form-control js-example-basic-multiple"
                                                    data-rule-required="true" data-msg-required="Please Choose Invoice Type"
                                                    id="inward_type">
                                                <option value="0" selected disabled>Select Invoice Type</option>
                                                <option value="self_collection" {{ "self_collection" == $search_outward_type ? 'selected="selected"' : ''}}>Self Collection</option>
                                                <option value="company_delivery" {{ "company_delivery" == $search_outward_type ? 'selected="selected"' : ''}}>Vendor Delivery</option>
                                                <option value="courier_service" {{ "courier_service" == $search_outward_type ? 'selected="selected"' : ''}}>Courier Service</option>
                                                <option value="third_party" {{ "third_party" == $search_outward_type ? 'selected="selected"' : ''}}>Third Party</option>

                                            </select>

                                            <span id="demo4" class="validate_sign"> </span>
                                        </div><!-- end input box -->
                                    </div>
                                    <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Start Date
                                            </label>
                                            <input  type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
                                                    <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......"/>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
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

                                            <a class="save_button form-control" href="{{ route('stock_outward') }}" role="button">
                                                <i class="fa fa-plus"></i> Stock Outward
                                            </a>

                                            @include('include/print_button')

                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>

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

                            <th scope="col" align="center" class="align_center text-center tbl_txt_3">
                                Inward #
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_6">
                                Inward Date
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_8">
                                Inward Type
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_7">
                                Party Name
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_8">
                                Name
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_9">
                                Cnic
                            </th>

                            <th scope="col" align="center" class="align_center text-center tbl_txt_7">
                                Mobile No
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_6">
                                Slip No
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_6">
                                Slip Date
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_6">
                                Booking City
                            </th>

                            <th scope="col" align="center" class="align_center text-center tbl_txt_6">
                                Vehicle #
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_6">
                                vehicle type
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_20">
                                Remarks
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

                            <tr data-remarks="{{$delivery_option->so_remarks}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Delivery Option">

                                <td class="align_center text-center tbl_txt_3">

                                    {{$delivery_option->so_id}}
                                </td>
                                <td class="align_right text-left tbl_txt_6">
                                    {{date('d-M-y', strtotime(str_replace('/', '-', $delivery_option->so_datetime)))}}
                                </td>
                                @php
                                    $type='';
                                        if($delivery_option->so_type == 'self_collection'){$type='Self Collection';}
                                        else if($delivery_option->so_type == 'company_delivery'){$type='Vendor Delivery';}
                                        else if($delivery_option->so_type == 'courier_service'){$type='Courier Service';}
                                        else if($delivery_option->so_type == 'third_party'){$type='Third Party';}

                                @endphp
                                <td class="view align_left text-left tbl_amnt_10" data-id="{{$delivery_option->so_id}}" data-do-type="{{$delivery_option->so_type}}">
                                    {{$type}}
                                </td>
                                <td class="align_left text-left tbl_txt_7">
                                    {{$delivery_option->so_party_name}}
                                </td>

                                @php
                                    $ip_browser_info= ''.$delivery_option->so_ip_adrs.','.str_replace(' ','-',$delivery_option->so_brwsr_info).'';
                                @endphp

                                <td class="align_left text-left tbl_txt_8">
                                    {{$delivery_option->sc_name}} {{$delivery_option->tp_driver_name}} {{$delivery_option->cs_courier_name}} {{$delivery_option->user_name}}
                                </td>
                                <td class="align_left text-left tbl_txt_9">
                                    {{$delivery_option->sc_cnic}} {{$delivery_option->user_cnic}}
                                </td>
                                <td class="align_center text-left tbl_txt_7">

                                    {{$delivery_option->sc_mobile}} {{$delivery_option->tp_mobile}} {{$delivery_option->user_mobile}}
                                </td>
                                <td class="align_left text-left tbl_txt_6">
                                    {{$delivery_option->cs_slip}}
                                </td>
                                <td class="align_center text-left tbl_txt_6">
                                    {{$delivery_option->cs_slip_date}}
                                </td>
                                <td class="align_left text-left tbl_txt_6">
                                    {{$delivery_option->city_name}}
                                </td>
                                <td class="align_left text-left tbl_txt_6">
                                    {{$delivery_option->tp_vehicle_no}}
                                </td>
                                <td class="align_center text-left tbl_txt_6">
                                    {{$delivery_option->tp_vehicle_type}}
                                </td>
                                <td class="align_left edit text-left tbl_txt_20">
                                    {{$delivery_option->sc_remarks}} {{$delivery_option->tp_remarks}} {{$delivery_option->cs_remarks}} {{$delivery_option->cd_remarks}}
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Stock Inward</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>


                    </table>
                </div>
                {{--                <span class="hide_column">  {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'to'=>$search_to, 'from'=>$search_from,'inward_type'=>$search_outward_type])->links() }}</span>--}}
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Stock Outward Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="itm_vchr form_manage">
                        <div class="form_header">
                            <h4 class="text-white file_name">
                                <span class="db sml_txt"> Stock Ouward #: </span>
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
        var base = '{{ route('stock_outward_detail_list') }}',
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
            $(".modal-body").load('{{ url("stock_outward_view_details/view/") }}/' + id + '?type=' + type, function (response, status, xhr) {

                console.log(response);
                $("#myModal").modal({show: true});
            });

        });
    </script>

    <script>

        jQuery(document).ready(function () {
            $("#inward_type").select2();
            $(".fa fa-search").click();

        });



        jQuery("#cancel").click(function () {

            $("#search").val('');
            $("#inward_type").select2().val(0).trigger("change");
            $("#inward_type > option").removeAttr('selected');
            $("#to").val('');
            $("#from").val('');

        });


    </script>



@endsection

