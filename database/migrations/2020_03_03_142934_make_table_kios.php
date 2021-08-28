<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTableKios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('kios', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_kios_utama')->nullable();
            $table->string('nama_Kios');
            $table->string('kode_kios');
            $table->uuid('tipe_kios');
            $table->integer('id_kota');
            $table->integer('id_area');
            $table->string('alamat_kios');
            $table->string('maps');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('email');
            $table->string('nama_pic');
            $table->string('nomor_hp_pic');
            $table->string('nomor_ktp_pic');
            $table->string('image_ktp');
            $table->string('nomor_npwp_pic');
            $table->string('image_npwp');
            $table->string('image_kios_depan');
            $table->string('image_kios_dalam');
            $table->string('image_selfi_ktp');
            $table->string('password');
            $table->string('confirm_password')->nullable();
            $table->string('status');
            $table->date('deleted_at')->nullable();
            $table->date('exp_date')->nullable();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE kios ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kios');
    }
}
