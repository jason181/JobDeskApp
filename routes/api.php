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
Route::get('proyek/all/{id}','ProyekController@allProject');

Route::post ('proyek/add','ProyekController@storeAll'); //Ready & Checked
Route::patch ('proyek/update/{id}','ProyekController@updateAll'); //Ready & Checked

//Sub Divisi
Route::resource('sub_divisi_proyek','SubDivisiProyekController'); //Ready

//Sub Item Pekerjaan
Route::resource('sub_item_pekerjaan','SubItemPekerjaanController'); //Ready

//Token
Route::get('/session', 'TokenController@validateToken');
Route::post('/authenticate', 'TokenController@authenticate'); //Ready
Route::get('/token', 'TokenController@validateToken'); //Ready

// Persentase
Route::get('/hitungSubItem/{id}','SubItemPekerjaanController@hitungPersentaseSubItem'); //Ready & Checked
Route::get('/hitungItem/{id}','ItemPekerjaanController@hitungPersentaseItem'); //Ready & Checked
Route::get('/hitungSubDivisi/{id}','SubDivisiProyekController@hitungPersentaseSubDIvisi'); //Ready & Checked
Route::get('/hitungDivisi/{id}','DivisiProyekController@hitungPersentaseDivisi'); //Ready & Checked
Route::get('/hitungProyek/{id}','ProyekController@hitungPersentaseProyek'); //Ready & Checked

// Dashboard
Route::get('/getProject/{id}','AkunController@getProject');

//Fingerprint
Route::get('/UserData', 'UserDataController@index');
Route::get('/sinkronisasi', 'UserDataController@sinkronisasi');
Route::resource('Fingerprint','FingerprintController');
Route::patch('/active/{id}','FingerprintController@active');
Route::patch('/deactive/{id}','FingerprintController@deactive');
Route::get('/check-connection/{id}','FingerprintController@check_connection');
// Route::group(['prefix' => 'fingerprint'], function() {
//     Route::get('/', 'FPController@index')->name('fingerprint_index');
//     Route::get('create', 'FPController@create')->name('fingerprint_create');
//     Route::post('create', 'FPController@store')->name('fingerprint_store');
//     Route::get('{id}/edit', 'FPController@edit')->name('fingerprint_edit');
//     Route::post('update', 'FPController@update')->name('fingerprint_update');
//     Route::get('{id}/delete', 'FPController@delete')->name('fingerprint_delete');
//     Route::get('{id}/check-connection', 'FPController@check_connection')->name('fingerprint_check_connection');
//     Route::get('{id}/active', 'FPController@active')->name('fingerprint_active');
//     Route::get('{id}/deactive', 'FPController@deactive')->name('fingerprint_deactive');
// });
  