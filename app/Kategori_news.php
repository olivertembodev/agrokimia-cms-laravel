<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori_news extends Model
{
    protected $table = 'kategori_news';
    // protected $guard = 'administrator';

    use SoftDeletes;
    public $incrementing = false;public $keyType = 'uuid';
    
    protected $fillable = [
        'nama_kategori', 'image', 'created_by', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function categories()
    {
        return $this->hasOne('App\News', 'id', 'id_kategori_berita');
    }
    public function admins()
    {
        return $this->belongsTo('App\Administrator', 'created_by', 'id');
    }
}
