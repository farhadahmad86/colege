<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProducedStockModel extends Model
{
    // tabel name
    protected $table = 'financials_produced_stock';

    // Primary Key attributes
    protected $primaryKey = 'ps_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
