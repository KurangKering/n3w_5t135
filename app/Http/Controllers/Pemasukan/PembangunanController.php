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
      $pembangunans = Pembangunan_det::with('pembangunan.mahasiswa')->latest()->get();
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

     $biayaPembangunan = \Config::get('enums.biaya_pembangunan');
     $total = 0;
     $sisaBayar = $biayaPembangunan;
     $jumlah_bayar = $request->get('jumlah_bayar');

     if ($jumlah_bayar == 0) {
      return response()->json(['success' => false, 'msg' => 'Periksa Jumlah Bayar']);

    }
    $pembangunan = Pembangunan::firstOrCreate(
      [
        'mahasiswa_id' => $request->get('mahasiswa_id'),
      ]);

    $pembangunan = Pembangunan::where(['mahasiswa_id' => $request->get('mahasiswa_id')])->first();
    if ($pembangunan) {
      if ($pembangunan->ket_bayar == 'Lunas') {
        return response()->json(['success' => false, 'msg' => 'Data Sudah Lunas']);
      }
      $sisaBayar = $biayaPembangunan - $pembangunan->pembangunan_det->sum('jumlah_bayar');
    }

    if ($jumlah_bayar > $sisaBayar) {
      return response()->json(['success' => false, 'msg' => 'Jumlah bayar lebih besar dari sisa']);

    }

    $transaksi = new Transaksi();

    $transaksi->jenis_transaksi = 'pemasukan';
    $transaksi->detail_transaksi = 2;
    $transaksi->save();

    $total = $pembangunan->pembangunan_det->sum('jumlah_bayar') + $request->get('jumlah_bayar');
    $isLunas = $total == $biayaPembangunan ? 'Lunas' : 'Angsur';


    $detail = new Pembangunan_det();
    $detail->jumlah_bayar = $request->get('jumlah_bayar');
    $detail->tanggal_bayar = $request->get('tanggal_bayar');
    $detail->transaksi_id = $transaksi->getKey();
    $detail->pembangunan_id = $pembangunan->id;
    $detail->status = $isLunas;
    $detail->save();

    $pembangunan->ket_bayar = $isLunas;
    $pembangunan->save();




    $pembangunan->save();




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

      $biayaPembangunan = \Config::get('enums.biaya_pembangunan');
      $total = 0;
      $detail = Pembangunan_det::with('pembangunan.pembangunan_det')->findOrFail($id); 

      $pembangunan = $detail->pembangunan;
      $total = $pembangunan->pembangunan_det->where('id', '!=', $detail->id)->sum('jumlah_bayar');

      $sisa_bayar = $biayaPembangunan - $total;
      return view('pemasukan.pembangunan.edit', compact('detail', 'sisa_bayar'));
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
    ]);

     $detail = Pembangunan_det::findOrFail($id);
     $pembangunan = $detail->pembangunan;

     $jumlahSebagian = $pembangunan->pembangunan_det->where('id', '!=', $id)->sum('jumlah_bayar');
     $jumlahSeluruh = $jumlahSebagian + $request->get('jumlah_bayar');
     $biayaPembangunan = \Config::get('enums.biaya_pembangunan');
     $status = $biayaPembangunan == $jumlahSeluruh ? 'Lunas' : 'Angsur';

     $pembangunan->pembangunan_det->where('status', 'Lunas')->each(function($i) {
      $i->status = 'Angsur';
      $i->save();
    });


     $detail->jumlah_bayar = $request->get('jumlah_bayar');
     $detail->tanggal_bayar = $request->get('tanggal_bayar');
     $detail->status = $status;
     $detail->save();



     $pembangunan->ket_bayar = $status;
     $pembangunan->save();


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
      $newMahasiswa->pembangunan->ket_bayar = 'Angsur';
      $newMahasiswa->pembangunan->save();

      $newMahasiswa->pembangunan->pembangunan_det->where('status', 'Lunas')->each(function($i) {
        $i->status = 'Angsur';
        $i->save();
      });

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
      $kwitansi->nama = $transaksi->pembangunan->mahasiswa->calon_mahasiswa->nama;
      $kwitansi->jenis_transaksi  = $transaksi->transaksi->jenis_transaksi;
      $kwitansi->detail_transaksi  = $transaksi->transaksi->detail_transaksi;

      $kwitansi->jumlah_bayar  = $transaksi->jumlah_bayar;
      $kwitansi->nama_penerima = \Auth::user()->name;
      $kwitansi->nama_pembayar = $transaksi->pembangunan->mahasiswa->calon_mahasiswa->nama;


      return view ('kwitansi.template', compact('kwitansi'));
      // $pdf = \PDF::loadView('kwitansi.template', compact('kwitansi'));

      // return $pdf->stream($transaksi->pendaftaran->mahasiswa->nama_mhs.'-pendaftaran.pdf');

    }




  }
