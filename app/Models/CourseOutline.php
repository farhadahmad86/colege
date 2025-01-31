<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseOutline extends Model
{
    use HasFactory;
    protected $table = 'course_outlines';
    protected $primaryKey = 'co_id';
    public $timestamps = false;
}
