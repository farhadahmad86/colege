<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    // tabel name
    protected $table = 'financials_departments';

    // Primary Key attributes
    protected $primaryKey = 'dep_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;


}
