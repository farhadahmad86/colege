<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IMEIModel extends Model
{
      // tabel name
      protected $table = 'mobile_imei';

      // Primary Key attributes
      protected $primaryKey = 'mi_id';
      public $incrementing = true;

      // Timestamp Attributes
      public $timestamps = false;
}
