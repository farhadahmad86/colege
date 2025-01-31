<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CashReceiptVoucherModel extends Model
{
    // tabel name
    protected $table = 'financials_cash_receipt_voucher';

    // Primary Key attributes
    protected $primaryKey = 'cr_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'cr_createdby', 'user_id');
    }
}
