<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembangunan extends Model
{
	protected $table = 'pembangunans';
	protected $fillable = ['ket_bayar', 'mahasiswa_id'];


	public function mahasiswa()
	{
		return $this->belongsTo('App\Mahasiswa');
	}

	public function pembangunan_det()
	{
		return $this->hasMany('App\Pembangunan_det');
	}
}
