<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPackagesModel extends Model
{
    // tabel name
    protected $table = 'financials_product_packages';

    // Primary Key attributes
    protected $primaryKey = 'pp_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
