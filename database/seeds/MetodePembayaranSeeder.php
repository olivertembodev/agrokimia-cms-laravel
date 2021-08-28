<?php

use Illuminate\Database\Seeder;

class MetodePembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipe_pembayarans')->truncate();
        DB::table('tipe_pembayarans')->insert([
        	'nama_metode' => 'Cash',
        	'kode_pembayaran' => 'CA'
        ]);
        DB::table('tipe_pembayarans')->insert([
        	'nama_metode' => 'Cicilan',
        	'kode_pembayaran' => 'CC'
        ]);
        DB::table('tipe_pembayarans')->insert([
        	'nama_metode' => 'Transfer/Virtual Account',
        	'kode_pembayaran' => 'TF'
        ]);
    }
}
