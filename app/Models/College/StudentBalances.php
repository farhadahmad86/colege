<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentBalances extends Model
{
    protected $guarded = [];
    // tabel name
    protected $table = 'student_balances';

    // Primary Key attributes
    protected $primaryKey = 'sbal_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
