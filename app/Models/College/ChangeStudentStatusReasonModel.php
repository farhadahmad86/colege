<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeStudentStatusReasonModel extends Model
{
    // tabel name
    protected $table = 'change_student_status_reason';

    // Primary Key attributes
    protected $primaryKey = 'cssr_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
