<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandModel extends Model
{
    // tabel name
    protected $table = 'financials_brands';

    // Primary Key attributes
    protected $primaryKey = 'br_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
//
}
