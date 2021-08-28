<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTableMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('menus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('parent_menu_id');
            $table->integer('menu_id');
            $table->string('nama_menu');
            $table->string('slug');
            $table->string('icon');
            $table->integer('no_urut');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE menus ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
