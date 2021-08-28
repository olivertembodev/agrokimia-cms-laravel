<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUserNotif extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_notifications', function($table) {
            $table->dropColumn('id_task');
            $table->dropColumn('id_informasi');
            $table->dropColumn('id_news');
        });
        
        Schema::table('user_notifications', function (Blueprint $table) {
            $table->uuid('id_detail')->nullable();
            $table->string('page')->nullable();
            $table->string('tipe_page')->nullable();
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
