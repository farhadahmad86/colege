<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryInfoModel extends Model
{
    // tabel name
    protected $table = 'financials_salary_info';

    // Primary Key attributes
    protected $primaryKey = 'si_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
