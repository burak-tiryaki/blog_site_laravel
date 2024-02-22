<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Validator;

class HomepageController extends Controller
{
    public function __construct()
    {
        if(config('app.custom_site_active') == "0")
            abort(403,'Site currently OFFLINE!');
        
        //--- view'lerde GLOBAL DEĞİŞKEN TANIMLAMA
        // Menu Pages
        view()->share('pages',Page::where('page_status',1)->orderBy('page_order','ASC')->get());
        
        // for sidebar category list
        view()->share('categories', Category::where('category_status',1)->get());
    }

    public function index()
    {
        $viewData['articles'] = Article::where('article_status',1)
                                        ->whereHas('getCategory', function ($query) {
                                            $query->where('category_status', 1);
                                        })
                                        ->OrderBy('created_at','DESC')
                                        ->paginate(2);
        
        return view('front.mainpage',$viewData);
    }

    public function getOneArticle($categorySlug,$slug)
    {
        $category = Category::where(['category_slug'=>$categorySlug,'category_status'=>1])->first() ?? abort(403,'Category Yok');
        $article = Article::where(['article_slug' =>$slug, 'category_id'=>$category->category_id, 'article_status'=>1])->first() ?? abort(403,'Article Yok');
        //$article->update(['article_hit' => $article->article_hit + 1]);
        $viewData['article'] = $article;
        
        return view('front.getArticle',$viewData);
    }

    public function category($slug)
    {
        $category = Category::where(['category_slug'=>$slug,'category_status'=>1])->first() ?? abort(403,'Category Yok');
        
        $viewData['articles'] = Article::where(['category_id'=>$category->category_id, 'article_status'=>1])
                                ->orderBy('created_at','DESC')
                                ->paginate(2) ?? abort(403,'Article Yok');
        $viewData['category'] = $category;
        
        return view('front.category',$viewData);
    }

    public function page($slug)
    {
        $page = Page::where(['page_slug'=>$slug, 'page_status'=>1])->first() ?? abort(403,'Missing Page');
        $viewData['page'] = $page;

        return view('front.page',$viewData);
    }

    public function getContact()
    {
        return view('front.contact');
    }

    public function postContact(Request $request)
    {
        // $rules = [
        //     "name" => 'required',
        //     "email" => 'required|email',
        //     'subject' => 'required',
        //     'message' => 'required'
        // ];
        // $validate = Validator::make($request->post(),$rules);
        // if($validate->fails()){
        //     return redirect('contact')->withErrors($validate)->withInput();
        // }

        $request->validate([
            "name" => 'required',
            "email" => 'required|email',
            'subject' => 'required|not_in:notSelected',
            'message' => 'required'
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();
        return redirect()->route('contact')->with('status','Your message successfuly sended.');
    }
}
