<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashTransferModel extends Model
{
    // tabel name
    protected $table = 'financials_cash_transfer';

    // Primary Key attributes
    protected $primaryKey = 'ct_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
