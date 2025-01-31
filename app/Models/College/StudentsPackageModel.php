<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsPackageModel extends Model
{
    // tabel name
    protected $table = 'students_package';

    // Primary Key attributes
    protected $primaryKey = 'sp_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
