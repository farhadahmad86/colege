<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryAccountStructureModel extends Model
{
    // tabel name
    protected $table = 'financials_salary_account_structure';

    // Primary Key attributes
    protected $primaryKey = 'sas_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
