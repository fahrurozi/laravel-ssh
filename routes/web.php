<?php

use Illuminate\Support\Facades\Route;

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
});

Route::get('/test', [App\Http\Controllers\TestController::class, 'index']);
Route::get('/test_ssh', [App\Http\Controllers\TestController::class, 'test_ssh'])->name('test_ssh');
Route::get('/connect', [App\Http\Controllers\TestController::class, 'connect'])->name('connect');
Route::get('/test_insert_data', [App\Http\Controllers\TestController::class, 'test_insert_data']);
Route::get('/show_data', [App\Http\Controllers\TestController::class, 'show_data']);
Route::get('/list_connections', [App\Http\Controllers\TestController::class, 'list_connections'])->name('list_connections');
Route::get('/add_connection', [App\Http\Controllers\TestController::class, 'add_connection'])->name('add_connection');
