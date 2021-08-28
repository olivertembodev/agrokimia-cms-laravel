<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kecamatan extends Model
{
    use SoftDeletes;
    protected $dates        = ['deleted_at'];
    protected $primaryKey   = 'id';
    protected $keyType      = 'string';
    public $incrementing    = true;
}
