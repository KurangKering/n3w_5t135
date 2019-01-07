<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
	protected $table = 'pendaftarans';
	protected $fillable = ['ket_bayar', 'calon_mahasiswa_id'];
	public function calon_mahasiswa()
	{
		return $this->belongsTo('App\Calon_mahasiswa');
	}

	public function pendaftaran_det()
	{
		return $this->hasMany('App\Pendaftaran_det');
	}
}
