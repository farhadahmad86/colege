<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionModel extends Model
{
    // tabel name
    protected $table = 'financials_production';

    // Primary Key attributes
    protected $primaryKey = 'prod_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
