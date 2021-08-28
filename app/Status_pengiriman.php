<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status_pengiriman extends Model
{
	use SoftDeletes;
	
	protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
	protected $dates = ['deleted_at'];
	protected $table 	= 'tipe_pengirimans';
    protected $fillable = [
        'nama_metode', 'kode_metode', 'deleted_at', 'created_at', 'updated_at',
    ];
}
