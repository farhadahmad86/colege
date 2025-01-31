<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReceiptNoteItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_goods_receipt_note_items';

    // Primary Key attributes
    protected $primaryKey = 'grni_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
