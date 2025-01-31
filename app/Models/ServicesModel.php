<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicesModel extends Model
{
    // tabel name
    protected $table = 'financials_services';

    // Primary Key attributes
    protected $primaryKey = 'ser_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
