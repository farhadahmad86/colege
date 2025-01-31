<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkExamModel extends Model
{
    use HasFactory;
    protected $table = 'marks_exam';
    protected $primaryKey = 'me_id';
    public $timestamps = false;

    protected $fillable=['me_id'];
}
