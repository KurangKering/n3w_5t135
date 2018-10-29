<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\Pemasukan;
use App\Pengeluaran;
use App\Pembayaran_semester;
use App\Pemasukan_lain;
use App\Pendaftaran;
use App\Pembayaran_gaji;
use App\Pengeluaran_lain;
use DB;
class DashboardController extends Controller
{

	public function dummy()
	{
		return view('layouts.new_template');
	}
	public function index()
	{
		
		// $pembayaran_semesters = DB::table('pembayaran_semesters')
		// ->select(
		// 	DB::raw(' "pemasukan" as jenis_transaksi, "pembayaran_semester" as detail_transaksi, pemasukans.transaksi_id,
		// 		tanggal_bayar, 
		// 		jumlah_bayar as total_bayar'))
		// ->join('pemasukans', 
		// 	'pemasukans.id', 
		// 	'=', 
		// 	'pembayaran_semesters.pemasukan_id')
		// ->whereYear('tanggal_bayar', 2018);


		// $pendaftarans = DB::table('pendaftarans')
		// ->select(
		// 	DB::raw(' "pemasukan" as jenis_transaksi, "pendaftaran" as detail_transaksi, pemasukans.transaksi_id, 
		// 		tanggal_bayar, 
		// 		(bayar_pustaka + bayar_alma + bayar_pendaftaran) as total_bayar'))
		// ->join('pemasukans',
		// 	'pemasukans.id',
		// 	'=', 
		// 	'pendaftarans.pemasukan_id')
		// ->whereYear('tanggal_bayar', 2018);

		// $pemasukan_lains = DB::table('pemasukan_lains')
		// ->select(
		// 	DB::raw(' "pemasukan" as jenis_transaksi, "pemasukan_lain" as detail_transaksi, pemasukans.transaksi_id, 
		// 		tanggal_bayar, 
		// 		total_bayar'))
		// ->join('pemasukans',
		// 	'pemasukans.id',
		// 	'=', 
		// 	'pemasukan_lains.pemasukan_id')
		// ->whereYear('tanggal_bayar', 2018);

		// $pembayaran_gajis = DB::table('pembayaran_gajis')
		// ->select(
		// 	DB::raw(' "pengeluaran" as jenis_transaksi, "pembayaran_gaji" as detail_transaksi, pengeluarans.transaksi_id, 
		// 		tanggal_bayar, 
		// 		jumlah_gaji as total_bayar'))
		// ->join('pengeluarans',
		// 	'pengeluarans.id',
		// 	'=', 
		// 	'pembayaran_gajis.pengeluaran_id')
		// ->whereYear('tanggal_bayar', 2018);

		// $pengeluaran_lains = DB::table('pengeluaran_lains')
		// ->select(
		// 	DB::raw(' "pengeluaran" as jenis_transaksi, "pengeluaran_lain" as detail_transaksi, pengeluarans.transaksi_id, 
		// 		tanggal_bayar, 
		// 		total_bayar'))
		// ->join('pengeluarans',
		// 	'pengeluarans.id',
		// 	'=', 
		// 	'pengeluaran_lains.pengeluaran_id')
		// ->whereYear('tanggal_bayar', 2018);
		
		// $transaksi = $pembayaran_semesters
		// ->union($pendaftarans)
		// ->union($pemasukan_lains)
		// ->union($pembayaran_gajis)
		// ->union($pengeluaran_lains);


		//print_r($transaksi->orderBy('tanggal_bayar', 'desc')->get()->toArray());
		
		return view('dashboard');
	}
}
