<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RewardKios extends Model
{
	use SoftDeletes;

	protected $table 	= 'reward_kios';
	protected $dates = ['deleted_at'];
    public $incrementing = false;
    public $keyType = 'uuid';
	protected $fillable = [
        'id','foto_kios', 'nama_kios', 'id_kios', 'alamat_kios', 'jumlah_reward', 'detail_transaksi', 'deleted_at', 'created_at', 'updated_at',
    ];
}
