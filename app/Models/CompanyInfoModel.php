<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyInfoModel extends Model
{
    // tabel name
    protected $table = 'financials_company_info';

    // Primary Key attributes
    protected $primaryKey = 'ci_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
