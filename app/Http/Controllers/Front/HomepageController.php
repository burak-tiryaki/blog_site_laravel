<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;


class HomepageController extends Controller
{
    public function index()
    {
        $viewData['categories'] = Category::all();
        $viewData['articles'] = Article::OrderBy('created_at','DESC')->paginate(2);
        
        return view('front.mainpage',$viewData);
    }

    public function getOneArticle($categorySlug,$slug)
    {
        $category = Category::where('category_slug',$categorySlug)->first() ?? abort(403,'Category Yok');
        $article = Article::where(['article_slug' =>$slug, 'category_id'=>$category->category_id])->first() ?? abort(403,'Article Yok');
        //$article->update(['article_hit' => $article->article_hit + 1]);
        $viewData['article'] = $article;
        $viewData['categories'] = Category::all();
        return view('front.getArticle',$viewData);
    }

    public function category($slug)
    {
        $category = Category::where('category_slug',$slug)->first() ?? abort(403,'Category Yok');
        $viewData['articles'] = Article::where(['category_id'=>$category->category_id])->orderBy('created_at','DESC')->paginate(2) ?? abort(403,'Article Yok');

        $viewData['category'] = $category;
        
        // for sidebar category list
        $viewData['categories'] = Category::all();

        return view('front.category',$viewData);
    }
}
