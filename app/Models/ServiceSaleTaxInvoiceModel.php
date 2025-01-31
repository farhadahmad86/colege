<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceSaleTaxInvoiceModel extends Model
{
    // tabel name
    protected $table = 'financials_service_saletax_invoice';

    // Primary Key attributes
    protected $primaryKey = 'sesi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
