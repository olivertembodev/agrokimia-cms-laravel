<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    //
    use SoftDeletes;
    public $incrementing = false;public $keyType = 'uuid';

    public function tipe_tasks()
    {
        return $this->belongsTo('App\TipeTask', 'id_tipe_tasks', 'id');
    }

    public function saless()
    {
        return $this->belongsTo('App\Sales', 'id_sales', 'id');
    }

    public function kioss()
    {
        return $this->belongsTo('App\Kios', 'id_kios', 'id');
    }

}
