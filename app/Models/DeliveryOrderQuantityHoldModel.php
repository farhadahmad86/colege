<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrderQuantityHoldModel extends Model
{
    // tabel name
    protected $table = 'financials_delivery_order_qty_hold_log';

    // Primary Key attributes
    protected $primaryKey = 'doqh_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
