<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class BankReceiptVoucherModel extends Model
{
    // tabel name
    protected $table = 'financials_bank_receipt_voucher';

    // Primary Key attributes
    protected $primaryKey = 'br_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class, 'br_createdby', 'user_id');
    }
}
