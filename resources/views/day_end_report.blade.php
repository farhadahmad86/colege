@extends('extend_index')

@section('content')

    <form action="trial_balance" name="form1" id="form1" method="post" onsubmit="return validate_form()">
            @csrf
            <div class="row">

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <div class="col-lg-5 col-md-12 col-sm-12">
                            <label class="required">Date :</label>
                            <span id="demo1" class="validate_sign"> </span>
                            <input tabindex="1" autofocus type="text" name="to" id="to" class="form-control datepicker1" autofocus
                                   autocomplete="off" <?php if(isset($to)){?> value="{{$to}}"
                                   <?php } ?> placeholder="Date......" readonly/>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <label> </label>
                            <button tabindex="2" type="submit" name="save" id="save" class="save_button form-control"
                                    style="margin-top: 10px; ">Search
                            </button>
                        </div>


                    </div>

                </div> <!-- left column ends here -->

            {{--</div>--}}

        </form>

    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">


        <div class="clearfix">
            <div class="pull-left">
                <h4 class="text-blue get-heading-text">Product Costing</h4>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th tabindex="-1" scope="col" style="width:80px; text-align: center !important" align="center">pid</th>
                    <th scope="col" style="width:80px; text-align: center !important" align="center">product</th>
                    <th scope="col" style="width:80px; text-align: center !important" align="center">cost</th>

                </tr>
                </thead>

                <tbody>

                @forelse($product_costings as $product_costing)

                    <tr>
                        <td class="align_left">{{$product_costing->pc_pro_id}}</td>
                        <td class="align_right">{{$product_costing->pro_title}}</td>
                        <td class="align_right">{{$product_costing->pc_pro_cost}}</td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="11">
                            <center><h3 style="color:#554F4F">No Entry</h3></center>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>


        <div class="clearfix">
            <div class="pull-left">
                <h4 class="text-blue">Trial Balance</h4>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col" style="width:80px; text-align: center !important" align="center">Party</th>
                    <th scope="col" style="width:80px; text-align: center !important" align="center">Debit</th>
                    <th scope="col" style="width:80px; text-align: center !important" align="center">Credit</th>

                </tr>
                </thead>

                <tbody>
                @php
                    $sr=1;

                    $total_debit=0;
                    $total_credit=0;
                @endphp
                @forelse($trial_balances as $trial_balance)

                    <tr>
                        <td class="align_left">{{$trial_balance->aoc_account_name}}</td>
                        <td class="align_right">{{$trial_balance->aoc_type == 'CR' ? '' : number_format($trial_balance->aoc_balance,2)}}</td>
                        <td class="align_right">{{$trial_balance->aoc_type == 'DR' ? '' : number_format($trial_balance->aoc_balance,2)}}</td>
                    </tr>
                    @php
                        $sr++;
                        if($trial_balance->aoc_type=='DR'){
                    $total_debit += $trial_balance->aoc_balance;
                        }else{
                    $total_credit += $trial_balance->aoc_balance;
                        }
                    @endphp
                @empty
                    <tr>
                        <td colspan="11">
                            <center><h3 style="color:#554F4F">No Entry</h3></center>
                        </td>
                    </tr>
                @endforelse

                <?php if($sr > 1){ ?>

                <tr>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td class="align_right total_value" colspan="2">Total Debit</td>
                    <td class="align_right total_value">Total Credit</td>
                </tr>

                <tr>
                    <td class="align_right total_value" colspan="2">{{number_format($total_debit,2)}}</td>
                    <td class="align_right total_value">{{number_format($total_credit,2)}}</td>
                </tr>

                <?php } ?>
                </tbody>
            </table>
        </div>


        <div class="clearfix">
            <div class="pull-left">
                <h4 class="text-blue">Income Statement</h4>
            </div>
        </div>

        <div class="table-responsive">

            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    {{--<th scope="col" style="width:80px; text-align: center !important" align="center">Party</th>--}}
                    {{--<th scope="col" style="width:80px; text-align: center !important" align="center">Debit</th>--}}
                    {{--<th scope="col" style="width:80px; text-align: center !important" align="center">Credit</th>--}}

                </tr>
                </thead>

                <tbody>
                @if(!empty($income_statement) && isset($income_statement))

                    <tr>
                        <td class="align_left">Sales</td>
                        <td class="align_right">{{number_format($income_statement->is_sales,2)}}</td>
                        <td class="align_right"></td>
                    </tr>
                    <tr>
                        <td class="align_left">LESS: Sales Return</td>
                        <td class="align_right">{{number_format($income_statement->is_sales_return,2)}}</td>
                        <td class="align_right"></td>
                    </tr>
                    <tr>
                        <td class="align_left">Total Sales</td>
                        <td class="align_right"></td>
                        <td class="align_right">{{number_format($income_statement->is_total_sales,2)}}</td>
                    </tr>
                    <tr>
                        <td class="align_left">Cost Of Goods Sold</td>

                    </tr>
                    <tr>
                        <td class="align_left">Opening Stock/Inventory</td>
                        <td class="align_right">{{number_format($income_statement->is_opening_inventory,2)}}</td>
                        <td class="align_right"></td>
                    </tr>
                    <tr>
                        <td class="align_left">Add: Purchases</td>
                        <td class="align_right">{{number_format($income_statement->is_purchase,2)}}</td>
                        <td class="align_right"></td>
                    </tr>
                    <tr>
                        <td class="align_left">LESS: Purchase Return</td>
                        <td class="align_right">{{number_format($income_statement->is_purchase_return,2)}}</td>
                        <td class="align_right"></td>
                    </tr>
                    <tr>
                        <td class="align_left">Total Purchase</td>
                        <td class="align_right">{{number_format($income_statement->is_total_purchase,2)}}</td>
                        <td class="align_right"></td>
                    </tr>
                    <tr>
                        <td class="align_left">Less: Ending Inventory</td>
                        <td class="align_right">{{number_format($income_statement->is_ending_inventory,2)}}</td>
                        <td class="align_right"></td>
                    </tr>
                    <tr>
                        <td class="align_left">Less: Cost Of Goods Sold</td>
                        <td class="align_right"></td>
                        <td class="align_right">{{number_format($income_statement->is_total_cgs,2)}}</td>
                    </tr>
                    <tr>
                        <td class="align_left">Gross Revenue One</td>
                        <td class="align_right"></td>
                        <td class="align_right">{{number_format($income_statement->is_gross_revenue_one,2)}}</td>
                    </tr>
                    <tr>
                        <td class="align_left">Other Revenues</td>

                    </tr>

                    @foreach($accounts as $account)
                        @if($account->isi_type=='REVENUE')

                            <tr>
                                <td class="align_left">{{$account->isi_title}}</td>
                                <td class="align_right">{{number_format($account->isi_amount,2)}}</td>
                                <td class="align_right"></td>
                            </tr>

                        @endif
                    @endforeach
                    <tr>
                        <td class="align_left">Total Other Revenue</td>
                        <td class="align_right"></td>
                        <td class="align_right">{{number_format($income_statement->is_other_total_revenue,2)}}</td>
                    </tr>
                    <tr>
                        <td class="align_left">Gross Revenue Two</td>
                        <td class="align_right"></td>
                        <td class="align_right">{{number_format($income_statement->is_gross_revenue_two,2)}}</td>
                    </tr>
                    <tr>
                        <td class="align_left">Expenses</td>

                    </tr>
                    @foreach($accounts as $account)
                        @if($account->isi_type=='EXPENSE')

                            <tr>
                                <td class="align_left">{{$account->isi_title}}</td>
                                <td class="align_right">{{number_format($account->isi_amount,2)}}</td>
                                <td class="align_right"></td>
                            </tr>

                        @endif
                    @endforeach
                    <tr>
                        <td class="align_left">Total Expenses</td>
                        <td class="align_right"></td>
                        <td class="align_right">{{number_format($income_statement->is_total_expense,2)}}</td>
                    </tr>
                    <tr>
                        <td class="align_left total_value">Total {{$income_statement->is_profit_loss}}</td>
                        <td class="align_right"></td>
                        <td class="align_right total_value">{{number_format($income_statement->is_profit_loss_amount,2)}}</td>
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
            {{--                </div>--}}


        </div>


        <div class="clearfix">
            <div class="pull-left">
                <h4 class="text-blue">Balance Sheet</h4>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col" style="width:80px; text-align: center !important" align="center">Assets : {{$balance_sheets->bs_total_assets}}</th>
                    <th scope="col" style="width:80px; text-align: center !important" align="center">Liability : {{$balance_sheets->bs_total_liabilities}}</th>
                    <th scope="col" style="width:80px; text-align: center !important" align="center">Equity : {{$balance_sheets->bs_total_equity}}</th>

                </tr>
                </thead>

                <tbody>

                @foreach($balance_sheet_items as $balance_sheet_item)

                    @if($balance_sheet_item->bsi_type == 'ASSETS')
                        <tr>
                            <td class="align_left">{{$balance_sheet_item->bsi_title}}</td>
                            <td class="align_right"></td>
                            <td class="align_right">{{$balance_sheet_item->bsi_amount}}</td>
                        </tr>

                        @elseif($balance_sheet_item->bsi_type == 'LIABILITIES')
                        <tr>
                            <td class="align_left">{{$balance_sheet_item->bsi_title}}</td>
                            <td class="align_right">{{$balance_sheet_item->bsi_amount}}</td>
                            <td class="align_right"></td>
                        </tr>

                        @else

                        <tr>
                            <td class="align_left">{{$balance_sheet_item->bsi_title}}</td>
                            <td class="align_right"></td>
                            <td class="align_right">{{$balance_sheet_item->bsi_amount}}</td>
                        </tr>

                    @endif

                @endforeach

                </tbody>
            </table>
        </div>


    </div> <!-- white column form ends here -->

@endsection

@section('scripts')

    <script type="text/javascript">

        function validate_form() {
            var to = document.getElementById("to").value;

            var flag_submit = true;
            var focus_once = 0;

            if (to.trim() == "") {
                document.getElementById("demo1").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#to").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo1").innerHTML = "";
            }
            return flag_submit;
        }
    </script>

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

