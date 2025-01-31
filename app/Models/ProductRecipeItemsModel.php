<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRecipeItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_product_recipe_items';

    // Primary Key attributes
    protected $primaryKey = 'pri_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
