<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartyClaimModel extends Model
{
    // tabel name
    protected $table = 'financials_party_claims';

    // Primary Key attributes
    protected $primaryKey = 'pc_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
