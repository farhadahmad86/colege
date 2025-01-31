<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceSaleTaxInvoiceItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_service_saletax_invoice_items';

    // Primary Key attributes
    protected $primaryKey = 'sesii_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
