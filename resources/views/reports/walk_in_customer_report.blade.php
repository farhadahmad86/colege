@extends('extend_index')

@section('content')
    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Walk in Customer List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                {{--                    <div class="search_form {{ ( !empty($search) || !empty($search_first_head) || !empty($search_second_head) || !empty($search_third_head) || !empty($search_group) ) ? '' : 'search_form_hidden' }}">--}}
                {{--                        <div class="row">--}}

                {{--                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}


                {{--                                    <form action="{{ route('product_list') }}" name="form1" id="form1" method="post">--}}
                {{--                                        @csrf--}}
                {{--                                        <div class="row">--}}

                {{--                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">--}}
                {{--                                                <div class="input_bx"><!-- start input box -->--}}
                {{--                                                    <label>--}}
                {{--                                                        All Column Search--}}
                {{--                                                    </label>--}}
                {{--                                                    <input type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}" autocomplete="off">--}}
                {{--                                                    <datalist id="browsers">--}}
                {{--                                                        @foreach($product as $value)--}}
                {{--                                                            <option value="{{$value}}">--}}
                {{--                                                        @endforeach--}}
                {{--                                                    </datalist>--}}
                {{--                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
                {{--                                                </div>--}}
                {{--                                            </div> <!-- left column ends here -->--}}

                {{--                                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">--}}
                {{--                                                <div class="row">--}}

                {{--                                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">--}}
                {{--                                                        <div class="input_bx"><!-- start input box -->--}}
                {{--                                                            <label>--}}
                {{--                                                                Main Unit--}}
                {{--                                                            </label>--}}
                {{--                                                            <select class="inputs_up form-control cstm_clm_srch" name="main_unit" id="main_unit">--}}
                {{--                                                                <option value="">Select Main Unit</option>--}}
                {{--                                                                @foreach($main_units as $main_unit)--}}
                {{--                                                                    <option value="{{$main_unit->mu_id}}" {{ $main_unit->mu_id == $search_main_unit ? 'selected="selected"' : '' }}>{{$main_unit->mu_title}}</option>--}}
                {{--                                                                @endforeach--}}
                {{--                                                            </select>--}}
                {{--                                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
                {{--                                                        </div>--}}
                {{--                                                    </div>--}}

                {{--                                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">--}}
                {{--                                                        <div class="input_bx"><!-- start input box -->--}}
                {{--                                                            <label>--}}
                {{--                                                                Unit--}}
                {{--                                                            </label>--}}
                {{--                                                            <select class="inputs_up form-control cstm_clm_srch" name="unit" id="unit">--}}
                {{--                                                                <option value="">Select Unit</option>--}}
                {{--                                                                @foreach($units as $unit)--}}
                {{--                                                                    <option value="{{$unit->unit_id}}" {{ $unit->unit_id == $search_unit ? 'selected="selected"' : '' }}>{{$unit->unit_title}}</option>--}}
                {{--                                                                @endforeach--}}
                {{--                                                            </select>--}}
                {{--                                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
                {{--                                                        </div>--}}
                {{--                                                    </div>--}}

                {{--                                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">--}}
                {{--                                                        <div class="input_bx"><!-- start input box -->--}}
                {{--                                                            <label>--}}
                {{--                                                                Group--}}
                {{--                                                            </label>--}}
                {{--                                                            <select class="inputs_up form-control cstm_clm_srch" name="group" id="group">--}}
                {{--                                                                <option value="">Select Group</option>--}}
                {{--                                                                @foreach($groups as $group)--}}
                {{--                                                                    <option value="{{$group->grp_id}}" {{ $group->grp_id == $search_group ? 'selected="selected"' : '' }}>{{$group->grp_title}}</option>--}}
                {{--                                                                @endforeach--}}
                {{--                                                            </select>--}}
                {{--                                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
                {{--                                                        </div>--}}
                {{--                                                    </div>--}}

                {{--                                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">--}}
                {{--                                                        <div class="input_bx"><!-- start input box -->--}}
                {{--                                                            <label>--}}
                {{--                                                                Category--}}
                {{--                                                            </label>--}}
                {{--                                                            <select class="inputs_up form-control cstm_clm_srch" name="category" id="category">--}}
                {{--                                                                <option value="">Select Category</option>--}}
                {{--                                                                @foreach($categories as $category)--}}
                {{--                                                                    <option value="{{$category->cat_id}}" {{ $category->cat_id == $search_category ? 'selected="selected"' : '' }}>{{$category->cat_title}}</option>--}}
                {{--                                                                @endforeach--}}
                {{--                                                            </select>--}}
                {{--                                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
                {{--                                                        </div>--}}
                {{--                                                    </div>--}}

                {{--                                                </div>--}}
                {{--                                            </div>--}}

                {{--                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
                {{--                                                <div class="form_controls">--}}

                {{--                                                    <button type="reset" type="button" name="cancel" id="cancel" class="cancel_button form-control">--}}
                {{--                                                        <i class="fa fa-trash"></i> Clear--}}
                {{--                                                    </button>--}}
                {{--                                                    <button type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">--}}
                {{--                                                        <i class="fa fa-search"></i> Search--}}
                {{--                                                    </button>--}}

                {{--                                                    <a class="save_button form-control" href="{{ route('add_product') }}" role="button">--}}
                {{--                                                        <i class="fa fa-plus"></i> Product--}}
                {{--                                                    </a>--}}

                {{--                                                    @include('include/print_button')--}}

                {{--                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}

                {{--                                                </div>--}}
                {{--                                            </div>--}}


                {{--                                        </div>--}}
                {{--                                    </form>--}}


                {{--                                <form name="edit" id="edit" action="{{ route('edit_product') }}" method="post">--}}
                {{--                                    @csrf--}}
                {{--                                    <input name="group_id" id="group_id" type="hidden">--}}
                {{--                                    <input name="category_id" id="category_id" type="hidden">--}}
                {{--                                    <input name="product_title" id="product_title" type="hidden">--}}
                {{--                                    <input name="remarks" id="remarks" type="hidden">--}}
                {{--                                    <input name="product_id" id="product_id" type="hidden">--}}
                {{--                                    <input name="main_unit_id" id="main_unit_id" type="hidden">--}}
                {{--                                    <input name="unit_id" id="unit_id" type="hidden">--}}
                {{--                                    <input name="purchase_price" id="purchase_price" type="hidden">--}}
                {{--                                    <input name="sale_price" id="sale_price" type="hidden">--}}
                {{--                                    <input name="bottom_price" id="bottom_price" type="hidden">--}}
                {{--                                    <input name="expiry" id="expiry" type="hidden">--}}
                {{--                                    <input name="min_qty" id="min_qty" type="hidden">--}}
                {{--                                    <input name="alert" id="alert" type="hidden">--}}
                {{--                                    <input name="product_code" id="product_code" type="hidden">--}}
                {{--                                </form>--}}

                {{--                                <form name="delete" id="delete" action="{{ route('delete_product') }}" method="post">--}}
                {{--                                    @csrf--}}
                {{--                                    <input name="product_id" id="del_product_id" type="hidden">--}}
                {{--                                    <input name="product_code" id="del_product_code" type="hidden">--}}
                {{--                                </form>--}}

                {{--                            </div>--}}

                {{--                        </div>--}}
                {{--                    </div><!-- search form end -->--}}


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">
                        <thead>
                        <tr>

                            <th scope="col" align="center" class="align_center text-center acnt_lgr_wdth_1">
                                Invoice#
                            </th>
                            <th scope="col" align="center" class="align_center text-center acnt_lgr_wdth_7">
                                Customer Name
                            </th>
                            <th scope="col" align="center" class="align_center text-center acnt_lgr_wdth_7">
                                Phone Number
                            </th>
                            <th scope="col" align="center" class="align_center text-center acnt_lgr_wdth_6">
                                Whatsapp
                            </th>
                            <th scope="col" align="center" class="align_center text-center acnt_lgr_wdth_2">
                                Email
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $sr=1;
                        @endphp
                        @forelse($walk_in_customers as $walk_in_customer)

                            <tr>
                                <td class="align_center text-center edit acnt_lgr_wdth_1">

                                    <a class="view" data-transcation_id="{{config('global_variables.SALE_VOUCHER_CODE').$walk_in_customer->si_id}}" data-toggle="modal" data-target="#myModal"
                                       style="cursor:pointer; color: #0099ff;">
                                        {{config('global_variables.SALE_VOUCHER_CODE').$walk_in_customer->si_id}}
                                    </a>
                                </td>
                                <td class="align_center text-center edit acnt_lgr_wdth_7">
                                    {{$walk_in_customer->si_customer_name}}
                                </td>
                                <td class="align_center text-center edit acnt_lgr_wdth_7">
                                    {{$walk_in_customer->si_phone_number}}
                                </td>
                                <td class="align_left text-center edit acnt_lgr_wdth_6">
                                    {{$walk_in_customer->si_whatsapp}}
                                </td>
                                <td class="align_center text-center edit acnt_lgr_wdth_2">
                                    {{$walk_in_customer->si_email}}
                                </td>
                            </tr>
                            @php
                                $sr++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Record</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                </div>
                <span class="hide_column">{{ $walk_in_customers ->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-blue table-header">Items Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive table-values">
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-6 col-md-6"></div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')


    <script>
        jQuery(".view").click(function () {

            var transcation_id = jQuery(this).attr("data-transcation_id");

            jQuery(".table-header").html("");
            jQuery(".table-values").html("");

            $(".modal-body").load('{{ url('/transaction_view_details_SH/') }}/' + transcation_id, function () {
                $('#myModal').modal({show: true});
            });

        });

    </script>
@endsection
