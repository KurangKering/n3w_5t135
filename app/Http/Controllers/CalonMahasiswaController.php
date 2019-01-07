<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calon_mahasiswa;
use LogHelper;
class CalonMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

     $calon_mahasiswas = Calon_Mahasiswa::get();
     return view('calon_mahasiswa.index',  compact('calon_mahasiswas'));
 }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('calon_mahasiswa.tambah');
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
        'nisn' => 'required|unique:calon_mahasiswa,nisn',
        'nama' => 'required',
        'program_studi' => 'required',
        'tahun_masuk' => 'required',
        'tempat_lahir' => 'required',
        'tanggal_lahir' => 'required',
        'jenis_kelamin' => 'required',
        'agama' => 'required',
        'asal_sekolah' => 'required',
        'alamat' => 'required',
        'no_hp' => 'required',
        'email' => 'required|email',
    ]);

      $calon_mahasiswa = new Calon_mahasiswa();
      $calon_mahasiswa->nisn = $request->get('nisn');
      $calon_mahasiswa->nama = $request->get('nama');
      $calon_mahasiswa->program_studi = $request->get('program_studi');
      $calon_mahasiswa->tahun_masuk = $request->get('tahun_masuk');
      $calon_mahasiswa->tempat_lahir = $request->get('tempat_lahir');
      $calon_mahasiswa->tanggal_lahir = $request->get('tanggal_lahir');
      $calon_mahasiswa->jenis_kelamin = $request->get('jenis_kelamin');
      $calon_mahasiswa->agama = $request->get('agama');
      $calon_mahasiswa->asal_sekolah = $request->get('asal_sekolah');
      $calon_mahasiswa->alamat = $request->get('alamat');
      $calon_mahasiswa->no_hp = $request->get('no_hp');
      $calon_mahasiswa->email = $request->get('email');
      $calon_mahasiswa->status = '0';

      $calon_mahasiswa->save();
      LogHelper::addToLog('Menambah Data Calon Mahasiswa dengan NISN  : '. $calon_mahasiswa->nisn);
      return redirect(route('calon_mahasiswa.index'));


  }

    /**
     * Show data single mahasiswa beserta data pembayaran semester,
     * route('mahasiswa/show_pembayaran_semester/{mahasiswa_id}')
     * url('mahasiswa/show_pembayaran_semester/{mahasiswa_id}')
     */
    public function show_pembayaran_semester(Request $request, $id) 
    {
      $biayaSemester  = \Config::get('enums.biaya_semester');
      $mahasiswa = Calon_Mahasiswa::with('pembayaran_semester.pembayaran_semester_det')->find($id);
      if ($mahasiswa->pembayaran_semester) {
        $mahasiswa->pembayaran_semester->each(function($iii) use ($biayaSemester) {
          $iii->total = 0;
          $iii->pembayaran_semester_det->each(function($iiii) use($iii) {
            $iiii->tgl_bayar_manusia = indonesian_date($iiii->tanggal_bayar, 'j F Y');
            $iiii->jumlah_bayar_manusia = rupiah($iiii->jumlah_bayar);

            $iii->total += $iiii->jumlah_bayar;
        });
          $iii->total_manusia = rupiah($iii->total);
          $iii->sisa = $biayaSemester - $iii->total;
          $iii->sisa_manusia = rupiah($iii->sisa);
      });
    }

    if ($request->wantsJson())
    {

        return $mahasiswa;
    }

    return $mahasiswa;
      // return view('calon_mahasiswa.detail', compact('mahasiswa'));

}
    /**
     * Show data single mahasiswa beserta data pembangunan,
     * route('mahasiswa/show_pembangunan/{mahasiswa_id}')
     * url('mahasiswa/show_pembangunan/{mahasiswa_id}')
     */
    public function show_pembangunan(Request $request, $id) 
    {

      $mahasiswa = Calon_Mahasiswa::find($id);
      if ($mahasiswa->pembangunan) {
        $mahasiswa->pembangunan->pembangunan_det->each(function($iii) use($mahasiswa) {

          $iii->tgl_bayar_manusia = indonesian_date($iii->tanggal_bayar);
          $iii->jumlah_bayar_manusia = rupiah($iii->jumlah_bayar);

          $mahasiswa->pembangunan->total_angka += $iii->jumlah_bayar;
          $mahasiswa->pembangunan->total += $iii->jumlah_bayar;
      });
        $mahasiswa->pembangunan->total = rupiah($mahasiswa->pembangunan->total);  

    }

    if ($request->wantsJson())
    {

        return $mahasiswa;
    }

    return $mahasiswa;
      // return view('calon_mahasiswa.detail', compact('mahasiswa'));

}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
      $mahasiswa = Calon_Mahasiswa::with('pendaftaran.pendaftaran_det')->find($id);
      if ($mahasiswa->pendaftaran) {
        $mahasiswa->pendaftaran->pendaftaran_det->each(function($iii) use($mahasiswa) {
          $jumlahBayar = $iii->bayar_pustaka+ $iii->bayar_alma + $iii->bayar_pendaftaran;

          $iii->tgl_bayar_manusia = indonesian_date($iii->tanggal_bayar);
          $iii->bayar_pustaka_manusia = rupiah($iii->bayar_pustaka);
          $iii->bayar_alma_manusia = rupiah($iii->bayar_alma);
          $iii->bayar_pendaftaran_manusia = rupiah($iii->bayar_pendaftaran);
          $iii->jumlah_bayar_manusia = rupiah($jumlahBayar);

          $mahasiswa->pendaftaran->total += $jumlahBayar;
      });

        $mahasiswa->pendaftaran->total = rupiah($mahasiswa->pendaftaran->total);  
    }


    if ($request->wantsJson())
    {

        return $mahasiswa;
    }

    return $mahasiswa;
      // return view('calon_mahasiswa.detail', compact('mahasiswa'));
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $mahasiswa = Calon_Mahasiswa::find($id);
      return view('calon_mahasiswa.edit', compact('mahasiswa'));
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
        'nisn' => 'required|unique:calon_mahasiswa,nisn,'.$id,
        'nama' => 'required',
        'program_studi' => 'required',
        'tahun_masuk' => 'required',
        'tempat_lahir' => 'required',
        'tanggal_lahir' => 'required',
        'jenis_kelamin' => 'required',
        'agama' => 'required',
        'asal_sekolah' => 'required',
        'alamat' => 'required',
        'no_hp' => 'required',
        'email' => 'required|email',
    ]);


      $mahasiswa                   = Calon_Mahasiswa::find($id);
      $mahasiswa->nisn              = $request->get('nisn');
      $mahasiswa->nama         = $request->get('nama');
      $mahasiswa->program_studi    = $request->get('program_studi');
      $mahasiswa->tahun_masuk   = $request->get('tahun_masuk');
      $mahasiswa->tempat_lahir     = $request->get('tempat_lahir');
      $mahasiswa->tanggal_lahir    = $request->get('tanggal_lahir');
      $mahasiswa->jenis_kelamin    = $request->get('jenis_kelamin');
      $mahasiswa->agama            = $request->get('agama');
      $mahasiswa->asal_sekolah     = $request->get('asal_sekolah');
      $mahasiswa->alamat           = $request->get('alamat');
      $mahasiswa->no_hp            = $request->get('no_hp');
      $mahasiswa->email            = $request->get('email');

      $mahasiswa->save();
      LogHelper::addToLog('Merubah Data Calon Mahasiswa dengan id_calon_mahasiswa : '. $mahasiswa->getKey());

      return redirect(route('calon_mahasiswa.index'));
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     $mahasiswa = Calon_Mahasiswa::find($id);
     $mahasiswa->delete();
     LogHelper::addToLog('Menghapus Data Mahasiswa dengan id_mahasiswa : '. $mahasiswa->getKey());

     return redirect(route('mahasiswa.index'));

 }

 public function kodok()
 {
    return 'sadfasfas';
}
}
