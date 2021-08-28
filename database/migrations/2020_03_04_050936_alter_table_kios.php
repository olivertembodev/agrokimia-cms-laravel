<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableKios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kios', function (Blueprint $table) {
            $table->string('nomor_ktp_pic')->nullable()->change();
            $table->string('image_ktp')->nullable()->change();
            $table->string('nomor_npwp_pic')->nullable()->change();
            $table->string('image_npwp')->nullable()->change();
            $table->string('image_kios_depan')->nullable()->change();
            $table->string('image_kios_dalam')->nullable()->change();
            $table->string('image_selfi_ktp')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
