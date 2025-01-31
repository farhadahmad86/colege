<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_purchase_invoice_items';

    // Primary Key attributes
    protected $primaryKey = 'pii_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
