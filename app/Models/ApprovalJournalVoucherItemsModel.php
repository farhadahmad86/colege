<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalJournalVoucherItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_approval_journal_voucher_items';

    // Primary Key attributes
    protected $primaryKey = 'ajvi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;

    public function postingReference()
    {
        // Define the relationship between ApprovalJournalVoucherItemsModel and PostingReferenceModel
        return $this->belongsTo(PostingReferenceModel::class, 'ajvi_pr_id', 'pr_id');
    }
}
