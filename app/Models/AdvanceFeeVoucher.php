<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvanceFeeVoucher extends Model
{
    // tabel name
    protected $table = 'advance_fee_vouchers';

    // Primary Key attributes
    protected $primaryKey = 'afv_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
