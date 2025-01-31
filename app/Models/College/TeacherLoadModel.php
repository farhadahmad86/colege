<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherLoadModel extends Model
{
    use HasFactory;
    protected $table = 'teacher_load';
    protected $primaryKey = 'tl_id';
    public $timestamps = false;

    //    Relationships
    public function colleges()
    {
        return $this->hasOne('App\Models\College\College', 'clg_id', 'subject_clg_id');
    }
    public function branches()
    {
        return $this->hasOne('App\Models\College\Branch', 'branch_id', 'subject_branch_id');
    }
    public function users()
    {
        return $this->hasOne('App\user', 'user_id', 'tl_created_by');
    }
    public function financialsUser()
{
    return $this->belongsTo(User::class, 'subject_teacher_id', 'user_id');
}
}
