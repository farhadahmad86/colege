<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceiptNoteReturnItemsModal extends Model
{
    // tabel name
    protected $table = 'financials_goods_receipt_note_return_items';

    // Primary Key attributes
    protected $primaryKey = 'grnri_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
