<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePaidVoucherItemsModel extends Model
{
    protected $table = 'financials_fee_paid_voucher_items';
    protected $primaryKey = 'fpvi_id';
    public $timestamps = false;
}
