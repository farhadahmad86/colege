<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddInventoryModel extends Model
{
    // tabel name
    protected $table = 'new_new_inventory';

    // Primary Key attributes
    protected $primaryKey = 'new_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
