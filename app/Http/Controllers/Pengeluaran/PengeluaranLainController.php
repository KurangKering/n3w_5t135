<?php

namespace App\Http\Controllers\Pengeluaran;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pengeluaran_lain;
use App\Pengeluaran;
use App\Transaksi;
use LogHelper;
class PengeluaranLainController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
        $pengeluaran_lains = Pengeluaran_lain::get();
        return view('pengeluaran.pengeluaran_lain.index', compact('pengeluaran_lains'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengeluaran.pengeluaran_lain.tambah');
        
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
            'lampiran' => 'sometimes|file|max:1000',
            'jenis_bayar' => 'required',
            'uraian' => 'required',
            'tanggal_bayar' => 'required',
            'total_bayar' => 'required|numeric',
            'keterangan' => 'required',
        ]);

        $uploadedFile = $request->file('lampiran');  
        $path = $uploadedFile ? $uploadedFile->store('pengeluaran_lain/lampiran') : '';


        $transaksi = new Transaksi();
        $transaksi->jenis_transaksi = "Pengeluaran Lain";
        $transaksi->save();

        

        $pengeluaran_lain                  = new Pengeluaran_lain();
        $pengeluaran_lain->lampiran    = $path;
        $pengeluaran_lain->jenis_bayar    = $request->get('jenis_bayar');
        $pengeluaran_lain->uraian         = $request->get('uraian');
        $pengeluaran_lain->tanggal_bayar  = $request->get('tanggal_bayar');
        $pengeluaran_lain->total_bayar    = $request->get('total_bayar');
        $pengeluaran_lain->keterangan     = $request->get('keterangan');
        $pengeluaran_lain->transaksi_id     = $transaksi->getKey();
        $pengeluaran_lain->save();
        LogHelper::addToLog('Menambah Data Pengeluaran Lain dengan id : '. $pengeluaran_lain->getKey());

        return redirect(route('pengeluaran_lain.index'));
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
        $pengeluaran_lain = Pengeluaran_lain::find($id);
        return view('pengeluaran.pengeluaran_lain.edit', compact('pengeluaran_lain'));

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
        'lampiran' => 'sometimes|file|max:1000',
        'jenis_bayar' => 'required',
        'uraian' => 'required',
        'tanggal_bayar' => 'required',
        'total_bayar' => 'required|numeric',
        'keterangan' => 'required',
    ]);
     $pengeluaran_lain                  = Pengeluaran_lain::find($id);
     $pengeluaran_lain->jenis_bayar    = $request->get('jenis_bayar');
     $pengeluaran_lain->uraian         = $request->get('uraian');
     $pengeluaran_lain->tanggal_bayar  = $request->get('tanggal_bayar');
     $pengeluaran_lain->total_bayar    = $request->get('total_bayar');
     $pengeluaran_lain->keterangan     = $request->get('keterangan');

     if ($request->file('lampiran')) {
       $lampiranLama = $pengeluaran_lain->lampiran;
       $deleteLampiranLama = Storage::delete($lampiranLama);
       $lampiranBaru = $request->file('lampiran');  
       $pathLampiranBaru = $lampiranBaru->store('pengeluaran_lain/lampiran');

       $pengeluaran_lain->lampiran     = $pathLampiranBaru;
   }

   $pengeluaran_lain->save();
   LogHelper::addToLog('Merubah Data Pengeluaran Lain dengan id : '. $pengeluaran_lain->getKey());

   return redirect(route('pengeluaran_lain.index'));

}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengeluaran_lain = Pengeluaran_lain::find($id);
        $pathLampiran = $pengeluaran_lain->lampiran;
        $deleteLampiran = Storage::delete($pathLampiran);

        $pengeluaran_lain->transaksi->delete();
        $pengeluaran_lain->delete();
        LogHelper::addToLog('Menghapus Data Pengeluaran Lain dengan id : '. $pengeluaran_lain->getKey());

        return redirect(route('pengeluaran_lain.index'));
    }

    public function cetakLampiran($id) 
    {
        $pengeluaran_lain = Pengeluaran_lain::findOrFail($id);
        $fileLampiran = storage_path('app/public/'. $pengeluaran_lain->lampiran);
        if (!file_exists($fileLampiran)) {
            return abort(404);
        }
        return response()->file($fileLampiran);
    }
    public function cetakKwitansi($id)
    {
        $transaksi = Pengeluaran_lain::findOrFail($id);

      $kwitansi = new \stdClass();
      $kwitansi->id_transaksi = $transaksi->transaksi_id;
      $kwitansi->tanggal_bayar = $transaksi->tanggal_bayar;
      $kwitansi->nama = '';
      $kwitansi->jenis_transaksi  = $transaksi->transaksi->jenis_transaksi;
      $kwitansi->jumlah_bayar = $transaksi->total_bayar;
      $kwitansi->nama_penerima = \Auth::user()->name;
      $kwitansi->nama_pembayar = '';

      $pdf = \PDF::loadView('kwitansi.template', compact('kwitansi'));

      return $pdf->stream($transaksi->id .'-pemasukan_lain.pdf');

  }
}
