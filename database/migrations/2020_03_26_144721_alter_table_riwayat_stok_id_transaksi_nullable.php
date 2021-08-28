<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRiwayatStokIdTransaksiNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('riwayat_stoks', function (Blueprint $table) {
            $table->dropColumn('id_transaksi');
        });
        Schema::table('riwayat_stoks', function (Blueprint $table) {
            $table->uuid('id_transaksi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
