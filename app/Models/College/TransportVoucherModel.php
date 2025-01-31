<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportVoucherModel extends Model
{
    use HasFactory;
    // tabel name
    protected $table = 'transport_voucher';

    // Primary Key attributes
    protected $primaryKey = 'tv_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
