<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableLoanArreas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('loan_arreas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_invoice')->nullable();
            $table->uuid('id_loans');
            $table->date('date');
            $table->float('nominal');
            $table->integer('status')->nullable();
            $table->integer('no_cicilan');
            $table->integer('status_lunas')->nullable();
            $table->string('kode_status_cicilan');
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE loan_arreas ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_arreas');
    }
}
