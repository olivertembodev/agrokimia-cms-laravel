<?php

use Faker\Factory as FakeData;
use Illuminate\Database\Seeder;

class Faker extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakeData::create('id_ID');

        for ($i = 1; $i <= 30; $i++) {

            // insert data ke table pegawai menggunakan Faker
            DB::table('products')->insert([

                'id_category_product' => '1ba1e028-eb09-4014-b8da-bf6a39362632',
                'id_principle'        => '945ce299-f081-4689-9774-51cb87608d30',
                'nama_product'        => $faker->name,
                'lot_product'         => $faker->jobTitle,
                'deskripsi'           => $faker->jobTitle,
                'cara_pakai'          => $faker->jobTitle,
                'expired_date'        => $faker->date($format = 'Y-m-d', $max = 'now'),
                'harga_jual'          => $faker->numberBetween(1000, 9999),
                'harga_beli'          => $faker->numberBetween(1000, 9999),
                'reward_poin'         => $faker->numberBetween(25, 40),
            ]);
        }
    }
}
