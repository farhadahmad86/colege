<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryModel extends Model
{
    // tabel name
    protected $table = 'financials_inventory';

    // Primary Key attributes
    protected $primaryKey = 'invt_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
