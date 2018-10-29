<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran_gaji extends Model
{
    public function pegawai()
    {
    	return $this->belongsTo('App\Pegawai');
    }
   public function transaksi()
	{
		return $this->belongsTo('App\Transaksi');
	}
}
