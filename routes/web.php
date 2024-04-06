<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PdfController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/index/{id}', [HomeController::class, 'index'])->name('index')->middleware('guest');

Route::prefix('admin')->group(function () {
    // Login-Regis-Logout
    Route::get('/Login', [LoginController::class, 'adminlogin'])->name('admin.login')->middleware('guest');
    Route::post('/Login/Proses', [LoginController::class, 'adminloginproses'])->name('admin.login.proses')->middleware('guest');
    Route::get('/Logout', [LoginController::class, 'adminlogout'])->name('admin.logout')->middleware('adminpetugas');
    // Dashboard Admin/Petugas
    Route::get('/Dashboard', [DashboardController::class, 'admindashboard'])->name('admin.dashboard')->middleware('adminpetugas');
    // CRUD Data Pegawai
    Route::resource('DataPegawai', PetugasController::class)->middleware('admin');
    // CRUD Buku
    Route::resource('buku', BukuController::class)->middleware('adminpetugas');
    Route::resource('peminjaman', PeminjamanController::class);
    // CRUD Kategori
    Route::resource('kategori', KategoriController::class)->middleware('adminpetugas');
});

Route::get('buku/kategori/{id}', [BukuController::class, 'kategori'])->name('buku.kategori');
Route::post('buku/peminjaman/{id}', [BukuController::class, 'peminjamanbuku']);

// USER
Route::prefix('user')->group(function () {
    Route::get('/login', [LoginController::class, 'userlogin'])->name('user.login')->middleware('guest');
    Route::post('/login/proses', [LoginController::class, 'userloginproses'])->name('user.loginproses');
    Route::get('/register', [LoginController::class, 'regis'])->name('user.regis')->middleware('guest');
    Route::post('/register/proses', [LoginController::class, 'regisproses'])->name('user.regisproses');
    Route::get('user/logout', [LoginController::class, 'userlogout'])->name('user.logout')->middleware('auth');
    Route::get('/kategori/{id}', [UserController::class, 'kategori'])->name('user.kategori')->middleware('auth');
    Route::get('/buku/blog', [UserController::class, 'blog'])->name('user.buku.blog')->middleware('auth');
    Route::post('/generate-laporan', [PeminjamanController::class, 'generatelaporan'])->name('user.generatelaporan')->middleware('auth');
    Route::get('/history/peminjaman', [UserController::class, 'historypeminjaman'])->name('user.history.peminjaman')->middleware('auth');
    Route::get('/peminjaman/{id}', [UserController::class, 'peminjamanid'])->name('user.peminjaman');
});

// Generate Laporan
Route::post('generatelaporan', [PdfController::class, 'generate'])->name('generate.pdf');
