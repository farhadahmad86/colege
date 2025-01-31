<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanModel extends Model
{
    // tabel name
    protected $table = 'financials_loan';

    // Primary Key attributes
    protected $primaryKey = 'loan_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
