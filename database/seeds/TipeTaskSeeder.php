<?php

use Illuminate\Database\Seeder;

class TipeTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        date_default_timezone_set('Asia/Jakarta');
        DB::table('tipe_tasks')->truncate();
        DB::table('tipe_tasks')->insert(
            ['kode_task' =>  1, 'nama_kode'=>'Verifikasi','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
        DB::table('tipe_tasks')->insert(
            ['kode_task' =>  2, 'nama_kode'=>'Penagihan','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
        DB::table('tipe_tasks')->insert(
            ['kode_task' =>  3, 'nama_kode'=>'Pengiriman','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
        // DB::table('tipe_tasks')->insert(
        //     ['kode_task' =>  4, 'nama_kode'=>'Tagihan Tunggakan','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        // );
        DB::table('tipe_tasks')->insert(
            ['kode_task' =>  5, 'nama_kode'=>'lain-lain','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
    }
}
