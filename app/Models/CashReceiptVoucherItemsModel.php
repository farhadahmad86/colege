<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashReceiptVoucherItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_cash_receipt_voucher_items';

    // Primary Key attributes
    protected $primaryKey = 'cri_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
