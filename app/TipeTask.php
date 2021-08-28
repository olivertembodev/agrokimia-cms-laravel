<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipeTask extends Model
{
    //
    use SoftDeletes;
    public $incrementing = false;public $keyType = 'uuid';
}
