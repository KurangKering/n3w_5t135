<?php

namespace App\Http\Controllers\Pengeluaran;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pembayaran_gaji;
use App\Pegawai;
use App\Transaksi;
use App\Pengeluaran;
use LogHelper;
class PembayaranGajiController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
        $pembayaran_gajis = Pembayaran_gaji::get();

        return view('pengeluaran.pembayaran_gaji.index', compact('pembayaran_gajis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('pengeluaran.pembayaran_gaji.tambah', compact('pegawais'));
        
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
            'tanggal_bayar' => 'required',
            'jumlah_gaji' => 'required|numeric',
            'uraian' => 'required',
            'pegawai_id' => 'required',
        ]);

        $uploadedFile = $request->file('lampiran');  
        $path = $uploadedFile ? $uploadedFile->store('pembayaran_gaji/lampiran') : '';

        $transaksi = new Transaksi();
        $transaksi->jenis_transaksi = 'pengeluaran';
        $transaksi->detail_transaksi = 0;
        $transaksi->save();



        $pembayaran_gaji = new Pembayaran_gaji();
        $pembayaran_gaji->lampiran = $path;
        $pembayaran_gaji->tanggal_bayar = $request->get('tanggal_bayar');
        $pembayaran_gaji->jumlah_gaji = $request->get('jumlah_gaji');
        $pembayaran_gaji->uraian = $request->get('uraian');
        $pembayaran_gaji->pegawai_id = $request->get('pegawai_id');
        $pembayaran_gaji->transaksi_id = $transaksi->getKey();
        $pembayaran_gaji->save();
        LogHelper::addToLog('Menambah Data Pembayaran Gaji dengan id : '. $pembayaran_gaji->getKey());

        return redirect(route('pembayaran_gaji.index'));
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
       $pembayaran_gaji = Pembayaran_gaji::find($id);
       return view('pengeluaran.pembayaran_gaji.edit', compact('pembayaran_gaji'));
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
        'tanggal_bayar' => 'required',
        'jumlah_gaji' => 'required|numeric',
        'uraian' => 'required',
    ]);


       $pembayaran_gaji = Pembayaran_gaji::find($id);
       $pembayaran_gaji->tanggal_bayar = $request->get('tanggal_bayar');
       $pembayaran_gaji->jumlah_gaji = $request->get('jumlah_gaji');
       $pembayaran_gaji->uraian = $request->get('uraian');


       if ($request->file('lampiran')) {
         $lampiranLama = $pembayaran_gaji->lampiran;
         $deleteLampiranLama = Storage::delete($lampiranLama);
         $lampiranBaru = $request->file('lampiran');  
         $pathLampiranBaru = $lampiranBaru->store('pembayaran_gaji/lampiran');
         $pembayaran_gaji->lampiran     = $pathLampiranBaru;
     }


     $pembayaran_gaji->save();
     LogHelper::addToLog('Merubah Data Pembayaran Gaji dengan id : '. $pembayaran_gaji->getKey());

     return redirect(route('pembayaran_gaji.index'));
 }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pembayaran_gaji = Pembayaran_gaji::find($id);
        $pathLampiran = $pembayaran_gaji->lampiran;
        $deleteLampiran = Storage::delete($pathLampiran);
        
        $pembayaran_gaji->transaksi->delete();
        $pembayaran_gaji->delete();
        LogHelper::addToLog('Menghapus Data Pembayaran Gaji dengan id : '. $pembayaran_gaji->getKey());

        return redirect(route('pembayaran_gaji.index'));
    }

    public function cetakLampiran($id) 
    {
        $pembayaran_gaji = Pembayaran_gaji::findOrFail($id);
        $fileLampiran = storage_path('app/public/'. $pembayaran_gaji->lampiran);
        if (!file_exists($fileLampiran)) {
            return abort(404);
        }
        return response()->file($fileLampiran);
    }
    public function cetakKwitansi($id)
    {
        $transaksi = Pembayaran_gaji::findOrFail($id);

        $kwitansi = new \stdClass();
        $kwitansi->id_transaksi = $transaksi->transaksi_id;
        $kwitansi->tanggal_bayar = $transaksi->tanggal_bayar;
        $kwitansi->nama = $transaksi->pegawai->nama_pegawai;
        $kwitansi->jenis_transaksi  = $transaksi->transaksi->jenis_transaksi;
        $kwitansi->detail_transaksi  = $transaksi->transaksi->detail_transaksi;

        $kwitansi->jumlah_bayar = $transaksi->jumlah_gaji;
        $kwitansi->nama_penerima = \Auth::user()->name;
        $kwitansi->nama_pembayar = $transaksi->pegawai->nama_pegawai;

        return view('kwitansi.template', compact('kwitansi'));
        // $pdf = \PDF::loadView('kwitansi.template', compact('kwitansi'));

        // return $pdf->stream($transaksi->id .'-pembayaran_semester.pdf');

    }
}
