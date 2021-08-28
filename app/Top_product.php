<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Top_product extends Model
{
    protected $table = 'top_products';

    use SoftDeletes;
    public $incrementing = false;public $keyType = 'uuid';

    protected $fillable = [
        'id_product', 'expired_top_product', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function products()
    {
        return $this->belongsTo('App\Product', 'id_product', 'id');
    }
    // public function admins()
    // {
    //     return $this->belongsTo('App\Administrator', 'created_by', 'id');
    // }
}
