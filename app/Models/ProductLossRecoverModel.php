<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLossRecoverModel extends Model
{
    // tabel name
    protected $table = 'financials_product_loss_recover';

    // Primary Key attributes
    protected $primaryKey = 'plr_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
