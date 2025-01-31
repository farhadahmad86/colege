<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovementChildModel extends Model
{
    // tabel name
    protected $table = 'financials_stock_movement_child';

    // Primary Key attributes
    protected $primaryKey = 'smc_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
