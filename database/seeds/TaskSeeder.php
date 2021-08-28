<?php

use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         //
        //  $id =DB::table('category_products')->insertGetId(
        //     ['nama_category'=>'Hila','icon'=>'pnh.png','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        // );
        // DB::table('products')->insert(
        //     ['id_category_product'=>$id,'id_principle'=>'2d33c615-7f56-4500-a620-aabe777ca272','nama_product'=>'Pupuk Petros','lot_product'=>'wkwkwk','harga_jual'=>30000,'harga_beli'=>27000,'reward_poin'=>20,'created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        // );
        // DB::table('detail_transaction')->insert(
        //     ['id_transaction'=>'06864113-0835-46d2-a8b8-b5399c425923','id_product'=>'ffd495e4-ca84-4905-b035-870ea0d188dd','jumlah'=>3,'created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        // );


        // DB::table('tenors')->insert(
        //     ['no_invoice'=>'1B2D','id_loans'=>'7605c3e6-cb9c-44c6-afb6-d5848d26523e','date'=>date('Y-m-d'),'nominal'=>140000,'no_cicilan'=>2,'status_lunas'=>0,'kode_status_cicilan'=>'belum','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        // );


        // DB::table('loans')->insert(
        //     ['nominal'=>13000,'total'=>3100,'status'=>1,'status_lunas'=>1,'deskripsi'=>'iki nyicil','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d'),'id_transaksi'=>'6852e5f2-5cb9-4e43-811a-869e7c7b02bd']
        // );
    }
}
