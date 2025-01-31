<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleSaletaxInvoiceModel extends Model
{
    // tabel name
    protected $table = 'financials_sale_saletax_invoice';

    // Primary Key attributes
    protected $primaryKey = 'ssi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
