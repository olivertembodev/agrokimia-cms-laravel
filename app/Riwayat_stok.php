<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Riwayat_Stok extends Model
{
    protected $table = 'riwayat_stoks';

    use SoftDeletes;
    public $incrementing = false;public $keyType = 'uuid';

    protected $guarded = [];

    public function products()
    {
        return $this->belongsTo('App\Product', 'id_product', 'id');
    }
    public function transaksis()
    {
        return $this->belongsTo('App\Status_transaksi', 'id_transaksi', 'id');
    }
    public function admins()
    {
        return $this->belongsTo('App\Administrator', 'created_by', 'id');
    }

}
