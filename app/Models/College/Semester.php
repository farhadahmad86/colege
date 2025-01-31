<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    protected $table = 'semesters';
    protected $primaryKey = 'semester_id';
    public $timestamps = false;

    //   setter
    public function setSemesterNameAttribute($value)
    {
        $this->attributes['semester_name'] = ucwords($value);
    }
    //    getter
    public function getSemesterNameAttribute($value)
    {
        return ucwords($value);
    }

    //    Relationships
    public function colleges()
    {
        return $this->hasOne('App\Models\College\College', 'clg_id', 'semester_clg_id');
    }
    public function users()
    {
        return $this->hasOne('App\User', 'user_id', 'semester_created_by');
    }
}
