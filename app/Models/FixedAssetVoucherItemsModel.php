<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedAssetVoucherItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_fixed_asset_voucher_items';

    // Primary Key attributes
    protected $primaryKey = 'favi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
