<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseSaletaxItemsInvoiceModel extends Model
{
    // tabel name
    protected $table = 'financials_purchase_saletax_invoice_items';

    // Primary Key attributes
    protected $primaryKey = 'psii_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
