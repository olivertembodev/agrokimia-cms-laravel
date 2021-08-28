<?php

use Illuminate\Database\Seeder;

class Coba extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // DB::table('transactions')->insert(
        //     ['no_invoice'=>'2B3C','id_kios'=>'90e4c09c-5ba2-4c1e-95ae-30ca24e0ffe6','nominal'=>333,'total'=>555,'status'=>1,'tanggal'=>date('Y-m-d'),'created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        // );

        // DB::table('loans')->insert(
        //     ['nominal'=>13000,'total'=>3100,'status'=>1,'status_lunas'=>1,'deskripsi'=>'iki nyicil','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d'),'id_transaksi'=>'de4e66a9-ac6b-4d09-9cb5-b5a3dc84da74']
        // );

        // DB::table('detail_transaction')->insert(
        //     ['id_transaction'=>'fe366a62-f6cb-489d-9fc0-5d1889f58260','id_product'=>'52088be0-c0c8-4d5c-ac32-d7e20e591565','jumlah'=>3,'created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        // );
        // 

        // DB::table('tenors')->insert(
        //     ['no_invoice'=>'1B2D','id_loans'=>'af02d593-7409-43cb-9304-fecec62d182d','date'=>date('Y-m-d'),'nominal'=>140000,'no_cicilan'=>2,'status_lunas'=>0,'kode_status_cicilan'=>'belum','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        // );

        // iki ws nyicil nuggak sisan
        // DB::table('tenors')->insert(
        //     ['no_invoice'=>'3N3B','id_loans'=>'af02d593-7409-43cb-9304-fecec62d182d','date'=>date('Y-m-d'),'nominal'=>30000,'no_cicilan'=>3,'status_lunas'=>0,'kode_status_cicilan'=>'nunggak sian','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        // );

        // 
        DB::table('loan_arreas')->insert(
            ['no_invoice'=>'4N3T','id_loans'=>'d2c3c088-c404-43df-9450-9ed1b51f36ea','date'=>date('Y-m-d'),'nominal'=>3000,'no_cicilan'=>3,'status_lunas'=>0,'kode_status_cicilan'=>'nunggak sian','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
    }
}
