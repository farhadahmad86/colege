<?php

namespace App\Models\College;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTableModel extends Model
{
    use HasFactory;
    protected $table = 'class_timetable';
    protected $primaryKey = 'tm_id';
    public $timestamps = false;


    public function users()
    {
        return $this->hasOne('App\user', 'user_id', 'tm_created_by');
    }
    public function teacher()
    {
        return $this->hasOne('App\user', 'user_id', 'tm_teacher_id');
    }
    public function subject()
    {
        return $this->hasOne('App\Models\College\Subject', 'subject_id', 'tm_subject_id');
    }
}
