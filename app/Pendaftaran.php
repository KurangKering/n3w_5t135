<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
	protected $table = 'pendaftarans';
	protected $fillable = ['ket_bayar', 'mahasiswa_id'];
	public function mahasiswa()
	{
		return $this->belongsTo('App\Mahasiswa');
	}

	public function pendaftaran_det()
	{
		return $this->hasMany('App\Pendaftaran_det');
	}
}
