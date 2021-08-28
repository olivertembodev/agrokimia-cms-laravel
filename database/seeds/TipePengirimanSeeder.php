<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipePengirimanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipe_pengirimans')->insert([
        	'nama_metode' => 'JNE',
            'kode_metode' => 'JE',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tipe_pengirimans')->insert([
        	'nama_metode' => 'JNT',
            'kode_metode' => 'JT',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tipe_pengirimans')->insert([
        	'nama_metode' => 'TIKI',
            'kode_metode' => 'TK',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tipe_pengirimans')->insert([
        	'nama_metode' => 'Ambil Ditempat',
            'kode_metode' => 'AD',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
