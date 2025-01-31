<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class SingleEntryController extends Controller
{
    public function single_entry()
    {
        $accounts = AccountRegisterationModel::get();
        return view('single_entry.single_entry', compact('accounts'));

    }

    public function store_single_entry(Request $request)
    {
        $accountUID = $request->account_uid;
        $debitCredit = $request->debit_credit;
        $amount = $request->amount;
        $remarks = $request->reamrks;

        if ($debitCredit == 1) {
            $balances = new BalancesModel();
            $balance = $this->AssignAccountBalancesValues($balances, 0, $accountUID, $amount, 'Dr', $request->remarks,
                'SINGLE ENTRY', '', '' .
                '', '', '', '');

            if (!$balance->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }
            return redirect()->back()->with('success', 'Account UID ' . $accountUID . ' debited with amount: ' . $amount);

        } else if ($debitCredit == 2) {
            $balances = new BalancesModel();
            $balance = $this->AssignAccountBalancesValues($balances, 0, $accountUID, $amount, 'Cr', $request->remarks,
                'SINGLE ENTRY', '', '' .
                '', '', '', '');
            if (!$balance->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }
            return redirect()->back()->with('success', 'Account UID ' . $accountUID . ' credited with amount: ' . $amount);

        } else {
            return redirect()->back()->with('fail', 'Type Debit/Credit not found!');
        }
        return redirect()->back()->with('success', 'Successfully saved');
    }
}
