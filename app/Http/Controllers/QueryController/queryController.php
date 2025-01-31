<?php

use App\Models\ProductModel;
use App\Models\WarehouseStockModel;


public function queryForShiftingData()
        {

            $adv_salaries = AdvanceSalaryModel::select('as_id', 'as_emp_advance_salary_account', 'as_amount', 'as_remarks')
                ->get();

            $rollBack = false;
            DB::beginTransaction();

            if (isset($adv_salaries) && !empty($adv_salaries)) {
                foreach ($adv_salaries as $adv_salary) {
                    $adv_salary_item = new AdvanceSalaryItemsModel();
                    $adv_salary_item->asi_as_id = $adv_salary->as_id;
                    $adv_salary_item->asi_emp_advance_salary_account = $adv_salary->as_emp_advance_salary_account;
                    $adv_salary_item->asi_amount = $adv_salary->as_amount;
                    $adv_salary_item->asi_remarks = $adv_salary->as_remarks;


                    echo "Advance Salary ID => " . $adv_salary->as_id . " <br />";
                    echo "Advance Salary ID => " . $adv_salary->as_emp_advance_salary_account . " <br />";
                    echo "Advance Salary ID => " . $adv_salary->as_amount . " <br />";
                    echo "Advance Salary ID => " . $adv_salary->as_remarks . " <br />";
                    echo "<br /> <hr /> <br />";


                    if (!$adv_salary_item->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return response()->json("error during save", 200);
                    }
                }
            }

            if ($rollBack) {
                DB::rollBack();
                return response()->json("error during save", 200);
            } else {
                DB::commit();
                return response()->json("success during save", 200);
            }

        }


    public function balanceAmountSet(){


        $getAllAccountBalances = DB::table('financials_balances')->where("bal_transaction_type", "OPENING_BALANCE")->get();


        foreach($getAllAccountBalances as $getAllAccountBalance){


            $getSingleAccountBalances = DB::table('financials_balances')->where("bal_account_id", $getAllAccountBalance->bal_account_id)->where("bal_transaction_type", "!=", "OPENING_BALANCE")->orderBy("bal_id", "ASC")->get();


            $getSingleAccountOpeningBalance = DB::table('financials_balances')->where("bal_account_id", $getAllAccountBalance->bal_account_id)->where("bal_transaction_type", "OPENING_BALANCE")->first();

            $openingBalance = $getSingleAccountOpeningBalance->bal_total;

            $i = 0;

            foreach($getSingleAccountBalances as $getSingleAccountBalance){

                DB::table('financials_balances')->where("bal_id", $getSingleAccountBalance->bal_id)->where("bal_account_id", $getSingleAccountBalance->bal_account_id)->delete();

                echo "Line Number  ".$i++." Delete successfully ";

            }


            $genearl2 = [];
            $genearl2["account_today_debit"] = 0.00;
            $genearl2["account_today_credit"] = 0.00;
            $genearl2["account_monthly_debit"] = 0.00;
            $genearl2["account_monthly_credit"] = 0.00;
            $genearl2["account_balance"] = $openingBalance;
            $accountBalanceUpdate = DB::table('financials_accounts')->where("account_uid", $getAllAccountBalance->bal_account_id)->update($genearl2);

            echo "<br> <hr> <br>";
        }


    }


    public function balanceAmountSet(){

        //UPDATE `financials_accounts` SET `account_credit_limit` = 0.00, `account_credit_limit_status` = 0, `account_discount_type` = 0, `account_today_opening_type` = "", `account_today_opening` = 0.00, `account_today_debit` = 0.00, `account_today_credit` = 0.00, `account_monthly_opening` = 0.00, `account_monthly_debit` = 0.00, `account_monthly_credit` = 0.00, `account_balance` = 0.00



        // dd($getAllAccountBalances);
        // $getAllAccountBalances = DB::table('financials_balances')->where("bal_transaction_type", "OPENING_BALANCE")->where("bal_cr", "!=", "0")->get();
        $getAllAccountBalances = DB::table('financials_balances')->where("bal_transaction_type", "OPENING_BALANCE")->get();


        foreach($getAllAccountBalances as $getAllAccountBalance){

        $genearl = [];
        // $genearl["bal_total"] = -( $getAllAccountBalance->bal_cr );
        if( $getAllAccountBalance->bal_cr != 0 ){
         $genearl["bal_total"] = -( $getAllAccountBalance->bal_cr );
        }
        elseif( $getAllAccountBalance->bal_dr != 0 ){
         $genearl["bal_total"] = $getAllAccountBalance->bal_dr;
        }
        else{
         $genearl["bal_total"] = 0;
        }

        // $singleAccountBalanceUpdate = DB::table('financials_balances')->where("bal_account_id", $getAllAccountBalance->bal_account_id)->where("bal_transaction_type", "OPENING_BALANCE")->where("bal_cr", "!=", "0")->update($genearl);

        $singleAccountBalanceUpdate = DB::table('financials_balances')->where("bal_account_id", $getAllAccountBalance->bal_account_id)->where("bal_transaction_type", "OPENING_BALANCE")->update($genearl);

        $getSingleAccountBalances = DB::table('financials_balances')->where("bal_account_id", $getAllAccountBalance->bal_account_id)->where("bal_transaction_type", "!=", "OPENING_BALANCE")->orderBy("bal_id", "ASC")->get();


        // $getSingleAccountOpeningBalance = DB::table('financials_balances')->where("bal_account_id", $getAllAccountBalance->bal_account_id)->where("bal_transaction_type", "OPENING_BALANCE")->where("bal_cr", "!=", "0")->first();

        $getSingleAccountOpeningBalance = DB::table('financials_balances')->where("bal_account_id", $getAllAccountBalance->bal_account_id)->where("bal_transaction_type", "OPENING_BALANCE")->first();

        $openingBalance = $getSingleAccountOpeningBalance->bal_total;


        foreach($getSingleAccountBalances as $getSingleAccountBalance){
         if( $getSingleAccountBalance->bal_cr != 0 && $getSingleAccountBalance->bal_transaction_type != "OPENING_BALANCE" ){

             $setTotalBal = $openingBalance - $getSingleAccountBalance->bal_cr;

             $genearl3 = [];
             $genearl3["bal_total"] = $setTotalBal;
             DB::table('financials_balances')->where("bal_id", $getSingleAccountBalance->bal_id)->where("bal_account_id", $getSingleAccountBalance->bal_account_id)->update($genearl3);

             $openingBalance = $setTotalBal;
             echo $openingBalance." credit execute ";
         }
         else if( $getSingleAccountBalance->bal_dr != 0 && $getSingleAccountBalance->bal_transaction_type != "OPENING_BALANCE" ){

             $setTotalBal = $openingBalance + $getSingleAccountBalance->bal_dr;

             $genearl3 = [];
             $genearl3["bal_total"] = $setTotalBal;
             DB::table('financials_balances')->where("bal_id", $getSingleAccountBalance->bal_id)->where("bal_account_id", $getSingleAccountBalance->bal_account_id)->update($genearl3);

             $openingBalance = $setTotalBal;
             echo $openingBalance." debit execute ";

         }
         // dd($getSingleAccountBalance);
        }


        $genearl2 = [];
        $genearl2["account_balance"] = $openingBalance;
        $accountBalanceUpdate = DB::table('financials_accounts')->where("account_uid", $getAllAccountBalance->bal_account_id)->update($genearl2);

        echo "<br> <br> <hr> <br> <br>";
        }


     }



    public function assignDepartmentToEmployee(){

        $getAllAccounts = DB::table('financials_accounts')
            ->where('account_employee_id', '!=', 0)
            ->select( 'account_id', 'account_parent_code', 'account_employee_id')
            ->get();

        foreach ( $getAllAccounts as $getAllAccount ){
            $getDepartment = DB::table('financials_departments')
                ->where( 'dep_account_code', $getAllAccount->account_parent_code )
                ->first();
            if( isset($getDepartment) && !empty($getDepartment) ) {
                $updateDepartmentId = AccountRegisterationModel::where('account_parent_code', $getAllAccount->account_parent_code)
                    ->where('account_id', $getAllAccount->account_id )
                    ->first();
                $updateDepartmentId->account_department_id = $getDepartment->dep_id;
                $updateDepartmentId->save();

                echo "Department Id ".$getDepartment->dep_id." =&= Account Id ".$getAllAccount->account_id." <br /> <hr />>";
            }
        }


    }


    public function assignDepartmentToEmployee(){

        $getAllAccounts = DB::table('financials_accounts')
            ->where('account_employee_id', '!=', 0)
            ->where('account_department_id', '!=', Null)
            ->select( 'account_id', 'account_parent_code', 'account_employee_id', 'account_department_id')
            ->get();

        foreach ( $getAllAccounts as $getAllAccount ){

            $getSameNameEmployeAccount = DB::table('financials_accounts')
                ->where( 'account_employee_id', $getAllAccount->account_employee_id )
                ->where( 'account_department_id', '!=', Null)
                ->select('account_department_id', 'account_employee_id')
                ->first();


            if( isset($getSameNameEmployeAccount) && !empty($getSameNameEmployeAccount) ) {

                $updateDepartmentId = AccountRegisterationModel::
                where( 'account_employee_id', $getAllAccount->account_employee_id )
                    ->where( 'account_department_id', Null)
                    ->first();
                if( isset($updateDepartmentId) && !empty($updateDepartmentId) ){
                    $updateDepartmentId->account_department_id = $getSameNameEmployeAccount->account_department_id;
                    $updateDepartmentId->save();
                    echo " =&= Account Id ".$updateDepartmentId->account_id." <br /> <hr />>";
                }

            }
        }


    }



    public function proDellOnWarehouseStock(){
        $getProducts = ProductModel::select('pro_p_code', 'pro_title', 'pro_qty_for_sale')->get();
        $sr = 0;

        foreach ( $getProducts as $getProduct ){
            $checkStock = WarehouseStockModel::where( 'whs_product_code', $getProduct->pro_p_code )->get();
            if( count($checkStock) > 1 ){
                $delOneProFromStock = WarehouseStockModel::where('whs_product_code', $getProduct->pro_p_code)->orderBy('whs_id', 'ASC')->first()->delete();

                $updateRemainingProFromStock = WarehouseStockModel::where('whs_product_code', $getProduct->pro_p_code)->first();
                $updateRemainingProFromStock->whs_stock = $getProduct->pro_qty_for_sale;
                $updateRemainingProFromStock->save();

                echo $sr.":- || ".$getProduct->pro_title." Product update <br/> and Product code is '.$getProduct->pro_p_code.'<hr /><br/>";
            }
            else{
                echo $sr.":- || ".$getProduct->pro_title." Product Not Found <br/> and Product code is '.$getProduct->pro_p_code.'<hr /><br/>";
            }

            $sr++;
        }
    }


?>