<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::orderBy('created_at','DESC')->get();
        return view('back.articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('back.articles.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required|not_in:notSelected',
            'image' => 'nullable | mimes:png,jpg,jpeg,webp',
            'content' => 'required'
        ]);
        $data = [
            'article_title' => $request->title,
            'category_id' => $request->category,
            'article_content' => $request->content,
            'article_slug' => Str::slug($request->title),
            'article_status' => $request->status == true ? 1 : 0,
        ];
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = Str::slug($request->title).'_'.date("Ymd_His").'.'.$request->image->getClientOriginalExtension();
            $imagePath = 'uploads/articleimage/';
            $image->move($imagePath,$imageName);
            
            $data['article_image'] = '/'.$imagePath.$imageName;
        }

        $article = Article::create($data);

        if ($article instanceof Article)
        {
            toastr('Article successfuly created.','success','Success!');
            
            return redirect(route('admin.articles.index'));
        }
            
        toastr('Article can not created!','error','Error!');
        return redirect(route('admin.articles.create'))->with('status','Article can not created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $article = Article::where('article_id',$id)->firstOrFail();
        return view('back.articles.update',compact('categories','article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required|not_in:notSelected',
            'image' => 'nullable | mimes:png,jpg,jpeg,webp',
            'content' => 'required'
        ]);
        $data = [
            'article_title' => $request->title,
            'category_id' => $request->category,
            'article_content' => $request->content,
            'article_slug' => Str::slug($request->title),
            'article_status' => $request->status == true ? 1 : 0,
        ];
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = Str::slug($request->title).'_'.date("Ymd_His").'.'.$request->image->getClientOriginalExtension();
            $imagePath = 'uploads/articleimage/';
            $image->move($imagePath,$imageName);
            $data['article_image'] = '/'.$imagePath.$imageName;

            if (File::exists(public_path($request->oldimage)) && $request->oldimage != '/front/assets/img/home-bg.jpg') 
            {
                // Eski dosyayı sil
                unlink(public_path($request->oldimage));
                Session::flash('status', 'Eski dosya başarıyla silindi.');
            }
            
        }

        $article = Article::where('article_id',$id)->update($data);

        if ($article > 0)
        {
            toastr('Article successfuly updated.','success','Success!');
            
            return redirect(route('admin.articles.index'));
        }
            
        toastr('Article can not updated!','error','Error!');
        return redirect(route('admin.articles.edit',$id))->with('status','Article can not updated!');
    }

    public function changeStatus($id)
    {
        $article = Article::where('article_id',$id)->first();

        $article->where('article_id',$id)->update([
            'article_status' => ($article->article_status == 1 ? 0 : 1)
        ]);
        
        toastr('Article status changed.','success','Success!');

        return redirect(route('admin.articles.index'));
    }

    public function trashArticle($id)
    {
        Article::where('article_id',$id)->delete();
        
        toastr('Article successfuly TRASHED.','success','Success!');

        return redirect(route('admin.articles.index'));
    }
    
    public function getTrashedArticles()
    {
        $articles = Article::onlyTrashed()->orderBy('deleted_at','DESC')->get();
        return view('back.articles.trashed',compact('articles'));
    }

    public function recoverArticle($id)
    {
        $article = Article::onlyTrashed()->where('article_id',$id)->restore();
        
        toastr('Article successfuly RECOVERED.','success','Success!');

        return redirect(route('admin.articles.getTrashedArticles'));
    }

    public function hardDeleteArticle($id)
    {
        $article = Article::onlyTrashed()->where('article_id',$id)->first();
        
        if (File::exists(public_path($article->article_image)) && $article->article_image != '/front/assets/img/home-bg.jpg') 
        {
            // Eski dosyayı sil
            unlink(public_path($article->article_image));
        }
        
        $article->where('article_id',$id)->forceDelete();
        toastr('Article successfuly DELETED.','success','Success!');

        return redirect(route('admin.articles.index'));
    }
    
    /**
     * Remove the specified resource from storage.
     * This method can be use with forms.
     */
    public function destroy(string $id)
    {
        //
    }
}
