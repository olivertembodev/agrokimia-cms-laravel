<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTablePromo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('promotions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_kupon');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('is_percentage');
            $table->integer('minimal_transaksi')->nullable();
            $table->float('potongan')->nullable();
            $table->float('max_potongan')->nullable();
            $table->text('deskripsi')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE promotions ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }
      /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotions');
    }
}
