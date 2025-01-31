<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetedRawStockModel extends Model
{
    // tabel name
    protected $table = 'financials_budgeted_raw_stock';

    // Primary Key attributes
    protected $primaryKey = 'brs_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
