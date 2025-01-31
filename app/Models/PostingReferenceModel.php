<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostingReferenceModel extends Model
{
    // tabel name
    protected $table = 'financials_posting_reference';

    // Primary Key attributes
    protected $primaryKey = 'pr_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
