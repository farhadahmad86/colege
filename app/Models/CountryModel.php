<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryModel extends Model
{
    // tabel name
    protected $table = 'financials_country';

    // Primary Key attributes
    protected $primaryKey = 'c_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
