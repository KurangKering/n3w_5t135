<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran_lain extends Model
{
	public function transaksi()
	{
		return $this->belongsTo('App\Transaksi');
	}
}
