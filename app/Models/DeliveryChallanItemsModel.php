<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryChallanItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_delivery_challan_items';

    // Primary Key attributes
    protected $primaryKey = 'dci_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
