<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\my_controller;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\authController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Mail\sendEmail;
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
    return view('welcome');
})->name('home')->middleware('authEmail');



route::get('/home',[dashboardController::class, 'home'])->middleware('authEmail');


//ROUTE UNTUK REGISTER
Route::get('/register',function(){
    return view('register');
});
Route::post('/regis',[my_controller::class, 'register'])->name('post.regis');
Route::get('/regis',function(){
    return view('register');
});

//ROUTE authController
Route::get('logout', [authController::class, 'logout'])->name('logout');
Route::get('/login',[authController::class, 'getLogin'])->name('login');
Route::post('/login/posLogin',[authController::class, 'posLogin'])->name('pos.login');

Route::post('/logout',[authController::class, 'logout'])->name('logout');

//ROUTE AUTH VERIFY

Route::get('/home/verify',[authController::class, 'emailverify'])->name('sendEmail_verify');

Route::get('/email/verify/{token}' , [authController::class, 'verify']);

Route::get('/notice',function(){
    return view('notice.verify_notice');
})->name('notice');

Route::get('/dataMeja', function(){
    return view('pages.dataMeja');
})->name('dataMeja')->middleware('authEmail');

//Route::get('/buatFolder',[dashboardcontroller::class, 'buatFolder']);

Route::post('/dataMeja/saveMeja',[dashboardController::class, 'saveMeja'])->name('post.meja')->middleware('authEmail');
Route::get('/dataMeja/saveMeja', function() { return view('pages.dataMeja'); })->middleware('authEmail');
Route::get('/dashboard' ,[dashboardcontroller::class, 'dashboard'])->name('dashboard')->middleware('authEmail');
Route::get('/formMenu', function(){ return view('pages.formMenu'); })->name('formMenu')->middleware('authEmail');

Route::get('/formMenu/actionMenu',function(){ 
    return view('pages.formMenu'); 
})->middleware('authEmail');

Route::post('/formMenu/actionMenu', [dashboardController::class, 'actionMenu'])->name('post.actionMenu')->middleware('authEmail');

Route::get('/dataItem', function(){
    return view('pages.list_item');
})->name('list_item')->middleware('authEmail');

Route::get('/dataItem/edit_produk/{id}',[dashboardController::class, 'editProduk'])->name('editProd')->middleware('authEmail');
Route::get('pesanan', function(){
    return view('pages.pagePemesanan');
})->name('pagePesanan')->middleware('authEmail');

Route::post('/pesanan/actionPesanan',[dashboardController::class, 'act_pesanan'])->name('actionpesanan')->middleware('authEmail');
Route::get('/dapur', function() { return view('pages.dapur');})->name('halDapur')->middleware('authEmail');
Route::post('/dapur/actionDapur',[dashboardController::class, 'actDapur'])->name('actionDapur')->middleware('authEmail');
Route::get('/dapur/orderMonitor', function() {  return view('pages.dapurOrder'); })->name('dapur_order')->middleware('authEmail');
