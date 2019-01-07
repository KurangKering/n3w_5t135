<?php

namespace App\Http\Controllers\Pemasukan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pendaftaran;
use App\Pendaftaran_det;
use App\Mahasiswa;
use App\Calon_mahasiswa;
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


      $pendaftarans = Pendaftaran_det::with('pendaftaran.calon_mahasiswa')->latest()->get();
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
      'bayar_pendaftaran' => 'required|numeric',
      'tanggal_bayar' => 'required',
      'calon_mahasiswa_id' => 'required',
    ]);


     $biayaPendaftaran = \Config::get('enums.biaya_pendaftaran');
     $total = 0;
     $sisaBayar = $biayaPendaftaran;
     $jumlah_bayar = $request->get('bayar_pendaftaran');

     if ($jumlah_bayar == 0) {
      return response()->json(['success' => false, 'msg' => 'Periksa Jumlah Bayar']);

    }
    $pendaftaran = Pendaftaran::firstOrCreate(
      [
        'calon_mahasiswa_id' => $request->get('calon_mahasiswa_id'),
      ]);

    $pendaftaran = Pendaftaran::where(['calon_mahasiswa_id' => $request->get('calon_mahasiswa_id')])->first();
    if ($pendaftaran) {
      if ($pendaftaran->ket_bayar == 'Lunas') {
        return response()->json(['success' => false, 'msg' => 'Data Sudah Lunas']);
      }
      $sisaBayar = $biayaPendaftaran - $pendaftaran->pendaftaran_det->sum('bayar_pendaftaran');
    }

    if ($jumlah_bayar > $sisaBayar) {
      return response()->json(['success' => false, 'msg' => 'Jumlah bayar lebih besar dari sisa']);

    }


    $transaksi = new Transaksi();

    $transaksi->jenis_transaksi = 'pemasukan';
    $transaksi->detail_transaksi = 0;
    $transaksi->save();




    $detail = new Pendaftaran_det();
    $detail->bayar_pendaftaran = $request->get('bayar_pendaftaran');
    $detail->tanggal_bayar = $request->get('tanggal_bayar');
    $detail->transaksi_id = $transaksi->getKey();
    $detail->pendaftaran_id = $pendaftaran->id;
    $detail->save();

    $pendaftaran = $detail->pendaftaran;
    $total = $pendaftaran->pendaftaran_det->sum('bayar_pendaftaran');
    $isLunas = 'Angsur';

    if ($total == $biayaPendaftaran)
    {
      $isLunas = 'Lunas';
    } 
    $pendaftaran->ket_bayar = $isLunas; 
    $pendaftaran->save();

    $detail->status = $isLunas;
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
      $biayaPendaftaran = \Config::get('enums.biaya_pendaftaran');
      $total = 0;

      
      $detail = Pendaftaran_det::with('pendaftaran.pendaftaran_det')->findOrFail($id); 
      $pendaftaran = $detail->pendaftaran;
      $total = $pendaftaran->pendaftaran_det->where('id', '!=', $detail->id)->sum('bayar_pendaftaran');

      $sisa_bayar = $biayaPendaftaran - $total;
      return view('pemasukan.pendaftaran.edit', compact('detail', 'sisa_bayar'));
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
      'bayar_pendaftaran' => 'required|numeric',
      'tanggal_bayar' => 'required',
    ]);
     $detail = Pendaftaran_det::findOrFail($id);
     $detail->bayar_pendaftaran = $request->get('bayar_pendaftaran');
     $detail->tanggal_bayar = $request->get('tanggal_bayar');
     $detail->save();

     $sisa = $request->get('sisa');
     $biayaPendaftaran = \Config::get('enums.biaya_pendaftaran');
     $total = 0;

     $pendaftaran = $detail->pendaftaran;
     $total = $pendaftaran->pendaftaran_det->sum('bayar_pendaftaran');
     $isLunas = $total == $biayaPendaftaran;

     $pendaftaran->pendaftaran_det->each(function($i) {
      $i->status = 'Angsur';
      $i->save();
    });

     if ($isLunas) {
       $pendaftaran->ket_bayar = 'Lunas';
       $detail->status = 'Lunas';
     } else {
      $pendaftaran->ket_bayar = 'Angsur';
    }
    $pendaftaran->save();
    $detail->save();




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


      $mahasiswa = Calon_mahasiswa::with('pendaftaran.pendaftaran_det')->whereHas('pendaftaran.pendaftaran_det', function($i) use($id) {
        $i->where('id', $id );
      })->get()->first();

      

      $detail = $mahasiswa->pendaftaran->pendaftaran_det->where('id',$id)->first();
      $delTransaksi = $detail->transaksi->delete();
      $delDetail = $detail->delete();
      $detail->pendaftaran->ket_bayar = 'Angsur';
      $detail->pendaftaran->save();

      $detail->pendaftaran->pendaftaran_det->each(function($i) {
        $i->status = 'Angsur';
        $i->save();
      });

      $newMahasiswa = Calon_mahasiswa::findOrFail($mahasiswa->id);

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
      $transaksi = Pendaftaran_det::with('pendaftaran.calon_mahasiswa')->findOrFail($id);

      $kwitansi = new \stdClass();
      $kwitansi->id_transaksi = $transaksi->transaksi_id;
      $kwitansi->tanggal_bayar = $transaksi->tanggal_bayar;
      $kwitansi->nama = $transaksi->pendaftaran->calon_mahasiswa->nama;
      $kwitansi->jenis_transaksi  = $transaksi->transaksi->jenis_transaksi;
      $kwitansi->detail_transaksi  = $transaksi->transaksi->detail_transaksi;
      $kwitansi->jumlah_bayar = $transaksi->bayar_pendaftaran;
      $kwitansi->nama_penerima = \Auth::user()->name;
      $kwitansi->nama_pembayar = $transaksi->pendaftaran->calon_mahasiswa->nama;

      return view ('kwitansi.template', compact('kwitansi'));
      // $pdf = \PDF::loadView('kwitansi.template', compact('kwitansi'));

      // return $pdf->stream($transaksi->pendaftaran->mahasiswa->nama_mhs.'-pendaftaran.pdf');

    }




  }
