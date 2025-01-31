<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopicModel extends Model
{
    // tabel name
    protected $table = 'financials_topic';

    // Primary Key attributes
    protected $primaryKey = 'top_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
//
//    public function accountregisteration(){
//        return $this->hasMany('App\Models\AccountRegisterationModel', 'account_area', 'area_title');
//    }

}
