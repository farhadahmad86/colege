<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductManufactureItemsModel extends Model
{
    //for mass updation
    protected $guarded = [];
    // tabel name
    protected $table = 'financials_product_manufacture_items';

    // Primary Key attributes
    protected $primaryKey = 'pmi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
