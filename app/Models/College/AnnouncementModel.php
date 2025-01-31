<?php

namespace App\Models\College;

use App\Models\CreateSectionModel;
use App\Models\Models\Classes;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementModel extends Model
{
    use HasFactory;
    protected $table = 'announcement';
    protected $primaryKey = 'ann_id';
    public $timestamps = false;

}
