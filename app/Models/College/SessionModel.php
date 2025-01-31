<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionModel extends Model
{
    use HasFactory;
    protected $table = 'sessions';
    protected $primaryKey = 'session_id';
    public $timestamps = false;

    //   setter
    public function setSessionNameAttribute($value)
    {
        $this->attributes['session_name'] = ucwords($value);
    }
    //    getter
    public function getSessionNameAttribute($value)
    {
        return ucwords($value);
    }

    //    Relationships
    public function colleges()
    {
        return $this->hasOne('App\Models\College\College', 'clg_id', 'session_clg_id');
    }
    public function users()
    {
        return $this->hasOne('App\User', 'user_id', 'session_created_by');
    }
}
