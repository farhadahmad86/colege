<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentUploadModel extends Model
{
    use HasFactory;
    protected $table = 'documents';
    protected $primaryKey = 'd_id';
    public $timestamps = false;
}
