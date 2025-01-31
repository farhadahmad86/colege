<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpeningTrialBalanceModel extends Model
{
    // tabel name
    protected $table = 'financials_opening_trial_balance';

    // Primary Key attributes
    protected $primaryKey = 'tb_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
