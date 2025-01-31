<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceModel extends Model
{
    use HasFactory;
    // tabel name
    protected $table = 'financials_attendance';

    // Primary Key attributes
    protected $primaryKey = 'atten_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
