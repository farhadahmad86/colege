<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostDatedChequeModel extends Model
{
    // tabel name
    protected $table = 'financials_post_dated_cheques';

    // Primary Key attributes
    protected $primaryKey = 'pdc_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
