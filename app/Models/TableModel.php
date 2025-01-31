<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableModel extends Model
{
    // tabel name
    protected $table = 'financials_table';

    // Primary Key attributes
    protected $primaryKey = 'tb_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
