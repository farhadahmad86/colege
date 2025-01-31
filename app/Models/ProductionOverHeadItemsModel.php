<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionOverHeadItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_production_over_head_items';

    // Primary Key attributes
    protected $primaryKey = 'pohi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
