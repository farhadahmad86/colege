<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceModel extends Model
{
    // tabel name
    protected $table = 'financials_sale_invoice';

    // Primary Key attributes
    protected $primaryKey = 'si_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
