@extends('back.layouts.layout')
@section('title','Update Article')

@section('content')

@if(session('status'))
<div class="row">{{-- Alert --}}
    <div class="col-12 text-center">
        <div class="alert alert-success mt-4">
            {{ session('status') }}
        </div>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header d-flex align-items-center">
        <span>
            <i class="fas fa-edit me-1"></i>
            Update Article
        </span>
        <span class="ms-auto">
            <a href="{{route('admin.articles.index')}}" class="btn btn-outline-primary">
                <i class="fa fa-eye"></i>
                All Articles
            </a>
        </span>
    </div>
    <div class="card-body">
        <form action="{{route('admin.articles.update',$article->article_id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="" class="form-label">Title</label>
                <input type="text" name="title" value="{{$article->article_title}}" class="form-control" required>
                @error('title') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Category</label>
                <select name="category" id="" class="form-select" required>
                    <option value="notSelected">Select a category</option>
                    @foreach ($categories as $cat)
                        <option {{$article->category_id == $cat->category_id ? 'selected' : ''}} value="{{$cat->category_id}}">{{$cat->category_name}}</option>
                    @endforeach
                </select>
                @error('category') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Upload Picture</label>
                <div class="row align-items-center">
                    <div class="col-sm-3">
                        <img src="{{asset($article->article_image)}}" class="w-100" alt="" srcset="">
                        <input type="hidden" name="oldimage" value="{{$article->article_image}}">
                    </div>
                    <div class="col-sm-9">
                        <input type="file" name="image" accept="image/*" class="form-control" >
                    </div>
                </div>
                @error('image') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Content</label>
                <div id="editor" style="height: 14em">{!!$article->article_content!!}</div>
                <input type="hidden" name="content" id="content">
                @error('content') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" {{$article->article_status == 1 ? 'checked' : ''}} name="status" id="" class="form-check-input">
                <label class="form-check-label">Set as Active?</label>
            </div>
            <div class="mb-3 d-grid gap-2">
                <button type="submit" class="btn btn-primary">Create Article</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('headScript')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.2/dist/quill.snow.css" rel="stylesheet" />
@endsection
    
    
@section('script')
    <!-- Include the Quill library -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.2/dist/quill.js"></script>

    <!-- Initialize Quill editor -->
    <script>
    
    const quill = new Quill('#editor', {
        theme: 'snow',
        'height': '500'
    });

    // Form submit edildiğinde, Quill editöründeki HTML içeriğini gizli bir input alanına ekleyin
    var form = document.querySelector('form');

    form.onsubmit = function() {
        var content = document.querySelector('input#content');
        content.value = quill.root.innerHTML;
    };

    </script>

@endsection