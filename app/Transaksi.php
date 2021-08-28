<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    public $incrementing  = false;
    protected $dates      = ['deleted_at'];
    protected $table      = 'transactions';

    public function tipes()
    {
        return $this->belongsTo('App\TipePembayaran', 'id_tipe_pembayaran', 'id');
    }
}
