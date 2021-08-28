<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTableRewardProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('reward_products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_product');
            $table->string('nama_product');
            $table->string('stock');
            $table->string('deskripsi');
            $table->string('image');
            $table->integer('nominal_reward');
            $table->date('expired')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE reward_products ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reward_products');
    }
}
