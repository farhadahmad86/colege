<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturnSaletaxInvoiceModel extends Model
{
    // tabel name
    protected $table = 'financials_purchase_return_saletax_invoice';

    // Primary Key attributes
    protected $primaryKey = 'prsi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
