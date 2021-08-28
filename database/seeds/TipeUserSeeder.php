<?php

use Illuminate\Database\Seeder;

class TipeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipe_users')->insert(
            ['kode_user' =>  1, 'nama_kode'=>'Sales','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
        DB::table('tipe_users')->insert(
            ['kode_user' =>  2, 'nama_kode'=>'Kios','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
    }
}
