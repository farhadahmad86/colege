<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseStockModel extends Model
{
    // tabel name
    protected $table = 'financials_warehouse_stock';

    // Primary Key attributes
    protected $primaryKey = 'whs_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
