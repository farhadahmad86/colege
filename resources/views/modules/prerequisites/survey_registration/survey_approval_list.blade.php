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
                            <h4 class="text-white get-heading-text file_name">{{$page}} Survey List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

            <!-- <div class="search_form {{ ( !empty($search) || !empty($search_account) || !empty($search_product) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            @php
                                if($page == 'Rejected'){
                                $route='survey_reject_list';
                                }else{
                                $route='survey_approve_list';
                                }
                            @endphp
                            <form class="prnt_lst_frm" action="{{ route($route) }}" name="form1" id="form1" method="post">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."
                                                   value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($party as $value)
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
                                                        Account
                                                    </label>
                                                    <select tabindex="2" class="inputs_up  form-control" name="account" id="account">
                                                        <option value="">Select Account</option>
                                                        @foreach($accounts as $account)
                                                            <option
                                                                value="{{$account->account_uid}}" {{ $account->account_uid == $search_account ? 'selected="selected"' : '' }}>{{$account->account_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Order List
                                                    </label>
                                                    <select tabindex="3" class="inputs_up  form-control" name="order_list" id="order_list">
                                                        <option value="">Select Project</option>
                                                        @foreach($order_lists as $order_list)
                                                            <option
                                                                value="{{$order_list->ol_id}}" {{ $order_list->ol_id == $search_order_list ? 'selected="selected"' : ''
                                                                }}>{{$order_list->ol_order_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Franchise Name
                                                    </label>
                                                    <select tabindex="3" class="inputs_up  form-control" name="franchise" id="franchise">
                                                        <option value="">Select Surveyor Name</option>
                                                        @foreach($franchises as $franchise)
                                                            <option
                                                                value="{{$franchise->id}}" {{ $franchise->id == $search_franchise ? 'selected="selected"' : ''
                                                                }}>{{$franchise->code}} {{$franchise->name}}</option>
                                                        @endforeach
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

                                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
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
                                Order List Title
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_6">
                                Product Title
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
                                Load Number
                            </th>
                            {{--                                    <th scope="col" align="center">Detail Remarks</th>--}}
                            {{--<th scope="col" style="width:80px; text-align: center !important" align="center">Party Code</th>--}}
                            <th scope="col" align="center" class="align_center text-center tbl_txt_8">
                                Whatsapp Number
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_8">
                                Board Type
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                                Images Before
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                                Images Type
                            </th>
                            {{--                            <th scope="col" align="center" class="align_center text-center tbl_txt_15">--}}
                            {{--                                Images After--}}
                            {{--                            </th>--}}


                            {{--                            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">--}}
                            {{--                                Execution--}}
                            {{--                            </th>--}}
                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Created At
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                                Status
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
                        @forelse($datas as $invoice)

                            <tr>
                                <td class="align_center text-center edit tbl_srl_4">
                                    {{$sr}}
                                </td>
                                <td class="align_center text-center edit tbl_srl_6">
                                    {{$invoice->companyName}}
                                </td>
                                <td class="align_center text-center edit tbl_srl_6">
                                    {{$invoice->order_title}}
                                    {{--                                    {{$invoice->projectName}}--}}
                                </td>
                                <td class="align_center text-center edit tbl_srl_6">                                    {{$invoice->pro_title}}
                                </td>
                                <td class="align_center text-center edit tbl_srl_8">
                                    {{$invoice->sr_shop_name}}
                                </td>
                                <td class="align_center text-center edit tbl_srl_8">
                                    {{$invoice->sr_shop_code}}
                                </td>
                                <td class="align_center text-center tbl_txt_10">
                                    {{ $invoice->sr_address }}
                                </td>

                                <td class="align_left text-left tbl_txt_8">
                                    {{$invoice->sr_contact}}
                                </td>
                                <td class="align_left text-left tbl_txt_8">
                                    {{$invoice->sr_contact2}}
                                </td>
                                <td class="align_left text-left tbl_txt_8">
                                    {{$invoice->sr_front_left_right_type}}
                                </td>
                                <td nowrap="" class="align_left text-left tbl_txt_5">
                                    <table style="padding: 0; margin: 0" border="0" cellspacing="0" cellpadding="0">
                                        <tbody style="padding: 0; margin: 0">
                                        <tr style="padding: 0; margin: 0">
                                            <td style="padding: 0; margin: 0; border:none" class="">
                                                {{--                                                @foreach($imgs[$invoice->sr_id] as $a)--}}

                                                {{--                                                   media-object  no-border-top-radius no-border-bottom-radius avatar avatar-sm pull-up--}}
                                                <a class="fancybox" data-fancybox-group="gallery" href="{{$invoice->sri_before_image}}" style="user-select: auto;"> <img class="rounded-circle"
                                                                                                                                                                         src="{{$invoice->sri_before_image}}"
                                                                                                                                                                         width="30px" height="30px"
                                                                                                                                                                         alt=""
                                                                                                                                                                         style="user-select: auto;"></a>


                                                {{--                                                @endforeach--}}

                                            </td>
                                        </tr>
                                        <tr style="padding: 0;margin: 0">
                                            <td style="padding: 0; margin: 0; border:none">

                                                {{--                                                @foreach($imgs[$invoice->sr_id] as $a)--}}

                                                <a data-toggle="modal" data-target=".bd-example-modal-lg" data-id="{{ $invoice->sri_id}}" class="href" style="user-select: auto;
                                                                        padding-left: 10px; padding-right: 10px"><i class="fa fa-info-circle" style="user-select: auto;"></i></a>


                                                {{--                                                @endforeach--}}

                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </td>
                                <td class="align_left text-left tbl_txt_5">
                                    {{$invoice->sri_image_type}}
                                </td>
                                {{--                                <td nowrap="" class="align_left text-left tbl_txt_15">--}}
                                {{--                                    @foreach($imgs[$invoice->sr_id] as $a)--}}

                                {{--                                        <a class="fancybox" data-fancybox-group="gallery" href="{{$a->sri_after_image}}"> <img class="media-object rounded-circle no-border-top-radius--}}
                                {{--                                        no-border-bottom-radius avatar avatar-sm pull-up"--}}
                                {{--                                                                                                                               src="{{$a->sri_after_image}}" width="30px" height="30px" alt=""></a>--}}
                                {{--                                    @endforeach--}}
                                {{--                                </td>--}}


                                {{--                                <td class="align_right text-right tbl_amnt_5">--}}
                                {{--                                    {{$invoice->sr_user_id}}--}}
                                {{--                                </td>--}}

                                {{--                                <td class="align_right text-right tbl_amnt_5">--}}
                                {{--                                    --}}{{--                                    {{$invoice->si_cash_received !=0 ? number_format($invoice->si_cash_received,2):''}}--}}
                                {{--                                </td>--}}

                                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $invoice->sr_user_id }}"
                                    {{--                                    data-user_info="{!! $ip_browser_info !!}" --}}
                                    title="Click To See User
                                Detail">
                                    {{$invoice->username}}
                                </td>
                                <td class="align_left text-left usr_prfl tbl_txt_8" title="Click To See User
                                Detail">
                                    {{$invoice->sr_created_at}}
                                </td>

                                <td class="align_left text-left tbl_txt_5">
                                    {{$invoice->sri_survey_status}}

                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="15">
                                    <center><h3 style="color:#554F4F">No List</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>


                    </table>
                </div>
                <span
                    class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'account'=>$search_account, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>
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

        var page= "{!! $page !!}";

        if(page == 'Rejected'){
            var base = '{{ route('survey_reject_list') }}',
                url;

        }else{
            var base = '{{ route('survey_approve_list') }}',
                url;

        }

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


@endsection

