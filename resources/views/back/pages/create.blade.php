@extends('back.layouts.layout')
@section('title','Create Page')

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
    <div class="card-header">
        <i class="fas fa-edit me-1"></i>
        Create Page
    </div>
    <div class="card-body">
        <form action="{{route('admin.pages.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
                @error('title') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Upload Picture <span class="text-muted"><small>(optional)</small></span></label>
                <input type="file" name="image" accept="image/*" class="form-control" >
                @error('image') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Order <span class="text-muted"><small>(optional)</small></span></label>
                <input type="number" name="order" class="form-control w-25" min="1">
                @error('order') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Content</label>
                <div id="editor" style="height: 14em"></div>
                <input type="hidden" name="content" id="content">
                @error('content') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="status" id="" class="form-check-input">
                <label class="form-check-label">Set as Active?</label>
            </div>
            <div class="mb-3 d-grid gap-2">
                <button type="submit" class="btn btn-primary">Create page</button>
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