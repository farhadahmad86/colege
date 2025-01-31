<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityModel extends Model
{
    // tabel name
    protected $table = 'financials_city';

    // Primary Key attributes
    protected $primaryKey = 'city_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
