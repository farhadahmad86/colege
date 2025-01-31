<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class BankPaymentVoucherModel extends Model
{
    // tabel name
    protected $table = 'financials_bank_payment_voucher';

    // Primary Key attributes
    protected $primaryKey = 'bp_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'bp_createdby', 'user_id');
    }
}
