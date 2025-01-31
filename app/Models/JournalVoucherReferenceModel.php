<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalVoucherReferenceModel extends Model
{
    // tabel name
    protected $table = 'financials_journal_voucher_reference';

    // Primary Key attributes
    protected $primaryKey = 'jvr_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
