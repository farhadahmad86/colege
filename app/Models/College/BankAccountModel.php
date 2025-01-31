<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccountModel extends Model
{
    protected $table = 'bank_information';
    protected $primaryKey = 'bi_id';
    public $timestamps = false;

}
