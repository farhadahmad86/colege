<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReceiptNoteModel extends Model
{
    // tabel name
    protected $table = 'financials_goods_receipt_note';

    // Primary Key attributes
    protected $primaryKey = 'grn_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
