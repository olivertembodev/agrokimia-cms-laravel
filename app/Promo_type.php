<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promo_type extends Model
{
    use SoftDeletes;

    protected $keyType = 'uuid';
    public $incrementing = false;
	protected $table 	= 'tipe_promos';
	protected $fillable = ['id','nama_type','deleted_at', 'created_at', 'updated_at'];

	public function categories()
	{
		return $this->hasOne('App\Promo', 'id', 'type_id');
	}
}
