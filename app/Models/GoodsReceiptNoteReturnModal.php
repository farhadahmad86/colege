<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceiptNoteReturnModal extends Model
{
    // tabel name
    protected $table = 'financials_goods_receipt_note_return';

    // Primary Key attributes
    protected $primaryKey = 'grnr_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
