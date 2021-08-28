<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemberitahuan extends Model
{
    //
    use SoftDeletes;

	protected $table 	= 'pemberitahuan';
    protected $dates = ['deleted_at'];
    public $incrementing = false;
    protected $fillable = [
        'id','id_user', 'judul', 'deskripsi', 'tanggal', 'created_by', 'updated_at','tipe_user','tampil_depan'
    ];
}
