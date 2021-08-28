<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product_image extends Model
{
    protected $table = 'product_images';

    use SoftDeletes;
    public $incrementing = false;public $keyType = 'uuid';
    
    protected $fillable = [
        'product_id','image', 'deleted_at', 'created_at', 'updated_at'
    ];
}
