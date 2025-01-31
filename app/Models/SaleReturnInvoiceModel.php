<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleReturnInvoiceModel extends Model
{
    // tabel name
    protected $table = 'financials_sale_return_invoice';

    // Primary Key attributes
    protected $primaryKey = 'sri_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
