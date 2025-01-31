<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicesInvoiceModel extends Model
{
    // tabel name
    protected $table = 'financials_service_invoice';

    // Primary Key attributes
    protected $primaryKey = 'sei_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
