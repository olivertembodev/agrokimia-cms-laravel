<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableStoks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('stoks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_produk');
            $table->uuid('id_principle');
            $table->integer('stok');
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE stoks ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stoks');
    }
}
