<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleReturnSaletaxInvoiceModel extends Model
{
    // tabel name
    protected $table = 'financials_sale_return_saletax_invoice';

    // Primary Key attributes
    protected $primaryKey = 'srsi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
