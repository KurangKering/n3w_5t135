<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePustakaAlmaDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pustaka_alma_det', function (Blueprint $table) {
            $table->increments('id');
             $table->unsignedDecimal('bayar_pustaka', 12,0)->nullable();
            $table->unsignedDecimal('bayar_alma', 12, 0)->nullable();
            $table->date('tanggal_bayar')->nullable();
            $table->unsignedInteger('transaksi_id')->nullable();
            $table->unsignedInteger('pustaka_alma_id')->nullable();
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
        Schema::dropIfExists('pustaka_alma__det');
    }
}
