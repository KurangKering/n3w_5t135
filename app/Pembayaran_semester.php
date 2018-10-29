<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran_semester extends Model
{
	protected $table = 'pembayaran_semesters';
	protected $fillable = ['ket_bayar', 'semester', 'mahasiswa_id'];

	public function mahasiswa()
	{
		return $this->belongsTo('App\Mahasiswa');
	}

	public function pembayaran_semester_det()
	{
		return $this->hasMany('App\Pembayaran_semester_det');
	}
	
}
