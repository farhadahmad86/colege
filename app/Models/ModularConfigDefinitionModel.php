<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ModularConfigDefinitionModel extends Model
{
    // tabel name
    protected $table = 'financials_modular_config_defination';

    // Primary Key attributes
    protected $primaryKey = 'mcd_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;


    public function childs() {
        $user = Auth::user();
        $softaware_pakge=PackagesModel::where('pak_id',1)->pluck('pak_name')->first();
        if($user->user_id == 1){
            $systm_cnfg_mdl = SystemConfigModel::where('sc_all_done','0')->first();
        if( $systm_cnfg_mdl === null ):
            return $this->hasMany('App\Models\ModularConfigDefinitionModel','mcd_parent_code','mcd_code')->where('mcd_after_config', '1')->orderby('mcd_code', 'ASC');
        elseif(isset($systm_cnfg_mdl) && $systm_cnfg_mdl->sc_all_done === 0):
            return $this->hasMany('App\Models\ModularConfigDefinitionModel','mcd_parent_code','mcd_code')->where('mcd_before_config','=', '1')->orderby('mcd_code', 'ASC');
        endif;
        }
        elseif($softaware_pakge=='Basic'){
            $systm_cnfg_mdl = SystemConfigModel::where('sc_all_done','0')->first();
            if( $systm_cnfg_mdl === null ):
                return $this->hasMany('App\Models\ModularConfigDefinitionModel','mcd_parent_code','mcd_code')->where('mcd_after_config', '1')->where('mcd_package', '=', 'Basic')->orderby('mcd_code',
                    'ASC');
            elseif(isset($systm_cnfg_mdl) && $systm_cnfg_mdl->sc_all_done === 0):
                return $this->hasMany('App\Models\ModularConfigDefinitionModel','mcd_parent_code','mcd_code')->where('mcd_before_config','=', '1')->where('mcd_package', '=', $softaware_pakge)->orderby('mcd_code', 'ASC');
            endif;
        }elseif ($softaware_pakge=='Advance'){
            $systm_cnfg_mdl = SystemConfigModel::where('sc_all_done','0')->first();
            if( $systm_cnfg_mdl === null ):
                return $this->hasMany('App\Models\ModularConfigDefinitionModel','mcd_parent_code','mcd_code')->where('mcd_after_config', '1')->whereIn('mcd_package', ['Basic','Advance'])->orderby('mcd_code', 'ASC');
            elseif(isset($systm_cnfg_mdl) && $systm_cnfg_mdl->sc_all_done === 0):
                return $this->hasMany('App\Models\ModularConfigDefinitionModel','mcd_parent_code','mcd_code')->where('mcd_before_config','=', '1')->whereIn('mcd_package', ['Basic','Advance'])->orderby('mcd_code', 'ASC');
            endif;
        }elseif ($softaware_pakge=='Premium'){
            $systm_cnfg_mdl = SystemConfigModel::where('sc_all_done','0')->first();
            if( $systm_cnfg_mdl === null ):
                return $this->hasMany('App\Models\ModularConfigDefinitionModel','mcd_parent_code','mcd_code')->where('mcd_after_config', '1')->whereIn('mcd_package', ['Basic','Advance','Premium'])
                    ->orderby('mcd_code', 'ASC');
            elseif(isset($systm_cnfg_mdl) && $systm_cnfg_mdl->sc_all_done === 0):
                return $this->hasMany('App\Models\ModularConfigDefinitionModel','mcd_parent_code','mcd_code')->where('mcd_before_config','=', '1')->whereIn('mcd_package', ['Basic','Advance','Premium'])
                    ->orderby('mcd_code', 'ASC');
            endif;
        }
//        $systm_cnfg_mdl = SystemConfigModel::where('sc_all_done','0')->first();
//        if( $systm_cnfg_mdl === null ):
//            return $this->hasMany('App\Models\ModularConfigDefinitionModel','mcd_parent_code','mcd_code')->where('mcd_after_config', '1')->orderby('mcd_code', 'ASC');
//        elseif(isset($systm_cnfg_mdl) && $systm_cnfg_mdl->sc_all_done === 0):
//            return $this->hasMany('App\Models\ModularConfigDefinitionModel','mcd_parent_code','mcd_code')->where('mcd_before_config','=', '1')->orderby('mcd_code', 'ASC');
//        endif;
    }

//    public function accounts() {
//        return $this->hasMany('App\Models\AccountRegisterationModel','account_parent_code','coa_code') ;
//    }
}
