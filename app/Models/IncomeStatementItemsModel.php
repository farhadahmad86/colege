<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeStatementItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_income_statement_items';

    // Primary Key attributes
    protected $primaryKey = 'isi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
