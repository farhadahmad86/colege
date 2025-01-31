<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryBatchModel extends Model
{
    // tabel name
    protected $table = 'new_new_inventory_batch';

    // Primary Key attributes
    protected $primaryKey = 'bat_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
