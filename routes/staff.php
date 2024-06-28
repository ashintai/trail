<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Staff\LoginController;
use App\Http\Controllers\Staff\HomeController;

Route::prefix('staff')->group(function () {
  Route::get('login', [LoginController::class, 'index'])->name('staff.login.index');
  Route::post('login', [LoginController::class, 'login'])->name('staff.login.login');
  Route::get('logout', [LoginController::class, 'logout'])->name('staff.login.logout');
});

Route::prefix('staff')->middleware('auth.staffs:staffs')->group(function(){
  Route::get('/', [HomeController::class, 'dashboard'])->name('staff.dashboard');
  Route::get('/dashboard' , [HomeController::class , 'dashboard'])->name('staff.index');
  Route::get('/detail/{id}' ,[HomeController::Class , 'detail'])->name('staff.detail/{detail}');
  Route::post('/update' , [HomeController::Class , 'update'])->name('staff.update');
  // QRコード読み取り関係のルート
  Route::get('/qrreader', [HomeController::class , 'qrreader'])->name('staff.qrreader');
  Route::post('/scan' , [HomeController::class , 'scan'])->name('staff.scan');
  Route::post('/qrset' ,[HomeController::class , 'qrset'])->name('qrset');
});