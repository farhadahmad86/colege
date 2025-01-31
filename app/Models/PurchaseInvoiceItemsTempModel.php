<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceItemsTempModel extends Model
{
     // tabel name
     protected $table = 'financials_purchase_invoice_items_temp';

     // Primary Key attributes
     protected $primaryKey = 'piit_id';
     public $incrementing = true;

     // Timestamp Attributes
     public $timestamps = false;
}
