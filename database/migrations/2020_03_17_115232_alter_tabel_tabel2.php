<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTabelTabel2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loans', function($table) {
            $table->dropColumn('no_invoice');
            $table->dropColumn('id_product');
            $table->dropColumn('id_kios');
            $table->dropColumn('jumlah');
            $table->dropColumn('no_cicilan');
            $table->dropColumn('tanggal');
        });
        Schema::table('loans', function (Blueprint $table) {
            $table->uuid('verified_by')->nullable();
            $table->integer('is_verified')->nullable();          
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->uuid('verified_by')->nullable();
            $table->integer('is_verified')->nullable();          
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
