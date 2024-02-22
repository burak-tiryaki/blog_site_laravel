<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Artisan;
use Config;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::orderBy('created_at','DESC')->get();
        return view('back.pages.index',compact('pages'));
    }
    public function changeStatus($id)
    {
        $page = Page::where('page_id',$id)->first();

        $page->where('page_id',$id)->update([
            'page_status' => ($page->page_status == 1 ? 0 : 1)
        ]);
        
        toastr('Page status changed.','success','Success!');

        return redirect(route('admin.pages.index'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'order' => 'nullable|unique:pages,page_order',
            'image' => 'nullable | mimes:png,jpg,jpeg,webp',
            'content' => 'required'
        ]);
        $data = [
            'page_title' => $request->title,
            'page_content' => $request->content,
            'page_slug' => Str::slug($request->title),
            'page_status' => $request->status == true ? 1 : 0,
        ];

        $lastPage = Page::orderBy('page_order','DESC')->first();
        $data['page_order'] = is_null($request->order) ? ($lastPage->page_order + 1) : $request->order;

        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = Str::slug($request->title).'_'.date("Ymd_His").'.'.$request->image->getClientOriginalExtension();
            $imagePath = 'uploads/pageimage/';
            $image->move($imagePath,$imageName);
            
            $data['page_image'] = '/'.$imagePath.$imageName;
        }

        $page = Page::create($data);

        if ($page instanceof Page)
        {
            toastr('Page successfuly created.','success','Success!');
            
            return redirect(route('admin.pages.index'));
        }
            
        toastr('Page can not created!','error','Error!');
        return redirect(route('admin.pages.create'))->with('status','Page can not created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $page = Page::where('page_id',$id)->firstOrFail();
        return view('back.pages.update',compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'order' => [
                'required',
                Rule::unique('pages','page_order')->ignore($id,'page_id'),
            ],
            'image' => 'nullable | mimes:png,jpg,jpeg,webp',
            'content' => 'required'
        ]);
        $data = [
            'page_title' => $request->title,
            'page_content' => $request->content,
            'page_order' => $request->order,
            'page_slug' => Str::slug($request->title),
            'page_status' => $request->status == true ? 1 : 0,
        ];
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = Str::slug($request->title).'_'.date("Ymd_His").'.'.$request->image->getClientOriginalExtension();
            $imagePath = 'uploads/pageimage/';
            $image->move($imagePath,$imageName);
            $data['page_image'] = '/'.$imagePath.$imageName;

            if (File::exists(public_path($request->oldimage)) && $request->oldimage != '/front/assets/img/about-bg.jpg') 
            {
                // Eski dosyayı sil
                unlink(public_path($request->oldimage));
                //Session::flash('status', 'Eski dosya başarıyla silindi.');
            }
            
        }

        $page = page::where('page_id',$id)->update($data);

        if ($page > 0)
        {
            toastr('Page successfuly UPDATED.','success','Success!');
            
            return redirect(route('admin.pages.index'));
        }
            
        toastr('page can not updated!','error','Error!');
        return redirect()->route('admin.pages.edit',$id)->with('status','page can not updated!');
    }

    public function deletePage(Request $request)
    {
        $page = Page::where('page_id',$request->deleteId)->first();

        Page::where('page_id',$request->deleteId)->delete() ?? abort(403, 'Error while page deleting!');

        if (File::exists(public_path($page->page_image)) && $page->page_image != '/front/assets/img/about-bg.jpg') 
        {
            // Eski dosyayı sil
            unlink(public_path($page->page_image));
        }

        toastr('Page successfully DELETED','success','Deleted!');
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
