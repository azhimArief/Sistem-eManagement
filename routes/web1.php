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

  
