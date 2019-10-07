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

//Divisi
Route::get('/divisi', 'DivisiRoleController@index');
Route::post('/divisi/store', 'DivisiRoleController@store');
Route::get('/divisi/{id}', 'DivisiRoleController@showbyID');
Route::patch('/divisi/update/{id}', 'DivisiRoleController@update'); 
Route::delete('/divisi/delete/{id}', 'DivisiRoleController@destroy');
Route::resource ('divisi','DivisiRoleController');

//Jabatan
Route::get('/jabatan', 'JabatanController@index');
Route::post('/jabatan/store', 'JabatanController@store');
Route::get('/jabatan/{id}', 'JabatanController@showbyID');
Route::patch('/jabatan/update/{id}', 'JabatanController@update'); 
Route::delete('/jabatan/delete/{id}', 'JabatanController@destroy');
Route::resource ('jabatan','JabatanController');


//Proyek
Route::get('/proyek', 'ProyekController@index');
Route::post('/proyek/store', 'ProyekController@store');
Route::get('/proyek/{id}', 'ProyekController@showbyID');
Route::patch('/proyek/update/{id}', 'ProyekController@update');
Route::delete('/proyek/delete/{id}', 'ProyekController@destroy');

//Token
Route::post('/authenticate', 'TokenController@authenticate');
Route::get('/session', 'TokenController@validateToken');

//Karyawan
Route::resource ('karyawan','KaryawanController');

//Akses
Route::resource('akses','AksesController');

//Akun  
Route::resource('akun','AkunController');

Route::post('/authenticate', 'TokenController@authenticate');
Route::get('/token', 'TokenController@validateToken');
