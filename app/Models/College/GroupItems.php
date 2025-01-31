<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupItems extends Model
{
    use HasFactory;
    protected $table = 'group_items';
    protected $primaryKey = 'grpi_id';
    public $timestamps = false;
}
