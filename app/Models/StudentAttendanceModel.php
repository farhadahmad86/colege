<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendanceModel extends Model
{
    use HasFactory;
    protected $table = 'student_attendance';
    protected $primaryKey = 'std_att_id';
    public $timestamps = false;

    // public function classes()
    // {
    //     return $this->hasOne('App\Http\Controllers\College\Classes');
    // }
    // public function sections()
    // {
    //     return $this->hasOne('App\Http\Controllers\College\Section');
    // }
    // public function students()
    // {
    //     return $this->hasOne('app\Http\Controllers\College\Student');
    // }
}
