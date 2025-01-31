<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddToCartModal extends Model
{
    // tabel name
    protected $table = 'financials_add_to_cart';

    // Primary Key attributes
    protected $primaryKey = 'atc_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;

}
