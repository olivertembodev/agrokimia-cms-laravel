<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log_admin extends Model
{
    protected $table = 'log_admins';
    public $incrementing = false;
    public $keyType = 'uuid';
    protected $guarded = [];

    public function admins()
    {
        return $this->belongsTo('App\Administrator', 'id_admin', 'id');
    }
    public function saless()
    {
        return $this->belongsTo('App\Sales', 'id_sales', 'id');
    }
    public function kioss()
    {
        return $this->belongsTo('App\Kios', 'id_kios', 'id');
    }
    public function principles()
    {
        return $this->belongsTo('App\Principle', 'id_vendor', 'id');
    }
    public function aktifitass()
    {
        return $this->belongsTo('App\Aktivitas_Logs', 'id_aktifitas', 'kode_aktifitas');
    }
    
}
