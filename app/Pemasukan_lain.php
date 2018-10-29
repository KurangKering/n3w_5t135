<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pemasukan_lain extends Model
{
	protected $table = 'pemasukan_lains';

	public function transaksi()
	{
		return $this->belongsTo('App\Transaksi');
	}
}
