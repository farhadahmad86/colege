<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    use HasFactory;
    protected $table = 'degrees';
    protected $primaryKey = 'degree_id';
    public $timestamps = false;

    //   setter
    public function setDegreeNameAttribute($value)
    {
        $this->attributes['degree_name'] = ucwords($value);
    }
    //    getter
    public function getDegreeNameAttribute($value)
    {
        return ucwords($value);
    }

    //    Relationships
    public function colleges()
    {
        return $this->hasOne('App\Models\College\College', 'clg_id', 'degree_clg_id');
    }
    public function users()
    {
        return $this->hasOne('App\User', 'user_id', 'degree_created_by');
    }
}
