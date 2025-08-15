<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

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

##お問い合わせフォーム画面
Route::get('/', [ContactController::class, 'index']);

##確認画面
Route::post('/confirm', [ContactController::class, 'confirm']);

##完了画面
Route::post('/contacts', [ContactController::class, 'store']);

##管理画面
Route::get('/admin', [AdminController::class, 'index']);

##検索機能
Route::get('/admin/search', [AdminController::class, 'search']);

##削除機能
Route::DELETE('/admin/delete', [AdminController::class, 'destroy']);

##ユーザー登録
Route::post('/register', [AuthController::class, 'create']);

##ログイン
Route::post('/login', [AuthController::class, 'login']);

##ログアウト
Route::post('/logout', [AuthController::class, 'logout']);

##エクスポート
Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');
