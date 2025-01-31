<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LanguageModel extends Model
{
    // tabel name
    protected $table = 'financials_language';

    // Primary Key attributes
    protected $primaryKey = 'lan_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
