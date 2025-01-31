<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionStockAdjustmentModel extends Model
{
    // tabel name
    protected $table = 'financials_production_stock_adjustment';

    // Primary Key attributes
    protected $primaryKey = 'psa_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
