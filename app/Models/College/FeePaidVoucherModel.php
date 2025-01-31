<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePaidVoucherModel extends Model
{
    protected $table = 'financials_fee_paid_voucher';
    protected $primaryKey = 'fpv_id';
    public $timestamps = false;
}
