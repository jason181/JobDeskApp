<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Akses
Route::resource('akses','AksesController'); //Ready
Route::resource('akses_pekerjaan','AksesPekerjaanController'); 

//Akun
Route::resource('akun','AkunController'); //Ready

//Divisi
Route::resource('divisi','DivisiRoleController'); //Ready & Checked
Route::resource('divisi_proyek','DivisiProyekController');

//Item Pekerjaan
Route::resource('item_pekerjaan','ItemPekerjaanController'); //Ready

//Jabatan
Route::resource('jabatan','JabatanController'); //Ready & Checked

//Karyawan
Route::resource ('karyawan','KaryawanController'); //Ready

//Log
Route::resource('log_pengerjaan','LogPengerjaanController');
Route::resource('log_sesi','LogSesiController');

//Proyek
Route::resource ('proyek','ProyekController'); //Ready & Checked

//Sub Divisi
Route::resource('sub_divisi_proyek','SubDivisiProyekController');

//Sub Item Pekerjaan
Route::resource('sub_item_pekerjaan','SubItemPekerjaanController');

//Token
Route::get('/session', 'TokenController@validateToken');
Route::post('/authenticate', 'TokenController@authenticate'); //Ready
Route::get('/token', 'TokenController@validateToken'); //Ready
