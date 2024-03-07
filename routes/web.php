<?php

use App\Http\Controllers\Back\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomepageController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\AuthController;
use App\Http\Controllers\Back\CategoryController;
use App\Http\Controllers\Back\ConfigController;
use App\Http\Controllers\Back\PageController;
use App\Http\Controllers\Back\UserController;
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

    Route::middleware('role:Admin|Editor|User')->group(function(){
        Route::get('/',[DashboardController::class,'index'])->name('dashboard');

        //------- Articles Routes -------
        Route::middleware('role:Admin|Editor')->get('articles/{article}/changeStatus', [ArticleController::class, 'changeStatus'])->name('articles.changeStatus');
        Route::get('articles/{article}/trashArticle', [ArticleController::class, 'trashArticle'])->name('articles.trashArticle');
        Route::get('articles/getTrashedArticles', [ArticleController::class, 'getTrashedArticles'])->name('articles.getTrashedArticles');
        Route::get('articles/{article}/recoverArticle', [ArticleController::class, 'recoverArticle'])->name('articles.recoverArticle');
        Route::middleware('permission:hard-delete')->get('articles/{article}/hardDeleteArticle', [ArticleController::class, 'hardDeleteArticle'])->name('articles.hardDeleteArticle');
        Route::get('articles/myArticles', [ArticleController::class, 'myArticles'])->name('articles.myArticles');

        Route::resource('articles',ArticleController::class)->except('index');
        Route::resource('articles',ArticleController::class)->middleware('permission:get-all-articles')->only('index');
                

        //------- Category Routes -------
        Route::middleware('role:Admin|Editor')->group(function(){
            Route::get('categories',[CategoryController::class, 'index'])->name('category.index');
            Route::get('category/{category}/changeStatus', [CategoryController::class, 'changeStatus'])->name('category.changeStatus');
            Route::post('category/createCategory', [CategoryController::class, 'createCategory'])->name('category.createCategory');
            Route::get('category/getData', [CategoryController::class, 'getData'])->name('category.getData');
            Route::post('category/updateCategory', [CategoryController::class, 'updateCategory'])->name('category.updateCategory');
            Route::post('category/deleteCategory', [CategoryController::class, 'deleteCategory'])->name('category.deleteCategory');
        });

        //------- Page Routes -------
        Route::middleware('role:Admin|Editor')->group(function(){
            Route::resource('pages', PageController::class);
            Route::middleware('permission:Edit Articles')->get('pages/{page}/changeStatus', [PageController::class, 'changeStatus'])->name('pages.changeStatus');
            Route::post('pages/deletePage', [PageController::class, 'deletePage'])->name('pages.deletePage');
        });

        //------- Config Routes -------
        Route::middleware('role:Admin')->group(function(){
            Route::get('/config',[ConfigController::class, 'index'])->name('config.index');
            Route::post('config', [ConfigController::class, 'configPost'])->name('config.configPost');
        });

        //------- User Routes -------
        Route::middleware('role:Admin')->group(function(){
            Route::get('users/{user}/changeStatus', [UserController::class, 'changeStatus'])->name('users.changeStatus');
            Route::get('user/getData', [UserController::class, 'getData'])->name('users.getData');
            Route::get('users/{user}/trashArticle', [UserController::class, 'trashUser'])->name('users.trashUser');
    
            Route::get('users/getTrashedUsers', [UserController::class, 'getTrashedUsers'])->name('users.getTrashedUsers');
            Route::get('users/{user}/recoveUser', [UserController::class, 'recoverUser'])->name('users.recoverUser');
            Route::get('users/{user}/hardDeleteUser', [UserController::class, 'hardDeleteUser'])->name('users.hardDeleteUser');
            Route::post('users/updateUser',[UserController::class, 'updateUser'])->name('users.updateUser');
            Route::resource('users', UserController::class);
        });

    });
});
Route::get('logout',[AuthController::class,'logout'])->name('logout');


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