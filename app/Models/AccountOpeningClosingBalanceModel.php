<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountOpeningClosingBalanceModel extends Model
{
    // tabel name
    protected $table = 'financials_account_opening_closing_balance';

    // Primary Key attributes
    protected $primaryKey = 'aoc_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
