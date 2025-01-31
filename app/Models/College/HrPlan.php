<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrPlan extends Model
{
    use HasFactory;
    protected $table = 'hr_plans';
    protected $primaryKey = 'hr_plan_id';
    public $timestamps = false;

    public function setHrPlanNameAttribute($value)
    {
        $this->attributes['hr_plan_name'] = ucwords($value);
    }
    //    getter
    public function getHrPlanNameAttribute($value)
    {
        return ucwords($value);
    }

    //    Relationships

    public function users()
    {
        return $this->hasOne('App\User', 'user_id', 'hr_plan_created_by');
    }
}
