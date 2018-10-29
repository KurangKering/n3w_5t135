<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
	protected $table = 'pegawais';


	public function pembayaran_gaji()
	{
		return $this->hasMany('App\Pembayaran_gaji', 'pegawai_id');
	}
}
