<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calon_mahasiswa extends Model
{
	protected $table = 'calon_mahasiswa';

	public function mahasiswa()
	{
		return $this->hasOne('App\Mahasiswa');
	}
	public function pendaftaran()
	{
		return $this->hasOne('App\Pendaftaran');
	}
}
