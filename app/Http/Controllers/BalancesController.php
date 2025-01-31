<?php

namespace App\Http\Controllers;

use App\Models\BalancesModel;
use Illuminate\Http\Request;

class BalancesController extends Controller
{
//    public function add_balance($account_uid,$current_balance,$account_nature)
//    {
//        $previous_balance=$this->calculate_balance($account_uid);
//
//        $total_balance=$previous_balance+$current_balance;
//
//        $account_balance=new BalancesModel();
//
//        $account_balance->bal_account_id=$account_uid;
//
//        if($account_nature==1)
//        {
//            $account_balance->bal_dr=$current_balance;
//            $account_balance->bal_total=$total_balance;
//            $account_balance->bal_cr=0;
//            if($previous_balance==0)
//            {
//                $account_balance->bal_transaction_type='OPENING_BALANCE';
//                $account_balance->bal_transaction_id=0;
//            }else{
//
//                $account_balance->bal_transaction_id=0;
//            }
//        }elseif ($account_nature==2){
//            $account_balance->bal_cr=$current_balance;
//            $account_balance->bal_total=$total_balance;
//            $account_balance->bal_dr=0;
//            if($previous_balance==0)
//            {
//                $account_balance->bal_transaction_type='OPENING_BALANCE';
//                $account_balance->bal_transaction_id=0;
//            }else{
//
//                $account_balance->bal_transaction_id=0;
//            }
//        }
//
//        $account_balance->save();
//
//    }

    public function calculate_balance($account_uid)
    {
        $total=BalancesModel::where('bal_account_id',$account_uid)->orderBy('bal_id','DESC')->pluck('bal_total')->first();

        return $total;
    }
}
