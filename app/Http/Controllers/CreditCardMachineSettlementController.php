<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\CreditCardMachineModel;
use App\Models\CreditCardMachineSettlementModel;
use App\Models\JournalVoucherItemsModel;
use App\Models\JournalVoucherModel;
use App\Models\ProductLossRecoverItemsModel;
use App\Models\SectorModel;
use App\Models\TransactionModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CreditCardMachineSettlementController extends Controller
{
    public function credit_card_machine_settlement()
    {
        $machines = CreditCardMachineModel::where('ccm_delete_status', '!=', 1)->where('ccm_disabled', '!=', 1)->orderBy('ccm_title', 'ASC')->get();
        return view('credit_card_machine_settlement', compact('machines'));
    }

    public function submit_credit_card_machine_settlement(Request $request)
    {
        $this->credit_card_machine_settlement_validation($request);

        $rollBack = false;
        $user = Auth::User();

        DB::beginTransaction();

        $credit_card_machine_info = CreditCardMachineModel::where('ccm_id', $request->credit_card_machine)->where('ccm_delete_status', '!=', 1)->where('ccm_disabled', '!=', 1)->first();

        if ($credit_card_machine_info !== null) {


            //////////////////////////// Credit Card Settlement Insertion ////////////////////////////////////

            $credit_card_machine_settlement = new CreditCardMachineSettlementModel();

            $credit_card_machine_settlement = $this->AssignCreditCardMachineSettlementValues($request, $credit_card_machine_settlement);

            if ($credit_card_machine_settlement->save()) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Credit Card Machine Settlement With Id: ' . $credit_card_machine_settlement->ccms_id . ' And Machine Name: ' . $credit_card_machine_info->ccm_title);
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Journal Voucher Insertion ////////////////////////////////////

            $jv = new JournalVoucherModel();

            $jv = $this->assign_journal_voucher_values($jv, $request);

            if ($jv->save()) {
                $jv_id = $jv->jv_id;

            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }

            $detail_remarks = '';

            $credit_card_amount = $request->amount;
            $posting_reference_id = $request->posting_reference;

            $service_charges_amount = ($credit_card_amount * $credit_card_machine_info->ccm_percentage) / 100;
            $bank_amount = $credit_card_amount - $service_charges_amount;

            $credit_card_account_uid = $credit_card_machine_info->ccm_credit_card_account_code;
            $credit_card_account_name = $this->get_account_name($credit_card_account_uid);
            $bank_account_uid = $credit_card_machine_info->ccm_bank_code;
            $bank_account_name = $this->get_account_name($bank_account_uid);
            $service_charges_account_uid = $credit_card_machine_info->ccm_service_account_code;
            $service_charges_account_name = $this->get_account_name($service_charges_account_uid);

            //////////////////////////// Detail Remarks Of Journal Voucher Insertion ////////////////////////////////////

            $detail_remarks .= $credit_card_account_name . ', ' . 'Cr' . '@' . number_format($credit_card_amount, 2) . PHP_EOL;
            $detail_remarks .= $bank_account_name . ', ' . 'Dr' . '@' . number_format($bank_amount, 2) . PHP_EOL;
            $detail_remarks .= $service_charges_account_name . ', ' . 'Dr' . '@' . number_format($service_charges_amount, 2) . PHP_EOL;


            $jv->jv_detail_remarks = $detail_remarks;

            if (!$jv->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Journal Voucher Items Insertion ////////////////////////////////////

            $jv_item1 = new JournalVoucherItemsModel();

            $jv_item1 = $this->assign_journal_voucher_items_values($jv_item1, $jv_id, $credit_card_account_uid, $credit_card_account_name, $credit_card_amount, 'Cr');

            if (!$jv_item1->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }

            $jv_item2 = new JournalVoucherItemsModel();

            $jv_item2 = $this->assign_journal_voucher_items_values($jv_item2, $jv_id, $bank_account_uid, $bank_account_name, $bank_amount, 'Dr');

            if (!$jv_item2->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }

            $jv_item3 = new JournalVoucherItemsModel();

            $jv_item3 = $this->assign_journal_voucher_items_values($jv_item3, $jv_id, $service_charges_account_uid, $service_charges_account_name, $service_charges_amount, 'Dr');

            if (!$jv_item3->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }

            $notes = 'JOURNAL_VOUCHER';

            $voucher_code = config('global_variables.JOURNAL_VOUCHER_CODE');

            $transaction_type = config('global_variables.JV');

            //////////////////////////// TRANSACTION CREDIT CARD ACCOUNT ////////////////////////////////////

            $transactions1 = new TransactionModel();
            $transaction1 = $this->AssignTransactionsValues($transactions1, 0, $credit_card_amount, $credit_card_account_uid, $notes, $transaction_type, $jv_id);

            if ($transaction1->save()) {
                $transaction_id1 = $transaction1->trans_id;

                $balances1 = new BalancesModel();

                $balance1 = $this->AssignAccountBalancesValues($balances1, $transaction_id1, $credit_card_account_uid, $credit_card_amount, 'Cr', $request->remarks,
                    $notes, $detail_remarks, $voucher_code . $jv_id,$posting_reference_id);

                if (!$balance1->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


            //////////////////////////// TRANSACTION BANK ACCOUNT ////////////////////////////////////

            $transactions1 = new TransactionModel();
            $transaction1 = $this->AssignTransactionsValues($transactions1, 0, $bank_amount, $bank_account_uid, $notes, $transaction_type, $jv_id);

            if ($transaction1->save()) {
                $transaction_id1 = $transaction1->trans_id;

                $balances1 = new BalancesModel();

                $balance1 = $this->AssignAccountBalancesValues($balances1, $transaction_id1, $bank_account_uid, $bank_amount, 'Dr', $request->remarks,
                    $notes, $detail_remarks, $voucher_code . $jv_id,$posting_reference_id);

                if (!$balance1->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// TRANSACTION BANK SERVICE CHARGES ACCOUNT ////////////////////////////////////

            $transactions1 = new TransactionModel();
            $transaction1 = $this->AssignTransactionsValues($transactions1, 0, $service_charges_amount, $service_charges_account_uid, $notes, $transaction_type, $jv_id);

            if ($transaction1->save()) {
                $transaction_id1 = $transaction1->trans_id;

                $balances1 = new BalancesModel();

                $balance1 = $this->AssignAccountBalancesValues($balances1, $transaction_id1, $service_charges_account_uid, $service_charges_amount, 'Dr', $request->remarks,
                    $notes, $detail_remarks, $voucher_code . $jv_id,$posting_reference_id);

                if (!$balance1->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {
            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    public function credit_card_machine_settlement_validation($request)
    {
        return $this->validate($request, [
            'credit_card_machine' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'time' => ['required', 'regex:/^((1[0-2]|0?[1-9]):([0-5][0-9]) ?([AaPp][Mm]))/'],
            'batch' => ['required', 'numeric'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    protected function AssignCreditCardMachineSettlementValues($request, $credit_card_machine_settlement)
    {
        $user = Auth::User();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $credit_card_machine_settlement->ccms_cc_machine_id = ucwords($request->credit_card_machine);
        $credit_card_machine_settlement->ccms_date = date('Y-m-d', strtotime($request->date));
        $credit_card_machine_settlement->ccms_time = date("H:i", strtotime($request->time));
        $credit_card_machine_settlement->ccms_batch_number = $request->batch;
        $credit_card_machine_settlement->ccms_amount = $request->amount;
        $credit_card_machine_settlement->ccms_pr_id = $request->posting_reference;
        $credit_card_machine_settlement->ccms_remarks = ucfirst($request->remarks);
        $credit_card_machine_settlement->ccms_user_id = $user->user_id;
        $credit_card_machine_settlement->ccms_day_end_id = $day_end->de_id;
        $credit_card_machine_settlement->ccms_day_end_date = $day_end->de_datetime;
        $credit_card_machine_settlement->ccms_datetime = Carbon::now()->toDateTimeString();
        $credit_card_machine_settlement->ccms_ip_adrs = $ip_rslt;
        $credit_card_machine_settlement->ccms_brwsr_info = $brwsr_rslt;

        return $credit_card_machine_settlement;
    }

    private function assign_journal_voucher_values($jv, $request)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $jv->jv_remarks = ucfirst($request->remarks);
        $jv->jv_total_dr = $request->amount;
        $jv->jv_total_cr = $request->amount;
        $jv->jv_created_datetime = Carbon::now()->toDateTimeString();
        $jv->jv_day_end_id = $day_end->de_id;
        $jv->jv_day_end_date = $day_end->de_datetime;
        $jv->jv_createdby = $user->user_id;

        // coding from shahzaib start
        $tbl_var_name = 'jv';
        $prfx = 'jv';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now()->toDateTimeString();
        // coding from shahzaib end

        return $jv;
    }

    private function assign_journal_voucher_items_values($jv_item, $jv_id, $account_id, $account_name, $amount, $type)
    {
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $jv_item->jvi_journal_voucher_id = $jv_id;
        $jv_item->jvi_account_id = $account_id;
        $jv_item->jvi_account_name = $account_name;
        $jv_item->jvi_amount = $amount;
        $jv_item->jvi_type = $type;
        $jv_item->jvi_remarks = '';
        $jv_item->jvi_brwsr_info = $brwsr_rslt;
        $jv_item->jvi_ip_adrs = $ip_rslt;
        $jv_item->jvi_update_datetime = Carbon::now()->toDateTimeString();

        return $jv_item;
    }

    public function credit_card_machine_settlement_list(Request $request, $array = null, $str = null)
    {
        $accounts = $this->get_fourth_level_account(config('global_variables.bank_head'), 0, 0);
        $machines = CreditCardMachineModel::orderBy('ccm_title', 'ASC')->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_bank = (!isset($request->account) && empty($request->account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->account;
        $search_machine = (!isset($request->machine) && empty($request->machine)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->machine;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.credit_card_machine_settlement_list.credit_card_machine_settlement_list';
        $pge_title = 'Credit Card Machine Settlement List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_bank, $search_machine, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('financials_credit_card_machine_settlement')
            ->leftJoin('financials_credit_card_machine', 'financials_credit_card_machine.ccm_id', 'financials_credit_card_machine_settlement.ccms_cc_machine_id')
            ->leftJoin('financials_accounts', 'financials_accounts.account_uid', 'financials_credit_card_machine.ccm_bank_code')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_credit_card_machine_settlement.ccms_user_id');

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('ccms_date', 'like', '%' . $search . '%')
                    ->orWhere('ccms_time', 'like', '%' . $search . '%')
                    ->orWhere('ccms_batch_number', 'like', '%' . $search . '%')
                    ->orWhere('ccms_amount', 'like', '%' . $search . '%')
                    ->orWhere('ccm_title', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%');
            });
        }


        if (!empty($search_bank)) {
            $pagination_number = 1000000;
            $query->where('ccm_bank_code', $search_bank);
        }

        if (!empty($search_machine)) {
            $pagination_number = 1000000;
            $query->where('ccm_id', $search_machine);
        }

        if (!empty($search_by_user)) {
            $query->where('ccms_user_id', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereBetween('ccms_day_end_date', [$start, $end]);
        } elseif (!empty($search_to)) {
            $query->where('ccms_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('ccms_day_end_date', $end);
        }

        $datas = $query->orderBy('ccms_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $party = CreditCardMachineSettlementModel::orderBy('ccms_batch_number', 'ASC')->pluck('ccms_batch_number')->all();

        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
              return view('credit_card_machine_settlement_list', compact('datas','accounts','machines', 'search','party','search_bank','search_machine','search_to','search_from','search_by_user'));
        }
    }
}
