<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPromotioModel extends Model
{
    use HasFactory;
    protected $table = 'student_promotion';
    protected $primaryKey = 'sp_id';
    public $timestamps = false;}
