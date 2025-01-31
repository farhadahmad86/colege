<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankReceiptVoucherItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_bank_receipt_voucher_items';


    // Primary Key attributes
    protected $primaryKey = 'bri_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
