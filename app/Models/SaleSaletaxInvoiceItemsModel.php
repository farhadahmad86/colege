<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleSaletaxInvoiceItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_sale_saletax_invoice_items';

    // Primary Key attributes
    protected $primaryKey = 'ssii_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
