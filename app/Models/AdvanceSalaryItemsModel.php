<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvanceSalaryItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_advance_salary_items';

    // Primary Key attributes
    protected $primaryKey = 'asi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;


//    public function childs() {
//        return $this->belongsTo('App\Models\AccountHeadsModel','coa_code','account_parent_code') ;
//    }
//
//    public function area(){
//        return $this->belongsTo('App\Models\AreaModel', 'area_title', 'account_area');
//    }
//
//    public function region(){
//        return $this->belongsTo('App\Models\RegionModel', 'reg_title', 'account_region_id');
//    }
//
//    public function sector(){
//        return $this->belongsTo('App\Models\SectorModel', 'sec_title', 'account_sector_id');
//    }
//
//    public function accountgroup(){
//        return $this->belongsTo('App\Models\AreaModel', 'ag_title', 'account_group_id');
//    }
}
