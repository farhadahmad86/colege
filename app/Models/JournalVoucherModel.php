<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class JournalVoucherModel extends Model
{
    // tabel name
    protected $table = 'financials_journal_voucher';

    // Primary Key attributes
    protected $primaryKey = 'jv_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'jv_createdby', 'user_id');
    }
}
