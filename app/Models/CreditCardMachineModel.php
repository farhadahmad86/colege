<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditCardMachineModel extends Model
{
    // tabel name
    protected $table = 'financials_credit_card_machine';

    // Primary Key attributes
    protected $primaryKey = 'ccm_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
