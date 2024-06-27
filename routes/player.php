<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Player\LoginController;
use App\Http\Controllers\Player\HomeController;

Route::prefix('player')->group(function () {
  Route::get('login', [LoginController::class, 'index'])->name('player.login.index');
  Route::post('login', [LoginController::class, 'login'])->name('player.login.login');
  Route::get('logout', [LoginController::class, 'logout'])->name('player.login.logout');
 });

Route::prefix('player')->middleware('auth.players:players')->group(function(){
  Route::get('/', [HomeController::class, 'dashboard'])->name('player.dashboard');
  Route::get('individual' , [HomeController::class , 'individual'])->name('player.individual');
  Route::get('member' , [Homecontroller::class , 'member'])->name('player.member');
  Route::get('/member/{id}' , [HomeController::class , 'each'])->name('player.member.each/{each}');
  Route::post('/promise/{id}' , [HomeController::class , 'promise'])->name('player.promise');
  Route::get('/park/{id}' , [HomeController::class , 'park'])->name('player.park/{park}');
});