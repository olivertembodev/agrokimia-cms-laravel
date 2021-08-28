<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableLoans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('loans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_invoice');
            $table->uuid('id_cicilan');
            $table->uuid('id_product');
            $table->uuid('id_kios');
            $table->integer('jumlah');
            $table->float('nominal');
            $table->float('total');
            $table->string('id_xendit')->nullable();
            $table->string('invoice_url')->nullable();
            $table->integer('status');
            $table->integer('status_lunas');
            $table->date('tanggal');
            $table->text('deskripsi')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE loans ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }
      /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
