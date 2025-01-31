<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanVoucherModel extends Model
{
    use HasFactory;

    // tabel name
    protected $table = 'financials_loan_voucher';

    // Primary Key attributes
    protected $primaryKey = 'lv_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'lv_createdby', 'user_id');
    }
}
