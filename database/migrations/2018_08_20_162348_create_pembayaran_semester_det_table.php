<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembayaranSemesterDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_semester_det', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedDecimal('jumlah_bayar', 12,0)->nullable();
            $table->date('tanggal_bayar')->nullable();
            $table->unsignedInteger('transaksi_id')->nullable();
            $table->unsignedInteger('pembayaran_semester_id')->nullable();
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
        Schema::dropIfExists('pembayaran_semester_det');
    }
}
