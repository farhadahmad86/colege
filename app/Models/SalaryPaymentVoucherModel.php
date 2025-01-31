<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryPaymentVoucherModel extends Model
{
    // tabel name
//    protected $table = 'financials_salary_payment_voucher';
    protected $table = 'financials_salary_payment';

    // Primary Key attributes
    protected $primaryKey = 'sp_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
