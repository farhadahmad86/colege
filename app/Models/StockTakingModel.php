<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTakingModel extends Model
{
    // tabel name
    protected $table = 'financials_stock_taking';

    // Primary Key attributes
    protected $primaryKey = 'st_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
