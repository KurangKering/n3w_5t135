<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengeluaranLainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluaran_lains', function (Blueprint $table) {
            $table->increments('id');
            $table->string('jenis_bayar')->nullable();
            $table->text('uraian')->nullable();
            $table->date('tanggal_bayar')->nullable();
            $table->decimal('total_bayar', 12,0)->nullable();
            $table->text('keterangan')->nullable();
            $table->string('lampiran')->nullable();
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
        Schema::dropIfExists('pengeluaran_lains');
    }
}
