<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvanceFeeReverseVoucher extends Model
{
    use HasFactory;
    // tabel name
    protected $table = 'advance_fee_reverse_vouchers';

    // Primary Key attributes
    protected $primaryKey = 'afrv_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
