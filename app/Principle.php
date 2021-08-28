<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Principle extends Authenticatable
{
    protected $table = 'principles';
    // protected $guard = 'administrator';

    use SoftDeletes,Notifiable;
    public $guard='principle';
    public $incrementing = false;public $keyType = 'uuid';

    protected $fillable = [
        'id_kategori', 'nama_principle', 'email', 'alamat_principle', 'phone_principle', 'tanggal_lahir', 'logo', 'nama_pic', 'nomor_pic', 'email_pic', 'status_principle', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function categories()
    {
        return $this->belongsTo('App\Category_principle', 'id_kategori', 'id');
    }

}
