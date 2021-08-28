<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stok extends Model
{
    protected $table = 'stoks';

    use SoftDeletes;
    public $incrementing = false;public $keyType = 'uuid';

    protected $fillable = [
        'id_produk', 'stok', 'date', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function products()
    {
        return $this->belongsTo('App\Product', 'id_produk', 'id');
    }
    // public function admins()
    // {
    //     return $this->belongsTo('App\Administrator', 'created_by', 'id');
    // }
}
