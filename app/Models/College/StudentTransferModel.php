<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTransferModel extends Model
{
    use HasFactory;
    protected $table = 'student_transfer';
    protected $primaryKey = 'st_id';
    public $timestamps = false;

    public function getStudent()
    {
        return $this->hasMany(Student::class,'id','st_std_id');
    }
}

