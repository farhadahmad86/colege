<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Model
{
    // tabel name
    protected $table = 'financials_employee';

    // Primary Key attributes
    protected $primaryKey = 'emp_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
