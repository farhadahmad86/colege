<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;

    protected $table='colleges';
    protected $primaryKey='clg_id';
    public $timestamps=false;
    protected $fillable = [
        'clg_name',
        'clg_logo',
    ];

    public function setClgNameAttribute($value){
        $this->attributes['clg_name']=ucwords($value);
    }
}
