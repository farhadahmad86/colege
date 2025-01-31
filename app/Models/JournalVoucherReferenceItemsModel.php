<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalVoucherReferenceItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_journal_voucher_reference_items';

    // Primary Key attributes
    protected $primaryKey = 'jvri_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
