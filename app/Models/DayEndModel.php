<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayEndModel extends Model
{
    // tabel name
    protected $table = 'financials_day_end';

    // Primary Key attributes
    protected $primaryKey = 'de_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
