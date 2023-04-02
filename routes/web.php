<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('chat', [App\Http\Controllers\ChatController::class, 'chat']);
Route::get('send', [App\Http\Controllers\ChatController::class, 'send']);
Route::post('send', [App\Http\Controllers\ChatController::class, 'send']);
Route::post('getOldMessage', [App\Http\Controllers\ChatController::class, 'getOldMessage']);
Route::post('saveToSession', [App\Http\Controllers\ChatController::class, 'saveToSession']);
Route::get('deleteSession', [App\Http\Controllers\ChatController::class, 'deleteSession']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
