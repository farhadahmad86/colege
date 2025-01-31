<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceSheetItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_balance_sheet_items';

    // Primary Key attributes
    protected $primaryKey = 'bsi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
