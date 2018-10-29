<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran_det extends Model
{
	protected $table = 'pendaftaran_det';

	public function transaksi()
	{
		return $this->belongsTo('App\Transaksi');
	}
	

	public function pendaftaran()
	{
		return $this->belongsTo('App\Pendaftaran');
	}
}
