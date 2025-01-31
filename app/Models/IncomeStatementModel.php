<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeStatementModel extends Model
{
    // tabel name
    protected $table = 'financials_income_statement';

    // Primary Key attributes
    protected $primaryKey = 'is_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
