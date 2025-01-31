<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryInfoModel extends Model
{
    protected $guarded = [];
    // tabel name
    protected $table = 'financials_categories';

    // Primary Key attributes
    protected $primaryKey = 'cat_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
