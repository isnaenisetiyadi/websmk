<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
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
    return view('app');
});
// Route::get('/', 'HomeController@index');

// Route::group(['middleware' => ['auth']], function () {
//     //     // Route::get('/','HomeController@index')->name('home');
//     Route::get('/', 'HomeController@index');
// });

// Route::middleware('auth')->prefix('auth')->group(function (){
//     Route::get('init','AppController@init');
//     Route::get('users','AppController@users');
//     Route::post('register','AppController@register');
// });
Route::prefix('auth')->group(function (){
    Route::get('init','AppController@init');
    Route::get('users','AppController@users');
    Route::get('noGuest','AppController@noGuest');
    Route::post('register','AppController@register');
    Route::post('login','AppController@login');
    Route::post('logout','AppController@logout');
    Route::post('destroy/{id}','AppController@destroy');
    Route::get('show/{id}','AppController@show');
    Route::post('update/{id}','AppController@update');

    Route::get('berita','BeritaController@index');
    Route::get('berita/show/{id}','BeritaController@show');
    Route::post('berita/showBySearch','BeritaController@showBySearch');
    Route::post('berita/store','BeritaController@store');
    Route::post('berita/update/{id}','BeritaController@update');
    Route::post('berita/destroy/{id}','BeritaController@destroy');
    Route::post('berita/excludeJurusan','BeritaController@excludeJurusan');
    Route::post('berita/excludeOrganisasi','BeritaController@excludeOrganisasi');
    
    Route::post('post/store','PostController@store');
});
Route::get('kategori/showBerita','KategoriController@showBerita');
Route::get('kategoris','KategoriController@index');
Route::get('kategori/posts','KategoriController@posts');
Route::get('kategori/postbykategori','KategoriController@postbykategori');
Route::get('postperkategori/{id}','PostController@postperkategori');
Route::get('postperkategori2/{id}','PostController@postperkategori2');
Route::post('kategori/store','KategoriController@store');
Route::post('kategori/update','KategoriController@update');
Route::post('kategori/destroy/{id}','KategoriController@destroy');

Route::get('post/hits','PostController@hits');
Route::get('post/show/{id}','PostController@show');
Route::get('post/slug/{slug}','PostController@slug');
Route::get('post/showAll','PostController@showAll');

Route::get('komentar/showbyberitaid/{berita_id}','KomentarController@showByBeritaId');
Route::post('komentar/store','KomentarController@store');

Route::get('gurus','GuruController@index');
Route::get('guru/showAll','GuruController@showAll');
Route::get('guru/showByName/{nama}','GuruController@showByName');
Route::get('guru/show/{id}','GuruController@show');
Route::post('guru/update/{id}','GuruController@update');
Route::post('guru/destroy/{id}','GuruController@destroy');
Route::post('guru/store','GuruController@store');
Route::post('guru/excludeJurusan','GuruController@excludeJurusan');
Route::post('guru/includeJurusan','GuruController@includeJurusan');
Route::post('guru/getGuruJurusan','GuruController@getGuruJurusan');

Route::post('pendidikan/update/{id}','PendidikanController@update');
Route::post('pendidikan/destroy/{id}','PendidikanController@destroy');
Route::post('pendidikan/simpan','PendidikanController@simpan');

Route::get('jurusans','JurusanController@index');
Route::get('jurusan/getAll','JurusanController@getAll');
Route::get('jurusan/showAll','JurusanController@showAll');
Route::get('jurusan/show/{id}','JurusanController@show');
Route::get('jurusan/slug/{slug}','JurusanController@slug');
Route::post('jurusan/store','JurusanController@store');
Route::post('jurusan/update/{id}','JurusanController@update');
Route::post('jurusan/destroy/{id}','JurusanController@destroy');

Route::get('organisasis','OrganisasiController@index');
Route::get('organisasi/getall','OrganisasiController@getall');
Route::get('organisasi/showAll','OrganisasiController@showAll');
Route::get('organisasi/slug/{slug}','OrganisasiController@slug');
Route::post('organisasi/store','OrganisasiController@store');
Route::post('organisasi/update/{id}','OrganisasiController@update');
Route::post('organisasi/destroy/{id}','OrganisasiController@destroy');

Route::post('program/showByOrganisasiSearch','ProgramController@showByOrganisasiSearch');
Route::post('program/store','ProgramController@store');
Route::post('program/update/{id}','ProgramController@update');
Route::post('program/destroy/{id}','ProgramController@destroy');

Route::get('sekolah/showAll','SekolahController@showAll');
Route::post('sekolah/update/{id}','SekolahController@update');

Route::post('misi/store','MisiController@store');
Route::post('misi/update/{id}','MisiController@update');
Route::post('misi/destroy/{id}','MisiController@destroy');

Route::get('guru/slug/{slug}','GuruController@slug');

Route::get('ujistr', function(){
    return $random = Str::random(64);
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
