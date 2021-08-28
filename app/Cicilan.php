<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cicilan extends Model
{
    use SoftDeletes;
	
	protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
	protected $dates = ['deleted_at'];
	protected $table 	= 'loans';
	protected $fillable = [
							'id',
							'no_invoice',
							'id_product',
							'id_kios',
							'jumlah',
							'nominal',
							'total',
							'id_xendit',
							'invoice_url',
                            'status',
                            'status_lunas',
                            'tanggal',
                            'deskripsi',
                            'id_transaksi',
                            'id_status_transaksi',
                            'no_cicilan',
                            'id_tipe_cicilan',
                            'approved_at'
							];

public function tansactions()
	{
	return $this->belongsTo('App\Promo_type', 'type_id', 'id');
	}
}