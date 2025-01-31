<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkTeacherAttendanceItemsModel extends Model
{
    use HasFactory;
    protected $table = 'lecturer_attendance_items';
    protected $primaryKey = 'lai_id';
    public $timestamps = false;
}
