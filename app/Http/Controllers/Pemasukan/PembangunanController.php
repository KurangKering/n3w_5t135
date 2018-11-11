<?php

namespace App\Http\Controllers\pemasukan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Transaksi;
use App\Pembangunan;
use App\Pembangunan_det;
use App\Mahasiswa;
use LogHelper;

class PembangunanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
      $pembangunans = Pembangunan_det::with('pembangunan.mahasiswa')->get();
      return view('pemasukan.pembangunan.index', compact('pembangunans'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('pemasukan.pembangunan.tambah');
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
      'jumlah_bayar' => 'required|numeric',
      'tanggal_bayar' => 'required',
      'mahasiswa_id' => 'required',
    ]);


     $transaksi = new Transaksi();
     $transaksi->jenis_transaksi = "Pembangunan";
     $transaksi->save();



     $pembangunan = Pembangunan::updateOrCreate(
      [
        'mahasiswa_id' => $request->get('mahasiswa_id'),
      ], 
      [
        'ket_bayar' => $request->get('ket_bayar'),
      ]);

     $detail = new Pembangunan_det();
     $detail->jumlah_bayar = $request->get('jumlah_bayar');
     $detail->tanggal_bayar = $request->get('tanggal_bayar');
     $detail->transaksi_id = $transaksi->getKey();
     $detail->pembangunan_id = $pembangunan->id;
     $detail->save();
     LogHelper::addToLog("Menambah Transaksi Pembangunan dengan pembangunan_id : $pembangunan->getKey() dan pembangunan_det_id = $detail->getKey() ");
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
      $pembangunan = Pembangunan::find($id);
      return view('pemasukan.pembangunan.detail', compact('pembangunan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      $detail = Pembangunan_det::with('pembangunan.pembangunan_det')->findOrFail($id); 
      return view('pemasukan.pembangunan.edit', compact('detail'));
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
      'jumlah_bayar' => 'required|numeric',
      'tanggal_bayar' => 'required',
      'ket_bayar' => 'required',
    ]);
     $detail = Pembangunan_det::findOrFail($id);
     $detail->jumlah_bayar = $request->get('jumlah_bayar');
     $detail->tanggal_bayar = $request->get('tanggal_bayar');
     $detail->save();
     $detail->pembangunan->ket_bayar = $request->get('ket_bayar');
     $detail->pembangunan->save();
     LogHelper::addToLog('Merubah Data Detail pembangunan dengan pembangunan_det_id : '. $detail->getKey());

     return redirect(route('pembangunan.index'));
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {


      $mahasiswa = Mahasiswa::with('pembangunan.pembangunan_det')->whereHas('pembangunan.pembangunan_det', function($i) use($id) {
        $i->where('id', $id );
      })->get()->first();

      

      $detail = $mahasiswa->pembangunan->pembangunan_det->where('id',$id)->first();
      $delTransaksi = $detail->transaksi->delete();
      $delDetail = $detail->delete();

      $newMahasiswa = Mahasiswa::findOrFail($mahasiswa->id);

      if (empty($newMahasiswa->pembangunan->pembangunan_det->toArray())) {
        $newMahasiswa->pembangunan->delete();
      }

      LogHelper::addToLog('Menghapus Data Pembangunan Detail dengan pembangunan_det_id : '. $detail->getKey());

      if ($request->wantsJson()) {
        return response()->json(['success'=> true, 'mahasiswa' => $mahasiswa]);
        
      }
      return redirect(route("pembangunan.index"));

    }

    public function cetakKwitansi($id)
    {
      $transaksi = Pembangunan_det::with('pembangunan.mahasiswa')->findOrFail($id);

      $kwitansi = new \stdClass();
      $kwitansi->id_transaksi = $transaksi->transaksi_id;
      $kwitansi->tanggal_bayar = $transaksi->tanggal_bayar;
      $kwitansi->nama = $transaksi->pembangunan->mahasiswa->nama_mhs;
      $kwitansi->jenis_transaksi  = $transaksi->transaksi->jenis_transaksi;
      $kwitansi->jumlah_bayar  = $transaksi->jumlah_bayar;
      $kwitansi->nama_penerima = \Auth::user()->name;
      $kwitansi->nama_pembayar = $transaksi->pembangunan->mahasiswa->nama_mhs;


      return view ('kwitansi.template', compact('kwitansi'));
      // $pdf = \PDF::loadView('kwitansi.template', compact('kwitansi'));

      // return $pdf->stream($transaksi->pendaftaran->mahasiswa->nama_mhs.'-pendaftaran.pdf');

    }




  }
