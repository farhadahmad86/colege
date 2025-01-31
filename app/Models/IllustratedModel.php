<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IllustratedModel extends Model
{
    // tabel name
    protected $table = 'financials_illustrated';

    // Primary Key attributes
    protected $primaryKey = 'ill_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
