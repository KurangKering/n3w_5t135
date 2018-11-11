<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembangunan_det extends Model
{

	protected $table = 'pembangunan_det';
	protected $fillable = ['jumlah_bayar', 'tanggal_bayar', 'transaksi_id', 'pembangunan_id'];


	public function transaksi()
	{
		return $this->belongsTo('App\Transaksi');
	}

	public function pembangunan()
	{
		return $this->belongsTo('App\Pembangunan');
	}
}
