<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
	public function pendaftaran_det()
	{
		return $this->hasOne('App\Pendaftaran');
	}
	public function pembayaran_semester_det()
	{
		return $this->hasOne('App\Pembayaran_semester_det');
	}
	public function pemasukan_lain()
	{
		return $this->hasOne('App\Pemasukan_lain');
	}

	public function pembayaran_gaji()
	{
		return $this->hasOne('App\Pembayaran_gaji');
	}
	public function pengeluaran_lain()
	{
		return $this->hasOne('App\Pengeluaran_lain');
	}

	

}
