<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapitalRegistrationModel extends Model
{
    // tabel name
    protected $table = 'financials_capital_register';

    // Primary Key attributes
    protected $primaryKey = 'cr_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
