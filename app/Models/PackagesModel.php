<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackagesModel extends Model
{
    // tabel name
    protected $table = 'financials_package';

    // Primary Key attributes
    protected $primaryKey = 'pak_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
