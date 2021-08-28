<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTableSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('sales', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_sales');
            $table->integer('id_kota');
            $table->integer('id_area');
            $table->string('alamat_sales');
            $table->string('nik');
            $table->string('nip');
            $table->string('jenis_kelamin');
            $table->string('email');
            $table->string('password');
            $table->string('confirm_password')->nullable();
            $table->string('status');
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE sales ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
