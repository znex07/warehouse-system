<?php

use Illuminate\Support\Facades\Route;

/*
|+--------------------------------------------------------------------------
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

Route::get('/search', [App\Http\Controllers\CargoController::class, 'search'])->name('search');
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();
//CREATE, READ, UPDATE, DELETE (cargo)
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/new-cargo', [App\Http\Controllers\CargoController::class, 'create'])->name('new-cargo');
Route::post('/view-search', [App\Http\Controllers\CargoController::class, 'show'])->name('view-search');
Route::post('/updateItem', [App\Http\Controllers\CargoController::class, 'edit'])->name('updateItem');
Route::post('/deleteItem', [App\Http\Controllers\CargoController::class, 'destroy'])->name('deleteItem');

Route::get('export', [App\Http\Controllers\CargoController::class,'export'])->name('export');
