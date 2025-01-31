<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillOfLabourItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_bill_of_labour_items';

    // Primary Key attributes
    protected $primaryKey = 'bli_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
