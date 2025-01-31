<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModularGroupModel extends Model
{
    // tabel name
    protected $table = 'financials_modular_groups';

    // Primary Key attributes
    protected $primaryKey = 'mg_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
