<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalonMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calon_mahasiswa', function (Blueprint $table) {
            $table->increments('id');
            $table->char('nisn')->unique();
            $table->string('nama')->nullable();
            $table->date('tanggal_masuk')->nullable();
            $table->string('program_studi')->nullable();
            $table->string('status')->nullable();
            $table->char('tahun_masuk')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('agama')->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->string('alamat')->nullable();
            $table->char('no_hp')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('calon_mahasiswa');
    }
}
