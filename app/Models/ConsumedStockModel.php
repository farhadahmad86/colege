<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsumedStockModel extends Model
{
    // tabel name
    protected $table = 'financials_consumed_stock';

    // Primary Key attributes
    protected $primaryKey = 'cs_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
