<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDeliveryChallanExtensionModel extends Model
{
    // tabel name
    protected $table = 'financials_si_dc_extension';

    // Primary Key attributes
    protected $primaryKey = 'sde_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
