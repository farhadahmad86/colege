<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogModel extends Model
{
    // tabel name
    protected $table = 'financials_log';

    // Primary Key attributes
    protected $primaryKey = 'log_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'log_data' => 'array'
    ];

    public static function createLog($code, $type, $json_data, $createdAt, $createdBy, $ipInfo, $browser)
    {
        return self::create([
            'log_code' => $code,
            'log_type' => $type,
            'log_data' => $json_data,
            'log_created_datetime' => $createdAt,
            'log_createdby' => $createdBy,
            'log_ip_adrs' => $ipInfo,
            'log_brwsr_info' => $browser,
        ]);
    }
}
