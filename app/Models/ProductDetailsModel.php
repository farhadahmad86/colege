<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetailsModel extends Model
{
    // tabel name
    protected $table = 'financials_product_detail';

    // Primary Key attributes
    protected $primaryKey = 'pd_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
