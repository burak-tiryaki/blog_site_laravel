@extends('back.layouts.layout')
@section('title','Trashed Articles')
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
            <a href="{{route('admin.articles.index')}}" class="btn btn-outline-primary">
                <i class="fa fa-eye"></i>
                All Articles
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
                    <td>
                        <a href="{{route('admin.articles.changeStatus',$article->article_id)}}" 
                            class="btn btn-sm {!!$article->article_status == 1 ? 'btn-success">Active' : 'btn-danger">Passive'!!}
                        </a>

                    </td>
                    <td>
                        <a href="{{route('admin.articles.recoverArticle',$article->article_id)}}" title="Recycle" class="btn btn-sm btn-primary"><i class="fa fa-recycle px-1"></i></a>
                        <a href="{{route('admin.articles.hardDeleteArticle',$article->article_id)}}" title="HARD Delete" class="btn btn-sm btn-danger"><i class="fa fa-times px-1"></i></a>
                    </td>
                </tr>
                @endforeach
               
            </tbody>
        </table>
    </div>
</div>

@endsection
