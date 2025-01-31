<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class AccountHeadsModel extends Model
{
    // tabel name
    protected $table = 'financials_coa_heads';

    // Primary Key attributes
    protected $primaryKey = 'coa_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;


    public function childs() {
        $user = Auth::user();
        return $this->hasMany('App\Models\AccountHeadsModel','coa_parent','coa_code')->where('coa_clg_id',$user->user_clg_id) ;
    }

    public function accounts() {
        $user = Auth::user();

        if($user->user_level==100){

            return $this->hasMany('App\Models\AccountRegisterationModel','account_parent_code','coa_code')->where('account_clg_id',$user->user_clg_id);
        }else{
            return $this->hasMany('App\Models\AccountRegisterationModel','account_parent_code','coa_code')->where('account_clg_id',$user->user_clg_id)->whereIn('account_group_id',explode(',',$user->user_account_reporting_group_ids));
        }

    }
}
