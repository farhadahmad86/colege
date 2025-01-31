<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectAssigModel extends Model
{
    use HasFactory;

    protected $table = 'subject_assign';
    protected $primaryKey = 'sa_id';
    // Timestamp Attributes
    public $timestamps = false;

    // Relationship
    public function users()
    {
        return $this->hasOne('App\user', 'user_id', 'sa_created_by');
    }
    public function department()
    {
        return $this->hasOne('App\Models\Department', 'dep_id', 'sa_dep_id');
    }
    public function employee()
    {
        return $this->hasOne('App\user', 'user_id', 'sa_user_id');
    }
    public function subjects()
    {
        return $this->hasOne('App\Models\College\Subject', 'subject_id', 'sa_subject_id');
    }
}
