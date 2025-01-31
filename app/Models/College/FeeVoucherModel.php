<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeVoucherModel extends Model
{
    protected $table = 'financials_fee_voucher';
    protected $primaryKey = 'fv_id';
    public $timestamps = false;
}
