<?php

use Illuminate\Database\Seeder;

class Aktifitasseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('aktifity_logs')->insert([
            ['nama_aktifitas'=>'Menambah Data','kode_aktifitas' =>'ADD-001','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')],
            ['nama_aktifitas'=>'Mengupdate Data','kode_aktifitas' =>'UPD-002','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')],
            ['nama_aktifitas'=>'Menghapus Data','kode_aktifitas' =>'DEL-003','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')],
            ['nama_aktifitas'=>'Menampilkan Data','kode_aktifitas' =>'DTL-004','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')],
            ]
        );
    }
}
