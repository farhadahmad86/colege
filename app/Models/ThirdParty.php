<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThirdParty extends Model
{
    // tabel name
    protected $table = 'financials_third_party';

    // Primary Key attributes
    protected $primaryKey = 'tp_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
