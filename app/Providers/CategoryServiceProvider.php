<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Servis sınıfını kullanarak bir değişken oluşturabilirsiniz
        $categoryFromService = $this->getVariableFromService();

        // View composer'ı tanımlayarak view'e değişkeni ekleyin
        view()->composer('front.partials.sidebar', function ($view) use ($categoryFromService) {
            $view->with('categoryFromService', $categoryFromService);
        });
    }
    protected function getVariableFromService()
    {
        // Burada değişkenin değerini belirleyin (örneğin, bir veritabanından çekme)
        
        $data["categoryNames"]=DB::table('categories')->get();
        return $data;
        
        //return Category::all();
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
