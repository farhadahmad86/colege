<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $table = 'schools';
    protected $primaryKey = 'sch_id';
    public $timestamps = false;

    //   setter
    public function setSchNameAttribute($value)
    {
        $this->attributes['sch_name'] = ucwords($value);
    }
    //    getter
    public function getSchNameAttribute($value)
    {
        return ucwords($value);
    }

    //    Relationships
    public function colleges()
    {
        return $this->hasOne('App\Models\College\College', 'clg_id', 'sch_clg_id');
    }
    public function users()
    {
        return $this->hasOne('App\User', 'user_id', 'sch_created_by');
    }
}
