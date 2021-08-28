<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $table = 'products';

    use SoftDeletes;
    public $incrementing = false;
    public $keyType = 'uuid';

    protected $guarded = [];

    public function categories()
    {
        return $this->belongsTo('App\Category_product', 'id_category_product', 'id');
    }
    public function principles()
    {
        return $this->belongsTo('App\Principle', 'id_principle', 'id');
    }
    public function stocks()
    {
        return $this->hasOne('App\Stok',  'id_produk', 'id');
    }
    public function riwayats()
    {
        return $this->hasMany('App\Riwayat_Stok',  'id_product', 'id');
    }
    public function images()
    {
        return $this->hasMany('App\Product_image',  'product_id', 'id');
    }
}
