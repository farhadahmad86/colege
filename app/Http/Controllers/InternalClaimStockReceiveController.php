<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\PartyClaimItemModel;
use App\Models\PartyClaimModel;
use App\Models\PostingReferenceModel;
use App\Models\StockMovementModels;
use App\Models\TransactionModel;
use App\Models\WarehouseModel;
use App\Models\WarehouseStockModel;
use App\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InternalClaimStockReceiveController extends Controller
{
    public function add_claim_stock_receive()
    {
        // $heads = config('global_variables.party_claims_accounts_head');
        // $accounts = AccountRegisterationModel::where('account_parent_code', $heads)->where('account_delete_status', '!=', 1)->where('account_disabled', '!=', 1)->orderBy('account_uid', 'ASC')->get();
        $products = $this->get_all_products();

        $pro_code = '';
        $pro_name = '';
        foreach ($products as $product) {
            $pro_code .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-purchase_price='$product->pro_purchase_price' data-scale_size='$product->unit_scale_size' data-unit='$product->unit_title' data-main_unit='$product->mu_title'>$product->pro_p_code</option>";
            $pro_name .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-purchase_price='$product->pro_purchase_price' data-scale_size='$product->unit_scale_size' data-unit='$product->unit_title' data-main_unit='$product->mu_title'>$product->pro_title</option>";
        }


        return view('add_internal_claim_stock_transfer_warehouse_voucher', compact('pro_code', 'pro_name' ));

    }

    public function submit_claim_stock_receive(Request $request)
    {
        $this->validate($request, [
            'party_claim_account' => ['required', 'string'],
            'claim_issue_voucher' => ['nullable', 'string'],
            'remarks' => ['required'],
            'total_items' => ['required', 'numeric', 'gt:0'],
            'total_price' => ['required', 'numeric', "min:0"],
            'products_array' => ['required'],
        ]);

        $products = json_decode($request->products_array, true);

        $user = Auth::user();
        $rollBack = false;

        DB::beginTransaction();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $partyClaim = $this->assign_party_claim_values($request, $user, $day_end);
        if (!$partyClaim->save()) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        $data = $this->AssignWarehouseStocksValues([], $products, 1);
        if (!WarehouseStockModel::insert($data))
        {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Warehouse Stock Summary Insertion ////////////////////////////////////

        $warehouses_summary = [];
        $warehouse_stock_summary = $this->AssignWarehouseStocksSummaryValues($warehouses_summary, $products, 'CLAIM RECEIVED');

        if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        $detail_remarks = '';

        foreach ($products as $product)
        {
            $detail_remarks .= $product['product_name'] . ', ' . $product['product_qty'] . '@' . number_format($product['product_amount'], 2) . PHP_EOL;

            $partyClaimItem = $this->assign_party_claim_items_value($product, $partyClaim);
            if (!$partyClaimItem->save())
            {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $stock_movement_last_entry = StockMovementModels::where('sm_product_code', '=', $product['product_code'])->orderBy('sm_id', 'desc')->first();
            $stock_movement = $this->assignStockMovementValues($request, $product, $user, $day_end, $stock_movement_last_entry);
            if (!$stock_movement->save())
            {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }
        }

        $partyClaim->pc_detail_remarks = $detail_remarks;
        $partyClaim->save();

        $amount = $request->total_price;

        $stock_in_hand = config('global_variables.stock_in_hand');
        $claim_issue =  config('global_variables.claim_received');
        $party_claim_account =  $request->party_claim_account;

        $transactions1 = new TransactionModel();
        $transaction1 = $this->AssignTransactionsValues($transactions1, $stock_in_hand, $amount, 0, '', '', 0);

        if ($transaction1->save()) {

            $transaction_id1 = $transaction1->trans_id;

            $balances1 = new BalancesModel();

            $balance1 = $this->AssignAccountBalancesValues($balances1, $transaction_id1, $stock_in_hand, $amount, 'Dr', $request->remarks,
                'CLAIM_RECEIVED', '', '', $request->posting_reference);

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


        $transactions1 = new TransactionModel();
        $transaction1 = $this->AssignTransactionsValues($transactions1, $claim_issue, $amount, 0, '', '', 0);

        if ($transaction1->save()) {

            $transaction_id1 = $transaction1->trans_id;

            $balances1 = new BalancesModel();

            $balance1 = $this->AssignAccountBalancesValues($balances1, $transaction_id1, $claim_issue, $amount, 'Dr', $request->remarks,
                'CLAIM_RECEIVED', '', '', $request->posting_reference);

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

        $transactions1 = new TransactionModel();
        $transaction1 = $this->AssignTransactionsValues($transactions1, 0, $amount, $party_claim_account, '', '', 0);


        if ($transaction1->save()) {

            $transaction_id1 = $transaction1->trans_id;

            $balances1 = new BalancesModel();

            $balance1 = $this->AssignAccountBalancesValues($balances1, $transaction_id1, $party_claim_account, $amount, 'Cr', $request->remarks,
                'CLAIM_RECEIVED', '', '', $request->posting_reference);

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

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Claim Receive With SM_Id: ' . $stock_movement->sm_id . ' And Name: ' . $stock_movement->sm_type);

            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    private function assignStockMovementValues(Request $request, $product, $user, $day_end, $stock_movement_last_entry)
    {
        $stock_movement = new StockMovementModels();
        $stock_movement->sm_type = 'CLAIM RECEIVED';
        $stock_movement->sm_product_code = $product['product_code'];
        $stock_movement->sm_product_name = $product['product_name'];
        $stock_movement->sm_in_qty = $product['product_qty'];
        $stock_movement->sm_in_bonus = null;
        $stock_movement->sm_in_rate = $product['product_rate'];
        $stock_movement->sm_in_total = $product['product_amount'];
        $stock_movement->sm_out_qty = null;
        $stock_movement->sm_out_bonus = null;
        $stock_movement->sm_out_rate = null;
        $stock_movement->sm_out_total = null;

        $stock_movement->sm_internal_hold = null;
        $stock_movement->sm_internal_bonus = null;
        $stock_movement->sm_internal_claim = $product['product_qty'];

        $stock_movement->sm_bal_qty_for_sale = $stock_movement_last_entry->sm_bal_qty_for_sale + $product['product_qty'] - $stock_movement->sm_internal_claim;

        $stock_movement->sm_bal_bonus_inward = 0;
        $stock_movement->sm_bal_bonus_outward = 0;
        $stock_movement->sm_bal_bonus_qty = $stock_movement_last_entry->sm_bal_bonus_qty;

        $stock_movement->sm_bal_hold = 0;
        $stock_movement->sm_bal_total_hold = $stock_movement_last_entry->sm_bal_total_hold;
        $stock_movement->sm_bal_claims = $stock_movement_last_entry->sm_bal_claims + $stock_movement->sm_internal_claim;

        $stock_movement->sm_bal_total_qty_wo_bonus = $stock_movement->sm_bal_qty_for_sale + $stock_movement->sm_bal_total_hold + $stock_movement->sm_bal_claims;
        $stock_movement->sm_bal_total_qty = $stock_movement->sm_bal_total_qty_wo_bonus + $stock_movement->sm_bal_bonus_qty;

        $sm_bal_rate_dividend = $stock_movement_last_entry->sm_bal_total_qty_wo_bonus + $stock_movement->sm_in_qty;
        $stock_movement->sm_bal_rate = ($stock_movement_last_entry->sm_bal_total + $stock_movement->sm_in_total) / ( $sm_bal_rate_dividend == 0 ? 1 : $sm_bal_rate_dividend );
        $stock_movement->sm_bal_total = $stock_movement->sm_bal_total_qty_wo_bonus * $stock_movement->sm_bal_rate;

        $stock_movement->sm_day_end_id = $day_end->de_id;
        $stock_movement->sm_day_end_date = $day_end->de_datetime;
        $stock_movement->sm_voucher_code = '';
        $stock_movement->sm_remarks = '';
        $stock_movement->sm_user_id = $user->user_id;
        $stock_movement->sm_date_time = now();

        return $stock_movement;
    }

    private function assign_party_claim_values($request, $user, $day_end)
    {
        $partyClaim = new PartyClaimModel();
        $partyClaim->pc_type = 'CLAIM RECEIVED';
        $partyClaim->pc_party_claim_account = $request->party_claim_account;
        $partyClaim->pc_pr_id = $request->posting_reference;
//        $partyClaim->pc_purchase_invoice_num = '';
//        $partyClaim->pc_sale_return_invoice_num = '';
        $partyClaim->pc_claim_issue_voucher_num = $request->claim_issue_voucher;
        $partyClaim->pc_remarks = $request->remarks;
        $partyClaim->pc_total_amount = $request->total_price;
        $partyClaim->pc_user_id = $user->user_id;
        $partyClaim->pc_day_end_id = $day_end->de_id;
        $partyClaim->pc_day_end_date = $day_end->de_datetime;
        $partyClaim->pc_datetime = Carbon::now()->toDateTimeString();;
        $partyClaim->pc_ip_adrs = $this->getIp();
        $partyClaim->pc_brwsr_info = $this->getBrwsrInfo();

        return $partyClaim;
    }

    private function assign_party_claim_items_value($product, PartyClaimModel $partyClaim)
    {
        $partyClaimItem = new PartyClaimItemModel();
        $partyClaimItem->pci_pc_id = $partyClaim->pc_id;
        $partyClaimItem->pci_product_code = $product['product_code'];
        $partyClaimItem->pci_product_name = $product['product_name'];
        $partyClaimItem->pci_remarks = $product['product_remarks'];
        $partyClaimItem->pci_warehouse_id = $product['warehouse'];
        $partyClaimItem->pci_warehouse_name = $product['warehouse_name'];
        $partyClaimItem->pci_qty = $product['product_qty'];
        $partyClaimItem->pci_scale_size = $product['product_scale_size'];
        $partyClaimItem->pci_uom = $product['product_uom'];
        $partyClaimItem->pci_rate = $product['product_rate'];
        $partyClaimItem->pci_amount = $product['product_amount'];

        return $partyClaimItem;
    }

    public function claim_stock_receive_list(Request $request, $array = null, $str = null)
    {
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : null) : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : null) : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : null) : $request->from;

        $prnt_page_dir = 'print.party_claim.received.claim_stock_receive';
        $pge_title = 'Claim Stock Receive';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from);
        $pagination_number = (empty($ar)) ? 30 : 100000000;

        if (!empty($search) || !empty($search_to) || !empty($search_from)) {
            $searchData = [ 'search' => $search, 'to' => date('Y-m-d', strtotime($search_to)), 'from' =>  date('Y-m-d', strtotime($search_from)) ];
            $partyClaims = $this->search($searchData);
        } else {
            $partyClaims = PartyClaimModel::orderBy('pc_id', 'ASC')->where('pc_type', '=', 'CLAIM RECEIVED');
        }

        $ttl_amount = $partyClaims->sum('pc_total_amount');
        $partyClaims = $partyClaims->paginate($pagination_number);
        $partyClaims = $this->mapData($partyClaims);

        if (isset($request->array) && !empty($request->array)) {
            return $this->printable($request, $partyClaims, $srch_fltr, $prnt_page_dir, $pge_title);
        } else {
            return view('claim_stock_receive_list', compact('partyClaims', 'ttl_amount','search', 'search_to', 'search_from'));
        }
    }

    private function search(array $searchData)
    {
        $query = PartyClaimModel::orderBy('pc_id', 'DESC')->where('pc_type', '=', 'CLAIM RECEIVED');

        if (!empty($searchData['search'])) {
            $query->where(function ($q) use ($searchData) {
                $q->Where('pc_id', 'like', '%' . $searchData['search'] . '%')
                    ->orWhere('pc_detail_remarks', 'like', '%' . $searchData['search'] . '%')
                    ->orWhere('pc_total_amount', 'like', '%' . $searchData['search'] . '%');
            });
        }
        if ((!empty($searchData['to'])) && (!empty($searchData['from']))) {
            $query->whereDate('pc_day_end_date', '>=', $searchData['to'])
                ->whereDate('pc_day_end_date', '<=', $searchData['from']);
        } elseif (!empty($searchData['to'])) {
            $query->where('pc_day_end_date', $searchData['to']);
        } elseif (!empty($searchData['from'])) {
            $query->where('pc_day_end_date', $searchData['from']);
        }

        return $query;
    }

    private function mapData($partyClaims)
    {
        return $partyClaims->setCollection( $partyClaims->getCollection()->map(function ($partyClaim) {
            $partyClaim['createdBy'] = User::where('user_id', '=', $partyClaim->pc_user_id)->pluck('user_name')->first();
            return $partyClaim;
        }));
    }

    private function printable(Request $request, $partyClaims, $srch_fltr, $prnt_page_dir, $pge_title)
    {
        $type = (isset($request->str)) ? $request->str : '';

        $footer = view('print._partials.pdf_footer')->render();
        $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
        $options = stream_context_create([
            'ssl'=>[
                'verify_peer'=>FALSE,
                'verify_peer_name'=>FALSE,
                'allow_self_signed'=>TRUE,
            ]
        ]);
        $optionss =[
            'footer-html' => $footer,
            'header-html' => $header,
        ];
        $pdf = PDF::setOptions(['isHTML5ParserEnabled'=>true, 'isRemoteEnabled'=>true]);
        $pdf->getDomPDF()->setHttpContext($options,$optionss);
        $pdf->loadView($prnt_page_dir, compact('partyClaims', 'type', 'pge_title'));
        // $pdf->setOptions($options);

        if ($type === 'pdf') {
            return $pdf->stream($pge_title . '_x.pdf');
        } else if ($type === 'download_pdf') {
            return $pdf->download($pge_title . '_x.pdf');
        } else if ($type === 'download_excel') {
            return Excel::download(new ExcelFileCusExport($partyClaims, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
        }
    }

    public function claim_stock_receive_items_view_details_SH(Request $request, $id)
    {
        $jrnl = PartyClaimModel::where('pc_id', $id)->first();
        $items = PartyClaimItemModel::where('pci_pc_id', $id)->get();
        $nbrOfWrds = $this->myCnvrtNbr($jrnl->pc_total_amount);
        $invoice_nbr = $jrnl->pc_id;
        $invoice_date = $jrnl->pc_datetime;
        $invoice_remarks = $jrnl->pc_remarks;
        $type = 'grid';
        $pge_title = 'Claim Stock Receive Items';

        return view('voucher_view.party_claim.receive.party_stock_receive_list_modal', compact('items', 'jrnl', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'invoice_remarks'));
    }

    public function claim_stock_receive_items_view_details_pdf_SH(Request $request, $id)
    {
        $jrnl = PartyClaimModel::where('pc_id', $id)->first();
        $items = PartyClaimItemModel::where('pci_pc_id', $id)->get();
        $nbrOfWrds = $this->myCnvrtNbr($jrnl->pc_total_amount);
        $invoice_nbr = $jrnl->pc_id;
        $invoice_date = $jrnl->pc_datetime;
        $invoice_remarks = $jrnl->pc_remarks;
        $type = 'pdf';
        $pge_title = 'Claim Stock Receive Items';

        $footer = view('voucher_view._partials.pdf_footer')->render();
        $header = view('voucher_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type', 'invoice_remarks'))->render();
        $options = stream_context_create([
            'ssl'=>[
                'verify_peer'=>FALSE,
                'verify_peer_name'=>FALSE,
                'allow_self_signed'=>TRUE,
            ]
        ]);
        $optionss =[
            'footer-html' => $footer,
            'header-html' => $header,
            'margin-top' => 24,
        ];
        $pdf = PDF::setOptions(['isHTML5ParserEnabled'=>true, 'isRemoteEnabled'=>true]);
        $pdf->getDomPDF()->setHttpContext($options,$optionss);
        $pdf->loadView('voucher_view.party_claim.receive.party_stock_receive_list_modal', compact('items', 'jrnl', 'nbrOfWrds', 'type','invoice_nbr','invoice_date','pge_title'));
        // $pdf->setOptions($options);

        return $pdf->stream('Party-Claim-Receive-Detail.pdf');
    }


}
