<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceSheetModel extends Model
{
    // tabel name
    protected $table = 'financials_balance_sheet';

    // Primary Key attributes
    protected $primaryKey = 'bs_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
