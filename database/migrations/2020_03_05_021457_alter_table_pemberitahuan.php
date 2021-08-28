<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePemberitahuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pemberitahuan', function (Blueprint $table) {
            $table->integer('tipe_user');
            $table->integer('tampil_depan')->nullable();
        });

        Schema::table('tasks', function($table) {
            $table->dropColumn('id_kota');
            $table->dropColumn('id_area');
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->integer('id_kota');
            $table->integer('id_area');
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
