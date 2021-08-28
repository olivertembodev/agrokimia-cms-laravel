<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->uuid('id_status_pembayaran')->nullable();
            $table->uuid('id_status_transaksi')->nullable();
            $table->uuid('id_status_pengiriman')->nullable();
            $table->integer('status_lunas')->nullable();
        });
        Schema::table('loans', function (Blueprint $table) {
            $table->uuid('id_status_pembayaran')->nullable();
            $table->uuid('id_transaksi');
            $table->uuid('id_status_transaksi')->nullable();
            $table->uuid('id_status_pengiriman')->nullable();
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
