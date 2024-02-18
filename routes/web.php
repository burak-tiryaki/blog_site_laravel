<?php

use App\Http\Controllers\Back\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomepageController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\AuthController;
use App\Http\Controllers\Back\CategoryController;
use App\Models\Category;
use Monolog\Handler\RotatingFileHandler;

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

        //------- Articles Routes -------
        Route::get('articles/{article}/changeStatus', [ArticleController::class, 'changeStatus'])->name('articles.changeStatus');
        Route::get('articles/{article}/trashArticle', [ArticleController::class, 'trashArticle'])->name('articles.trashArticle');
        Route::get('articles/getTrashedArticles', [ArticleController::class, 'getTrashedArticles'])->name('articles.getTrashedArticles');
        Route::get('articles/{article}/recoverArticle', [ArticleController::class, 'recoverArticle'])->name('articles.recoverArticle');
        Route::get('articles/{article}/hardDeleteArticle', [ArticleController::class, 'hardDeleteArticle'])->name('articles.hardDeleteArticle');
        Route::resource('articles',ArticleController::class);

        //------- Category Routes -------
        Route::get('categories',[CategoryController::class, 'index'])->name('category.index');
        Route::get('category/{category}/changeStatus', [CategoryController::class, 'changeStatus'])->name('category.changeStatus');
        Route::post('category/createCategory', [CategoryController::class, 'createCategory'])->name('category.createCategory');
        Route::get('category/getData', [CategoryController::class, 'getData'])->name('category.getData');
        Route::post('category/updateCategory', [CategoryController::class, 'updateCategory'])->name('category.updateCategory');
        Route::post('category/deleteCategory', [CategoryController::class, 'deleteCategory'])->name('category.deleteCategory');

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