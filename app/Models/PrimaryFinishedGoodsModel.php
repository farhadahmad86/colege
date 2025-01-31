<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrimaryFinishedGoodsModel extends Model
{
    // tabel name
    protected $table = 'financials_primary_finished_goods';

    // Primary Key attributes
    protected $primaryKey = 'pfg_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
