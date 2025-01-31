<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntryLogModel extends Model
{
    // tabel name
    protected $table = 'financials_entry_log';

    // Primary Key attributes
    protected $primaryKey = 'el_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
