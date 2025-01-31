<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceModel extends Model
{
    // tabel name
    protected $table = 'financials_purchase_invoice';

    // Primary Key attributes
    protected $primaryKey = 'pi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
