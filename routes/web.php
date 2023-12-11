<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TanggapanController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\MasyarakatController;
use App\Models\Pengaduan;

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
    return view('login');
})->middleware('guest');

//Register
Route::get('/registrasi', [RegistrasiController::class, 'index'])->middleware('guest');
Route::post('/daftar-masyarakat', [RegistrasiController::class, 'daftarMas'])->middleware('guest');

//Register Petugas
Route::get('/registrasi-petugas', [RegistrasiController::class, 'indexPet'])->middleware('guest');
Route::post('/daftar-masyarakat', [RegistrasiController::class, 'daftarPet'])->middleware('guest');


// Login
Route::get('/login', [LoginController::class, 'index'])->middleware('guest');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

//Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth:petugas,masyarakat');

//Pengaduan
Route::resource('/pengaduan', PengaduanController::class)->middleware('auth:web,masyarakat');

Route::get('/lihat-tanggapan/{id_pengaduan}/edit', [PengaduanController::class, 'lihatTanggapan'])->middleware('auth:masyarakat');

//Verifikasi & Validasi
Route::get('/verifikasi-nonvalid',[VerifikasiController::class, 'index'])->middleware('auth:petugas')->name('nonvalid');
Route::get('/verifikasi-valid/{id_pengaduan}',[VerifikasiController::class, 'valid'])->middleware('auth:petugas');
Route::get('/verifikasi-valid',[VerifikasiController::class, 'indexValid'])->middleware('auth:petugas');
Route::get('/verifikasi-ditolak',[VerifikasiController::class, 'indexDitolak'])->middleware('auth:petugas');
Route::get('/verifikasi-ditolak/{id_pengaduan}',[VerifikasiController::class, 'ditolak'])->middleware('auth:petugas');

Route::get('/validasi-proses',[ValidasiController::class, 'indexProses'])->middleware('auth:petugas');
Route::get('/validasi-proses/{id_pengaduan}',[ValidasiController::class, 'proses'])->middleware('auth:petugas');

Route::get('/validasi-selesai',[ValidasiController::class, 'indexSelesai'])->middleware('auth:petugas');
Route::get('/validasi-selesai/{id_pengaduan}',[ValidasiController::class, 'selesai'])->middleware('auth:petugas');
Route::get('/tanggapi-aduan/{id_pengaduan}',[TanggapanController::class, 'index'])->middleware('auth:petugas');
Route::post('/tanggapan-simpan/{id_pengaduan}',[TanggapanController::class, 'simpanTanggapan'])->middleware('auth:petugas');

Route::get('/laporan',[LaporanController::class, 'index'])->middleware('auth:petugas');
Route::get('/cetak-laporan',[LaporanController::class, 'printPengaduan'])->middleware('auth:petugas');


// CRUD Petugas
Route::resource('/data-petugas', PetugasController::class)->middleware('auth:petugas');

// Crud Masyarakat
Route::resource('/data-masyarakat', MasyarakatController::class)->middleware('auth:petugas');