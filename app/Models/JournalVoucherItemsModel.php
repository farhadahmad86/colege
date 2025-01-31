<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalVoucherItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_journal_voucher_items';

    // Primary Key attributes
    protected $primaryKey = 'jvi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
