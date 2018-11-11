<?php

namespace App\Http\Controllers\Pemasukan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pembayaran_semester;
use App\Pembayaran_semester_det;
use App\Mahasiswa;
use App\Transaksi;
use App\Pemasukan;
use LogHelper;
class PembayaranSemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $pembayaran_det = Pembayaran_semester_det::with('pembayaran_semester.mahasiswa')->latest()->get();
      return view('pemasukan.pembayaran_semester.index', compact('pembayaran_det'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $mahasiswas = Mahasiswa::all();
      return view('pemasukan.pembayaran_semester.tambah', compact('mahasiswas'));
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
      'semester' => "required",
      'jumlah_bayar' => 'required|numeric',
      'tanggal_bayar' => 'required',
      'status' => 'required',
      'mahasiswa_id' => 'required',
    ]);
     $transaksi = new Transaksi();
     $transaksi->jenis_transaksi = "Pembayaran Semester";
     $transaksi->save();

     $pembayaran = Pembayaran_semester::updateOrCreate(
      [
        'mahasiswa_id' => $request->get('mahasiswa_id'),
        'semester' => $request->get('semester'),
      ], 
      [
        'ket_bayar' => $request->get('status'),
      ]);

     $detail = new Pembayaran_semester_det();
     $detail->jumlah_bayar = $request->get('jumlah_bayar');
     $detail->tanggal_bayar = $request->get('tanggal_bayar');
     $detail->transaksi_id = $transaksi->getKey();
     $detail->pembayaran_semester_id = $pembayaran->getKey();
     $detail->save();
     LogHelper::addToLog('Menambah Data Pembayaran Semester dengan id detail : '. $detail->getKey());
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
      $pembayaran_semester = Pembayaran_semester::find($id);
      return view('pemasukan.pembayaran_semester.detail', compact('pembayaran_semester'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $detail = Pembayaran_semester_det::with('pembayaran_semester.mahasiswa')->findOrFail($id);
      $mahasiswa = Mahasiswa::findOrFail($detail->pembayaran_semester->mahasiswa->id);

      return view('pemasukan.pembayaran_semester.edit', compact('detail', 'mahasiswa'));
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
      'status' => 'required',
      'mahasiswa_id' => 'required',
    ]);

     $detail = Pembayaran_semester_det::findOrFail($id);
     $detail->jumlah_bayar = $request->get('jumlah_bayar');
     $detail->tanggal_bayar = $request->get('tanggal_bayar');
     $detail->save();
     $detail->pembayaran_semester->ket_bayar = $request->get('status');
     $detail->pembayaran_semester->save();

     LogHelper::addToLog('Merubah Data Pembayaran Semester dengan detail id : '. $detail->getKey());

     return redirect(route('pembayaran_semester.index'));
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {



      $detail = Pembayaran_semester_det::with('pembayaran_semester.mahasiswa', 'transaksi')->findOrFail($id);
      $detail->transaksi->delete();
      $detail->delete();

      $pembayaran = Pembayaran_semester::findOrFail($detail->pembayaran_semester->id);
      

      if (empty($pembayaran->pembayaran_semester_det->toArray())) {
        $pembayaran->delete();
      }

      LogHelper::addToLog('Menghapus Data Pembayaran Semester dengan detail id : '. $detail->getKey());
      if ($request->wantsJson()) {
        return response()->json(['success'=> true, 'mahasiswa' => $detail->pembayaran_semester->mahasiswa]);
        
      }
      return redirect(route('pembayaran_semester.index'));
    }

    public function cetakKwitansi($id)
    {
      $transaksi = Pembayaran_semester_det::findOrFail($id);

      $kwitansi = new \stdClass();
      $kwitansi->id_transaksi = $transaksi->transaksi_id;
      $kwitansi->tanggal_bayar = $transaksi->tanggal_bayar;
      $kwitansi->nama = $transaksi->pembayaran_semester->mahasiswa->nama_mhs;
      $kwitansi->jenis_transaksi  = $transaksi->transaksi->jenis_transaksi;
      $kwitansi->jumlah_bayar = $transaksi->jumlah_bayar;
      $kwitansi->nama_penerima = \Auth::user()->name;
      $kwitansi->nama_pembayar = $transaksi->pembayaran_semester->mahasiswa->nama_mhs;

      return view('kwitansi.template', compact('kwitansi'));
      // $pdf = \PDF::loadView('kwitansi.template', compact('kwitansi'));

      // return $pdf->stream($transaksi->pembayaran_semester->mahasiswa->nama_mhs.'-pembayaran_semester.pdf');

    }


    /**
     * url('pemasukan/pembayaran_semester/{mahasiswa_id}/show_data'')
     */
    public function getDataPembayaran($id)
    {
      $mahasiswa = Mahasiswa::with('pembayaran_semesters')->findOrFail($id);
      return $mahasiswa;
      
    }
  }
