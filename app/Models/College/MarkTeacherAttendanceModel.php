<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkTeacherAttendanceModel extends Model
{
    use HasFactory;
    protected $table = 'lecturer_attendance';
    protected $primaryKey = 'la_id';
    public $timestamps = false;

    public function setLaStartTimeAttribute($value)
    {
        $this->attributes['la_start_time'] = date("H:i", strtotime($value));
    }
    public function setLaEndTimeAttribute($value)
    {
        $this->attributes['la_end_time'] = date("H:i", strtotime($value));
    }
    //    getter
    public function getLaStartTimeAttribute($value)
    {
        return  $value != null ? date("g:i A", strtotime($value)) : '';
    }
    public function getLaEndTimeAttribute($value)
    {
        return $value != null ? date("g:i A", strtotime($value)) : '';
    }
}
