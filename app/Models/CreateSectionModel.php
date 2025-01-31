<?php

namespace App\Models;

use App\Models\StudentAttendanceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StudentAttendanceModel as StudentAttendance;

class CreateSectionModel extends Model
{
    protected $table = 'create_section';
    protected $primary_key = 'cs_id';
    public $timestamps = false;


    public function studentAttendance()
    {
        return $this->hasMany(StudentAttendance::class, 'std_att_section_id', 'cs_id');
    }
}
