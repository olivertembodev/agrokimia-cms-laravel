<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTableRewardTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('reward_transaksi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('nama_kios');
            $table->uuid('nama_produk');
            $table->integer('total_reward');
            $table->date('tanggal');
            $table->string('status_transaksi_reward');
            $table->string('detail_transaksi');
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE reward_transaksi ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reward_transaksi');
    }
}
