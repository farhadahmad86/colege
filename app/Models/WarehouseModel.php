<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseModel extends Model
{
    // tabel name
    protected $table = 'financials_warehouse';

    // Primary Key attributes
    protected $primaryKey = 'wh_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
