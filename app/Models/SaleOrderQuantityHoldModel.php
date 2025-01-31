<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleOrderQuantityHoldModel extends Model
{
    // tabel name
    protected $table = 'financials_sale_order_qty_hold_log';

    // Primary Key attributes
    protected $primaryKey = 'soqh_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
