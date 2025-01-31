<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalancesModel extends Model
{

    protected $guarded = [];
    // tabel name
    protected $table = 'financials_balances';

    // Primary Key attributes
    protected $primaryKey = 'bal_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
