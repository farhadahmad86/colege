<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleReturnSaletaxInvoiceItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_sale_return_saletax_invoice_items';

    // Primary Key attributes
    protected $primaryKey = 'srsii_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
