<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryADItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_salary_ad_items';

    // Primary Key attributes
    protected $primaryKey = 'sadi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
