<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartyClaimItemModel extends Model
{
    // tabel name
    protected $table = 'financials_party_claims_items';

    // Primary Key attributes
    protected $primaryKey = 'pci_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
