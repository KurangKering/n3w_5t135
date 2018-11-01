<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pegawai;
use LogHelper;
class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    	$pegawais = Pegawai::get();
    	return view('pegawai.index',  compact('pegawais'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('pegawai.tambah');
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
            'nip' => 'required|unique:pegawais,nip',
            'nama_pegawai' => 'required',
            'jabatan' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email',

        ]);
        $pegawai                  = new Pegawai();
        $pegawai->nip           = $request->get('nip');
        $pegawai->nama_pegawai  = $request->get('nama_pegawai');
        $pegawai->jabatan       = $request->get('jabatan');
        $pegawai->tempat_lahir  = $request->get('tempat_lahir');
        $pegawai->tanggal_lahir = $request->get('tanggal_lahir');
        $pegawai->jenis_kelamin = $request->get('jenis_kelamin');
        $pegawai->agama         = $request->get('agama');
        $pegawai->no_hp         = $request->get('no_hp');
        $pegawai->email         = $request->get('email');
        $pegawai->save();
        LogHelper::addToLog('Menambah Data Pegawai dengan id_pegawai : '. $pegawai->getKey());

        return redirect(route('pegawai.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
    	$pegawai = Pegawai::findOrFail($id);
        $pegawai->tanggal_lahir_manusia = indonesian_date($pegawai->tanggal_lahir);
        if ($request->wantsJson()) {
            return $pegawai;
        }
    	return view('pegawai.detail', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$pegawai = Pegawai::find($id);
    	return view('pegawai.edit', compact('pegawai'));
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
        'nip' => 'required|unique:pegawais,nip,'. $id,
        'nama_pegawai' => 'required',
        'jabatan' => 'required',
        'tempat_lahir' => 'required',
        'tanggal_lahir' => 'required',
        'jenis_kelamin' => 'required',
        'agama' => 'required',
        'no_hp' => 'required',
        'email' => 'required|email',

    ]);

       $pegawai                  = Pegawai::find($id);
       $pegawai->nip           = $request->get('nip');
       $pegawai->nama_pegawai  = $request->get('nama_pegawai');
       $pegawai->jabatan       = $request->get('jabatan');
       $pegawai->tempat_lahir  = $request->get('tempat_lahir');
       $pegawai->tanggal_lahir = $request->get('tanggal_lahir');
       $pegawai->jenis_kelamin = $request->get('jenis_kelamin');
       $pegawai->agama         = $request->get('agama');
       $pegawai->no_hp         = $request->get('no_hp');
       $pegawai->email         = $request->get('email');
       $pegawai->save();
       LogHelper::addToLog('Merubah Data Pegawai dengan id_pegawai : '. $pegawai->getKey());

       return redirect(route('pegawai.index'));
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$pegawai = Pegawai::find($id);
    	$pegawai->delete();
        LogHelper::addToLog('Menghapus Data Pegawai dengan id_pegawai : '. $pegawai->getKey());

        return redirect(route('pegawai.index'));
    }
}
