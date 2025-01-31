<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanVoucherItemsModel extends Model
{
    use HasFactory;

    // tabel name
    protected $table = 'financials_loan_voucher_items';

    // Primary Key attributes
    protected $primaryKey = 'lvi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;

}
