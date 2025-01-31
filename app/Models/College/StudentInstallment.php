<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInstallment extends Model
{
    // tabel name
    protected $table = 'student_installments';

    // Primary Key attributes
    protected $primaryKey = 'si_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;

}
