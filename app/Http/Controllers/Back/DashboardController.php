<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Request;
use stdClass;

class DashboardController extends Controller
{
    public function index()
    {
        $viewData = new stdClass();
        $viewData->articlesTotalView = Article::sum('article_hit');
        $viewData->articlesCount = Article::count();
        $viewData->pageCount = Page::count();
        $viewData->catCount = Category::count();
        return view('back.dashboard',compact('viewData'));
    }
}
