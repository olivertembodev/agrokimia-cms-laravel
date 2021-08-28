<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class MenuModel extends Model
{
    protected $table 	= 'menus';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;

}


