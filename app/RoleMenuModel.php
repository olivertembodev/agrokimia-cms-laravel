<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleMenuModel extends Model
{
    Use SoftDeletes;
    protected $table 	= 'role_menus';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    protected $date = ['deleted_at'];
    public $incrementing = false;
}
