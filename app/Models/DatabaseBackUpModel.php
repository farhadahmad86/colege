<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatabaseBackUpModel extends Model
{
    protected $guarded = [];
    // tabel name
    protected $table = 'financials_database_backup';

    // Primary Key attributes
    protected $primaryKey = 'dbb_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
