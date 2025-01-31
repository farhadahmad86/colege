<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ExpensePaymentVoucherModel extends Model
{
    // tabel name
    protected $table = 'financials_expense_payment_voucher';

    // Primary Key attributes
    protected $primaryKey = 'ep_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'ep_createdby', 'user_id');
    }
}
