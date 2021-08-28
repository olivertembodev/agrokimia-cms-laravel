<?php

use Illuminate\Database\Seeder;

class LoansSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('loans')->insert(
            ['no_invoice'=>'1B2D','id_product'=>'ffd495e4-ca84-4905-b035-870ea0d188dd','id_kios'=>'24877d6b-7982-4e06-9dcf-a2605dfacf4f','jumlah'=>30,'nominal'=>140000,'total'=>2400000,'status'=>1,'status_lunas'=>1,'tanggal'=>date('Y-m-d'),'deskripsi'=>'iki nyicil','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d'),'id_transaksi'=>'06864113-0835-46d2-a8b8-b5399c425923']
        );
    }
}
