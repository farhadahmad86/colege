<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImPrintModel extends Model
{
    // tabel name
    protected $table = 'financials_imprint';

    // Primary Key attributes
    protected $primaryKey = 'imp_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
//
//    public function accountregisteration(){
//        return $this->hasMany('App\Models\AccountRegisterationModel', 'account_group_id', 'ag_title');
//    }

}
