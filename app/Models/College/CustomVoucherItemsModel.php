<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomVoucherItemsModel extends Model
{
    protected $table = 'student_custom_voucher_items';
    protected $primaryKey = 'cvi_id';
    public $timestamps = false;
}
