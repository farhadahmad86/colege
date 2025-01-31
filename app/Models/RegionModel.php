<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegionModel extends Model
{
    // tabel name
    protected $table = 'financials_region';

    // Primary Key attributes
    protected $primaryKey = 'reg_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
//
//    public function accountregisteration(){
//        return $this->hasMany('App\Models\AccountRegisterationModel', 'account_region_id', 'reg_title');
//    }

}
