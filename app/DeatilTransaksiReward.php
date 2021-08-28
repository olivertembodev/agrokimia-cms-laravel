<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailTransaksiReward extends Model
{
	use SoftDeletes;

	protected $table 	= 'detail_transaksi_reward';
	protected $dates = ['deleted_at'];
    public $incrementing = false;
    public $keyType = 'uuid';
}
