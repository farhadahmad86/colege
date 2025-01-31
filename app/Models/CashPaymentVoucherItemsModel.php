<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashPaymentVoucherItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_cash_payment_voucher_items';

    // Primary Key attributes
    protected $primaryKey = 'cpi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
