<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class DiagramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $from = '';
        $end = '';
        return view('diagram.index', compact('from', 'end'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    public function get_data(Request $request)
    {
        $from = $request->get('start');
        $end = $request->get('end');


        $pembayaran_semester_det = DB::table('pembayaran_semester_det')
        ->select(
            DB::raw(' transaksis.jenis_transaksi, transaksis.detail_transaksi, transaksi_id,
                tanggal_bayar,
                jumlah_bayar as total_bayar'))
        ->join('transaksis',
            'transaksis.id',
            '=',
            'pembayaran_semester_det.transaksi_id');

        $pembangunan_det = DB::table('pembangunan_det')
        ->select(
            DB::raw(' transaksis.jenis_transaksi, transaksis.detail_transaksi, transaksi_id,
                tanggal_bayar,
                jumlah_bayar as total_bayar'))
        ->join('transaksis',
            'transaksis.id',
            '=',
            'pembangunan_det.transaksi_id');

        $pendaftaran_det = DB::table('pendaftaran_det')
        ->select(
            DB::raw(' transaksis.jenis_transaksi, transaksis.detail_transaksi, transaksi_id,
                tanggal_bayar,
                bayar_pendaftaran as total_bayar'))
        ->join('transaksis',
            'transaksis.id',
            '=',
            'pendaftaran_det.transaksi_id');

        $pustaka_alma_det = DB::table('pustaka_alma_det')
        ->select(
            DB::raw(' transaksis.jenis_transaksi, transaksis.detail_transaksi, transaksi_id,
                tanggal_bayar,
                (bayar_pustaka + bayar_alma) as total_bayar'))
        ->join('transaksis',
            'transaksis.id',
            '=',
            'pustaka_alma_det.transaksi_id');

        $pemasukan_lains = DB::table('pemasukan_lains')
        ->select(
            DB::raw(' transaksis.jenis_transaksi, transaksis.detail_transaksi, transaksi_id,
                tanggal_bayar,
                total_bayar'))
        ->join('transaksis',
            'transaksis.id',
            '=',
            'pemasukan_lains.transaksi_id');
        $pembayaran_gajis = DB::table('pembayaran_gajis')
        ->select(
            DB::raw(' transaksis.jenis_transaksi, transaksis.detail_transaksi, transaksi_id,
                tanggal_bayar,
                jumlah_gaji as total_bayar'))
        ->join('transaksis',
            'transaksis.id',
            '=',
            'pembayaran_gajis.transaksi_id');
        $pengeluaran_lains = DB::table('pengeluaran_lains')
        ->select(
            DB::raw(' transaksis.jenis_transaksi, transaksis.detail_transaksi, transaksi_id,
                tanggal_bayar,
                total_bayar'))
        ->join('transaksis',
            'transaksis.id',
            '=',
            'pengeluaran_lains.transaksi_id');


        if ($from) {
            $pembayaran_gajis        = $pembayaran_gajis->where('tanggal_bayar', '>=', $from);
            $pemasukan_lains         = $pemasukan_lains->where('tanggal_bayar', '>=', $from);
            $pembangunan_det         = $pembangunan_det->where('tanggal_bayar', '>=', $from);
            $pendaftaran_det         = $pendaftaran_det->where('tanggal_bayar', '>=', $from);
            $pustaka_alma_det        = $pustaka_alma_det->where('tanggal_bayar', '>=', $from);
            $pembayaran_semester_det = $pembayaran_semester_det->where('tanggal_bayar', '>=', $from);
            $pengeluaran_lains       = $pengeluaran_lains->where('tanggal_bayar', '>=', $from);
        }
        if ($end) {
            $pembayaran_gajis        = $pembayaran_gajis->where('tanggal_bayar', '<=', $end);
            $pemasukan_lains         = $pemasukan_lains->where('tanggal_bayar', '<=', $end);
            $pembangunan_det         = $pembangunan_det->where('tanggal_bayar', '<=', $end);
            $pendaftaran_det         = $pendaftaran_det->where('tanggal_bayar', '<=', $end);
            $pustaka_alma_det        = $pustaka_alma_det->where('tanggal_bayar', '<=', $end);
            $pembayaran_semester_det = $pembayaran_semester_det->where('tanggal_bayar', '<=', $end);
            $pengeluaran_lains       = $pengeluaran_lains->where('tanggal_bayar', '<=', $end);
        }

        $transaksis = $pembayaran_semester_det
        ->union($pembangunan_det)
        ->union($pendaftaran_det)
        ->union($pustaka_alma_det)
        ->union($pemasukan_lains)
        ->union($pembayaran_gajis)
        ->union($pengeluaran_lains);

        $transaksis = $transaksis->orderBy('tanggal_bayar', 'desc')->get();
        $total['pemasukan']   = $transaksis->where('jenis_transaksi', 'pemasukan')->sum('total_bayar');
        $total['pengeluaran'] = $transaksis->where('jenis_transaksi', 'pengeluaran')->sum('total_bayar');
        $total['seluruhnya']  = $total['pemasukan'] - $total['pengeluaran'];
        $labels = ['Pemasukan','Pengeluaran'];
        $values = [$total['pemasukan'],$total['pengeluaran']];

        $filled = $total['pemasukan'] == 0 && $total['pengeluaran'] == 0  ? false : true;
        $title = "Diagram Transaksi " . indonesian_date($from) . " Sampai " . indonesian_date($end);
        return response()->json([
            'label' => $labels, 
            'data' => $values, 
            'filled' => $filled, 
            'title' => $title]
        );
    }
}
