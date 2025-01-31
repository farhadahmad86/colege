<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ApprovalJournalVoucherModel extends Model
{
    // tabel name
    protected $table = 'financials_approval_journal_voucher';

    // Primary Key attributes
    protected $primaryKey = 'ajv_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'ajv_createdby', 'user_id');
    }
}
