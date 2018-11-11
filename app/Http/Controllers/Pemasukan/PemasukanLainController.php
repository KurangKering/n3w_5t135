<?php

namespace App\Http\Controllers\Pemasukan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pemasukan_lain;
use App\Pemasukan;
use App\Transaksi;
use LogHelper;
use App\User;
use DB;
class PemasukanLainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemasukan_lains = Pemasukan_lain::paginate(10);
        return view('pemasukan.pemasukan_lain.index', compact('pemasukan_lains'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('pemasukan.pemasukan_lain.tambah');

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
        $path = $uploadedFile ? $uploadedFile->store('pemasukan_lain/lampiran') : '';

        $jenis = $request->get('jenis_bayar');
        $transaksi = new Transaksi();
        $transaksi->jenis_transaksi = "Pemasukan Lain";
        $transaksi->save();



        $pemasukan_lain                  = new Pemasukan_lain();
        $pemasukan_lain->lampiran       = $path;
        $pemasukan_lain->jenis_bayar    = $request->get('jenis_bayar');
        $pemasukan_lain->uraian         = $request->get('uraian');
        $pemasukan_lain->tanggal_bayar  = $request->get('tanggal_bayar');
        $pemasukan_lain->total_bayar    = $request->get('total_bayar');
        $pemasukan_lain->keterangan     = $request->get('keterangan');
        $pemasukan_lain->transaksi_id     = $transaksi->getKey();
        $pemasukan_lain->save();
        LogHelper::addToLog('Menambah Data Pemasukan lain dengan id : '. $pemasukan_lain->getKey());

        return redirect(route('pemasukan_lain.index'));
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

        $pemasukan_lain = Pemasukan_lain::find($id);
        return view('pemasukan.pemasukan_lain.edit', compact('pemasukan_lain'));
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

            // 'lampiran' => 'sometimes|file|max:1000',
            'jenis_bayar' => 'required',
            'uraian' => 'required',
            'tanggal_bayar' => 'required',
            'total_bayar' => 'required|numeric',
            'keterangan' => 'required',
        ]);
        $path = '';


        $pemasukan_lain                  = Pemasukan_lain::find($id);
        $pemasukan_lain->jenis_bayar    = $request->get('jenis_bayar');
        $pemasukan_lain->uraian         = $request->get('uraian');
        $pemasukan_lain->tanggal_bayar  = $request->get('tanggal_bayar');
        $pemasukan_lain->total_bayar    = $request->get('total_bayar');
        $pemasukan_lain->keterangan     = $request->get('keterangan');

        if ($request->file('lampiran')) {
            $lampiranLama = $pemasukan_lain->lampiran;
            $deleteLampiranLama = Storage::delete($lampiranLama);
            $lampiranBaru = $request->file('lampiran');  
            $pathLampiranBaru = $lampiranBaru->store('pemasukan_lain/lampiran');
            $pemasukan_lain->lampiran     = $pathLampiranBaru;
        }




        $pemasukan_lain->save();

        LogHelper::addToLog('Merubah Data Pemasukan lain dengan id : '. $pemasukan_lain->getKey());

        return redirect(route('pemasukan_lain.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pemasukan_lain = Pemasukan_lain::find($id);
        $pathLampiran = $pemasukan_lain->lampiran;
        $deleteLampiran = Storage::delete($pathLampiran);

        
        $pemasukan_lain->transaksi->delete();
        $pemasukan_lain->delete();
        LogHelper::addToLog('Menghapus Data Pemasukan lain dengan id : '. $pemasukan_lain->getKey());

        return redirect(route('pemasukan_lain.index'));
    }

    public function cetakLampiran($id) 
    {
        $pemasukan = Pemasukan_lain::findOrFail($id);
        $fileLampiran = storage_path('app/public/'. $pemasukan->lampiran);
        return response()->file($fileLampiran, ['Content-Type' => 'application/json']);
    }

    public function cetakKwitansi($id)
    {
      $transaksi = Pemasukan_lain::findOrFail($id);

      $kwitansi = new \stdClass();
      $kwitansi->id_transaksi = $transaksi->transaksi_id;
      $kwitansi->tanggal_bayar = $transaksi->tanggal_bayar;
      $kwitansi->nama = '';
      $kwitansi->jenis_transaksi  = $transaksi->jenis_transaksi;
      $kwitansi->jumlah_bayar = $transaksi->total_bayar;
      $kwitansi->nama_penerima = \Auth::user()->name;
      $kwitansi->nama_pembayar = '';

      return view('kwitansi.template', compact('kwitansi'));
      // $pdf = \PDF::loadView('kwitansi.template', compact('kwitansi'));

      // return $pdf->stream($transaksi->id .'-pemasukan_lain.pdf');

  }

}
