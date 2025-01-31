<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturnSaletaxInvoiceItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_purchase_return_saletax_invoice_items';

    // Primary Key attributes
    protected $primaryKey = 'prsii_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
