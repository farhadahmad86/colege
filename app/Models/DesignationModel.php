<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignationModel extends Model
{
    use HasFactory;
    // tabel name
    protected $table = 'financials_designation';

    // Primary Key attributes
    protected $primaryKey = 'desig_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
