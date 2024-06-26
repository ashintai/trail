<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\HomeController;

Route::prefix('admin')->group(function () {
  Route::get('login', [LoginController::class, 'index'])->name('admin.login.index');
  Route::post('login', [LoginController::class, 'login'])->name('admin.login.login');
  Route::get('logout', [LoginController::class, 'logout'])->name('admin.login.logout');
});

Route::prefix('admin')->middleware('auth.admins:admins')->group(function(){
  Route::get('/', [HomeController::class, 'dashboard'])->name('admin.dashboard');
  Route::get('/dashboard' , [HomeController::class , 'dashboard'])->name('admin.index');
  Route::get('/newplayer' , [HomeController::class , 'newplayer'])->name('admin.newplayer');
  Route::get('/initial' , [HomeController::Class , 'initial'])->name('admin.initial');
  Route::post('/create_newplayer', [HomeController::Class , 'create_newplayer'])->name('admin.create_newplayer');
  Route::post('/csvImport' , [HomeController::Class, 'csvImport'])->name('admin.csvImport');
  Route::get('/edit/{id}' ,[HomeController::Class , 'edit'])->name('admin.edit/{edit}');
  Route::post('/edit_player' , [HomeController::Class , 'edit_player'])->name('admin.edit_player');
  Route::post('/ini_categories', [HomeController::Class , 'ini_categories'])->name('admin.ini_categories');
  Route::post('/ini_parks' , [HomeController::Class , 'ini_parks'])->name('admin.ini_parks');
  Route::post('/staffaccount' , [HomeController::Class , 'staffaccount'])->name('admin.staffaccount');


});