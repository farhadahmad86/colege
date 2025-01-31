<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOutwardModel extends Model
{
    // table name
    protected $table = 'financials_stock_outward';

    // Primary Key attributes
    protected $primaryKey = 'so_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
