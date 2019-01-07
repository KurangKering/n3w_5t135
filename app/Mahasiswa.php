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
	
	public function pembangunan()
	{
		return $this->hasOne('App\Pembangunan');
	}
	public function calon_mahasiswa()
	{
		return $this->belongsTo('App\Calon_mahasiswa');
	}

	public function pustaka_alma()
	{
		return $this->hasOne('App\Pustaka_alma');
	}
}
