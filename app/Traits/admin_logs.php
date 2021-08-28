<?php
namespace App\Traits;
use Illuminate\Support\Facades\DB;
use App\role;
use Illuminate\Support\Facades\Auth;
use Session;
class admin_logs {
    public static function addLogs($id_act,$modul) {
        date_default_timezone_set("Asia/Jakarta");
        DB::table('log_admins')->insert([
            'id_admin' => Auth::id(),
            'id_aktifitas' => $id_act,
            'modul' => $modul,
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' =>  date('Y-m-d H:i:s')
        ]);
    }
}
