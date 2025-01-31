<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublisherModel extends Model
{
    // tabel name
    protected $table = 'financials_publisher';

    // Primary Key attributes
    protected $primaryKey = 'pub_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;

}
