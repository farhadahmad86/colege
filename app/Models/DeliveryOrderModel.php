<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrderModel extends Model
{
    // tabel name
    protected $table = 'financials_delivery_order';

    // Primary Key attributes
    protected $primaryKey = 'do_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
