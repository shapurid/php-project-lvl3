<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlsController;

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
})->name('root');

Route::name('urls.')->group(function () {
    Route::get('/urls', [UrlsController::class, 'index'])->name('index');
});
