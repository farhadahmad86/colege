<?php

namespace App\Traits;

use App\Models\AccountHeadsModel;
use App\Models\AccountRegisterationModel;
use App\User;
use Illuminate\Support\Facades\Auth;

trait PartyNameTrait
{
    public function get_account_query($case_name)
    {
        $user = auth()->user();
        $query = null;

        $head_fixed_asset = config('global_variables.fixed_asset_second_head');
        $fixed_account_parent = AccountHeadsModel::where('coa_clg_id', $user->user_clg_id)->where('coa_parent', $head_fixed_asset)->pluck('coa_code');

        switch ($case_name) {
            case 'purchase':
                $heads = explode(',', config('global_variables.payable_receivable_purchaser'));
                if ($user->user_role_id == config('global_variables.purchaser_role_id')) {
                    $account = $this->get_teller_or_purchaser_account($user->user_id);
                    $purchaser_account = $account->user_purchaser_wic_account_uid;
                } else {
                    $purchaser_account = config('global_variables.purchaser_account');
                }
                $query = AccountRegisterationModel::whereIn('account_parent_code', $heads)->where('account_clg_id', $user->user_clg_id)
                    ->whereNotIn(
                        'account_uid',
                        AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_parent_code', config('global_variables.purchaser_account_head'))
                            ->where('account_uid', '!=', $purchaser_account)
                            ->pluck('account_uid')->all()
                    );

                break;

            case 'sale':

                $heads = explode(',', config('global_variables.payable_receivable_walk_in_customer'));
                if ($user->user_role_id == config('global_variables.teller_account_id')) {
                    $account = $this->get_teller_or_purchaser_account($user->user_id);
                    $wic_account = $account->user_teller_wic_account_uid;
                } else {
                    $wic_account = config('global_variables.walk_in_customer');
                }
                $query = AccountRegisterationModel::whereIn('account_parent_code', $heads)->where('account_clg_id', $user->user_clg_id)
                    ->whereNotIn(
                        'account_uid',
                        AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_parent_code', config('global_variables.walk_in_customer_head'))
                            ->where('account_uid', '!=', $wic_account)
                            ->pluck('account_uid')->all()
                    );

                break;

            case 'cash_voucher':

                $heads = explode(',', config('global_variables.cash_voucher_accounts_not_in'));
                $query = AccountRegisterationModel::query();
                $query = $query->whereNotIn('account_parent_code', $heads)
                    ->where('account_clg_id', $user->user_clg_id)
                    ->whereNotIn('account_parent_code', $fixed_account_parent)
                    ->orderBy('account_parent_code', 'ASC');

                $query2 = AccountRegisterationModel::query();
                $query2 = $query2->where('account_parent_code', config('global_variables.cash'))
                    ->where('account_clg_id', $user->user_clg_id)
                    ->where('account_uid', '!=', config('global_variables.stock_in_hand'))
                    ->orderBy('account_parent_code', 'ASC');

                break;

            case 'bank_voucher':

                $heads = explode(',', config('global_variables.bank_voucher_accounts_not_in'));
                $query = AccountRegisterationModel::query();
                $query = $query->whereNotIn('account_parent_code', $heads)
                    ->where('account_clg_id', $user->user_clg_id)
                    ->whereNotIn('account_parent_code', $fixed_account_parent)
                    ->orderBy('account_parent_code', 'ASC');

                $query2 = AccountRegisterationModel::query();
                $query2 = $query2->where('account_parent_code', config('global_variables.bank_head'))
                    ->where('account_clg_id', $user->user_clg_id)
                    ->where('account_uid', '!=', config('global_variables.stock_in_hand'))
                    ->orderBy('account_parent_code', 'ASC');
                break;

            case 'expense_payment_voucher':

                $expense_voucher_accounts_cash_bank_heads = explode(',', config('global_variables.expense_voucher_accounts_cash_bank'));
                $query = AccountRegisterationModel::whereIn('account_parent_code', $expense_voucher_accounts_cash_bank_heads)
                    ->where('account_clg_id', $user->user_clg_id)->orderBy('account_uid', 'ASC');

                $expense_voucher_accounts_not_in_heads = explode(',', config('global_variables.expense_voucher_accounts_not_in'));
                $query2 = AccountRegisterationModel::query();
                $query2 = $query2->where('account_parent_code', 'like', config('global_variables.expense') . '%')
                    ->where('account_clg_id', $user->user_clg_id)
                    ->whereNotIn('account_parent_code', $expense_voucher_accounts_not_in_heads)
                    ->orderBy('account_parent_code', 'ASC');

                break;

            case 'journal_voucher':
                $journal_voucher_accounts_not_in_heads = explode(',', config('global_variables.journal_voucher_accounts_not_in'));

                $query = AccountRegisterationModel::query();
                $query = $query->whereNotIn('account_parent_code', $journal_voucher_accounts_not_in_heads)
                    ->where('account_clg_id', $user->user_clg_id)
//                    ->whereNotIn('account_parent_code', $fixed_account_parent)
                    ->orderBy('account_parent_code', 'ASC');

                break;

            case 'salary_payment_voucher':

                $salary_payment_accounts_not_in_heads = explode(',', config('global_variables.salary_payment_accounts_not_in'));
                $query = AccountRegisterationModel::query();
                $query = $query->whereNotIn('account_parent_code', $salary_payment_accounts_not_in_heads)
                    ->where('account_clg_id', $user->user_clg_id)
                    ->orderBy('account_parent_code', 'ASC');

                break;

            case 'advance_salary':

                $heads = explode(',', config('global_variables.payable_receivable_cash_bank'));

                $query = AccountRegisterationModel::query();
                $query = $query->whereIn('account_parent_code', $heads)
                    ->where('account_uid', '!=', config('global_variables.stock_in_hand'))
                    ->where('account_clg_id', $user->user_clg_id)
                    ->orderBy('account_parent_code', 'ASC');

                $query2 = AccountRegisterationModel::query();
                $query2 = $query2->where('account_parent_code', '=', config('global_variables.advance_salary_head'))
                    ->where('account_clg_id', $user->user_clg_id)
                    ->where('account_uid', '!=', config('global_variables.stock_in_hand'))
                    ->orderBy('account_parent_code', 'ASC');

                break;

            case 'payable_receivable':

                $heads = explode(',', config('global_variables.payable_receivable'));

                $query = AccountRegisterationModel::query();
                $query = $query->whereIn('account_parent_code', $heads)
                    ->where('account_clg_id', $user->user_clg_id)
                    ->orderBy('account_parent_code', 'ASC');

                $query2 = AccountRegisterationModel::query();
                $query2 = $query2
                    ->where('account_uid', 'like', '4%')
                    ->where('account_clg_id', $user->user_clg_id)
                    ->whereNotIn('account_parent_code', [41111, 41410])
                    ->orderBy('account_parent_code', 'ASC');

                break;

            case 'claim_account':

                $heads = explode(',', config('global_variables.party_claims_accounts_head'));

                $query = AccountRegisterationModel::query();
                $query = $query->whereIn('account_parent_code', $heads)
                    ->where('account_clg_id', $user->user_clg_id)
                    ->where('account_delete_status', '!=', 1)
                    ->where('account_disabled', '!=', 1)
                    ->orderBy('account_parent_code', 'ASC');

                $query2 = AccountRegisterationModel::query(); //this query note use any where need to modyfy for new query if need new account query
                $query2 = $query2
                    ->where('account_clg_id', $user->user_clg_id)
                    ->where('account_uid', 'like', '4%')
                    ->orderBy('account_parent_code', 'ASC');

                break;
            case 'revenue':


                $query = AccountRegisterationModel::query();
                $query = $query->where('account_uid','Like','3%')
                    ->where('account_clg_id', $user->user_clg_id)
                    ->orderBy('account_parent_code', 'ASC');

                $query2 = AccountRegisterationModel::query();
                $query2 = $query2
                    ->where('account_uid','Like','3%')
                    ->where('account_clg_id', $user->user_clg_id)
                    ->orderBy('account_parent_code', 'ASC');

                break;
            default:
                $query = [];
                break;
        }

        $accounts = $this->filterAccount($query);
        $accounts_2 = isset($query2) ? $this->filterAccount($query2) : null;

        return [$accounts, $accounts_2 ?? null];
    }


    public function filterAccount($query)
    {
        $user = Auth::user();
        return $query->where('account_delete_status', '!=', 1)
            ->where('account_clg_id', $user->user_clg_id)
            ->where('account_disabled', '!=', 1)
            ->orderBy('account_uid', 'ASC')
            ->get();
    }

    public function get_teller_or_purchaser_account($teller_id)
    {
        $user = Auth::user();
        $account = User::where('user_id', $teller_id)->where('user_clg_id', $user->user_clg_id)->first();
        return $account;
    }
}
