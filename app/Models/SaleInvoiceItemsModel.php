<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_sale_invoice_items';

    // Primary Key attributes
    protected $primaryKey = 'sii_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
