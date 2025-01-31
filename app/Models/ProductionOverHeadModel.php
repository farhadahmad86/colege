<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionOverHeadModel extends Model
{
    // tabel name
    protected $table = 'financials_production_over_head';

    // Primary Key attributes
    protected $primaryKey = 'poh_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
