<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Limit_kredit extends Model
{
    use SoftDeletes;
    protected $table = 'limit_kredits';
    public $incrementing = false;
    public $keyType = 'uuid';
    protected $guarded = [];

    // public function products()
    // {
    //     return $this->belongsTo('App\Product', 'id_product', 'id');
    // }
    // public function transaksis()
    // {
    //     return $this->belongsTo('App\Status_transaksi', 'id_transaksi', 'id');
    // }
}
