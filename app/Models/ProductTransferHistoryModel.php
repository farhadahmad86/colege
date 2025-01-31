<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTransferHistoryModel extends Model
{
    // tabel name
    protected $table = 'financials_product_transfer_history';

    // Primary Key attributes
    protected $primaryKey = 'pth_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
