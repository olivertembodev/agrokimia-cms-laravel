<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUserNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_notifications', function($table) {
            $table->dropColumn('id_user');
        });
        Schema::table('user_notifications', function($table) {
            $table->dropColumn('tipe_user');
        });
        Schema::table('user_notifications', function (Blueprint $table) {
            $table->uuid('id_user')->nullable();
        });
        Schema::table('user_notifications', function (Blueprint $table) {
            $table->integer('tipe_user')->nullable();
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
