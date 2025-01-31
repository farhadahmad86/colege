<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpensePaymentVoucherItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_expense_payment_voucher_items';

    // Primary Key attributes
    protected $primaryKey = 'epi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
