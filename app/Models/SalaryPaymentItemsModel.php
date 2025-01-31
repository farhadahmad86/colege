<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryPaymentItemsModel extends Model
{
    // tabel name
    protected $table = 'financials_salary_payment_items';

    // Primary Key attributes
    protected $primaryKey = 'spi_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
