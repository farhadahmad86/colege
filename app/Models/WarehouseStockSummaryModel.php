<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseStockSummaryModel extends Model
{
    // tabel name
    protected $table = 'financials_warehouse_stock_summary';

    // Primary Key attributes
    protected $primaryKey = 'whss_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
