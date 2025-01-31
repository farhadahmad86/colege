<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewGroupsModel extends Model
{
    protected $table = 'new_groups';
    protected $primaryKey = 'ng_id';
    public $timestamps = false;

}
