<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixedAssetModel extends Model
{
    // tabel name
    protected $table = 'financials_fixed_asset';

    // Primary Key attributes
    protected $primaryKey = 'fa_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
