<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomVoucherModel extends Model
{
    protected $table = 'student_custom_voucher';
    protected $primaryKey = 'cv_id';
    public $timestamps = false;
}
