<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductManufactureModel extends Model
{
    //for mass updation
    protected $guarded = [];
    // tabel name
    protected $table = 'financials_product_manufacture';

    // Primary Key attributes
    protected $primaryKey = 'pm_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
