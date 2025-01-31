<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AdvanceSalaryModel extends Model
{
    // tabel name
    protected $table = 'financials_advance_salary';

    // Primary Key attributes
    protected $primaryKey = 'as_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'as_created_by', 'user_id');
    }
}
