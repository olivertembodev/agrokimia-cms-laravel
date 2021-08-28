<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRolePembayarans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('role_pembayarans', function($table) {
            $table->dropColumn('nama_role_pembayaran');
            $table->dropColumn('tipe_pembayaran');
        });
        Schema::table('role_pembayarans', function (Blueprint $table) {
            $table->uuid('id_tipe_kios')->nullable();
            $table->uuid('id_tipe_pembayaran')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
