<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category_product extends Model
{
    protected $table = 'category_products';
    // protected $guard = 'administrator';

    use SoftDeletes;
    public $incrementing = false;public $keyType = 'uuid';
    
    protected $fillable = [
        'id','nama_category', 'icon', 'deleted_at', 'created_at', 'updated_at'
    ];

    // public function categories()
    // {
    //     return $this->hasOne('App\Principle', 'id', 'id_kategori');
    // }
}
