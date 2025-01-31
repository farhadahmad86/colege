<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $table = 'branches';
    protected $primaryKey = 'branch_id';
    public $timestamps = false;
    //    protected $fillable = [
    //        'branch_name',
    //        'branch_address',
    //    ];

    //   setter
    public function setBranchNameAttribute($value)
    {
        $this->attributes['branch_name'] = ucwords($value);
    }
    //    getter
    public function getBranchNameAttribute($value)
    {
        return ucwords($value);
    }
    public function getBranchTypeAttribute($value)
    {
        return ucwords($value);
    }

    //    Relationships
    public function colleges()
    {
        return $this->hasOne('App\Models\College\College', 'clg_id', 'branch_clg_id');
    }
    public function users()
    {
        return $this->hasOne('App\User', 'user_id', 'branch_user_id');
    }
}
