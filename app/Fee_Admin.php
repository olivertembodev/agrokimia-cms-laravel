<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fee_Admin extends Model
{
	use SoftDeletes;
	
	protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
	protected $dates = ['deleted_at'];
	protected $table 	= 'fee_admin';
}
