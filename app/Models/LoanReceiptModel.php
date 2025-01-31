<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanReceiptModel extends Model
{
    // tabel name
    protected $table = 'financials_loan_receipt_voucher';

    // Primary Key attributes
    protected $primaryKey = 'lrv_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class, 'lrv_createdby', 'user_id');
    }
}
