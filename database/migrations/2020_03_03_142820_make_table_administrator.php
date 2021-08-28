<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTableAdministrator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('administrators', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_role');
            $table->string('name');
            $table->string('nik')->nullable();
            $table->string('nip')->nullable();
            $table->string('phone')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('email');
            $table->string('password');
            $table->string('confirm_password')->nullable();
            $table->string('address')->nullable();
            $table->string('status');
            $table->string('remember_token')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE administrators ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrators');
    }
}
