<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenreModel extends Model
{
    // tabel name
    protected $table = 'financials_genre';

    // Primary Key attributes
    protected $primaryKey = 'gen_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
