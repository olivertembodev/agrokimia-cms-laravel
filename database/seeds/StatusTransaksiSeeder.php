<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_transaksis')->insert([
        	'nama_status' => 'Transaksi',
            'kode_status' => 'TRan',
            'urutan'      => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('status_transaksis')->insert([
        	'nama_status' => 'Menunggu Pembayaran',
            'kode_status' => 'MBay',
            'urutan'      => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('status_transaksis')->insert([
        	'nama_status' => 'Pembayaran Diterima',
            'kode_status' => 'BTer',
            'urutan'      => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('status_transaksis')->insert([
        	'nama_status' => 'Menunggu Konfirmasi',
            'kode_status' => 'MKonf',
            'urutan'      => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('status_transaksis')->insert([
        	'nama_status' => 'Pesanan Diproses',
            'kode_status' => 'PPro',
            'urutan'      => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('status_transaksis')->insert([
        	'nama_status' => 'Pesanan Dikirim',
            'kode_status' => 'PKir',
            'urutan'      => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('status_transaksis')->insert([
        	'nama_status' => 'Pesanan Tiba',
            'kode_status' => 'PTib',
            'urutan'      => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('status_transaksis')->insert([
        	'nama_status' => 'Pesanan Komplain',
            'kode_status' => 'PKom',
            'urutan'      => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('status_transaksis')->insert([
        	'nama_status' => 'Pesanan Selesai',
            'kode_status' => 'PSel',
            'urutan'      => 9,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('status_transaksis')->insert([
        	'nama_status' => 'Pesanan Dibatalkan',
            'kode_status' => 'PBat',
            'urutan'      => 10,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('status_transaksis')->insert([
        	'nama_status' => 'Pesanan Dibatalkan Admin',
            'kode_status' => 'PBatMin',
            'urutan'      => 11,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}
