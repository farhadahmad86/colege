<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourierCompanyBranchesModel extends Model
{
    // tabel name
    protected $table = 'financials_courier_company_branches';

    // Primary Key attributes
    protected $primaryKey = 'ccb_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
