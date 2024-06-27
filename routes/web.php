<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\DompdfController;
use App\Http\Controllers\Admin\LoginController;

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

// 管理者、スタッフ、参加者へのルート読込
include __DIR__ . '/admin.php';
include __DIR__ . '/staff.php';
include __DIR__ . '/player.php';

// ログインを必要としないTopページへのルート
Route::get('/', function () {
    return view('welcome');
});

//管理者の設定
Route::post('/admin_pass' , [LoginController::class , 'admin_pass'])->name('admin_pass');

// 駐車券ＰＤＦ発行
Route::get('dompdf/pdf' , [DompdfController::class , 'generatePDF']);

// // 参加者一覧へのルート
// Route::get('/index' , [IndexController::class,'index'])->name('index');
// // 参加者編集へのルート
// Route::get('/edit/{id}' , [IndexController::class,'edit'])->name('edit');
// // エントリーのCSVファイル読込へのルート
// Route::post('/csvImport' , [IndexController::class ,'csvImport'])->name('csvImport');
// // 参加者のログイン画面
// Route::get('/login' , [IndexController::class , 'login'])->name('login');
// // グループ申込での個人選択画面へのルート
// Route::get('group' , [IndexController::class, 'group'])->name('group');
// // 各個人の誓約書の画面へのルート
// Route::get('promise' , [IndexController::class , 'promise'])->name('promise');
// // Park　Catgories　DB　の初期化
// Route::get('init' , [IndexController::class , 'init'])->name('init');

