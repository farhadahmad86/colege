<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGroupModel extends Model
{
    // tabel name
    protected $table = 'financials_product_group';

    // Primary Key attributes
    protected $primaryKey = 'pg_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
