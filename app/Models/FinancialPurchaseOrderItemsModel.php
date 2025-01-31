<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialPurchaseOrderItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_purchase_order_items';

    // Primary Key attributes
    protected $primaryKey = 'poi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
//
//    public function accountregisteration(){
//        return $this->hasMany('App\Models\AccountRegisterationModel', 'account_group_id', 'ag_title');
//    }

}
