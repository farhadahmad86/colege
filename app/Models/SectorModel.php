<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectorModel extends Model
{
    // tabel name
    protected $table = 'financials_sectors';

    // Primary Key attributes
    protected $primaryKey = 'sec_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
//
//    public function accountregisteration(){
//        return $this->hasMany('App\Models\AccountRegisterationModel', 'account_sector_id', 'sec_title');
//    }

}
