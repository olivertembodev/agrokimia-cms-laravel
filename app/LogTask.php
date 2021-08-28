<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogTask extends Model
{
    //
	use SoftDeletes;

    protected $table = 'log_tasks';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $dates = ['deleted_at'];
}
