<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovementModels extends Model
{
    // tabel name
    protected $table = 'financials_stock_movement';

    // Primary Key attributes
    protected $primaryKey = 'sm_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
