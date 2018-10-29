<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
// 	return view('welcome');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');





/*
| Baris dibawah ini adalah baris Route:get dimana url dapat dipanggil
| tanpa harus membuat controller terlebih dahulu. langsung panggil
| dengan helper url('link_nya_disini')
 */
Route::get('json/mahasiswa/{id}', function($id){
	return app('App\Mahasiswa')->find($id);
});


/*
| Baris dibawah ini adalah baris Route Group
|
|
 */


Route::group(['middleware' => ['auth']], function() {
	Route::resource('/','DashboardController');
	/*
	| Profil Controller
	 */
	Route::get('api_laporan', 'LaporanController@apiLaporan')->name('api_laporan');
	Route::get('profil', 'ProfilController@index')->name('profil.index');
	Route::get('profil/edit', 'ProfilController@edit')->name('profil.edit');
	Route::post('profil/update', 'ProfilController@update')->name('profil.update');
/*
|	Baris dibawah ini adalah baris Route::get custom json
|
 */
Route::get('jsonDataTables/semua_mahasiswa', 'DataTablesJsonController@semua_mahasiswa');
Route::get('jsonDataTables/semua_pegawai', 'DataTablesJsonController@semua_pegawai');
Route::get('jsonDataTables/semua_pembayaran_semester', 'DataTablesJsonController@semua_pembayaran_semester');


Route::group(['middleware' => ['role:Administrator']], function() {
	Route::resources([
		'users'                         => 'UserController',
		'roles'                         => 'RoleController',
	]);
});

Route::group(['middleware' => ['role:Ketua']], function() {
	Route::resources([
		'laporan'                         => 'LaporanController',
		'history'                     => 'HistoryController',


	]);
});

Route::group(['middleware' => ['role:Member']], function() {

	/**
	 * Route untuk lampiran seluruh transaksi
	 */
	Route::get('pemasukan/pemasukan_lain/{id}/lampiran', 
		'pemasukan\PemasukanLainController@cetakLampiran')
	->name('lampiran.pemasukan_lain');

	Route::get('pengeluaran/pembayaran_gaji/{id}/lampiran', 
		'pengeluaran\PembayaranGajiController@cetakLampiran')
	->name('lampiran.pembayaran_gaji');

	Route::get('pengeluaran/pengeluaran_lain/{id}/lampiran', 
		'pengeluaran\PengeluaranLainController@cetakLampiran')
	->name('lampiran.pengeluaran_lain');


	Route::get('pengeluaran/pengeluaran_lain/{id}/lampiran', 
		'pengeluaran\PengeluaranLainController@cetakLampiran')
	->name('lampiran.pengeluaran_lain');

	/**
	 * Route untuk kwitansi seluruh transaksi
	 * 
	 */
	Route::get('pemasukan/pendaftaran/{id}/kwitansi', 
		'pemasukan\PendaftaranController@cetakKwitansi')
	->name('kwitansi.pendaftaran');

	Route::get('pemasukan/pembayaran_semester/{id}/kwitansi', 
		'pemasukan\PembayaranSemesterController@cetakKwitansi')
	->name('kwitansi.pembayaran_semester');

	Route::get('pemasukan/pemasukan_lain/{id}/kwitansi', 
		'pemasukan\PemasukanLainController@cetakKwitansi')
	->name('kwitansi.pemasukan_lain');

	Route::get('pengeluaran/pembayaran_gaji/{id}/kwitansi', 
		'pengeluaran\PembayaranGajiController@cetakKwitansi')
	->name('kwitansi.pembayaran_gaji');

	Route::get('pengeluaran/pengeluaran_lain/{id}/kwitansi', 
		'pengeluaran\PengeluaranLainController@cetakKwitansi')
	->name('kwitansi.pengeluaran_lain');

	/**
	 *
	 * Route tambahan Pembyaran Semester
	 * 
	 */
	Route::get('pemasukan/pembayaran_semester/{mahasiswa_id}/show_data', 'pemasukan\PembayaranSemesterController@getDataPembayaran');

	
	Route::resources([
		'mahasiswa'                     => 'MahasiswaController',
		'pegawai'                       => 'PegawaiController',
		'pemasukan/pendaftaran'         => 'Pemasukan\PendaftaranController',
		'pemasukan/pembayaran_semester' => 'Pemasukan\PembayaranSemesterController',
		'pemasukan/pemasukan_lain'      => 'Pemasukan\PemasukanLainController',
		'pengeluaran/pembayaran_gaji'   => 'Pengeluaran\PembayaranGajiController',
		'pengeluaran/pengeluaran_lain'  => 'Pengeluaran\PengeluaranLainController',
	]);
});





});	
