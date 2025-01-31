<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalarySlipVoucherItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_salary_slip_voucher_items';

    // Primary Key attributes
    protected $primaryKey = 'ssi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
