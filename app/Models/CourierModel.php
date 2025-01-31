<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourierModel extends Model
{
    // tabel name
    protected $table = 'financials_courier_company';

    // Primary Key attributes
    protected $primaryKey = 'cc_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
