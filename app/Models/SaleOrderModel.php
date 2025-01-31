<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleOrderModel extends Model
{
    // tabel name
    protected $table = 'financials_sale_order';

    // Primary Key attributes
    protected $primaryKey = 'so_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
