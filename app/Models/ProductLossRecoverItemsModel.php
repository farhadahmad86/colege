<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLossRecoverItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_product_loss_recover_items';

    // Primary Key attributes
    protected $primaryKey = 'plri_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
