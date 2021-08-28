<?php

use Illuminate\Database\Seeder;

class KiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kios')->insert(
            ['id_kios_utama'=>'2ac745e7-80e1-4cd1-8df7-4faf3cfb73a9','nama_Kios'=>'ALfa','kode_kios'=>20200316102613-1, 'nama_Kios'=>'ALfa','tipe_kios'=>'50758f1f-9585-4b07-a7b2-3c2456dfba92', 'id_kota'=>123, 'id_area'=>123,  'alamat_kios'=>'Lamongan','maps'=>'https://www.google.com/maps/search/?api=1&query=-6.889296499999999,112.3635806', 'latitude'=>-6.889296499999999,'longitude'=>112.3635806, 'email'=>'ALfa@gmail.com','nama_pic'=>'TestKios','nomor_hp_pic'=>"085712345678", 'nomor_ktp_pic'=>"223333848991929", 'image_ktp'=>"https://akn.s3-id-jkt-1.kilatstorage.id/e3C2eJBlQK4NwD0ACDEcywjkWiGw50DKi1D8IQWD.jpeg", 'nomor_npwp_pic'=>"12345", 'image_npwp'=>"https://akn.s3-id-jkt-1.kilatstorage.id/01ZkHONByxQI74VCVaeQ9cQh6MOvqw7nrJHXrse2.jpeg", 'image_kios_depan'=>"https://akn.s3-id-jkt-1.kilatstorage.id/01ZkHONByxQI74VCVaeQ9cQh6MOvqw7nrJHXrse2.jpeg", 'image_kios_dalam'=>"https://akn.s3-id-jkt-1.kilatstorage.id/01ZkHONByxQI74VCVaeQ9cQh6MOvqw7nrJHXrse2.jpeg", 'image_selfi_ktp'=>"https://akn.s3-id-jkt-1.kilatstorage.id/01ZkHONByxQI74VCVaeQ9cQh6MOvqw7nrJHXrse2.jpeg",'password'=>"$2y$10$4SvTA/WWeGAQ94nZMhklT.qL55tCfJghA4Ml96gbMYzV4UKwKJaiK",'status' => 1, 'created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
    }
}
