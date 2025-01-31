<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FineadCalculationZoneModel extends Model
{
    // tabel name
    protected $table = 'finead_calculation_zone_wise';

    // Primary Key attributes
    protected $primaryKey = 'calz_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;

}
