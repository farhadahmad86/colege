<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    //for mass updation
    protected $guarded = [];
    // tabel name
    protected $table = 'financials_products';

    // Primary Key attributes
    protected $primaryKey = 'pro_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
