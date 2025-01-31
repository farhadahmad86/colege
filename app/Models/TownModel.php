<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TownModel extends Model
{
    // tabel name
    protected $table = 'financials_towns';

    // Primary Key attributes
    protected $primaryKey = 'town_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
