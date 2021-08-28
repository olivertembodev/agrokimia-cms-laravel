<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableLoans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loans', function($table) {
            $table->dropColumn('id_cicilan');
            $table->dropColumn('id_status_pembayaran');
            $table->dropColumn('id_status_pengiriman');
        });

        Schema::table('transactions', function($table) {
            $table->dropColumn('id_status_pembayaran');
            $table->dropColumn('id_status_pengiriman');
        });
        
        Schema::table('loans', function (Blueprint $table) {
            $table->uuid('id_tipe_cicilan')->nullable();        
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->uuid('id_tipe_pembayaran')->nullable();
            $table->uuid('id_tipe_pengiriman')->nullable();
        });
        Schema::table('sales', function (Blueprint $table) {
            $table->string('firebase_token')->nullable();
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
