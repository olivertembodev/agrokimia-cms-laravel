<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aktivitas_Logs extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'aktifity_logs';
    public $incrementing = false;
}
