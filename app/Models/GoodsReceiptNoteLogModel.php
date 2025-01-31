<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReceiptNoteLogModel extends Model
{
    // tabel name
    protected $table = 'financials_grn_log';

    // Primary Key attributes
    protected $primaryKey = 'grnl_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
