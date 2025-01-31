<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicesInvoiceItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_service_invoice_items';

    // Primary Key attributes
    protected $primaryKey = 'seii_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
