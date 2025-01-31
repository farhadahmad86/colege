<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FineadZoneQuantityModel extends Model
{
    // tabel name
    protected $table = 'finead_calculate_zone_qty';

    // Primary Key attributes
    protected $primaryKey = 'fcqz_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
