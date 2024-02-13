<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomepageController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\AuthController;

/*
|--------------------------------------------------------------------------
| Back Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function(){

    Route::middleware('isLogin')->group(function(){
    Route::get('login',[AuthController::class,'getLogin'])->name('login');
    Route::post('login',[AuthController::class,'login'])->name('login');
    });

    Route::middleware('isAdmin')->group(function(){
        Route::get('panel',[DashboardController::class,'index'])->name('dashboard');
        Route::get('logout',[AuthController::class,'logout'])->name('logout');
    });
});


/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomepageController::class,'index']);
Route::get('/category/{category}', [HomepageController::class,'category'])->name('category');
Route::get('/{category}/{slug}', [HomepageController::class,'getOneArticle'])->name('get.article');
//Sabit URL'ler altta olduğu gibi değişken olanlardan önce tanımlanmalıdır. Sıra önemli.
Route::get('/contact',[HomepageController::class,'getContact'])->name('contact');
Route::post('/contact',[HomepageController::class,'postContact'])->name('contact.post');
Route::get('/{page}',[HomepageController::class,'page'])->name('page');