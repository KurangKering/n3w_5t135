<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran_semester_det extends Model
{
	protected $table = "pembayaran_semester_det";
	public function transaksi()
	{
		return $this->belongsTo('App\Transaksi');
	}

	public function pembayaran_semester()
	{
		return $this->belongsTo('App\Pembayaran_semester');
	}
}
