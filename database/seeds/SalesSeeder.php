<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinces')->insert(
            ['id'=>1,'name' =>  'Prov 1', 'province_code'=>101, 'status' => 1,'created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
        DB::table('cities')->insert(
            ['id'=>1, 'city_code' => 201,'province_code'=>101,'name' =>  'Kota 1', 'status' => 1,'created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
        DB::table('areas')->insert(
            ['id'=>1,'province_code'=>101,'city_code'=>201, 'area_code'=>301,'name' =>  'Area 1', 'status' => 1,'created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
        DB::table('sales')->insert(
            ['nama_sales' =>  'Muhib','id_kota' =>1, 'id_area' => 1,'alamat_sales' =>  'Bojonegoro','nik' =>  '1929292929','nip' =>  '19292929','email' =>  'muhibudinkartasa@gmail.com','jenis_kelamin' =>  'L','status'=>1,'created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d'),'password' => Hash::make('admin123'),'confirm_password' => encrypt('admin123')]
        );
    }
}
