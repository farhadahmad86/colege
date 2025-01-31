<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class GenerateSalarySlipModel extends Model
{
    // tabel name
    protected $table = 'financials_generate_salary_slip_voucher';

    // Primary Key attributes
    protected $primaryKey = 'gss_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'gss_created_by', 'user_id');
    }
}
