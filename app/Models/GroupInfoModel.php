<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupInfoModel extends Model
{
    // tabel name
    protected $table = 'financials_groups';

    // Primary Key attributes
    protected $primaryKey = 'grp_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
