<?php

namespace App\Models\College;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'students';
    protected $guard = 'student';
    protected $primaryKey = 'id';
    protected $fillable = [
        'full_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $timestamps=false;
    public function setFullNameAttribute($value){
        $this->attributes['full_name']=ucwords($value);
    }
    public function setFatherNameAttribute($value){
        $this->attributes['father_name']=ucwords($value);
    }
    public function getDobAttribute($value)
    {
        return  date('d-M-y', strtotime(str_replace('/', '-', $value)));
    }
    public function getAdmissionDateAttribute($value)
    {
        return  date('d-M-y', strtotime(str_replace('/', '-', $value)));
    }
}
