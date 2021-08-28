<?php

use Illuminate\Database\Seeder;

class StatusRewardSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_reward')->insert(
            ['id'=>'61601F92398431BB59F9D42888F2E2CB', 'kode_status'=>'1','nama_status'=>'Pengajuan Reward Dikirimkan','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
        DB::table('status_reward')->insert(
            ['id'=>'3A9B06D16F332D9401DC0C584BA902D2', 'kode_status'=>'2','nama_status'=>'Dalam Proses','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
        DB::table('status_reward')->insert(
            ['id'=>'E2D0160C0809F620B4055676C4D1B7D5', 'kode_status'=>'3','nama_status'=>'Berhasil','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
        DB::table('status_reward')->insert(
            ['id'=>'2FC0F1FC9B52D0D14FCD5EB0E19A05F8', 'kode_status'=>'4','nama_status'=>'Dibatalkan','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
        DB::table('status_reward')->insert(
            ['id'=>'3497C67F5611AADAEFDFDF38E21C27D8', 'kode_status'=>'5', 'nama_status'=>'Ditolak Admin','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
    }
}
