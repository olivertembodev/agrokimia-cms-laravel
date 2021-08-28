<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanArrea extends Model
{
    //
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
	protected $dates = ['deleted_at'];
	protected $table 	= 'loan_arreas';
}
