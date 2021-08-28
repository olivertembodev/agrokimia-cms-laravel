<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterIdAktifitasLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_admins', function($table) {
            $table->dropColumn('aktifitas');
        });
        Schema::table('log_users', function($table) {
            $table->dropColumn('aktifitas');
        });
        Schema::table('log_admins', function (Blueprint $table) {
            $table->string('id_aktifitas');
        });
        Schema::table('log_users', function (Blueprint $table) {
            $table->string('id_aktifitas');
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
