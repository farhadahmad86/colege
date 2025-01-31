<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolesModel extends Model
{
    // tabel name
    protected $table = 'financials_user_role';

    // Primary Key attributes
    protected $primaryKey = 'user_role_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
