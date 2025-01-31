<?php

namespace App\Models\College;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassTimetableItem extends Model
{
    use HasFactory;
    protected $table = 'class_timetable_item';
    protected $primaryKey = 'tmi_id';
    public $timestamps = false;

}
