<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourierService extends Model
{
    // tabel name
    protected $table = 'financials_courier_service';

    // Primary Key attributes
    protected $primaryKey = 'cs_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
