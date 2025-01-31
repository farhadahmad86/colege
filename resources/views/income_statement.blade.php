
@extends('extend_index')

@section('content')

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Income Statement</h4>
                            </div>
                            <div class="list_btn list_mul">
                                <div class="srch_box_opn_icon">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->

                    <!-- <div class="search_form {{ ( !empty($to) ) ? '' : 'search_form_hidden' }}"> -->

                    <div class="">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <form class="prnt_lst_frm" action="{{ route('income_statement') }}" name="form1" id="form1" method="post">
                                    @csrf
                                    <div class="row">

                                        <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label>
                                                    Select Date
                                                </label>
                                                <input type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($to)){?> value="{{$to}}" <?php } ?> placeholder="Date......" />
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div>
                                        </div> <!-- left column ends here -->

                                        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                            <div class="form_controls text-center text-lg-left">

                                                <button type="reset" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                    <i class="fa fa-trash"></i> Clear
                                                </button>
                                                <button type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                    <i class="fa fa-search"></i> Search
                                                </button>

                                                @include('include/print_button')

                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                            </div>
                                        </div>


                                    </div>
                                </form>


                            </div>

                        </div>
                    </div><!-- search form end -->




                    <div class="table-responsive">
                        <table class="table table-striped">

                            <tbody >
                            @if(!empty($income_statement) && isset($income_statement))

                                <tr>
                                    <th class="align_left text-left tbl_txt_70">Sales</th>
                                    <td class="align_right text-right tbl_amnt_15">{{number_format($income_statement->is_sales,2)}}</td>
                                    <td class="align_right text-right tbl_amnt_15"></td>
                                </tr>
                                <tr>
                                    <th class="align_left text-left tbl_txt_70">LESS: Sales Return</th>
                                    <td class="align_right text-right tbl_amnt_15">
                                        {{number_format($income_statement->is_sales_return,2)}}
                                    </td>
                                    <td class="align_right text-right tbl_amnt_15"></td>
                                </tr>
                                <tr>
                                    <th class="align_left text-left tbl_txt_70">Total Sales</th>
                                    <td class="align_right text-right tbl_amnt_15"></td>
                                    <td class="align_right text-right tbl_amnt_15">
                                        {{number_format($income_statement->is_total_sales,2)}}
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="align_left text-left tbl_txt_70">Cost Of Goods Sold</th>

                                </tr>
                                <tr>
                                    <th class="align_left text-left tbl_txt_70">Opening Stock/Inventory</th>
                                    <td class="align_right text-right tbl_amnt_15">
                                        {{number_format($income_statement->is_opening_inventory,2)}}
                                    </td>
                                    <td class="align_right text-right tbl_amnt_15"></td>
                                </tr>
                                <tr>
                                    <th class="align_left text-left tbl_txt_70">Add: Purchases</th>
                                    <td class="align_right text-right tbl_amnt_15">
                                        {{number_format($income_statement->is_purchase,2)}}
                                    </td>
                                    <td class="align_right text-right tbl_amnt_15"></td>
                                </tr>
                                <tr>
                                    <th class="align_left text-left tbl_txt_70">LESS: Purchase Return</th>
                                    <td class="align_right text-right tbl_amnt_15">
                                        {{number_format($income_statement->is_purchase_return,2)}}
                                    </td>
                                    <td class="align_right text-right tbl_amnt_15"></td>
                                </tr>
                                <tr>
                                    <th class="align_left text-left tbl_txt_70">Total Purchase</th>
                                    <td class="align_right text-right tbl_amnt_15">
                                        {{number_format($income_statement->is_total_purchase,2)}}
                                    </td>
                                    <td class="align_right text-right tbl_amnt_15"></td>
                                </tr>
                                <tr>
                                    <th class="align_left text-left tbl_txt_70">Less: Ending Inventory</th>
                                    <td class="align_right text-right tbl_amnt_15">
                                        {{number_format($income_statement->is_ending_inventory,2)}}
                                    </td>
                                    <td class="align_right text-right tbl_amnt_15"></td>
                                </tr>
                                <tr>
                                    <th class="align_left text-left tbl_txt_70">Less: Cost Of Goods Sold</th>
                                    <td class="align_right text-right tbl_amnt_15"></td>
                                    <td class="align_right text-right tbl_amnt_15">
                                        {{number_format($income_statement->is_total_cgs,2)}}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="align_left text-left tbl_txt_70">Gross Revenue One</th>
                                    <td class="align_right text-right tbl_amnt_15"></td>
                                    <td class="align_right text-right tbl_amnt_15">
                                        {{number_format($income_statement->is_gross_revenue_one,2)}}
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="align_left text-left tbl_txt_70">Other Revenues</th>
                                </tr>

                                @foreach($datas as $account)
                                    @if($account->isi_type=='REVENUE')

                                        <tr>
                                            <td class="align_left text-left tbl_txt_70">
                                                {{$account->isi_title}}
                                            </td>
                                            <td class="align_right text-right tbl_amnt_15">
                                                {{number_format($account->isi_amount,2)}}
                                            </td>
                                            <td class="align_right text-right tbl_amnt_15"></td>
                                        </tr>

                                    @endif
                                @endforeach
                                <tr>
                                    <th class="align_left text-left tbl_txt_70">Total Other Revenue</th>
                                    <td class="align_right text-right tbl_amnt_15"></td>
                                    <td class="align_right text-right tbl_amnt_15">
                                        {{number_format($income_statement->is_other_total_revenue,2)}}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="align_left text-left tbl_txt_70">Gross Revenue Two</th>
                                    <td class="align_right text-right tbl_amnt_15"></td>
                                    <td class="align_right text-right tbl_amnt_15">
                                        {{number_format($income_statement->is_gross_revenue_two,2)}}
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="align_left text-left tbl_txt_70">Expenses</th>
                                </tr>
                                @foreach($datas as $account)
                                @if($account->isi_type=='EXPENSE')

                                <tr>
                                    <td class="align_left text-left tbl_txt_70">{{$account->isi_title}}</td>
                                    <td class="align_right text-right tbl_amnt_15">
                                        {{number_format($account->isi_amount,2)}}
                                    </td>
                                    <td class="align_right text-right tbl_amnt_15"></td>
                                </tr>

                                @endif
                                @endforeach
                                <tr>
                                    <th class="align_left text-left tbl_txt_70">Total Expenses</th>
                                    <td class="align_right text-right tbl_amnt_15"></td>
                                    <td class="align_right text-right tbl_amnt_15">
                                        {{number_format($income_statement->is_total_expense,2)}}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="align_left text-left tbl_txt_70 total_value">
                                        Total {{$income_statement->is_profit_loss}}
                                    </th>
                                    <td class="align_right text-right tbl_amnt_15"></td>
                                    <td class="align_right text-right tbl_amnt_15 total_value">
                                        {{number_format($income_statement->is_profit_loss_amount,2)}}
                                    </td>
                                </tr>

                                @else
                                <tr>
                                    <td colspan="8">
                                        <center><h3 style="color:#554F4F">No Statement</h3></center>
                                    </td>
                                </tr>
                            @endif

                            </tbody>

                        </table>


                    </div>
                </div> <!-- white column form ends here -->


            </div><!-- col end -->


        </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('income_statement') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery(".edit").click(function () {

            var account_id = jQuery(this).attr("data-id");

            jQuery("#account_id").val(account_id);
            jQuery("#edit").submit();
        });

    </script>

    <script type="text/javascript">
        jQuery(function () {
            jQuery('.datepicker1').datepicker({
                language: 'en', dateFormat: 'dd-M-yyyy'
            });
        });
    </script>

@endsection

