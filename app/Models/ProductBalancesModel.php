<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBalancesModel extends Model
{
    // tabel name
    protected $table = 'financials_product_balances';

    // Primary Key attributes
    protected $primaryKey = 'pb_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
