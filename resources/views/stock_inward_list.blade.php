@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Stock Inward List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <div class="search_form m-0 p-0 {{ ( !empty($search) || !empty($search_to) || !empty($search_from) ) ? '' : '' }}">

                    <form class="highlight prnt_lst_frm" action="{{ route('stock_inward_list') }}" name="form1" id="form1" method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Search
                                    </label>
                                    <input type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="All Data Search"
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach($do_title as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Start Date
                                    </label>
                                    <input type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
                                           <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......"/>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        End Date
                                    </label>
                                    <input type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off"
                                           <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......"/>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-3 col-sm-12 col-xs-12 mt-4 text-right">
                                @include('include.clear_search_button')
                                <!-- Call add button component -->
                                    <x-add-button tabindex="9" href="{{ route('stock_inward') }}"/>

                                @include('include/print_button')

                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                            </div>
                        </div>
                    </form>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" class=" tbl_amnt_4">
                                Inward #
                            </th>
                            <th scope="col" class=" tbl_amnt_10">
                                Inward Date
                            </th>
                            <th scope="col" class=" tbl_amnt_10">
                                Inward Type
                            </th>
                            <th scope="col" class=" tbl_amnt_15">
                                Party Name
                            </th>
                            <th scope="col" class=" tbl_amnt_4">
                                PO #
                            </th>
                            <th scope="col" class=" tbl_txt_10">
                                QTY
                            </th>
                            <th scope="col" class=" tbl_amnt_10">
                                Receiving Date/Time
                            </th>

                            <th scope="col" class=" tbl_txt_27">
                                Remarks
                            </th>
                            <th scope="col" class="text-center align_center tbl_txt_10">
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

                            <tr data-remarks="{{$delivery_option->si_remarks}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Delivery Option">

                                <th>

                                    {{$delivery_option->si_id}}
                                </th>
                                <td>
                                    {{date('d-M-y', strtotime(str_replace('/', '-', $delivery_option->si_datetime)))}}
                                </td>
                                @php
                                    $type='';
                                        if($delivery_option->si_type == 'self_collection'){$type='Self Collection';}
                                        else if($delivery_option->si_type == 'company_delivery'){$type='Vendor Delivery';}
                                        else if($delivery_option->si_type == 'courier_service'){$type='Courier Service';}
                                        else if($delivery_option->si_type == 'third_party'){$type='Third Party';}

                                @endphp
                                <td class="view" data-id="{{$delivery_option->si_id}}" data-do-type="{{$delivery_option->si_type}}">
                                    {{$type}}
                                </td>
                                <td>
                                    {{$delivery_option->si_party_name}}
                                </td>
                                <td>
                                    {{$delivery_option->si_purchase_order_id}}

                                </td>
                                <td class="edit">
                                    {{$delivery_option->si_builty_qty}}
                                </td>
                                <td>
                                    {{date("d-M-y g:i a", strtotime($delivery_option->si_receiving_datetime))}}
                                </td>

                                <td class="edit">
                                    {{$delivery_option->si_remarks}}
                                </td>

                                @php
                                    $ip_browser_info= ''.$delivery_option->si_ip_adrs.','.str_replace(' ','-',$delivery_option->si_brwsr_info).'';
                                @endphp

                                <td class="usr_prfl" data-usr_prfl="{{ $delivery_option->user_id }}" data-user_info="{!! $ip_browser_info !!}"
                                    title="Click To See User Detail">
                                    {{$delivery_option->user_name}}
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
                <div class="row">
                    <div class="col-md-3">
                        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                    </div>
                    <div class="col-md-9 text-right">
                        <span class="hide_column">  {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'to'=>$search_to, 'from'=>$search_from])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Stock Inward Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="itm_vchr form_manage">
                        <div class="form_header">
                            <h4 class="text-white file_name">
                                <span class="db sml_txt"> Stock Inward #: </span>
                            </h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" class="wdth_5">Name</th>
                                    <th scope="col" class="wdth_5">CNIC</th>
                                    <th scope="col" class="wdth_5 ">Mobile</th>
                                    <th scope="col" class="wdth_5 ">Remarks</th>
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
        var base = '{{ route('stock_inward_list') }}',
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
            $(".modal-body").load('{{ url("stock_inward_view_details/view/") }}/' + id + '?type=' + type, function (response, status, xhr) {

                console.log(response);
                $("#myModal").modal({show: true});
            });

        });
    </script>

    <script>

        jQuery(document).ready(function () {

            $(".fa fa-search").click();

        });


        jQuery("#cancel").click(function () {

            $("#search").val('');

            $("#to").val('');
            $("#from").val('');

        });


    </script>



@endsection

