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
Route::resource('divisi','DivisiRoleController');

//Jabatan
Route::resource('jabatan','JabatanController');

//Proyek
Route::resource ('proyek','ProyekController');
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
