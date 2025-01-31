<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenerateSalarySlipItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_generate_salary_slip_voucher_items';

    // Primary Key attributes
    protected $primaryKey = 'gssi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
