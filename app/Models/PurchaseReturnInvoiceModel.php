<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturnInvoiceModel extends Model
{
    // tabel name
    protected $table = 'financials_purchase_return_invoice';

    // Primary Key attributes
    protected $primaryKey = 'pri_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
