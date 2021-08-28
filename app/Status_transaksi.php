<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status_transaksi extends Model
{
	use SoftDeletes;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
	protected $table 	= 'status_transaksis';
	protected $dates = ['deleted_at'];
    protected $fillable = [
        'nama_status', 'kode_status', 'urutan', 'deleted_at', 'created_at', 'updated_at',
    ];
}
