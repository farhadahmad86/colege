<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CashPaymentVoucherModel extends Model
{
    // tabel name
    protected $table = 'financials_cash_payment_voucher';

    // Primary Key attributes
    protected $primaryKey = 'cp_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'cp_createdby', 'user_id');
    }
}
