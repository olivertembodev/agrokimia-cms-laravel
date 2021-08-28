<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RewardProduct extends Model
{
	use SoftDeletes;

	protected $table 	= 'reward_products';
	protected $dates = ['deleted_at'];
    public $incrementing = false;
    public $keyType = 'uuid';
	protected $fillable = [
        'id','kode_product', 'nama_product', 'stock', 'deskripsi', 'image', 'nominal_reward', 'expired', 'deleted_at', 'created_at', 'updated_at',
    ];
}
