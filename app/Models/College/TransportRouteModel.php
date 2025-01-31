<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportRouteModel extends Model
{
    use HasFactory;
    protected $table = 'transport';
    protected $primaryKey = 'tr_id';
    public $timestamps = false;
}
