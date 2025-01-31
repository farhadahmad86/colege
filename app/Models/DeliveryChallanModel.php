<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryChallanModel extends Model
{
    // tabel name
    protected $table = 'financials_delivery_challan';

    // Primary Key attributes
    protected $primaryKey = 'dc_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
