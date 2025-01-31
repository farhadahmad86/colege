<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentModel extends Model
{
    protected $table = 'student_fee_components';
    protected $primaryKey = 'sfc_id';
    public $timestamps = false;

    public function setNameAttribute($value)
    {
        $this->attributes['sfc_name'] = ucwords($value);
    }
}
