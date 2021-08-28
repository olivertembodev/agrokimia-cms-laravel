<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipeUser extends Model
{
    //
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public $incrementing = false;
    protected $fillable = [
        'id','kode_user', 'nama_kode'
    ];
   
}
