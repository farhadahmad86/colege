<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRecipeModel extends Model
{
    // tabel name
    protected $table = 'financials_product_recipe';

    // Primary Key attributes
    protected $primaryKey = 'pr_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
