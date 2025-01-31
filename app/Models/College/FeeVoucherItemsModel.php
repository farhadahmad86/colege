<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeVoucherItemsModel extends Model
{
    protected $table = 'financials_fee_voucher_items';
    protected $primaryKey = 'fvi_id';
    public $timestamps = false;
}
