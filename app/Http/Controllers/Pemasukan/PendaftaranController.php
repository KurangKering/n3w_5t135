<?php

namespace App\Http\Controllers\Pemasukan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pendaftaran;
use App\Pendaftaran_det;
use App\Mahasiswa;
use App\Transaksi;
use App\Pemasukan;
use LogHelper;

class PendaftaranController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 


      $pendaftarans = Pendaftaran_det::with('pendaftaran.mahasiswa')->get();
      return view('pemasukan.pendaftaran.index', compact('pendaftarans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('pemasukan.pendaftaran.tambah');
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
      'bayar_pendaftaran' => 'required|numeric',
      'tanggal_bayar' => 'required',
      'mahasiswa_id' => 'required',
    ]);


     $transaksi = new Transaksi();
     $transaksi->jenis_transaksi = "Pendaftaran";
     $transaksi->save();


     
     $pendaftaran = Pendaftaran::updateOrCreate(
      [
        'mahasiswa_id' => $request->get('mahasiswa_id'),
      ], 
      [
        'ket_bayar' => $request->get('ket_bayar'),
      ]);

     $detail = new Pendaftaran_det();
     $detail->bayar_pustaka = $request->get('bayar_pustaka');
     $detail->bayar_alma = $request->get('bayar_alma');
     $detail->bayar_pendaftaran = $request->get('bayar_pendaftaran');
     $detail->tanggal_bayar = $request->get('tanggal_bayar');
     $detail->transaksi_id = $transaksi->getKey();
     $detail->pendaftaran_id = $pendaftaran->id;
     $detail->save();
     LogHelper::addToLog("Menambah Transaksi Pendaftaran dengan pendaftaran_id : $pendaftaran->getKey() dan pendaftaran_det_id = $detail->getKey() ");
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

      $detail = Pendaftaran_det::with('pendaftaran.pendaftaran_det')->findOrFail($id); 
      return view('pemasukan.pendaftaran.edit', compact('detail'));
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
      'bayar_pendaftaran' => 'required|numeric',
      'tanggal_bayar' => 'required',
      'ket_bayar' => 'required',
    ]);
     $detail = Pendaftaran_det::findOrFail($id);
     $detail->bayar_pustaka = $request->get('bayar_pustaka');
     $detail->bayar_alma = $request->get('bayar_alma');
     $detail->bayar_pendaftaran = $request->get('bayar_pendaftaran');
     $detail->tanggal_bayar = $request->get('tanggal_bayar');
     $detail->save();
     $detail->pendaftaran->ket_bayar = $request->get('ket_bayar');
     $detail->pendaftaran->save();
     LogHelper::addToLog('Merubah Data Detail Pendaftaran dengan pendaftaran_det_id : '. $detail->getKey());

     return redirect(route('pendaftaran.index'));
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {


      $mahasiswa = Mahasiswa::with('pendaftaran.pendaftaran_det')->whereHas('pendaftaran.pendaftaran_det', function($i) use($id) {
        $i->where('id', $id );
      })->get()->first();

      

      $detail = $mahasiswa->pendaftaran->pendaftaran_det->where('id',$id)->first();
      $delTransaksi = $detail->transaksi->delete();
      $delDetail = $detail->delete();

      $newMahasiswa = Mahasiswa::findOrFail($mahasiswa->id);

      if (empty($newMahasiswa->pendaftaran->pendaftaran_det->toArray())) {
        $newMahasiswa->pendaftaran->delete();
      }

      LogHelper::addToLog('Menghapus Data Pendaftaran Detail dengan pendaftaran_det_id : '. $detail->getKey());

      if ($request->wantsJson()) {
        return response()->json(['success'=> true, 'mahasiswa' => $mahasiswa]);
        
      }
      return redirect(route("pendaftaran.index"));

    }

    public function cetakKwitansi($id)
    {
      $transaksi = Pendaftaran_det::with('pendaftaran.mahasiswa')->findOrFail($id);

      $kwitansi = new \stdClass();
      $kwitansi->id_transaksi = $transaksi->transaksi_id;
      $kwitansi->tanggal_bayar = $transaksi->tanggal_bayar;
      $kwitansi->nama = $transaksi->pendaftaran->mahasiswa->nama_mhs;
      $kwitansi->jenis_transaksi  = $transaksi->transaksi->jenis_transaksi;
      $kwitansi->jumlah_bayar = $transaksi->bayar_alma + $transaksi->bayar_pustaka + $transaksi->bayar_pendaftaran;
      $kwitansi->nama_penerima = \Auth::user()->name;
      $kwitansi->nama_pembayar = $transaksi->pendaftaran->mahasiswa->nama_mhs;

      $pdf = \PDF::loadView('kwitansi.template', compact('kwitansi'));

      return $pdf->stream($transaksi->pendaftaran->mahasiswa->nama_mhs.'-pendaftaran.pdf');

    }




  }
