<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionModel extends Model
{
    // tabel name
    protected $table = 'financials_transactions';

    // Primary Key attributes
    protected $primaryKey = 'trans_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
