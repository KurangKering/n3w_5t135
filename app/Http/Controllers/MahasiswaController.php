<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mahasiswa;
use App\Pembayaran_semester;
use LogHelper;
class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 
    public function index()
    {

     $mahasiswas = Mahasiswa::get();
     return view('mahasiswa.index',  compact('mahasiswas'));
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('mahasiswa.tambah');
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
        'nim' => 'required|unique:mahasiswas,nim',
        'nama_mhs' => 'required',
        'jenis_kelas' => 'required',
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
      $mahasiswa = new Mahasiswa();
      $mahasiswa->nim = $request->get('nim');
      $mahasiswa->nama_mhs = $request->get('nama_mhs');
      $mahasiswa->jenis_kelas = $request->get('jenis_kelas');
      $mahasiswa->program_studi = $request->get('program_studi');
      $mahasiswa->tahun_masuk = $request->get('tahun_masuk');
      $mahasiswa->tempat_lahir = $request->get('tempat_lahir');
      $mahasiswa->tanggal_lahir = $request->get('tanggal_lahir');
      $mahasiswa->jenis_kelamin = $request->get('jenis_kelamin');
      $mahasiswa->agama = $request->get('agama');
      $mahasiswa->asal_sekolah = $request->get('asal_sekolah');
      $mahasiswa->alamat = $request->get('alamat');
      $mahasiswa->no_hp = $request->get('no_hp');
      $mahasiswa->email = $request->get('email');

      $mahasiswa->save();
      LogHelper::addToLog('Menambah Data Mahasiswa dengan id_mahasiswa : '. $mahasiswa->getKey());
      return redirect(route('mahasiswa.index'));


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
      $mahasiswa = Mahasiswa::with('pendaftaran.pendaftaran_det', 'pembayaran_semester.pembayaran_semester_det')->find($id);
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

      if ($mahasiswa->pembayaran_semester) {
        $mahasiswa->pembayaran_semester->each(function($iii) {
         $iii->pembayaran_semester_det->each(function($iiii) {
          $iiii->tgl_bayar_manusia = indonesian_date($iiii->tanggal_bayar);
          $iiii->jumlah_bayar_manusia = rupiah($iiii->jumlah_bayar);
        });
       });
      }

      if ($request->wantsJson())
      {

        return $mahasiswa;
      }

      return $mahasiswa;
      // return view('mahasiswa.detail', compact('mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $mahasiswa = Mahasiswa::find($id);
      return view('mahasiswa.edit', compact('mahasiswa'));
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
        'nim' => 'required|unique:mahasiswas,nim,'.$id,
        'nama_mhs' => 'required',
        'jenis_kelas' => 'required',
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


      $mahasiswa                   = Mahasiswa::find($id);
      $mahasiswa->nim              = $request->get('nim');
      $mahasiswa->nama_mhs         = $request->get('nama_mhs');
      $mahasiswa->jenis_kelas      = $request->get('jenis_kelas');
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
      LogHelper::addToLog('Merubah Data Mahasiswa dengan id_mahasiswa : '. $mahasiswa->getKey());

      return redirect(route('mahasiswa.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     $mahasiswa = Mahasiswa::find($id);
     $mahasiswa->delete();
     LogHelper::addToLog('Menghapus Data Mahasiswa dengan id_mahasiswa : '. $mahasiswa->getKey());

     return redirect(route('mahasiswa.index'));

   }

   public function kodok()
   {
    return 'sadfasfas';
  }
}