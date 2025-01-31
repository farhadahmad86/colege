<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyDelivery extends Model
{
    // tabel name
    protected $table = 'financials_company_delivery';

    // Primary Key attributes
    protected $primaryKey = 'cd_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
