<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockInwardModel extends Model
{
    // tabel name
    protected $table = 'financials_stock_inward';

    // Primary Key attributes
    protected $primaryKey = 'si_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
