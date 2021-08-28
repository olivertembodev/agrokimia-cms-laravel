<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    protected $table = 'news';
    // protected $guard = 'administrator';

    use SoftDeletes;
    public $incrementing = false;public $keyType = 'uuid';

    protected $fillable = [
        'id_kategori_berita', 'judul', 'deskripsi', 'tanggal', 'image', 'created_by', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function categories()
    {
        return $this->belongsTo('App\Kategori_news', 'id_kategori_berita', 'id');
    }
    public function admins()
    {
        return $this->belongsTo('App\Administrator', 'created_by', 'id');
    }
}
