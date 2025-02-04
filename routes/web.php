<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
  return view('layouts/screen');
    // return view('layouts/master');
});

Route::get('/login', function () {
  return view('auth/login');
    // return view('layouts/master');
});

// Route untuk search No.KP pegawai dan maklumat pegawai
Route::post('/search', 'PemohonController@search')->name('pemohon.search');
Route::get('/search/{id?}', 'PemohonController@search')->name('pemohon.search'); //home button dari page semak
// Route untuk simpan data pemohon
// Route::post('/search/store', 'PenggunaController@storePemohon')->name('pemohon.store');

// Modul pemohon untuk tempahan kenderaan
Route::get('/pemohon/tempahankenderaan/{id}', 'PemohonController@tambah_tempahankenderaan')->name('pemohon.tambah_tempahankenderaan');
Route::post('/pemohon/tempahankenderaan/simpan/{id}', 'PemohonController@simpant_tempahankenderaan')->name('pemohon.simpant_tempahankenderaan');
Route::get('/pemohon/tempahankenderaan/butiran/{id}', 'PemohonController@butiran_tempahankenderaan')->name('pemohon.butiran_tempahankenderaan');
Route::get('/pemohon/tempahankenderaan/kemaskini/{id}', 'PemohonController@kemaskini_tempahankenderaan')->name('pemohon.kemaskini_tempahankenderaan');
Route::post('/pemohon/tempahankenderaan/kemaskini/simpan/{id}', 'PemohonController@simpank_tempahankenderaan')->name('pemohon.simpank_tempahankenderaan');
Route::get('/pemohon/tempahankenderaan/batal/{id}', 'PemohonController@batal_tempahankenderaan')->name('pemohon.batal_tempahankenderaan');
Route::post('/pemohon/tempahankenderaan/batal/{id}', 'PemohonController@simpanb_tempahankenderaan')->name('pemohon.simpanb_tempahankenderaan');
Route::post('/pemohon/tempahankenderaan/sahkan/{id}', 'PemohonController@sah_tempahankenderaan')->name('pemohon.sah_tempahankenderaan');

// Modul pemohon untuk tempahan bilik
Route::get('cariBilik', 'PemohonBilikController@cariBilik')->name('cariBilik');//route tuk search bilik tapis
Route::get('/pemohon/tempahanbilik/{id}', 'PemohonBilikController@tambah_tempahanbilik')->name('pemohon.tambah_tempahanbilik'); // route to calendar main page
Route::post('/pemohon/tempahanbilik/{id}', 'PemohonBilikController@tambah_tempahanbilik')->name('pemohon.tambah_tempahanbilik'); // route to calendar main page for search filter
Route::get('/pemohon/tempahanbilik/tambah_bilik/{id}', 'PemohonBilikController@tambah_bilik')->name('pemohon.tambah_bilik');//route ke page form tempah bilik
Route::post('/pemohon/tempahanbilik/simpan_bilik/{nokp}', 'PemohonBilikController@simpan_bilik')->name('pemohon.simpan_bilik'); //route tuk simpan data tempahan bilik
Route::get('/pemohon/tempahanbilik/tambah_makanan/{id}', 'PemohonBilikController@tambah_makanan')->name('pemohon.tambah_makanan'); //route tuk ke form tempahan makanan
Route::get('/pemohon/tempahanbilik/hapus_makanan/{id}', 'PemohonBilikController@hapus_makanan')->name('pemohon.hapus_makanan'); //route tuk buang data tempahan makanan
Route::post('/pemohon/tempahanbilik/simpan_makanan/{id}', 'PemohonBilikController@simpan_makanan')->name('pemohon.simpan_makanan'); //route tuk simpan data tempahan makanan
Route::get('/pemohon/tempahanbilik/butiran/{id}/{id2}', 'PemohonBilikController@butiran_tempahanbilik')->name('pemohon.butiran_tempahanbilik'); //route untuk tngok butiran tempahan
Route::get('/pemohon/tempahanbilik/kemaskini/{id}', 'PemohonBilikController@kemaskini_tempahanbilik')->name('pemohon.kemaskini_tempahanbilik'); //route kemaskini tempahan bilik
Route::post('/pemohon/tempahanbilik/kemaskini/simpan/{id}', 'PemohonBilikController@simpanK_tempahanbilik')->name('pemohon.simpanK_tempahanbilik'); //simpan kemaskini tempahan
Route::get('/pemohon/tempahanbilik/batal/{id}', 'PemohonBilikController@batal_tempahanbilik')->name('pemohon.batal_tempahanbilik'); //ke page untuk confem batal tempahan
Route::post('/pemohon/tempahanbilik/batal/{id}', 'PemohonBilikController@simpanb_tempahanbilik')->name('pemohon.simpanb_tempahanbilik'); //batal tempahan
Route::get('/pemohon/lihatbilik/', 'PemohonBilikController@lihat_bilik')->name('pemohon.lihat_bilik'); //route ke lihat maklumat bilik
Route::post('/pemohon/lihatbilik/', 'PemohonBilikController@lihat_bilik')->name('pemohon.lihat_bilik'); //route post untuk tapis senarai 


//Modul Fullcalender
route::get('/calendar', 'FullCalendarController@index')->name('pemohon.calendar');
route::post('/pemohon/calendar/butiran', 'FullCalendarController@butiran_bilikcalendar')->name('pemohon.butiran_bilikcalendar');



Route::get('/pemohon/penilaian/{id}', 'PemohonController@penilaiankenderaan')->name('pemohon.penilaian');
Route::post('/pemohon/penilaian/{id}', 'PemohonController@simpan_penilaiankenderaan')->name('pemohon.penilaian');
Route::get('/pemandu/catatan/{id}', 'PemohonController@catatanpemandu')->name('pemandu.catatan');
Route::post('/pemandu/catatan/{id}', 'PemohonController@simpan_catatanpemandu')->name('pemandu.catatan');
 
//Pemohon semak status permohonan
Route::get('/pemohon/semak/{id}', 'PemohonController@semak')->name('pemohon.semak');


Route::get('/status', function () {
  return view('layouts/status');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function(){
  Route::get('/check', 'HomeController@check')->name('check');
  Route::get('/home', 'HomeController@index')->name('home');
  Route::get('/homeBilikMeet', 'HomeController@home')->name('homeBilikMeet');


  Route::get('/clock', 'HomeController@clock')->name('cariKenclockderaan');
  //Route::get('/home', 'HomeController@index')->name('home');

  Route::get('sendemail/{id}','TempahanKenderaanController@test');
  Route::get('send-mail', function () {

    \Mail::to('asnidadon@gmail.com')->send(new \App\Mail\MyTestMail());

    dd("Email is Sent.");
    // dd($details);
  });


  // Modul Tempahan tempahankenderaan
  Route::get('/tempahankenderaan', 'TempahanKenderaanController@index')->name('tempahankenderaan.index');
  Route::post('/tempahankenderaan', 'TempahanKenderaanController@index')->name('tempahankenderaan.index');
  Route::get('/tempahankenderaan/tambah', 'TempahanKenderaanController@tambah')->name('tempahankenderaan.tambah');
  Route::post('/tempahankenderaan/tambah', 'TempahanKenderaanController@simpan_tambah')->name('tempahankenderaan.simpan_tambah');
  Route::get('/tempahankenderaan/butiran/{id}', 'TempahanKenderaanController@butiran')->name('tempahankenderaan.butiran');
  Route::get('/tempahankenderaan/kemaskini/{id}', 'TempahanKenderaanController@kemaskini')->name('tempahankenderaan.kemaskini');
  Route::post('/tempahankenderaan/kemaskini/{id}', 'TempahanKenderaanController@simpan_kemaskini')->name('tempahankenderaan.simpan_kemaskini');
  Route::get('/tempahankenderaan/batal/{id}', 'TempahanKenderaanController@batal')->name('tempahankenderaan.batal');
  Route::post('/tempahankenderaan/batal/{id}', 'TempahanKenderaanController@simpan_batal')->name('tempahankenderaan.simpan_batal');
  Route::get('/tempahankenderaan/tindakan/{id}', 'TempahanKenderaanController@tindakan')->name('tempahankenderaan.tindakan');
  Route::post('/tempahankenderaan/tindakan/{id}', 'TempahanKenderaanController@simpan_tindakan')->name('tempahankenderaan.simpan_tindakan');
  Route::get('/tempahankenderaan/kemaskini_tindakan/{id}', 'TempahanKenderaanController@kemaskini_tindakan')->name('tempahankenderaan.kemaskini_tindakan');
  Route::post('/tempahankenderaan/kemaskini_tindakan/{id}', 'TempahanKenderaanController@simpan_kemaskini_tindakan')->name('tempahankenderaan.simpan_kemaskini_tindakan');
  Route::post('/tempahankenderaan/sahkan/{id}', 'TempahanKenderaanController@simpan_sah')->name('tempahankenderaan.simpan_sah');
  Route::get('/tempahankenderaan/butiran_tindakan/{id}', 'TempahanKenderaanController@butiran_tindakan')->name('tempahankenderaan.butiran_tindakan');
  //  Route::get('/tempahankenderaan/hapus/{id}', 'TempahanKenderaanController@hapus')->name('tempahankenderaan.hapus');
  //  Route::post('/tempahankenderaan/hapus/{id}', 'TempahanKenderaanController@simpan_hapus')->name('tempahankenderaan.simpan_hapus');


  Route::get('/cariKenderaan', 'TempahanKenderaanController@searchKenderaan')->name('cariKenderaan');
  Route::get('/cetak/permohonan/{id}','TempahanKenderaanController@cetak')->name('cetak');

  // Modul Kenderaan
  Route::get('/kenderaan', 'KenderaanController@index')->name('kenderaan.index');
  Route::post('/kenderaan', 'KenderaanController@index')->name('kenderaan.index');
  Route::get('/kenderaan/tambah', 'KenderaanController@tambah')->name('kenderaan.tambah');
  Route::post('/kenderaan/tambah', 'KenderaanController@simpan_tambah')->name('kenderaan.simpan_tambah');
  Route::get('/kenderaan/butiran/{id}', 'KenderaanController@butiran')->name('kenderaan.butiran');
  Route::get('/kenderaan/kemaskini/{id}', 'KenderaanController@kemaskini')->name('kenderaan.kemaskini');
  Route::post('/kenderaan/kemaskini/{id}', 'KenderaanController@simpan_kemaskini')->name('kenderaan.simpan_kemaskini');
  Route::get('/kenderaan/hapus/{id}', 'KenderaanController@hapus')->name('kenderaan.hapus');
  Route::post('/kenderaan/hapus/{id}', 'KenderaanController@simpan_hapus')->name('kenderaan.simpan_hapus');

  // Modul Pemandu
  Route::get('/pemandu', 'PemanduController@index')->name('pemandu.index');
  Route::post('/pemandu', 'PemanduController@index')->name('pemandu.index');
  Route::get('/pemandu/tambah', 'PemanduController@tambah')->name('pemandu.tambah');
  Route::post('/pemandu/tambah', 'PemanduController@simpan_tambah')->name('pemandu.simpan_tambah');
  Route::get('/pemandu/butiran/{id}', 'PemanduController@butiran')->name('pemandu.butiran');
  Route::get('/pemandu/kemaskini/{id}', 'PemanduController@kemaskini')->name('pemandu.kemaskini');
  Route::post('/pemandu/kemaskini/{id}', 'PemanduController@simpan_kemaskini')->name('pemandu.simpan_kemaskini');
  Route::get('/pemandu/hapus/{id}', 'PemanduController@hapus')->name('pemandu.hapus');
  Route::post('/pemandu/hapus/{id}', 'PemanduController@simpan_hapus')->name('pemandu.simpan_hapus');
  Route::get('/jadual', 'PemanduController@jadual')->name('jadual');
  Route::post('/jadual', 'PemanduController@jadual')->name('jadual');


  Route::get('/jadualPemandu', 'CalenderController@index')->name('pemandu.jadualPemandu');

  // Modul Pengguna
  Route::get('/pengguna', 'PenggunaController@index')->name('pengguna.index');
  Route::post('/pengguna', 'PenggunaController@index')->name('pengguna.index');
  Route::get('/pengguna/tambah', 'PenggunaController@tambah')->name('pengguna.tambah');
  Route::post('/pengguna/tambah', 'PenggunaController@simpan_tambah')->name('pengguna.simpan_tambah');
  Route::get('/pengguna/butiran/{id}', 'PenggunaController@butiran')->name('pengguna.butiran');
  Route::get('/pengguna/kemaskini/{id}', 'PenggunaController@kemaskini')->name('pengguna.kemaskini');
  Route::post('/pengguna/kemaskini/{id}', 'PenggunaController@simpan_kemaskini')->name('pengguna.simpan_kemaskini');
  Route::get('/pengguna/hapus/{id}', 'PenggunaController@hapus')->name('pengguna.hapus');
  Route::post('/pengguna/hapus/{id}', 'PenggunaController@simpan_hapus')->name('pengguna.simpan_hapus');


  // Modul Penilaian
  Route::get('/penilaian/kenderaan/{id}', 'PenilaianController@penilaiankenderaan')->name('penilaian.penilaiankenderaan');
  Route::post('/penilaian/kenderaan/{id}', 'PenilaianController@simpan_penilaiankenderaan')->name('penilaian.simpan_penilaiankenderaan');
  Route::get('/penilaian/catatanpemandu/{id}', 'PenilaianController@catatanpemandu')->name('penilaian.catatanpemandu');
  Route::post('/penilaian/catatanpemandu/{id}', 'PenilaianController@simpan_catatanpemandu')->name('penilaian.simpan_catatanpemandu');
  Route::get('/penilaian/borang', 'PenilaianController@borang')->name('penilaian.borang');
  Route::post('/penilaian/borang', 'PenilaianController@simpan_borang')->name('pemantauan.simpan_borang');
  Route::get('/penilaian/catatanp', 'PenilaianController@catatan_pemandu')->name('penilaian.catatan_pemandu');
  Route::post('/penilaian/catatanp', 'PenilaianController@simpan_catatan_pemandu')->name('penilaian.simpan_catatan_pemandu');

  // Modul Tempahan Bilik
 Route::get('/tempahanbilik', 'TempahanBilikController@index')->name('tempahanbilik.index');
 Route::post('/tempahanbilik', 'TempahanBilikController@index')->name('tempahanbilik.index');

 Route::get('/tempahanbilik/jadual', 'TempahanBilikController@jadual')->name('tempahanbilik.jadual'); // route to calendar page
 Route::post('/tempahanbilik/jadual', 'TempahanBilikController@jadual')->name('tempahanbilik.jadual'); // route to calendar page for search filter

 Route::get('/tempahanbilik/tambah', 'TempahanBilikController@tambah')->name('tempahanbilik.tambah');
 Route::post('/tempahanbilik/tambah', 'TempahanBilikController@simpan_tambah')->name('tempahanbilik.simpan_tambah');

 Route::get('/tempahanbilik/butiran/{id}', 'TempahanBilikController@butiran')->name('tempahanbilik.butiran');
 Route::post('/tempahanbilik/butiran_calendar/', 'FullCalendarController@butiran_bilikcalendar_admin')->name('tempahanbilik.butiran_bilikcalendar'); //butiran tapi untuk kalendar
 Route::get('/tempahanbilik/cetak_butiran/{id}', 'TempahanBilikController@cetak_butiran')->name('tempahanbilik.cetak_butiran'); //cetak butiran

 Route::get('/tempahanbilik/kemaskini/{id}', 'TempahanBilikController@kemaskini')->name('tempahanbilik.kemaskini');
 Route::post('/tempahanbilik/kemaskini/simpan/{id}', 'TempahanBilikController@simpan_kemaskini')->name('tempahanbilik.simpan_kemaskini');

 Route::get('/tempahanbilik/kemaskini/makanan/{id}', 'TempahanBilikController@makanan')->name('tempahanbilik.makanan');
 Route::post('/tempahanbilik/kemaskini/simpan_makanan/{id}', 'TempahanBilikController@simpan_makanan')->name('tempahanbilik.simpan_makanan');
 Route::get('/tempahanbilik/hapus_makanan/{id}', 'TempahanBilikController@hapus_makanan')->name('tempahanbilik.hapus_makanan'); //route tuk buang data tempahan makanan admin

 Route::get('/tempahanbilik/batal/{id}', 'TempahanBilikController@batal')->name('tempahanbilik.batal');
 Route::post('/tempahanbilik/batal/{id}', 'TempahanBilikController@simpan_batal')->name('tempahanbilik.simpan_batal');
 Route::get('/tempahanbilik/tindakan/{id}', 'TempahanBilikController@tindakan')->name('tempahanbilik.tindakan');
 Route::post('/tempahanbilik/tindakan/{id}', 'TempahanBilikController@simpan_tindakan')->name('tempahanbilik.simpan_tindakan');

 Route::get('/tempahanbilik/tindakan/ubahsuai_makanan/{id}', 'TempahanBilikController@ubahsuai_makanan')->name('tempahanbilik.ubahsuai_makanan'); //tindakan jika ubah menu makan
 Route::post('/tempahanbilik/tindakan/simpan/ubahsuai_makanan/{id}', 'TempahanBilikController@simpan_ubahsuai_makanan')->name('tempahanbilik.simpan_ubahsuai_makanan'); //simpan jika ubah menu makan

 Route::get('/tempahanbilik/kemaskini_tindakan/{id}', 'TempahanBilikController@kemaskini_tindakan')->name('tempahanbilik.kemaskini_tindakan');
 Route::post('/tempahanbilik/kemaskini_tindakan/{id}', 'TempahanBilikController@simpan_kemaskini_tindakan')->name('tempahanbilik.simpan_kemaskini_tindakan');
 Route::post('/tempahanbilik/sahkan/{id}', 'TempahanBilikController@simpan_sah')->name('tempahanbilik.simpan_sah');
 Route::get('/tempahanbilik/butiran_tindakan/{id}', 'TempahanBilikController@butiran_tindakan')->name('tempahanbilik.butiran_tindakan');

 // Modul Bilik
   Route::get('/bilik', 'BilikController@index')->name('bilik.index');
   Route::post('/bilik', 'BilikController@index')->name('bilik.index');
   Route::get('/bilik/tambah', 'BilikController@tambah')->name('bilik.tambah');
   Route::post('/bilik/tambah', 'BilikController@simpan_tambah')->name('bilik.simpan_tambah');
   Route::get('/bilik/butiran/{id}', 'BilikController@butiran')->name('bilik.butiran');
   Route::get('/bilik/kemaskini/{id}', 'BilikController@kemaskini')->name('bilik.kemaskini');
   Route::post('/bilik/kemaskini/{id}', 'BilikController@simpan_kemaskini')->name('bilik.simpan_kemaskini');
   Route::get('/bilik/hapus/{id}', 'BilikController@hapus')->name('bilik.hapus');
   Route::post('/bilik/hapus/{id}', 'BilikController@simpan_hapus')->name('bilik.simpan_hapus');

   // Modul Katerer
   Route::get('/katerer', 'KatererController@index')->name('katerer.index');
   Route::post('/katerer', 'KatererController@index')->name('katerer.index');
   Route::get('/katerer/tambah', 'KatererController@tambah')->name('katerer.tambah');
   Route::post('/katerer/tambah', 'KatererController@simpan_tambah')->name('katerer.simpan_tambah');
   Route::get('/katerer/butiran/{id}', 'KatererController@butiran')->name('katerer.butiran');
   Route::get('/katerer/kemaskini/{id}', 'KatererController@kemaskini')->name('katerer.kemaskini');
   Route::post('/katerer/kemaskini/{id}', 'KatererController@simpan_kemaskini')->name('katerer.simpan_kemaskini');
   Route::get('/katerer/hapus/{id}', 'KatererController@hapus')->name('katerer.hapus');
   Route::post('/katerer/hapus/{id}', 'KatererController@simpan_hapus')->name('katerer.simpan_hapus');

  // Modul Laporan
  Route::get('/laporan/keseluruhan', 'LaporanController@laporanKeseluruhan')->name('laporan.keseluruhan');
  Route::post('/laporan/keseluruhan', 'LaporanController@laporanKeseluruhan')->name('laporan.keseluruhan');
  Route::get('/laporan/pemandu', 'LaporanController@laporanPemandu')->name('laporan.pemandu');
  Route::post('/laporan/pemandu', 'LaporanController@laporanPemandu')->name('laporan.pemandu');
  //  Route::get('/laporan/statistik', 'LaporanController@laporanStatistik')->name('laporan.statistik');
  //  Route::post('/laporan/statistik', 'LaporanController@laporanStatistik')->name('laporan.statistik');
  Route::get('/laporan/penilaian', 'LaporanController@penilaian')->name('laporan.penilaian');
  Route::post('/laporan/penilaian', 'LaporanController@penilaian')->name('laporan.penilaian');
  Route::get('/laporan/ulasanpemandu', 'LaporanController@ulasanPemandu')->name('laporan.ulasanpemandu');
  Route::post('/laporan/ulasanpemandu', 'LaporanController@ulasanPemandu')->name('laporan.ulasanpemandu');

  //laporan bilik
  Route::get('/laporbilik/keseluruhan', 'LaporanBilikController@laporanKeseluruhan')->name('laporanbilik.keseluruhan');
  Route::post('/laporbilik/keseluruhan', 'LaporanBilikController@laporanKeseluruhan')->name('laporanbilik.keseluruhan');

  Route::get('/laporbilik/katerer', 'LaporanBilikController@laporanKaterer')->name('laporanbilik.katerer');
  Route::post('/laporbilik/katerer', 'LaporanBilikController@laporanKaterer')->name('laporanbilik.katerer');

  Route::get('/laporbilik/katerer/bulanan', 'LaporanBilikController@laporanKatererBulanan')->name('laporanbilik.katerer_bulanan');
  Route::post('/laporbilik/katerer/bulanan', 'LaporanBilikController@laporanKatererBulanan')->name('laporanbilik.katerer_bulanan');
  

  Route::get('/laporan/excel', 'LaporanController@excel')->name('laporan.excel');

  
});

Route::get('/cariPegawai', 'TempahanKenderaanController@searchPegawais')->name('cariPegawai');
Route::get('/cariDetailPegawai', 'TempahanKenderaanController@searchDetailPegawais')->name('cariDetailPegawai');