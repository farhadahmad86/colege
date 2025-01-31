<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedAssetVoucherModel extends Model
{
// tabel name
    protected $table = 'financials_fixed_asset_voucher';

    // Primary Key attributes
    protected $primaryKey = 'fav_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'fav_createdby', 'user_id');
    }
}
