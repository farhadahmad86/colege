<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitInfoModel extends Model
{
    // tabel name
    protected $table = 'financials_units';

    // Primary Key attributes
    protected $primaryKey = 'unit_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
