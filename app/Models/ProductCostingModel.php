<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCostingModel extends Model
{
    // tabel name
    protected $table = 'financials_product_costing';

    // Primary Key attributes
    protected $primaryKey = 'pc_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
