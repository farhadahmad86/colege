<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    protected $table = 'classes';
    protected $primaryKey = 'class_id';
    public $timestamps = false;

    //   setter
    public function setClassNameAttribute($value)
    {
        $this->attributes['class_name'] = ucwords($value);
    }
    //    getter
    public function getClassNameAttribute($value)
    {
        return ucwords($value);
    }

    //    Relationships
    public function colleges()
    {
        return $this->hasOne('App\Models\College\College', 'clg_id', 'class_clg_id');
    }
    public function branches()
    {
        return $this->hasOne('App\Models\College\Branch', 'branch_id', 'class_branch_id');
    }
    public function users()
    {
        return $this->hasOne('App\user', 'user_id', 'class_created_by');
    }
    public function degrees()
    {
        return $this->hasOne('App\Models\College\Degree', 'degree_id', 'class_degree_id');
    }
    public function groups()
    {
        return $this->hasOne('App\Models\College\Group', 'group_id', 'class_group_id');
    }
    public function subjects()
    {
        return $this->hasOne('App\Models\College\Subject', 'subject_id', 'class_subject_list');
    }
    public function sessions()
    {
        return $this->hasOne('App\Models\College\SessionModel', 'session_id', 'class_session_id');
    }
}
