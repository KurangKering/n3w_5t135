<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
	public function transaksi()
	{
		return $this->belongsTo('App\Transaksi');
	}

	public function pembayaran_semester()
	{
		return $this->hasOne('App\Pembayaran_semester');
	}

	public function pendaftaran()
	{
		return $this->hasOne('App\Pendaftaran');
	}
	public function pemasukan_lain()
	{
		return $this->hasOne('App\Pemasukan_lain');
	}



}
