<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelfCollection extends Model
{
    // tabel name
    protected $table = 'financials_self_collection';

    // Primary Key attributes
    protected $primaryKey = 'sc_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
