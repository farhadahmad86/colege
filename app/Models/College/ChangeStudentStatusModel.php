<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeStudentStatusModel extends Model
{
    protected $guarded = [];
    // tabel name
    protected $table = 'change_student_status';

    // Primary Key attributes
    protected $primaryKey = 'css_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
