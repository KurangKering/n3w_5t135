<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pustaka_alma_det extends Model
{
	protected $table = "pustaka_alma_det";


	public function pustaka_alma()
	{
		return $this->belongsTo('App\Pustaka_alma');
	}

	public function transaksi()
	{
		return $this->belongsTo('App\Transaksi');
	}
}
