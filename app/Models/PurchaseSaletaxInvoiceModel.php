<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseSaletaxInvoiceModel extends Model
{
    // tabel name
    protected $table = 'financials_purchase_saletax_invoice';

    // Primary Key attributes
    protected $primaryKey = 'psi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
