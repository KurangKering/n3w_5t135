<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Calon_mahasiswa;
use App\Mahasiswa;
use App\Pegawai;
use App\Pembayaran_semester;
use App\Pemasukan_lain;
use App\Pendaftaran;
use App\Pembayaran_gaji;
use App\Pengeluaran_lain;

class DataTablesJsonController extends Controller
{
	public function semua_calon_mahasiswa()
	{
		$mahasiswas = Calon_mahasiswa::with('pendaftaran.pendaftaran_det')->latest()->get();
		$mahasiswas->each(function($ii) {
			if ($ii->pendaftaran) {
				$ii->pendaftaran->pendaftaran_det->each(function($iii) use($ii) {

					$iii->tgl_bayar_manusia = indonesian_date($iii->tanggal_bayar);
					$iii->bayar_pendaftaran_manusia = rupiah($iii->bayar_pendaftaran);

					$ii->pendaftaran->total += $iii->bayar_pendaftaran;
				});

				$ii->pendaftaran->total = rupiah($ii->pendaftaran->total);	


			}
		});
		

		return DataTables::of($mahasiswas)
		->addColumn('action', function($mahasiswa) {
			return '<div style="display:flex;"> <a href="'.route('mahasiswa.show', $mahasiswa->id).'" class="btn btn-success">Detail</a>&nbsp;<a href="'.route('mahasiswa.edit', $mahasiswa->id).'" class="btn btn-warning">Edit</a>&nbsp;</div>';
		})
		->addColumn('nomor', null)
		->make(true);

		/*
		column action except <a id="'.$mahasiswa->id.'" class="btn-delete btn btn-danger">Delete</a>
		 */
	}

	public function semua_mahasiswa()
	{
		$mahasiswas = Mahasiswa::with('calon_mahasiswa', 'pembayaran_semester','pustaka_alma.pustaka_alma_det')->orderBy('mahasiswas.created_at', 'desc')->get();
		$mahasiswas->each(function($ii) {
			if ($ii->pendaftaran) {
				$ii->pendaftaran->pendaftaran_det->each(function($iii) use($ii) {
					$jumlahBayar = $iii->bayar_pustaka+ $iii->bayar_alma + $iii->bayar_pendaftaran;

					$iii->tgl_bayar_manusia = indonesian_date($iii->tanggal_bayar);
					$iii->bayar_pustaka_manusia = rupiah($iii->bayar_pustaka);
					$iii->bayar_alma_manusia = rupiah($iii->bayar_alma);
					$iii->bayar_pendaftaran_manusia = rupiah($iii->bayar_pendaftaran);
					$iii->jumlah_bayar_manusia = rupiah($jumlahBayar);

					$ii->pendaftaran->total += $jumlahBayar;
				});

				$ii->pendaftaran->total = rupiah($ii->pendaftaran->total);	


				$ii->pembayaran_semester->each(function($iii) {
					$iii->tgl_bayar_manusia = indonesian_date($iii->tanggal_bayar);
					$iii->jumlah_bayar_manusia = rupiah($iii->jumlah_bayar);
				});
			}
		});
		

		return DataTables::of($mahasiswas)
		->addColumn('action', function($mahasiswa) {
			return '<div style="display:flex;"> <a href="'.route('mahasiswa.show', $mahasiswa->id).'" class="btn btn-success">Detail</a>&nbsp;<a href="'.route('mahasiswa.edit', $mahasiswa->id).'" class="btn btn-warning">Edit</a>&nbsp;</div>';
		})
		->addColumn('nomor', null)
		->make(true);

		/*
		column action except <a id="'.$mahasiswa->id.'" class="btn-delete btn btn-danger">Delete</a>
		 */
	}
	public function semua_pegawai()
	{
		$pegawais = Pegawai::orderBy('pegawais.created_at', 'desc')->get();
		return DataTables::of($pegawais)
		->addColumn('action', function($pegawai) {
			return '<div style="display:flex;"> 
			<a href="'.route('pegawai.show', $pegawai->id).'" 
			class="btn btn-success">
			Detail
			</a>
			&nbsp;
			<a href="'.route('pegawai.edit', $pegawai->id).'" 
			class="btn btn-warning">
			Edit
			</a>&nbsp;
			</div>';
		})
		->addColumn('nomor', null)
		->addColumn('ttl', function($pegawai) {
			return $pegawai->tempat_lahir . ', ' . $pegawai->tanggal_lahir;
		})
		->make(true);

		/*
		column action except 
		<a id="'.$pegawai->id.'" 
			class="btn-delete btn btn-danger">
			Delete
			</a>
		 */
		}
		public function semua_pembayaran_semester()
		{
			$pembayaran_semesters = Pembayaran_semester::with('pemasukan', 'mahasiswa')->orderBy('pembayaran_semesters.created_at', 'desc')->get();
			return DataTables::of($pembayaran_semesters)
			->addColumn('action', function($pembayaran_semester) {
				return '<div style="display:flex;"> 
				<a href="'.route('pembayaran_semester.show', $pembayaran_semester->id).'" 
				class="btn btn-success">
				Detail
				</a>
				&nbsp;
				<a href="'.route('pembayaran_semester.edit', $pembayaran_semester->id).'" 
				class="btn btn-warning">
				Edit
				</a>&nbsp;
				<a id="'.$pembayaran_semester->id.'" 
				class="btn-delete btn btn-danger">
				Delete
				</a></div>';
			})
			->make(true);
		}


	}
