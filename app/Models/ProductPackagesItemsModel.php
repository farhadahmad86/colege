<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPackagesItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_product_packages_items';

    // Primary Key attributes
    protected $primaryKey = 'ppi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
