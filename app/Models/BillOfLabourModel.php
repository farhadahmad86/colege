<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class BillOfLabourModel extends Model
{
    // tabel name
    protected $table = 'financials_bill_of_labour';

    // Primary Key attributes
    protected $primaryKey = 'bl_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'bl_createdby', 'user_id');
    }
}
