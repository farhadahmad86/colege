<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainUnitModel extends Model
{
    // tabel name
    protected $table = 'financials_main_units';

    // Primary Key attributes
    protected $primaryKey = 'mu_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
