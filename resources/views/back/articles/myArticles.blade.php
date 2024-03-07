@extends('back.layouts.layout')
@section('title','My Articles')
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

<div class="card mb-4">
    <div class="card-header d-flex align-items-center">
        <span>
            <i class="fas fa-table-list me-1"></i>
            Articles (<strong>{{$articles->count()}}</strong>)
        </span>
        <span class="ms-auto">
            <a href="{{route('admin.articles.getTrashedArticles')}}" class="btn btn-outline-secondary">
                <i class="fa fa-trash"></i>
                Trashed Articles
            </a>
        </span>
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Category</th>
                    <th>Hit</th>
                    <th>Create Date</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Category</th>
                    <th>Hit</th>
                    <th>Create Date</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Options</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($articles as $article)
                <tr>
                    <td>
                        <img src="{{$article->article_image}}" style="max-width: 150px" class="w-100 d-inline-block rounded" alt="" srcset="">
                    </td>
                    <td>{{$article->article_title}}</td>
                    <td>{{ Str::words($article->article_content, 10) }}</td>
                    <td>{{$article->getCategory->category_name}}</td>
                    <td>{{$article->article_hit}}</td>
                    <td>{{$article->created_at}}</td>
                    <td>{{$article->getUser->user_name}}</td>
                    <td>
                        <a href="{{route('admin.articles.changeStatus',$article->article_id)}}" 
                            class="disabled btn btn-sm {!!$article->article_status == 1 ? 'btn-success' : 'btn-danger'!!}">
                            {!!$article->article_status == 1 ? 'Active' : 'Passive'!!}
                            
                        </a>

                    </td>
                    <td>
                        <a href="{{route('get.article',[$article->getCategory->category_name,$article->article_slug])}}" target="_blank" title="Show" class="btn btn-sm btn-success"><i class="fa fa-eye px-1"></i></a>
                        <a href="{{route('admin.articles.edit',$article->article_id)}}" title="Edit" class="btn btn-sm btn-primary"><i class="fa fa-pen px-1"></i></a>
                        <a href="{{route('admin.articles.trashArticle',$article->article_id)}}" title="Delete" class="btn btn-sm btn-danger"><i class="fa fa-trash px-1"></i></a>
                    </td>
                </tr>
                @endforeach
               
            </tbody>
        </table>
    </div>
</div>

@endsection
