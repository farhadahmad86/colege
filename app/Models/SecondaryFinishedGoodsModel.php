<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecondaryFinishedGoodsModel extends Model
{
    // tabel name
    protected $table = 'financials_secondary_finished_good';

    // Primary Key attributes
    protected $primaryKey = 'sfg_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
