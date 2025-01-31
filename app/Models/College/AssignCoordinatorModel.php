<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignCoordinatorModel extends Model
{

    use HasFactory;
    protected $table = 'assign_coordinator';
    protected $primaryKey = 'ac_id';
    public $timestamps = false;

    public function users()
    {
        return $this->hasOne('App\user', 'user_id', 'ac_created_by');
    }
}

