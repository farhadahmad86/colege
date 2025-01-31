<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = 'groups';
    protected $primaryKey = 'group_id';
    public $timestamps = false;

    //    Relationships
    public function colleges()
    {
        return $this->hasOne('App\Models\College\College', 'clg_id', 'group_clg_id');
    }
    public function branches()
    {
        return $this->hasOne('App\Models\College\Branch', 'branch_id', 'group_branch_id');
    }
    public function users()
    {
        return $this->hasOne('App\user', 'user_id', 'group_created_by');
    }
    public function class()
    {
        return $this->hasOne('App\Models\College\class', 'class_id', 'group_class_id');
    }
    public function subjects()
    {
        return $this->hasOne('App\Models\College\Subject', 'subject_id', 'group_subject_id');
    }
}
