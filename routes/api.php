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
Route::resource('akses_pekerjaan','AksesPekerjaanController'); //Half-Ready

//Akun
Route::resource('akun','AkunController'); //Ready

//Divisi
Route::resource('divisi','DivisiRoleController'); //Ready & Checked
Route::resource('divisi_proyek','DivisiProyekController'); //Ready

//Item Pekerjaan
Route::resource('item_pekerjaan','ItemPekerjaanController'); //Ready

//Jabatan
Route::resource('jabatan','JabatanController'); //Ready & Checked

//Karyawan
Route::resource ('karyawan','KaryawanController'); //Ready

//Log
Route::resource('log_pengerjaan','LogPengerjaanController'); //Ready
Route::post('log_pengerjaan/storeFile','LogPengerjaanController@storeFile'); //Ready & Checked
Route::resource('log_sesi','LogSesiController'); //Half-Ready

//Proyek
Route::resource ('proyek','ProyekController'); //Ready & Checked

//Sub Divisi
Route::resource('sub_divisi_proyek','SubDivisiProyekController'); //Ready

//Sub Item Pekerjaan
Route::resource('sub_item_pekerjaan','SubItemPekerjaanController'); //Ready

//Token
Route::get('/session', 'TokenController@validateToken');
Route::post('/authenticate', 'TokenController@authenticate'); //Ready
Route::get('/token', 'TokenController@validateToken'); //Ready
