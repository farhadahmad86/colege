<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearEndModel extends Model
{
    // tabel name
    protected $table = 'financials_year_end';

    // Primary Key attributes
    protected $primaryKey = 'ye_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
