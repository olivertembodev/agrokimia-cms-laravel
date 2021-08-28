<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableUserNotifictions extends Migration
{
    /**
     * Run the migrations.
     * fr
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_user');
            $table->integer('tipe_user');
            $table->uuid('id_task')->nullable();
            $table->uuid('id_informasi')->nullable();
            $table->uuid('id_news')->nullable();
            $table->uuid('created_by');
            $table->integer('is_view')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE user_notifications ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('user_notifications');
    }
}
