<?php

namespace App\Http\Controllers\Pemasukan;

use LogHelper;
use App\Http\Controllers\Controller;
use App\Pustaka_alma;
use App\Pustaka_alma_det;
use App\Transaksi;
use App\Mahasiswa;
use Illuminate\Http\Request;

class PustakaAlmaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



      $pustaka_alma = Pustaka_alma_det::with('pustaka_alma.mahasiswa')->latest()->get();
      return view('pemasukan.pustaka_alma.index', compact('pustaka_alma'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('pemasukan.pustaka_alma.tambah');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

     $this->validate($request, [
      'bayar_pustaka' => 'required|numeric',
      'bayar_alma' => 'required|numeric',
      'tanggal_bayar' => 'required',
      'mahasiswa_id' => 'required',
    ]);

     $biayaPustaka = \Config::get('enums.biaya_pustaka');
     $biayaAlma = \Config::get('enums.biaya_alma');
     $total = 0;
     $sisaBayarPustaka = $biayaPustaka;
     $sisaBayarAlma = $biayaAlma;
     $jumlah_bayar_pustaka = $request->get('bayar_pustaka');
     $jumlah_bayar_alma = $request->get('bayar_alma');

     if ($jumlah_bayar_alma == '0' && $jumlah_bayar_pustaka == '0') {
      return response()->json(['success' => false, 'msg' => 'Periksa Jumlah Bayar']);

    }
    $pustaka_alma = Pustaka_alma::firstOrCreate(
      [
        'mahasiswa_id' => $request->get('mahasiswa_id'),
      ]);

    $pustaka_alma = Pustaka_alma::where(['mahasiswa_id' => $request->get('mahasiswa_id')])->first();

    if ($pustaka_alma) {
      if ($pustaka_alma->ket_bayar == 'Lunas') {
        return response()->json(['success' => false, 'msg' => 'Data Sudah Lunas']);
      }
      $sisaBayarPustaka = $biayaPustaka - $pustaka_alma->pustaka_alma_det->sum('bayar_pustaka');
      $sisaBayarAlma = $biayaAlma - $pustaka_alma->pustaka_alma_det->sum('bayar_alma');
    }

    if ($jumlah_bayar_pustaka > $sisaBayarPustaka) {
      return response()->json(['success' => false, 'msg' => 'max Pembayaran Pustaka '. rupiah($sisaBayarPustaka)]);

    }
    if ($jumlah_bayar_alma > $sisaBayarAlma) {
      return response()->json(['success' => false, 'msg' => 'max Pembayaran Alma '. rupiah($sisaBayarAlma)]);

    }

    $transaksi = new Transaksi();

    $transaksi->jenis_transaksi = 'pemasukan';
    $transaksi->detail_transaksi = 1;
    $transaksi->save();



    $pustaka_alma = Pustaka_alma::firstOrCreate(
      [
        'mahasiswa_id' => $request->get('mahasiswa_id'),
      ], 
      [
      ]);

    $detail = new Pustaka_alma_det();
    $detail->bayar_pustaka = $request->get('bayar_pustaka');
    $detail->bayar_alma = $request->get('bayar_alma');
    $detail->tanggal_bayar = $request->get('tanggal_bayar');
    $detail->transaksi_id = $transaksi->getKey();
    $detail->pustaka_alma_id = $pustaka_alma->id;
    $detail->save();

    $pustaka_alma = $detail->pustaka_alma;
    $totalPustaka = $pustaka_alma->pustaka_alma_det->sum('bayar_pustaka');
    $totalAlma = $pustaka_alma->pustaka_alma_det->sum('bayar_alma');
    $isLunas = 'Angsur';


    if ($totalPustaka == $biayaPustaka && $totalAlma == $biayaAlma)
    {
      $isLunas = 'Lunas';
    } 
    $pustaka_alma->ket_bayar = $isLunas; 
    $pustaka_alma->save();



    $detail->status = $isLunas;
    $detail->save();

    LogHelper::addToLog("Menambah Transaksi Pustaka & Almamater dengan ID : $pustaka_alma->getKey() dan Detail ID = $detail->getKey() ");
    return response()->json(['success' => true]);

  }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $pendaftaran = Pendaftaran::find($id);
      return view('pemasukan.pendaftaran.detail', compact('pendaftaran'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      $detail = Pustaka_alma_det::with('pustaka_alma.pustaka_alma_det')->findOrFail($id); 
      return view('pemasukan.pustaka_alma.edit', compact('detail'));
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

     $this->validate($request, [
      'bayar_pustaka' => 'required|numeric',
      'bayar_alma' => 'required|numeric',
      'tanggal_bayar' => 'required',
    ]);


     $biayaPustaka = \Config::get('enums.biaya_pustaka');
     $biayaAlma = \Config::get('enums.biaya_alma');
     $total = 0;
     $sisaBayarPustaka = $biayaPustaka;
     $sisaBayarAlma = $biayaAlma;
     $jumlah_bayar_pustaka = $request->get('bayar_pustaka');
     $jumlah_bayar_alma = $request->get('bayar_alma');

     if ($jumlah_bayar_alma == '0' && $jumlah_bayar_pustaka == '0') {
      return response()->json(['success' => false, 'msg' => 'Periksa Jumlah Bayar']);
    }
    $pustaka_alma_det = Pustaka_alma_det::find($id);
    $pustaka_alma = $pustaka_alma_det->pustaka_alma;



    if ($pustaka_alma) {
     
      $sisaBayarPustaka = $biayaPustaka - $pustaka_alma->pustaka_alma_det->where('id', '!=', $id)->sum('bayar_pustaka');
      $sisaBayarAlma = $biayaAlma - $pustaka_alma->pustaka_alma_det->where('id', '!=', $id)->sum('bayar_alma');
    }

    if ($jumlah_bayar_pustaka > $sisaBayarPustaka) {
      return response()->json(['success' => false, 'msg' => 'max Pembayaran Pustaka '. rupiah($sisaBayarPustaka)]);

    }
    if ($jumlah_bayar_alma > $sisaBayarAlma) {
      return response()->json(['success' => false, 'msg' => 'max Pembayaran Alma '. rupiah($sisaBayarAlma)]);

    }


    $detail = $pustaka_alma_det;
    $detail->bayar_pustaka = $request->get('bayar_pustaka');
    $detail->bayar_alma = $request->get('bayar_alma');
    $detail->tanggal_bayar = $request->get('tanggal_bayar');
    $detail->save();

    $pustaka_alma = $pustaka_alma->fresh();

    $pustaka_alma->pustaka_alma_det->each(function($i) {
      $i->status = 'Angsur';
      $i->save();
    });

    $totalPustaka = $pustaka_alma->pustaka_alma_det->sum('bayar_pustaka');
    $totalAlma = $pustaka_alma->pustaka_alma_det->sum('bayar_alma');
    $isLunas = 'Angsur';


    if ($totalPustaka == $biayaPustaka && $totalAlma == $biayaAlma)
    {
      $isLunas = 'Lunas';
    } 
    $pustaka_alma->ket_bayar = $isLunas; 
    $pustaka_alma->save();



    $detail->status = $isLunas;
    $detail->save();


    LogHelper::addToLog('Merubah Data Detail Pustaka & Almamater dengan Detail ID : '. $detail->getKey());
    return response()->json(['success' => true, 'msg' => 'Berhasil Merubah Data Pustaka & Almamater']);
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {




      $detail = Pustaka_alma_det::find($id);

      $detail->pustaka_alma->pustaka_alma_det->each(function($i) {
        $i->status = 'Angsur';
        $i->save();
      });

      $detail->pustaka_alma->ket_bayar = 'Angsur';
      $detail->pustaka_alma->save();
      $detail->save();

      $delTransaksi = $detail->transaksi->delete();
      $delDetail = $detail->delete();





      $newPustakaAlma = Pustaka_alma::find($detail->pustaka_alma_id);

      if (empty($newPustakaAlma->pustaka_alma_det->toArray())) {
        $newPustakaAlma->delete();
      }

      LogHelper::addToLog('Menghapus Data Pustaka & Alamamter Detail dengan Detail ID : '. $detail->getKey());

      if ($request->wantsJson()) {
        return response()->json(['success'=> true, 'msg' => 'success']);
        
      }
      return redirect(route("pustaka_alma.index"));

    }

    public function cetakKwitansi($id)
    {
      $transaksi = Pustaka_alma_det::with('pustaka_alma.mahasiswa')->findOrFail($id);

      $kwitansi = new \stdClass();
      $kwitansi->id_transaksi = $transaksi->transaksi_id;
      $kwitansi->tanggal_bayar = $transaksi->tanggal_bayar;
      $kwitansi->nama = $transaksi->pustaka_alma->mahasiswa->calon_mahasiswa->nama;
      $kwitansi->jenis_transaksi  = $transaksi->transaksi->jenis_transaksi;
      $kwitansi->detail_transaksi  = $transaksi->transaksi->detail_transaksi;
      $kwitansi->jumlah_bayar = $transaksi->bayar_alma + $transaksi->bayar_pustaka;
      $kwitansi->nama_penerima = \Auth::user()->name;
      $kwitansi->nama_pembayar = $transaksi->pustaka_alma->mahasiswa->calon_mahasiswa->nama;


      return view ('kwitansi.template', compact('kwitansi'));
      // $pdf = \PDF::loadView('kwitansi.template', compact('kwitansi'));

      // return $pdf->stream($transaksi->pendaftaran->mahasiswa->nama_mhs.'-pendaftaran.pdf');

    }




  }
