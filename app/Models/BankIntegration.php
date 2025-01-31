<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankIntegration extends Model
{
    use HasFactory;
    protected $table = 'bank_integrations';
    protected $primaryKey = 'bi_id';
    public $timestamps = false;

    public function account()
    {
        return $this->belongsTo(AccountRegisterationModel::class, 'bi_account_no', 'account_uid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'bi_updated_at', 'user_id');
    }
}
