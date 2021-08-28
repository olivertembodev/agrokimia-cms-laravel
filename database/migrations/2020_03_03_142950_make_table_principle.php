<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTablePrinciple extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('principles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_kategori');
            $table->string('nama_principle');
            $table->string('email_principle')->nullable();
            $table->string('alamat_principle')->nullable();
            $table->string('phone_principle')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('logo');
            $table->string('nama_pic');
            $table->string('nomor_pic');
            $table->string('email_pic')->nullable();
            $table->string('status_principle');
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE principles ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('principles');
    }
}
