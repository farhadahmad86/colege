<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecrementIncrementModel extends Model
{
    protected $table = 'decrease_increase_package';
    protected $primaryKey = 'di_id';
    public $timestamps = false;
}
