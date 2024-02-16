@extends('back.layouts.layout')
@section('title','All Articles')
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
    <div class="card-header">
        <i class="fas fa-table-list me-1"></i>
        Articles (<strong>{{$articles->count()}}</strong>)
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
                    {{-- <td>
                        @livewire('buttons.status',[
                            'model' => $article,
                            'field' => 'article_status',
                            'key' => $article->article_id,
                        ]) 
                       
                        <!-- Rounded switch -->
                        <label class="switch">
                            <input type="checkbox" {{$article->article_status == 1 ?'checked':''}} article-id="{{$article->article_id}}">
                            <span class="slider round"></span>
                        </label> 
                    </td> --}}
                    <td>
                        <a href="#" title="Show" class="btn btn-sm btn-success"><i class="fa fa-eye px-1"></i></a>
                        <a href="{{route('admin.articles.edit',$article->article_id)}}" title="Edit" class="btn btn-sm btn-primary"><i class="fa fa-pen px-1"></i></a>
                        <a href="#" title="Delete" class="btn btn-sm btn-danger"><i class="fa fa-times px-1"></i></a>
                    </td>
                </tr>
                @endforeach
               
            </tbody>
        </table>
    </div>
</div>

@endsection
@section('headScript')
<style>
    /* The switch - the box around the slider */
    .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
    opacity: 0;
    width: 0;
    height: 0;
    }

    /* The slider */
    .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    }

    .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    }

    input:checked + .slider {
    background-color: #2196F3;
    }

    input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
    border-radius: 34px;
    }

    .slider.round:before {
    border-radius: 50%;
    }
    
</style>
@endsection

@section('scipt')
    <script>
        $(function() {
            $('.switch').change(function(){
            id = $(this)[0].getAttribute('article-id');
            })
    </script>
@endsection