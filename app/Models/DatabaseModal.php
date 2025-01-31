<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatabaseModal extends Model
{
//    use HasFactory;
    // tabel name
    protected $table = 'financials_database';

    // Primary Key attributes
    protected $primaryKey = 'db_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}

