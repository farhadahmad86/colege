<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleOrderItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_sale_order_items';

    // Primary Key attributes
    protected $primaryKey = 'soi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
