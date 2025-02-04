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
 Route::get('/permohonan', 'RisiController@index')->name('risi.index');
  // Route memaparkan borang tambah user baru
 Route::get('/permohonan/add', 'RisiController@create')->name('risi.create');
  // Route untuk memproses borang tambah user baru
 Route::post('/permohonan/add', 'RisiController@store')->name('risi.store');
  // Route memaparkan borang edit user
 Route::get('/permohonan/{id}/edit', 'RisiController@edit')->name('risi.edit');
  // Route memproses borang kemaskini user
 Route::patch('/permohonan/{id}/edit', 'RisiController@update')->name('risi.update');
  // Route menghapuskan maklumat user
 Route::delete('/permohonan/{id}', 'RisiController@destroy')->name('risi.destroy');
  // Route untuk view user
 Route::get('/permohonan/{id}/view', 'RisiController@view')->name('risi.view');
 
 // Modul Permohonan
 Route::get('/abc123/tambah', 'AbcController@tambah')->name('abc123.tambah');
 Route::get('/abc123', 'AbcController@index')->name('abc123.index');
 
 // Route untuk pengurusan pengguna
 Route::get('/pengguna', 'PenggunaController@index')->name('risi.index');
 Route::get('/pengguna/tambah', 'PenggunaController@tambah')->name('risi.tambah');
 Route::post('/pengguna/tambah', 'PenggunaController@simpan_tambah')->name('risi.simpan_tambah');
 Route::post('/pengguna/butiran/{id}', 'PenggunaController@butiran')->name('risi.butiran');
 Route::get('/pengguna/kemaskini/{id}', 'PenggunaController@kemaskini')->name('risi.kemaskini');
 Route::post('/pengguna/kemaskini/{id}', 'PenggunaController@simpan_kemaskini')->name('risi.simpan_kemaskini');
 Route::get('/pengguna/hapus/{id}', 'PenggunaController@hapus')->name('risi.hapus');
 Route::get('/pengguna/hapus/{id}', 'PenggunaController@hapus')->name('risi.hapus');
 
 // Modul Penerbitan
 Route::get('/penerbitan', 'PenerbitanController@index')->name('penerbitan.index');
 Route::get('/penerbitan/tambah', 'PenerbitanController@tambah')->name('penerbitan.tambah');
 Route::post('/penerbitan/tambah', 'PenerbitanController@simpan_tambah')->name('penerbitan.simpan_tambah');
 Route::get('/penerbitan/butiran/{id}', 'PenerbitanController@butiran')->name('penerbitan.butiran');
 Route::get('/penerbitan/kemaskini/{id}', 'PenerbitanController@kemaskini')->name('penerbitan.kemaskini');
 Route::post('/penerbitan/kemaskini/{id}', 'PenerbitanController@simpan_kemaskini')->name('penerbitan.simpan_kemaskini');
 Route::get('/penerbitan/hapus/{id}', 'PenerbitanController@hapus')->name('penerbitan.hapus');
 Route::post('/penerbitan/hapus/{id}', 'PenerbitanController@simpan_hapus')->name('penerbitan.simpan_hapus');
  

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
