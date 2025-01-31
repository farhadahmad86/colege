<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaModel extends Model
{
    // tabel name
    protected $table = 'financials_areas';

    // Primary Key attributes
    protected $primaryKey = 'area_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
//
//    public function accountregisteration(){
//        return $this->hasMany('App\Models\AccountRegisterationModel', 'account_area', 'area_title');
//    }

}
