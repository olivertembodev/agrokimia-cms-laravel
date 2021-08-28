<?php

use Illuminate\Database\Seeder;

class DetailTransaksiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id =DB::table('detail_transaction')->insertGetId(
            ['id_transaction'=>'e2fc1cad-2bde-4ad9-9af9-c11ab589ae48', 'id_product'=>'21b877d9-21d6-47ed-98a3-26a27587fec6','jumlah'=>22 ,'created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
    }
}
