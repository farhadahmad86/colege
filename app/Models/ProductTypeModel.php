<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTypeModel extends Model
{
    // tabel name
    protected $table = 'financials_product_type';

    // Primary Key attributes
    protected $primaryKey = 'pt_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
