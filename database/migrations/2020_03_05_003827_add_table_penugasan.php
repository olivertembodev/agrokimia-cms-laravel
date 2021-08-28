<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTablePenugasan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_tipe_tasks');
            $table->uuid('id_admin');
            $table->uuid('id_sales');
            $table->uuid('id_kios');
            $table->uuid('id_kota');
            $table->uuid('id_area');
            $table->uuid('id_transaksi')->nullable();
            $table->uuid('id_tagihan')->nullable();
            $table->string('catatan')->nullable();
            $table->integer('is_finish')->nullable();
            $table->text('deskripsi')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE tasks ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }
      /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
