{{--{{$products}}--}}
@extends('extend_index')

@section('styles_get')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/custom-search/custom-search.css') }}">
    {{--    nabeel css blue--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/nabeel_blue/last.css') }}">

@stop

@section('content')

    <!-- mana sara comments delete kr dia ha  previous sale invoice ka-->
    {{--                to get blue color cut invoice_bx from class--}}

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            {{--            edit it--}}
            <div id="main_bg" class="pd-20 border-radius-4 box-shadow mb-30 form_manage" style="background: #C4D3F5">

                {{--                form header --}}
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Assign Board Material</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <a class="add_btn list_link add_more_button"
                               href="{{ route('assign_board_material_list') }}" role="button">
                                <i class="fa fa-list"></i> Assign Board Material
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                {{--                invoice container--}}
                <div id="invoice_con"><!-- invoice container start -->
                    <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx"><!-- invoice box start -->

                        {{--form start--}}
                        <form name="f1" class="f1" id="f1" action="{{ route('submit_assign_board_material') }}"
                              onsubmit="return checkForm()" method="post" autocomplete="off">
                            @csrf
                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->

                                    {{--                                    above table--}}
                                    <div class="invoice_row"><!-- invoice row start -->
                                        <!-- add start -->
                                        <div class="invoice_col basis_col_16 upper">
                                            {{--above table row1--}}
                                            <div class="invoice_row"> <!--row1 start -->
                                                <!-- add end -->
                                                <div class="invoice_col basis_col_100 ml-2">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            Product
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->
                                                                <a href="{{ url('account_registration') }}"
                                                                   class="col_short_btn" target="_blank">
                                                                    <l class="fa fa-plus"></l>
                                                                </a>
                                                                <a id="refresh_account_name" class="col_short_btn">
                                                                    <l class="fa fa-refresh"></l>
                                                                </a>
                                                            </div><!-- invoice column short end -->


                                                            <select name="product" tabindex="1"
                                                                    data-rule-required="true"
                                                                    data-msg-required="Please Select Product"
                                                                    class="inputs_up form-control js-example-basic-multiple autofocus2"
                                                                    id="product">
                                                                <option value="" selected disabled>Select product</option>
                                                                @foreach($products as $product)
                                                                    <option value="{{$product->pro_p_code}}">{{$product->pro_title}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                            </div><!-- invoice row1 end -->

                                            {{--above table row2--}}
                                            <div class="invoice_row"><!--row2 start -->
                                                <!-- changed -->
                                                <div class="invoice_col basis_col_100 ml-2">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            Board Type
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->
                                                                <a href="{{ url('add_board_type') }}"
                                                                   class="col_short_btn" target="_blank">
                                                                    <l class="fa fa-plus"></l>
                                                                </a>
                                                                <a id="refresh_account_name" class="col_short_btn">
                                                                    <l class="fa fa-refresh"></l>
                                                                </a>
                                                            </div><!-- invoice column short end -->


                                                            <!-- invoice column input start -->
                                                            <select name="board_type" tabindex="1"
                                                                    data-rule-required="true"
                                                                    data-msg-required="Please Select Board Type"
                                                                    class="inputs_up form-control js-example-basic-multiple autofocus2"
                                                                    id="board_type">
                                                                <option value="" selected disabled>Select Board Type</option>
                                                                @foreach($board_types as $board_type)
                                                                    <option value="{{$board_type->bt_id}}">{{$board_type->bt_title}}</option>
                                                                @endforeach
                                                            </select>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <!-- add start -->
                                            </div><!-- invoice row2 + 85 end -->

                                            <div class="invoice_row justify-content-center"><!--row2 start -->

                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                    <button tabindex="11" type="submit" class="invoice_frm_btn" name="save"
                                                            id="save">
                                                        Save
                                                    </button>

                                                </div>
                                            </div>

                                        </div><!-- invoice row end -->

                                        <!-- add col-12 Filters start -->
                                        <div class="invoice_col basis_col_80" id="filters">
                                            <!-- invoice column start -->

                                            <div class="invoice_row"><!-- invoice row start -->


                                                <div class="invoice_col basis_col_100 ml-3"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="left"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.round_off_discount.description')}}</p>
                                                                        <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.round_off_discount.benefits')}}</p>
                                                                        <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.round_off_discount.example')}}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Board Materials
                                                        </div><!-- invoice column title end -->

                                                        <div class="invoice_col_input">

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->
{{--                                                                <a href="{{ url('add_board_material') }}"--}}
{{--                                                                   class="col_short_btn" target="_blank">--}}
{{--                                                                    <l class="fa fa-plus"></l>--}}
{{--                                                                </a>--}}
{{--                                                                <a id="refresh_account_name" class="col_short_btn">--}}
{{--                                                                    <l class="fa fa-refresh"></l>--}}
{{--                                                                </a>--}}
                                                            </div><!-- invoice column short end -->


                                                        <div class="invoice_col_txt mt-1">

                                                            <div class="invoice_row"><!-- invoice row start -->

                                                                <div class="basis_col_16">
                                                                    <!-- invoice column input start -->
                                                                    <div class="custom-checkbox float-left ml-2 mr-4">
                                                                        <input tabindex="-1" type="checkbox"
                                                                               name="all"
                                                                               class="custom-control-input company_info_check_box"
                                                                               id="all"
                                                                        >
                                                                        <label class="custom-control-label chck_pdng"
                                                                               for="all"> Select All </label>
                                                                    </div>
                                                                </div>



                                                            @foreach($board_materials as $board_material)
                                                                    {{--                                                                    <option value="{{$board_material->pro_p_code}}">{{$board_material->pro_title}}</option>--}}


                                                                    <div class="basis_col_16">
                                                                        <!-- invoice column input start -->
                                                                        <div class="custom-checkbox float-left ml-2 mr-4">
                                                                            <input tabindex="-1" type="checkbox"
                                                                                   name="board_material[]"
                                                                                   class="custom-control-input company_info_check_box"
                                                                                   id="board_material{{$board_material->pro_p_code}}" value="{{$board_material->pro_p_code}}"
                                                                            >
                                                                            <label class="custom-control-label chck_pdng"
                                                                                   for="board_material{{$board_material->pro_p_code}}"> {{$board_material->pro_title}} </label>
                                                                        </div>
                                                                    </div>

                                                                @endforeach


                                                            </div><!-- invoice column short end -->

                                                        </div><!-- invoice column input end -->
                                                        </div>


                                                    </div><!-- invoice column box end -->

                                                </div><!-- invoice column end -->

                                            </div><!-- invoice row end -->

                                        </div>
                                        <!-- add col-12 Filters end -->

                                    </div><!-- invoice row end -->


                                </div><!-- invoice row end -->
                            </div><!-- invoice column end -->


                        </form>
                        {{--form end--}}


                    </div><!-- invoice box end -->
                </div><!-- invoice container end -->

            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg mdl_wdth">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Trade Sales Invoice Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="printbody">

                    <div id="table_body">

                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button"
                                    onclick="gotoParty()"
                                    data-dismiss="modal">
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

    <script>
        jQuery(document).ready(function () {
            // Initialize select2

            jQuery("#product").select2();
            jQuery("#board_type").select2();

            // $("#invoice_btn").click();
        });


        $("#all").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

    </script>

@endsection



