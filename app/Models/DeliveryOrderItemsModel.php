<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrderItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_delivery_order_items';

    // Primary Key attributes
    protected $primaryKey = 'doi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
