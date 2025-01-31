<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturnInvoiceItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_purchase_return_invoice_items';

    // Primary Key attributes
    protected $primaryKey = 'prii_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
