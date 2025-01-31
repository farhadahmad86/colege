<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorModel extends Model
{
    // tabel name
    protected $table = 'financials_author';

    // Primary Key attributes
    protected $primaryKey = 'aut_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
