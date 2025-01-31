<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrderModel extends Model
{
    // tabel name
    protected $table = 'financials_work_order';

    // Primary Key attributes
    protected $primaryKey = 'odr_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
