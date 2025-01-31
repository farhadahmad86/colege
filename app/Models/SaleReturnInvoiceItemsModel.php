<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleReturnInvoiceItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_sale_return_invoice_items';

    // Primary Key attributes
    protected $primaryKey = 'srii_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
