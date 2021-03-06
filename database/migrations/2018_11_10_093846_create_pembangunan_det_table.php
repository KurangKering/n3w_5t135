<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembangunanDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembangunan_det', function (Blueprint $table) {
           $table->increments('id');
           $table->unsignedDecimal('jumlah_bayar', 12,0)->nullable();
           $table->date('tanggal_bayar')->nullable();
           $table->unsignedInteger('transaksi_id')->nullable();
           $table->unsignedInteger('pembangunan_id')->nullable();
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
        Schema::dropIfExists('pembangunan_det');
    }
}
