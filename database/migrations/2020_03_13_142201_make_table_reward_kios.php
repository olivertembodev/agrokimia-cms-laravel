<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTableRewardKios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('reward_kios', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('foto_kios');
            $table->string('nama_kios');
            $table->integer('id_kios');
            $table->string('alamat_kios');
            $table->integer('jumlah_reward');
            $table->string('detail_transaksi');
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE reward_kios ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reward_kios');
    }
}
