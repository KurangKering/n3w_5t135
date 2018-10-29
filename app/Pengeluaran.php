<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
	public function transaksi()
	{
		return $this->belongsTo('App\Transaksi');
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
