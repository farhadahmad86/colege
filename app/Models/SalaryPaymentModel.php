<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SalaryPaymentModel extends Model
{
    // tabel name
    protected $table = 'financials_salary_payment';

    // Primary Key attributes
    protected $primaryKey = 'sp_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'sp_createdby', 'user_id');
    }
}
