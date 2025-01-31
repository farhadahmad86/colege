<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountGroupModel extends Model
{
    // tabel name
    protected $table = 'financials_account_group';

    // Primary Key attributes
    protected $primaryKey = 'ag_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
//
//    public function accountregisteration(){
//        return $this->hasMany('App\Models\AccountRegisterationModel', 'account_group_id', 'ag_title');
//    }

}
