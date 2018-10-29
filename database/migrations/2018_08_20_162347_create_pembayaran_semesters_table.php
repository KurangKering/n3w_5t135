<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembayaranSemestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_semesters', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('semester')->nullable();
            $table->string('ket_bayar')->nullable();
            $table->unsignedInteger('mahasiswa_id');
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
        Schema::dropIfExists('pembayaran_semesters');
    }
}
