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
    return view('layouts/master');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

// Route untuk pengurusan data risi
  
  // Route memaparkan senarai maklumat risi
 //Route::get('/permohonan', 'PermohonanController@index')->name('risi.index');
  // Route memaparkan borang tambah user baru
 //Route::get('/permohonan/add', 'RisiController@create')->name('risi.create');
  // Route untuk memproses borang tambah user baru
 //Route::post('/permohonan/add', 'RisiController@store')->name('risi.store');
  // Route memaparkan borang edit user
 //Route::get('/permohonan/{id}/edit', 'RisiController@edit')->name('risi.edit');
  // Route memproses borang kemaskini user
 //Route::patch('/permohonan/{id}/edit', 'RisiController@update')->name('risi.update');
  // Route menghapuskan maklumat user
 //Route::delete('/permohonan/{id}', 'RisiController@destroy')->name('risi.destroy');
  // Route untuk view user
 //Route::get('/permohonan/{id}/view', 'RisiController@view')->name('risi.view');
 
 
 // Modul RISI
 Route::get('/risi', 'RisiController@index')->name('risi.index');
 Route::post('/risi', 'RisiController@index')->name('risi.index');
 Route::get('/risi/tambah', 'RisiController@tambah')->name('risi.tambah');
 Route::post('/risi/tambah', 'RisiController@simpan_tambah')->name('risi.simpan_tambah');
 Route::get('/risi/butiran/{id}', 'RisiController@butiran')->name('risi.butiran');
 Route::get('/risi/kemaskini/{id}', 'RisiController@kemaskini')->name('risi.kemaskini');
 Route::post('/risi/kemaskini/{id}', 'RisiController@simpan_kemaskini')->name('risi.simpan_kemaskini');
 Route::get('/risi/hapus/{id}', 'RisiController@hapus')->name('risi.hapus');
 Route::post('/risi/hapus/{id}', 'RisiController@simpan_hapus')->name('risi.simpan_hapus');
 
 // Modul Penerbitan
 Route::get('/penerbitan', 'PenerbitanController@index')->name('penerbitan.index');
 Route::post('/penerbitan', 'PenerbitanController@index')->name('penerbitan.index');
 Route::get('/penerbitan/tambah', 'PenerbitanController@tambah')->name('penerbitan.tambah');
 Route::post('/penerbitan/tambah', 'PenerbitanController@simpan_tambah')->name('penerbitan.simpan_tambah');
 Route::get('/penerbitan/butiran/{id}', 'PenerbitanController@butiran')->name('penerbitan.butiran');
 Route::get('/penerbitan/kemaskini/{id}', 'PenerbitanController@kemaskini')->name('penerbitan.kemaskini');
 Route::post('/penerbitan/kemaskini/{id}', 'PenerbitanController@simpan_kemaskini')->name('penerbitan.simpan_kemaskini');
 Route::get('/penerbitan/hapus/{id}', 'PenerbitanController@hapus')->name('penerbitan.hapus');
 Route::post('/penerbitan/hapus/{id}', 'PenerbitanController@simpan_hapus')->name('penerbitan.simpan_hapus');
 
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

 // Modul Pemantauan
 Route::get('/pemantauan', 'PemantauanController@index')->name('pemantauan.index');
 Route::post('/pemantauan', 'PemantauanController@index')->name('pemantauan.index');
 Route::get('/pemantauan/tambah', 'PemantauanController@tambah')->name('pemantauan.tambah');
 Route::post('/pemantauan/tambah', 'PemantauanController@simpan_tambah')->name('pemantauan.simpan_tambah');
 Route::get('/pemantauan/butiran/{id}', 'PemantauanController@butiran')->name('pemantauan.butiran');
 Route::get('/pemantauan/kemaskini/{id}', 'PemantauanController@kemaskini')->name('pemantauan.kemaskini');
 Route::post('/pemantauan/kemaskini/{id}', 'PemantauanController@simpan_kemaskini')->name('pemantauan.simpan_kemaskini');
 Route::get('/pemantauan/hapus/{id}', 'PemantauanController@hapus')->name('pemantauan.hapus');
 Route::post('/pemantauan/hapus/{id}', 'PemantauanController@simpan_hapus')->name('pemantauan.simpan_hapus');

  
