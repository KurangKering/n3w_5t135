<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembayaranGajisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_gajis', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal_bayar')->nullable();
            $table->decimal('jumlah_gaji', 12, 0)->nullable();
            $table->text('uraian')->nullable();
            $table->string('lampiran')->nullable();
            $table->unsignedInteger('pegawai_id');
            $table->unsignedInteger('transaksi_id');
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
        Schema::dropIfExists('pembayaran_gajis');
    }
}
