<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Redis;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('back.categories.index',compact('categories'));
    }

    public function changeStatus($id)
    {
        $category = Category::where('category_id',$id)->first();

        $category->where('category_id',$id)->update([
            'category_status' => ($category->category_status == 1 ? 0 : 1)
        ]);
        
        toastr('Category status changed.','success','Success!');

        return redirect()->back();
    }

    public function createCategory(Request $request)
    {
        Validator::extend('custom_rule_unique_category_slug', function ($attribute, $value, $parameters, $validator) use ($request) {
            // $attribute: Doğrulama yapılacak alanın adı
            // $value: Doğrulama yapılacak alanın değeri
            // $parameters: Doğrulama kuralındaki parametreler (isteğe bağlı)
            // $validator: Validator nesnesi
            $isExits =Category::where('category_slug', Str::slug($request->name))->first();
            if($isExits)
                return false;
            // Doğrulama kurallarını burada kontrol edin
            // Eğer doğruysa true, değilse false döndürün
            return true; // Örnek olarak her zaman true döndürüyoruz
        });
        
        // Şimdi özel doğrulama kuralınızı kullanabilirsiniz:
        $request->validate([
            'name' => 'required|unique:categories,category_name|custom_rule_unique_category_slug'
        ],[
            'name.custom_rule_unique_category_slug' => 'This category already exists.',
        ]);

        Category::create([
            'category_name' => Str::title($request->name),
            'category_slug' => Str::slug($request->name),
            'category_status' => $request->status == true ? 1 : 0,
        ]);
        
        toastr('New category CREATED!','success','Success!');

        return redirect()->back();        
    }

    public function getData(Request $request)
    {
        $category = Category::where('category_id',$request->id)->first();
        $category->categoryList = Category::select('category_id','category_name')->get();
        $category->articleCount = $category->getArticleCount();
        return response()->json($category);
    }

    public function updateCategory(Request $request)
    {
        Validator::extend('custom_rule_unique_category_slug', function ($attribute, $value, $parameters, $validator) use ($request) {
            // $attribute: Doğrulama yapılacak alanın adı
            // $value: Doğrulama yapılacak alanın değeri
            // $parameters: Doğrulama kuralındaki parametreler (isteğe bağlı)
            // $validator: Validator nesnesi
            $isExits =Category::where(function ($query) use ($request){
                return $query->where('category_id','!=',$request->id)
                            ->where('category_slug', $request->modalSlug)
                            ->orWhere('category_name',$request->modalName);
            })->first();
            if($isExits)
                return false;
            // Doğrulama kurallarını burada kontrol edin
            // Eğer doğruysa true, değilse false döndürün
            return true; // Örnek olarak her zaman true döndürüyoruz
        });
        
        // Şimdi özel doğrulama kuralınızı kullanabilirsiniz:
        $request->validate([
            'modalName' => [
                'required',
                Rule::unique('categories','category_name')->ignore($request->id,'category_id'),
            ],
            'modalSlug' => [
                'required',
                Rule::unique('categories','category_slug')->ignore($request->id,'category_id'),
            ],
        ]);

        Category::where('category_id',$request->id)->update([
            'category_name' => $request->modalName,
            'category_slug' => $request->modalSlug,
        ]);
        
        toastr('Category UPDATED!','success','Success!');

        return redirect(route('admin.category.index'));
    }

    public function deleteCategory(Request $request)
    {
        $articles = Article::where('category_id',$request->deleteId)
                    ->update([
                        'category_id' => $request->newCategoryId
                    ]) ?? abort(403,'Article Update Error!');

        $category = Category::where('category_id','!=',1)
                    ->where('category_id',$request->deleteId)
                    ->delete() ?? abort(403,'Error during kategory deletion!');

        toastr('Category Successfly DELETED!','success','Success!');
        return redirect()->back();
    }
}
