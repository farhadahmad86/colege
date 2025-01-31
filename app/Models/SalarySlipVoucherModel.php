<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalarySlipVoucherModel extends Model
{
    // tabel name
    protected $table = 'financials_salary_slip_voucher';

    // Primary Key attributes
    protected $primaryKey = 'ss_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
