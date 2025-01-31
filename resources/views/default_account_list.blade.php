
@extends('extend_index')

@section('styles_get')
    <style>
        input,
        textarea,
        select,
        .select2 {
            border: 1px solid #8e8e8e !important;
            border-radius: 4px !important;
            height: 32px !important;
            padding: 0 10px !important;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important;
        }
        .select2 {
            padding: 5px 10px !important;
        }
    </style>
@endsection

@section('content')

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Fixed Accounts</h4>
                        </div>
                    </div>
                </div><!-- form header close -->



                <div class="table-responsive" id="printTable">
                    <table class="table table-sm" id="fixTable">

                        <thead>
                            <tr>
                                <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                                    Sr#
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_44">
                                    Account ID
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_44">
                                    Account Title
                                </th>
                                <th scope="col" align="center" class="align_center text-center hide_column tbl_srl_8">
                                    Action
                                </th>
                            </tr>

                        </thead>

                        <tbody>
                        @php $sr = 1; @endphp
                        @forelse($accounts as $account)
                            <form name="f1" class="f1" id="f1" action="{{ route('update_default_account_list') }}" method="post">
                                @csrf
                                <tr>
                                    <td class="align_center text-center edit tbl_srl_4">
                                        {{$sr}}
                                    </td>
                                    <td class="align_left text-left edit tbl_txt_44">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">Account ID</label>
                                            <input type="text" class="inputs_up form-control shadow rounded" autocomplete="off" value="{{$account->account_uid}}" readonly/>
                                            <span id="demo1" class="validate_sign"> </span>
                                        </div><!-- end input box -->
                                    </td>
                                    <td class="align_left text-left edit tbl_txt_44">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="">Account Title</label>
                                            <input type="text" name="name" class="inputs_up form-control shadow rounded" placeholder="Account Title" value="{{$account->account_name}}" autofocus autocomplete="off"/>
                                            <span id="demo2" class="validate_sign"> </span>
                                        </div><!-- end input box -->
                                    </td>
                                    <td class="align_center text-right hide_column tbl_srl_8">

                                        <input type="hidden" name="id" class="form-control"
                                               value="{{$account->account_id}}" autocomplete="off"/>

                                        <input type="hidden" name="head_code" class="form-control"
                                               value="{{$account->account_parent_code}}" autocomplete="off"/>

                                        <div class="form_controls">
                                            <div class="form-group m-0 pt-3">
                                                <button type="submit" name="save" id="save" class="save_button form-control">
                                                    <i class="fa fa-floppy-o"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </form>
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

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">

                        <form name="f1" class="f1" id="f1" action="{{route('set_default_account')}}" method="post">
                            @csrf
                            <div class="form-group row">

                                {{--<div class="col-lg-8 col-md-8"></div>--}}
                                <div class="col-lg-2 col-md-2">
                                    <button type="button" name="save" id="save" class="save_button form-control"
                                            data-toggle="modal" data-target="#myModal">Reset Default
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div> <!-- left column ends here -->
                     <!-- right columns ends here -->
                </div> <!--  main row ends here -->
            </div> <!-- white column form ends here -->
        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-blue">Default Accounts Name</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>{{config('global_variables.cash_in_hand')}} : {{config('global_variables.cash_account_name')}}</p>
                    <p>{{config('global_variables.stock_in_hand')}} : {{config('global_variables.stock_account_name')}}</p>
                    <p>{{config('global_variables.purchase_sale_tax')}} : {{config('global_variables.purchase_sale_tax_account_name')}}</p>
                    <p>{{config('global_variables.walk_in_customer')}} : {{config('global_variables.walk_in_customer_account_name')}}</p>
                    <p>{{config('global_variables.other_asset_suspense_account')}} : {{config('global_variables.other_asset_suspense_account_name')}}</p>
                    <p>{{config('global_variables.sales_tax_payable_account')}} : {{config('global_variables.sale_sale_tax_account_name')}}</p>
                    <p>{{config('global_variables.service_sale_tax_account')}} : {{config('global_variables.service_tax_account_name')}}</p>
                    <p>{{config('global_variables.purchaser_account')}} : {{config('global_variables.purchaser_account_name')}}</p>
                    <p>{{config('global_variables.other_liability_suspense_account')}} : {{config('global_variables.other_liability_suspense_account_name')}}</p>
                    <p>{{config('global_variables.sale_account')}} : {{config('global_variables.sales_account_name')}}</p>
                    <p>{{config('global_variables.sales_returns_and_allowances')}} : {{config('global_variables.sales_returns_and_allowances_account_name')}}</p>
                    <p>{{config('global_variables.service_account')}} : {{config('global_variables.service_account_name')}}</p>
                    <p>{{config('global_variables.sale_margin_account')}} : {{config('global_variables.sales_margin_account_name')}}</p>
                    <p>{{config('global_variables.product_loss_recover_account')}} : {{config('global_variables.product_loss_recover_account_name')}}</p>
                    <p>{{config('global_variables.purchase_account')}} : {{config('global_variables.purchase_account_name')}}</p>
                    <p>{{config('global_variables.purchase_return_and_allowances')}} : {{config('global_variables.purchase_return_and_allowances_account_name')}}</p>
                    <p>{{config('global_variables.round_off_discount_account')}} : {{config('global_variables.round_off_discount_account_name')}}</p>
                    <p>{{config('global_variables.cash_discount_account')}} : {{config('global_variables.cash_discount_account_name')}}</p>
                    <p>{{config('global_variables.service_discount_account')}} : {{config('global_variables.service_discount_account_name')}}</p>
                    <p>{{config('global_variables.product_discount_account')}} : {{config('global_variables.product_discount_account_name')}}</p>
                    <p>{{config('global_variables.retailer_discount_account')}} : {{config('global_variables.retailer_discount_account_name')}}</p>
                    <p>{{config('global_variables.wholesaler_discount_account')}} : {{config('global_variables.wholesaler_discount_account_name')}}</p>
                    <p>{{config('global_variables.loyalty_card_discount_account')}} : {{config('global_variables.loyalty_discount_account_name')}}</p>
                    <p>{{config('global_variables.capital_undistributed_profit_and_loss')}} : {{config('global_variables.capital_undistributed_profit_and_loss_account_name')}}</p>
                </div>

                <div class="modal-footer">

                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">Cancel</button>
                    </div>
                    <div class="col-lg-6 col-md-6"></div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <button type="button" class="btn btn-default confirm form-control save_button">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>

        jQuery(".confirm").on("click", function () {
            jQuery("#f2").submit();
        });

    </script>

@endsection

