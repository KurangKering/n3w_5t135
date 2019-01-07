<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendaftaranDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftaran_det', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedDecimal('bayar_pendaftaran', 12, 0)->nullable();
            $table->date('tanggal_bayar')->nullable();
            $table->unsignedInteger('transaksi_id')->nullable();
            $table->unsignedInteger('pendaftaran_id')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendaftaran_det');
    }
}
