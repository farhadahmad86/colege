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

        .approval {
            cursor: pointer;
            color: green;
        }



         a{
             color: #007bff;
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
                            <h4 class="text-white get-heading-text file_name">Approved Purchase Requisition List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
            {{--                !empty($search) ||--}}
            <!-- <div class="search_form {{ (  !empty($search_product) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <form class="prnt_lst_frm" action="{{ route('Purchase_Requisition_invoice_list') }}" name="form1" id="form1" method="post">
                                @csrf
                                <div class="row">

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


                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                        <div class="row">

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        All Column Search
                                                    </label>
                                                    <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}" autocomplete="off">

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                    {{--                                            <input type="checkbox" name="check_desktop" id="check_desktop" value="1" {{$check_desktop==1 ? 'checked':'' }}>--}}
                                                    {{--                                            <label class="d-inline" for="check_desktop">Desktop Invoice</label>--}}
                                                </div>
                                            </div> <!-- left column ends here -->


                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Party
                                                    </label>
                                                    <select tabindex="2" class="inputs_up form-control" name="status" id="status">
                                                        <option value="">Select Status</option>
                                                        <option value="work" >Work Order</option>
                                                        <option value="open" >Open</option>
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>


                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Start Date
                                                    </label>
                                                    <input tabindex="5" type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
                                                           <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......"/>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        End Date
                                                    </label>
                                                    <input tabindex="6" type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off"
                                                           <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......"/>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button tabindex="7" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button tabindex="8" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    {{--                                                    <a tabindex="9" class="save_button form-control" href="{{ route('sale_invoice') }}" role="button">--}}
                                                    {{--                                                        <i class="fa fa-plus"></i> Sale Invoice--}}
                                                    {{--                                                    </a>--}}
                                                    {{--                                                    <button id="pptbtn" type="button" class="cancel_button form-control">--}}
                                                    {{--                                                        --}}{{--                                                        dropdown-item<i class="fa fa-file-excel-o"></i>--}}
                                                    {{--                                                        <i class="fa fa-arrow-down"></i> Export to PPTX--}}
                                                    {{--                                                    </button>--}}
                                                    @include('include/print_button')

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </form>


                            {{--                            <form name="edit" id="edit" action="{{ route('edit_account') }}" method="post">--}}
                            {{--                                @csrf--}}
                            {{--                                <input tabindex="10" name="account_id" id="account_id" type="hidden">--}}
                            {{--                            </form>--}}

                        </div>

                    </div>
                </div><!-- search form end -->

                <form method="post" action="{{route('survey_approved')}}" name="f1" class="f1" id="f1" onsubmit="return checkForm()">

{{--                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">--}}
{{--                        <div class="input_bx"><!-- start input box -->--}}
{{--                            <label class="required">--}}
{{--                                Vendor--}}
{{--                            </label>--}}
{{--                            <select tabindex="3" class="inputs_up  form-control" name="designer_name" id="designer_name" data-rule-required="true"--}}
{{--                                    data-msg-required="Please Select Designer Title">--}}
{{--                                <option value="" disabled selected>Select Vendor Name</option>--}}
{{--                                <option value="00" >No Designer</option>--}}
{{--                                @foreach($accounts as $account)--}}
{{--                                    <option value="{{$account->account_uid}}">{{$account->account_name}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="table-responsive" id="printTable">
                        <table class="table table-sm" id="fixTable">

                            <thead>
                            <tr>
                                {{--                                <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">--}}
                                {{--                                    <input type="checkbox" name="select-all" id="select-all"/>--}}
                                {{--                                </th>--}}
                                <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">
                                    Sr#
                                </th>
                                <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_6">
                                    Work Order ID
                                </th>
                                <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_6">
                                    Title
                                </th>

                                <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_8">
                                    Department
                                </th>
                                <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_10">
                                    Employee
                                </th>
                                <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_15">
                                    Remarks
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_srl_5">
                                    Total Items
                                </th>
                                <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_6">
                                    Deadline Date
                                </th>
                                <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_6">
                                    Created At
                                </th>

                                <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                                    Generate PO
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

                            @csrf
                            @forelse($datas as $invoice)

                                <tr>
                                    {{--                                    <td class="align_center text-center edit tbl_srl_4">--}}
                                    {{--                                        <input type="checkbox" name="checkbox[]" value="{{$invoice->fpr_id}}" id="{{$invoice->fpr_id}}"/>--}}
                                    {{--                                    </td>--}}
                                    <td class="align_center text-center edit tbl_srl_4">
                                        {{$sr}}
                                    </td>
                                    <td class="align_center text-center edit tbl_srl_6">
                                        {{$invoice->fpr_work_order_id}}
                                    </td>
                                    <td class="align_center text-center edit tbl_srl_6 view" data-id="{{$invoice->fpr_id}}">
                                        {{$invoice->fpr_title}}
                                        {{--                                    {{$invoice->projectName}}--}}
                                    </td>
                                    <td class="align_center text-center edit tbl_srl_8">
                                        {{$invoice->dep_title}}
                                    </td>
                                    <td class="align_center text-center edit tbl_srl_8">
                                        {{$invoice->user_name}}
                                    </td>
                                    <td class="align_center text-center edit tbl_srl_15">
                                        {{$invoice->fpr_remarks}}
                                    </td>
                                    <td class="align_left text-left tbl_srl_5">
                                        {{$invoice->fpr_total_items}}
                                    </td>
                                    <td class="align_center text-center tbl_txt_6">
                                        {{ $invoice->fpr_deadline }}
                                    </td>
                                    <td class="align_center text-center tbl_txt_6">
                                        {{ $invoice->fpr_created_at }}
                                    </td>






                                    <td class="align_left text-left tbl_txt_5">
                                        <a href="{{route('manufacturing_po_invoice_create',$invoice->fpr_id)}}">PO</a>
                                    </td>


                                </tr>
                                @php
                                    $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="15">
                                        <center><h3 style="color:#554F4F">No List Found</h3></center>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>

                        </table>
                    </div>
                    {{--                    <button tabindex="7" type="submit" class="save_button form-control" name="save" id="save"--}}
                    {{--                    >--}}
                    {{--                        Approved--}}
                    {{--                    </button>--}}
                    {{--                    <button type="submit" class="save_button form-control"></button>--}}
                </form>
                <span></span>
                {{--                    class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'account'=>$search_account,'franchise'=>$search_franchise, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>--}}
            </div> <!-- white column form ends here  'search'=>$search,-->


        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg mdl_wdth">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Purchase Request Detail</h4>
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

    {{--    required input validation --}}
{{--    <script type="text/javascript">--}}
{{--        function checkForm() {--}}
{{--            let designer_name = document.getElementById("designer_name"),--}}

{{--                validateInputIdArray = [--}}
{{--                    designer_name.id,--}}
{{--                ];--}}
{{--            return validateInventoryInputs(validateInputIdArray);--}}
{{--        }--}}
{{--    </script>--}}
    {{-- end of required input validation --}}






    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('Purchase_Requisition_invoice_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");

            $('.modal-body').load('{{url("Purchase_Requisition_items_invoice_list/view/") }}' + '/' + id, function () {
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

            $("#order_list").select2().val(null).trigger("change");
            $("#order_list > option").removeAttr('selected');

            $("#survey_name").select2().val(null).trigger("change");
            $("#survey_name > option").removeAttr('selected');

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
            jQuery("#order_list").select2();
            jQuery("#survey_name").select2();
            jQuery("#designer_name").select2();
            jQuery("#franchise").select2();
        });
    </script>

    <script>
        function dis_approve(id) {
            var rej_id = id
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "pr_disapprove",
                data: {id: rej_id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data.message);
                    location.reload();
                },

            });
            location.reload();
        }

        function approve_pr(id) {

            // var designer_id = $('#designer_name').val();
            var flag_submit1 = true;
            var focus_once1 = 0;

            if (designer_id == "" || designer_id == null) {

                if (focus_once1 == 0) {
                    jQuery("#designer_name").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (flag_submit1) {

                var ap_id = id

                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });

                jQuery.ajax({
                    url: "pr_approve",
                    data: {id: ap_id},
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    success: function (data) {
                        console.log(data.message);
                        location.reload();
                    },

                });
                location.reload();
            }

        }
    </script>

    <script>
        $('#select-all').click(function (event) {
            if (this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function () {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function () {
                    this.checked = false;
                });
            }
        });
    </script>


@endsection

