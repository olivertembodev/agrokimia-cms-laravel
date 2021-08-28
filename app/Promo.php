<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promo extends Model
{
    use SoftDeletes;
	
	protected $primaryKey = 'id';
    protected $keyType = 'uuid';
    public $incrementing = false;
	protected $dates = ['deleted_at'];
	protected $table 	= 'promotions';
	protected $fillable = [
							'id',
							'nama_kupon',
							'start_date',
							'end_date',
							'is_percentage',
							'minimal_transaksi',
							'potongan',
							'max_potongan',
							'deskripsi',
							'type_id'
							];

public function promo_types()
	{
	return $this->belongsTo('App\Promo_type', 'type_id', 'id');
	}
}

