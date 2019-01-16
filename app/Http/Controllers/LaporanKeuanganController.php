<?php

namespace App\Http\Controllers;

use DB;

class LaporanKeuanganController extends Controller
{
    public function index()
    {
        $pembayaran_semesters = DB::table('pembayaran_semesters')
            ->select(
                DB::raw(' "Pemasukan" as jenis_transaksi, "Pembayaran Semester" as detail_transaksi, pemasukans.transaksi_id,
				tanggal_bayar,
				jumlah_bayar as total_bayar'))
            ->join('pemasukans',
                'pemasukans.id',
                '=',
                'pembayaran_semesters.pemasukan_id')
            ->whereYear('tanggal_bayar', 2018);

        $pendaftarans = DB::table('pendaftarans')
            ->select(
                DB::raw(' "Pemasukan" as jenis_transaksi, "Pendaftaran" as detail_transaksi, pemasukans.transaksi_id,
				tanggal_bayar,
				(bayar_pustaka + bayar_alma + bayar_pendaftaran) as total_bayar'))
            ->join('pemasukans',
                'pemasukans.id',
                '=',
                'pendaftarans.pemasukan_id')
            ->whereYear('tanggal_bayar', 2018);

        $pemasukan_lains = DB::table('pemasukan_lains')
            ->select(
                DB::raw(' "Pemasukan" as jenis_transaksi, "Pemasukan Lain" as detail_transaksi, pemasukans.transaksi_id,
				tanggal_bayar,
				total_bayar'))
            ->join('pemasukans',
                'pemasukans.id',
                '=',
                'pemasukan_lains.pemasukan_id')
            ->whereYear('tanggal_bayar', 2018);

        $pembayaran_gajis = DB::table('pembayaran_gajis')
            ->select(
                DB::raw(' "Pengeluaran" as jenis_transaksi, "Pembayaran Gaji" as detail_transaksi, pengeluarans.transaksi_id,
				tanggal_bayar,
				jumlah_gaji as total_bayar'))
            ->join('pengeluarans',
                'pengeluarans.id',
                '=',
                'pembayaran_gajis.pengeluaran_id')
            ->whereYear('tanggal_bayar', 2018);

        $pengeluaran_lains = DB::table('pengeluaran_lains')
            ->select(
                DB::raw(' "Pengeluaran" as jenis_transaksi, "Pengeluaran Lain" as detail_transaksi, pengeluarans.transaksi_id,
				tanggal_bayar,
				total_bayar'))
            ->join('pengeluarans',
                'pengeluarans.id',
                '=',
                'pengeluaran_lains.pengeluaran_id')
            ->whereYear('tanggal_bayar', 2018);

        $transaksis = $pembayaran_semesters
            ->union($pendaftarans)
            ->union($pemasukan_lains)
            ->union($pembayaran_gajis)
            ->union($pengeluaran_lains);

        $transaksis = $transaksis->orderBy('tanggal_bayar', 'desc')->get();

        return view('laporan.index', compact('transaksis'));
    }
}
