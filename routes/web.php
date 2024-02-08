<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomepageController;
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

Route::get('/', [HomepageController::class,'index']);
Route::get('/category/{category}', [HomepageController::class,'category'])->name('category');
Route::get('/{category}/{slug}', [HomepageController::class,'getOneArticle'])->name('get.article');