<?php

namespace App\Http\Controllers;

use App\Calon_mahasiswa;
use App\Imports\MahasiswaImport;
use App\Mahasiswa;
use App\Pembayaran_semester;
use Illuminate\Http\Request;
use LogHelper;
use Maatwebsite\Excel\Facades\Excel;

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
        return view('mahasiswa.index', compact('mahasiswas'));
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
            'nim'  => 'required|unique:mahasiswas,nim',
            'nisn' => 'required',
        ]);
        $calon     = Calon_mahasiswa::where('nisn', $request->get('nisn'))->first();
        $mahasiswa = Mahasiswa::where('calon_mahasiswa_id', $calon->id)->get();

        if (count($mahasiswa) > 0) {
            return response()->json(['success' => false, 'msg' => 'Duplikat Data']);
        }
        if ($calon) {
            $mahasiswa                     = new Mahasiswa();
            $mahasiswa->nim                = $request->get('nim');
            $mahasiswa->calon_mahasiswa_id = $calon->id;
            $mahasiswa->status_mahasiswa   = 1;
            $mahasiswa->save();

            $calon->status = 1;
            $calon->save();

            LogHelper::addToLog('Menambah Data Mahasiswa dengan id_mahasiswa : ' . $mahasiswa->getKey());
            return response()->json(['success' => true, 'msg' => 'Berhasil Menambah Data Mahasiswa']);

        } else {
            return response()->json(['success' => false, 'msg' => 'NISN not Found !!!']);

        }

    }

    /**
     * Show data single mahasiswa beserta data pembayaran semester,
     * route('mahasiswa/show_pembayaran_semester/{mahasiswa_id}')
     * url('mahasiswa/show_pembayaran_semester/{mahasiswa_id}')
     */
    public function show_pembayaran_semester(Request $request, $id)
    {
        $biayaSemester = \Config::get('enums.biaya_semester');
        $mahasiswa     = Mahasiswa::with('pembayaran_semester.pembayaran_semester_det')->find($id);
        if ($mahasiswa->pembayaran_semester) {
            $mahasiswa->pembayaran_semester->each(function ($iii) use ($biayaSemester) {
                $iii->total = 0;
                $iii->pembayaran_semester_det->each(function ($iiii) use ($iii) {
                    $iiii->tgl_bayar_manusia    = indonesian_date($iiii->tanggal_bayar, 'j F Y');
                    $iiii->jumlah_bayar_manusia = rupiah($iiii->jumlah_bayar);

                    $iii->total += $iiii->jumlah_bayar;
                });
                $iii->total_manusia = rupiah($iii->total);
                $iii->sisa          = $biayaSemester - $iii->total;
                $iii->sisa_manusia  = rupiah($iii->sisa);
            });
        }

        if ($request->wantsJson()) {

            return $mahasiswa;
        }

        return $mahasiswa;
        // return view('mahasiswa.detail', compact('mahasiswa'));

    }
    /**
     * Show data single mahasiswa beserta data pembangunan,
     * route('mahasiswa/show_pembangunan/{mahasiswa_id}')
     * url('mahasiswa/show_pembangunan/{mahasiswa_id}')
     */
    public function show_pembangunan(Request $request, $id)
    {

        $mahasiswa = Mahasiswa::find($id);
        if ($mahasiswa->pembangunan) {
            $mahasiswa->pembangunan->pembangunan_det->each(function ($iii) use ($mahasiswa) {

                $iii->tgl_bayar_manusia    = indonesian_date($iii->tanggal_bayar);
                $iii->jumlah_bayar_manusia = rupiah($iii->jumlah_bayar);

                $mahasiswa->pembangunan->total_angka += $iii->jumlah_bayar;
                $mahasiswa->pembangunan->total += $iii->jumlah_bayar;
            });
            $mahasiswa->pembangunan->total = rupiah($mahasiswa->pembangunan->total);

        }

        if ($request->wantsJson()) {

            return $mahasiswa;
        }

        return $mahasiswa;
        // return view('mahasiswa.detail', compact('mahasiswa'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::with('calon_mahasiswa', 'pembayaran_semester.pembayaran_semester_det', 'pustaka_alma.pustaka_alma_det')->find($id);
        if ($mahasiswa->pendaftaran) {
            $mahasiswa->pendaftaran->pendaftaran_det->each(function ($iii) use ($mahasiswa) {
                $jumlahBayar = $iii->bayar_pustaka + $iii->bayar_alma + $iii->bayar_pendaftaran;

                $iii->tgl_bayar_manusia         = indonesian_date($iii->tanggal_bayar);
                $iii->bayar_pustaka_manusia     = rupiah($iii->bayar_pustaka);
                $iii->bayar_alma_manusia        = rupiah($iii->bayar_alma);
                $iii->bayar_pendaftaran_manusia = rupiah($iii->bayar_pendaftaran);
                $iii->jumlah_bayar_manusia      = rupiah($jumlahBayar);

                $mahasiswa->pendaftaran->total += $jumlahBayar;
            });

            $mahasiswa->pendaftaran->total = rupiah($mahasiswa->pendaftaran->total);
        }

        if ($mahasiswa->pembayaran_semester) {
            $mahasiswa->pembayaran_semester->each(function ($iii) {
                $iii->total = 0;
                $iii->pembayaran_semester_det->each(function ($iiii) use ($iii) {
                    $iiii->tgl_bayar_manusia    = indonesian_date($iiii->tanggal_bayar);
                    $iiii->jumlah_bayar_manusia = rupiah($iiii->jumlah_bayar);

                    $iii->total += $iiii->jumlah_bayar;
                });
                $iii->total_manusia = rupiah($iii->total);
            });
        }
        if ($mahasiswa->pembangunan) {
            $mahasiswa->pembangunan->pembangunan_det->each(function ($iii) use ($mahasiswa) {

                $iii->tgl_bayar_manusia    = indonesian_date($iii->tanggal_bayar);
                $iii->jumlah_bayar_manusia = rupiah($iii->jumlah_bayar);

                $mahasiswa->pembangunan->total_angka += $iii->jumlah_bayar;
                $mahasiswa->pembangunan->total += $iii->jumlah_bayar;
            });
            $mahasiswa->pembangunan->total = rupiah($mahasiswa->pembangunan->total);

        }

        if ($mahasiswa->pustaka_alma) {
            $mahasiswa->pustaka_alma->pustaka_alma_det->each(function ($iii) use ($mahasiswa) {
                $jumlahBayarPustaka = $iii->bayar_pustaka;
                $jumlahBayarAlma    = $iii->bayar_alma;

                $iii->tgl_bayar_manusia     = indonesian_date($iii->tanggal_bayar);
                $iii->bayar_pustaka_manusia = rupiah($iii->bayar_pustaka);
                $iii->bayar_alma_manusia    = rupiah($iii->bayar_alma);

                $mahasiswa->pustaka_alma->totalPustaka += $jumlahBayarPustaka;
                $mahasiswa->pustaka_alma->totalAlma += $jumlahBayarAlma;
            });

            $mahasiswa->pustaka_alma->totalPustaka = rupiah($mahasiswa->pustaka_alma->totalPustaka);
            $mahasiswa->pustaka_alma->totalAlma    = rupiah($mahasiswa->pustaka_alma->totalAlma);
        }

        if ($request->wantsJson()) {

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
            'nim'           => 'required|unique:mahasiswas,nim,' . $id,
            'nama'          => 'required',
            'program_studi' => 'required',
            'tahun_masuk'   => 'required',
            'tempat_lahir'  => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'agama'         => 'required',
            'asal_sekolah'  => 'required',
            'alamat'        => 'required',
            'no_hp'         => 'required',
            'email'         => 'required|email',
        ]);

        $mahasiswa                   = Mahasiswa::find($id);
        $mahasiswa->nim              = $request->get('nim');
        $mahasiswa->status_mahasiswa = $request->get('status_mahasiswa');
        $mahasiswa->save();

        $mahasiswa->calon_mahasiswa->nama          = $request->get('nama');
        $mahasiswa->calon_mahasiswa->program_studi = $request->get('program_studi');
        $mahasiswa->calon_mahasiswa->tahun_masuk   = $request->get('tahun_masuk');
        $mahasiswa->calon_mahasiswa->tempat_lahir  = $request->get('tempat_lahir');
        $mahasiswa->calon_mahasiswa->tanggal_lahir = $request->get('tanggal_lahir');
        $mahasiswa->calon_mahasiswa->jenis_kelamin = $request->get('jenis_kelamin');
        $mahasiswa->calon_mahasiswa->agama         = $request->get('agama');
        $mahasiswa->calon_mahasiswa->asal_sekolah  = $request->get('asal_sekolah');
        $mahasiswa->calon_mahasiswa->alamat        = $request->get('alamat');
        $mahasiswa->calon_mahasiswa->no_hp         = $request->get('no_hp');
        $mahasiswa->calon_mahasiswa->email         = $request->get('email');

        $mahasiswa->calon_mahasiswa->save();
        LogHelper::addToLog('Merubah Data Mahasiswa dengan id_mahasiswa : ' . $mahasiswa->getKey());

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
        LogHelper::addToLog('Menghapus Data Mahasiswa dengan id_mahasiswa : ' . $mahasiswa->getKey());

        return redirect(route('mahasiswa.index'));

    }

    public function import(Request $request)
    {
        $file = $request->file('file-excel');

        $collection = Excel::toCollection(new MahasiswaImport, $file);
        $mahasiswas = $collection[0];

        $response = [];
        foreach ($mahasiswas as $k => $mahasiswa) {
            if ($k == 0) {
                continue;
            }

            $nisn = $mahasiswa[0];
            $nama = $mahasiswa[1];
            $nim  = $mahasiswa[2];

            $resp['success'] = true;
            $resp['nisn']    = $nisn;
            $resp['nama']    = $nama;
            try {

                if ($nim == null) {
                    throw new \Exception('NIM tidak boleh kosong');

                }
                $calon = Calon_mahasiswa::where('nisn', $nisn)->first();
                if (!$calon) {
                    throw new \Exception('NISN tidak ada dalam record');
                }

                $mahasiswa = Mahasiswa::where('calon_mahasiswa_id', $calon->id)->first();

                if ($mahasiswa) {
                    throw new \Exception('Duplikat NISN');
                }

                $mahasiswa = Mahasiswa::where('nim', $nim)->first();

                if ($mahasiswa) {
                    throw new \Exception('Duplikat NIM');
                }

                $mahasiswa                     = new Mahasiswa();
                $mahasiswa->nim                = $nim;
                $mahasiswa->calon_mahasiswa_id = $calon->id;
                $mahasiswa->status_mahasiswa   = 1;
                $mahasiswa->save();

                $calon->status = 1;
                $calon->save();

                LogHelper::addToLog('Menambah Data Mahasiswa dengan id_mahasiswa : ' . $mahasiswa->getKey());

                $resp['success'] = true;
                $resp['msg']     = 'Berhasil Menambah Data';

            } catch (\Exception $e) {

                $resp['success'] = false;
                $resp['msg']     = $e->getMessage();
            }

            $response[] = $resp;

        }

        return response()->json($response);

    }
}
