<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RawStockCostingModel extends Model
{
    // tabel name
    protected $table = 'financials_raw_stock_costing';

    // Primary Key attributes
    protected $primaryKey = 'rsc_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
