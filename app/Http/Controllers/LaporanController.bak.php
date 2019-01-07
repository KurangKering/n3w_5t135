<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Transaksi;
use App\Pemasukan;
use App\Pengeluaran;
use App\Pendaftaran;
use App\Pemasukan_lain;
use App\Pembayaran_gaji;
use App\Pembayaran_semester;
use App\Pengeluaran_lain;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pembayaran_semester_det = DB::table('pembayaran_semester_det')
        ->select(
            DB::raw(' transaksis.jenis_transaksi, transaksi_id,
                tanggal_bayar, 
                jumlah_bayar as total_bayar'))
        ->join('transaksis', 
            'transaksis.id', 
            '=', 
            'pembayaran_semester_det.transaksi_id');

        $pembangunan_det = DB::table('pembangunan_det')
        ->select(
            DB::raw(' transaksis.jenis_transaksi, transaksi_id, 
                tanggal_bayar, 
                jumlah_bayar as total_bayar'))
        ->join('transaksis',
            'transaksis.id',
            '=', 
            'pembangunan_det.transaksi_id');

        $pendaftaran_det = DB::table('pendaftaran_det')
        ->select(
            DB::raw(' transaksis.jenis_transaksi, transaksi_id, 
                tanggal_bayar, 
                 bayar_pendaftaran as total_bayar'))
        ->join('transaksis',
            'transaksis.id',
            '=', 
            'pendaftaran_det.transaksi_id');

        $pustaka_alma_det = DB::table('pustaka_alma_det')
        ->select(
            DB::raw(' transaksis.jenis_transaksi, transaksi_id, 
                tanggal_bayar, 
                 (bayar_pustaka + bayar_alma) as total_bayar'))
        ->join('transaksis',
            'transaksis.id',
            '=', 
            'pustaka_alma_det.transaksi_id');

        $pemasukan_lains = DB::table('pemasukan_lains')
        ->select(
            DB::raw(' transaksis.jenis_transaksi, transaksi_id, 
                tanggal_bayar, 
                total_bayar'))
        ->join('transaksis',
            'transaksis.id',
            '=', 
            'pemasukan_lains.transaksi_id');
        $pembayaran_gajis = DB::table('pembayaran_gajis')
        ->select(
            DB::raw(' transaksis.jenis_transaksi, transaksi_id, 
                tanggal_bayar, 
                jumlah_gaji as total_bayar'))
        ->join('transaksis',
            'transaksis.id',
            '=', 
            'pembayaran_gajis.transaksi_id');
        $pengeluaran_lains = DB::table('pengeluaran_lains')
        ->select(
            DB::raw(' transaksis.jenis_transaksi, transaksi_id, 
                tanggal_bayar, 
                total_bayar'))
        ->join('transaksis',
            'transaksis.id',
            '=', 
            'pengeluaran_lains.transaksi_id'); 

        $from = $request->get('awal');
        $end = $request->get('akhir');

        if ($from) {
            $pembayaran_gajis = $pembayaran_gajis->where('tanggal_bayar', '>=', $from);
            $pemasukan_lains = $pemasukan_lains->where('tanggal_bayar', '>=', $from);
            $pembangunan_det = $pembangunan_det->where('tanggal_bayar', '>=', $from);
            $pendaftaran_det = $pendaftaran_det->where('tanggal_bayar', '>=', $from);
            $pustaka_alma_det = $pustaka_alma_det->where('tanggal_bayar', '>=', $from);
            $pembayaran_semester_det = $pembayaran_semester_det->where('tanggal_bayar', '>=', $from);
            $pengeluaran_lains = $pengeluaran_lains->where('tanggal_bayar', '>=', $from);
        }
        if ($end) {
            $pembayaran_gajis = $pembayaran_gajis->where('tanggal_bayar', '<=', $end);
            $pemasukan_lains = $pemasukan_lains->where('tanggal_bayar', '<=', $end);
            $pembangunan_det = $pembangunan_det->where('tanggal_bayar', '<=', $from);
            $pendaftaran_det = $pendaftaran_det->where('tanggal_bayar', '<=', $end);
            $pustaka_alma_det = $pustaka_alma_det->where('tanggal_bayar', '<=', $end);
            $pembayaran_semester_det = $pembayaran_semester_det->where('tanggal_bayar', '<=', $end);
            $pengeluaran_lains = $pengeluaran_lains->where('tanggal_bayar', '<=', $end);
        }




        $transaksis = $pembayaran_semester_det
        ->union($pembangunan_det)
        ->union($pendaftaran_det)
        ->union($pustaka_alma_det)
        ->union($pemasukan_lains)
        ->union($pembayaran_gajis)
        ->union($pengeluaran_lains);


        $transaksis = $transaksis->orderBy('tanggal_bayar', 'desc')->get();




        $total['pemasukan']   = $transaksis->whereIn('jenis_transaksi', \Config::get('enums.pemasukan'))->sum('total_bayar');
        $total['pengeluaran'] = $transaksis->whereIn('jenis_transaksi', \Config::get('enums.pengeluaran'))->sum('total_bayar');
        $total['seluruhnya']  = $total['pemasukan'] - $total['pengeluaran'];


        $pemasukanLainIDs = $transaksis->where('jenis_transaksi', 'Pemasukan Lain')->pluck('transaksi_id')->toArray();
        $pengeluaranLainIDs = $transaksis->where('jenis_transaksi', 'Pengeluaran Lain')->pluck('transaksi_id')->toArray();

        $pemasukan_lain = Pemasukan_lain::whereIn('transaksi_id', $pemasukanLainIDs)->get();
        $pengeluaran_lain = Pengeluaran_lain::whereIn('transaksi_id', $pengeluaranLainIDs)->get();
        $transaksis->where('jenis_transaksi', 'Pemasukan Lain')->each(function($i) use ($pemasukan_lain) {
            $i->jenis_lain = $pemasukan_lain->where('transaksi_id', $i->transaksi_id)->first()->jenis_bayar;
        });
        $transaksis->where('jenis_transaksi', 'Pengeluaran Lain')->each(function($i) use ($pengeluaran_lain) {
            $i->jenis_lain = $pengeluaran_lain->where('transaksi_id', $i->transaksi_id)->first()->jenis_bayar;
        });



        return view('laporan.index', compact('transaksis', 'total', 'from', 'end', 'pemasukan_lain', 'pengeluaran_lain'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function apiLaporan(Request $request)
    {
        $pembayaran_semester_det = DB::table('pembayaran_semester_det')
        ->select(
            DB::raw(' transaksis.jenis_transaksi, transaksi_id,
                tanggal_bayar, 
                jumlah_bayar as total_bayar'))
        ->join('transaksis', 
            'transaksis.id', 
            '=', 
            'pembayaran_semester_det.transaksi_id');

        $pendaftaran_det = DB::table('pendaftaran_det')
        ->select(
            DB::raw(' transaksis.jenis_transaksi, transaksi_id, 
                tanggal_bayar, 
                (bayar_pustaka + bayar_alma + bayar_pendaftaran) as total_bayar'))
        ->join('transaksis',
            'transaksis.id',
            '=', 
            'pendaftaran_det.transaksi_id');
        $pemasukan_lains = DB::table('pemasukan_lains')
        ->select(
            DB::raw(' transaksis.jenis_transaksi, transaksi_id, 
                tanggal_bayar, 
                total_bayar'))
        ->join('transaksis',
            'transaksis.id',
            '=', 
            'pemasukan_lains.transaksi_id');
        $pembayaran_gajis = DB::table('pembayaran_gajis')
        ->select(
            DB::raw(' transaksis.jenis_transaksi, transaksi_id, 
                tanggal_bayar, 
                jumlah_gaji as total_bayar'))
        ->join('transaksis',
            'transaksis.id',
            '=', 
            'pembayaran_gajis.transaksi_id');
        $pengeluaran_lains = DB::table('pengeluaran_lains')
        ->select(
            DB::raw(' transaksis.jenis_transaksi, transaksi_id, 
                tanggal_bayar, 
                total_bayar'))
        ->join('transaksis',
            'transaksis.id',
            '=', 
            'pengeluaran_lains.transaksi_id'); 

        $from = $request->get('awal');
        $end = $request->get('akhir');

        if ($from) {
            $pembayaran_gajis = $pembayaran_gajis->where('tanggal_bayar', '>=', $from);
            $pemasukan_lains = $pemasukan_lains->where('tanggal_bayar', '>=', $from);
            $pendaftaran_det = $pendaftaran_det->where('tanggal_bayar', '>=', $from);
            $pembayaran_semester_det = $pembayaran_semester_det->where('tanggal_bayar', '>=', $from);
            $pengeluaran_lains = $pengeluaran_lains->where('tanggal_bayar', '>=', $from);
        }
        if ($end) {
         $pembayaran_gajis = $pembayaran_gajis->where('tanggal_bayar', '<=', $end);
         $pemasukan_lains = $pemasukan_lains->where('tanggal_bayar', '<=', $end);
         $pendaftaran_det = $pendaftaran_det->where('tanggal_bayar', '<=', $end);
         $pembayaran_semester_det = $pembayaran_semester_det->where('tanggal_bayar', '<=', $end);
         $pengeluaran_lains = $pengeluaran_lains->where('tanggal_bayar', '<=', $end);
     }




     $transaksis = $pembayaran_semester_det
     ->union($pendaftaran_det)
     ->union($pemasukan_lains)
     ->union($pembayaran_gajis)
     ->union($pengeluaran_lains);


     $transaksis = $transaksis->orderBy('tanggal_bayar', 'desc')->get();



     $total['pemasukan']   = $transaksis->whereIn('jenis_transaksi', \Config::get('enums.pemasukan'))->sum('total_bayar');
     $total['pengeluaran'] = $transaksis->whereIn('jenis_transaksi', \Config::get('enums.pengeluaran'))->sum('total_bayar');
     $total['seluruhnya']  = $total['pemasukan'] - $total['pengeluaran'];

     $res = array_merge($total, ['data' => $transaksis->toArray()]);
     dd($res);
     return json_encode((object) $res);

 }
}
