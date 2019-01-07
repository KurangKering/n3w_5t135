<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pustaka_alma extends Model
{
	protected $table = "pustaka_alma";
	protected $fillable = ['ket_bayar', 'mahasiswa_id'];


	public function mahasiswa()
	{
		return $this->belongsTo('App\Mahasiswa');
	}

	public function pustaka_alma_det()
	{
		return $this->hasMany('App\Pustaka_alma_det');
	}
}
