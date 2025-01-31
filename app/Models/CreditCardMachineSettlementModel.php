<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditCardMachineSettlementModel extends Model
{
    // tabel name
    protected $table = 'financials_credit_card_machine_settlement';

    // Primary Key attributes
    protected $primaryKey = 'ccms_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
