<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $table='inquiries';
    protected $primaryKey='inq_id';
    public $timestamps=false;


    public function setInqFullNameAttribute($value){
        $this->attributes['inq_full_name']=ucwords($value);
    }
    public function setInqFatherNameAttribute($value){
        $this->attributes['inq_father_name']=ucwords($value);
    }
}
