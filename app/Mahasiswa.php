<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
	protected $table = 'mahasiswas';
	public function pembayaran_semester()
	{
		return $this->hasMany('App\Pembayaran_semester', 'mahasiswa_id');
	}
	public function pendaftaran()
	{
		return $this->hasOne('App\Pendaftaran');
	}
	public function pembangunan()
	{
		return $this->hasOne('App\Pembangunan');
	}
}
