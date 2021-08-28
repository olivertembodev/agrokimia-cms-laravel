<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RunningText extends Model
{
    use SoftDeletes;

    protected $keyType = 'uuid';
    public $incrementing = false;
	protected $table 	= 'running_texts';
	protected $fillable = ['id','text','deleted_at', 'created_at', 'updated_at'];

}
