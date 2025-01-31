<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StuckOffVoucherModel extends Model
{
    protected $guarded = [];
    // tabel name
    protected $table = 'stuck_off_voucher';

    // Primary Key attributes
    protected $primaryKey = 'sov_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
