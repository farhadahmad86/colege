<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllowanceDeductionModel extends Model
{
    // tabel name
    protected $table = 'financials_allowances_deductions';

    // Primary Key attributes
    protected $primaryKey = 'ad_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
