<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayEndConfigModel extends Model
{
    // tabel name
    protected $table = 'financials_day_end_config';

    // Primary Key attributes
    protected $primaryKey = 'dec_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
