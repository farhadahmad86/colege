<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankPaymentVoucherItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_bank_payment_voucher_items';

    // Primary Key attributes
    protected $primaryKey = 'bpi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
