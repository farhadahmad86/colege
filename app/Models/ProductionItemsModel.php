<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_production_items';

    // Primary Key attributes
    protected $primaryKey = 'prodi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
